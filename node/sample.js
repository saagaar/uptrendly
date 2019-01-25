// JavaScript Document
var app = require('http').createServer(handler);
var io = require('socket.io').listen(app, {
		log : false,
		//log : true,
	});
var fs = require('fs');
var dateFormat = require('dateformat');
var CronJob = require('cron').CronJob;
var mysql = require('mysql');
var Moment = require('moment-timezone');
var connection = mysql.createConnection({
		host : 'localhost',
		user : 'root',
		password : 'emts123',
		database : 'emts_bidwarz',
		port : 3306
	});

var mapuserifnotpresent='no';
var _bid_increment='';
var _reset_time='';
var port_number = '3000';
var socketCount = 0;
var auction_room_connected = '';
var roomsCount = {}; //an object that holds the numbers of users in each room
var socketMap = {}; //an object that holds information of users, socket and room(aid)
var connectionsArray = [];  //an array that holds all the connections
var dupmap={};

var user_id=0;
var users_seat_position =0; //geenrate random seat position for any user
var hand_raised_status=false;   //flag to check whether there is any current hands raise or not.
var previous_hand_raised_bidder;//the user_id of an user that has raised the hand in the previous auction. (he/she must fall down his/her hand when another user wish to bid in the same auction.)
var hand_down_broadcast_image;
var previous_user_color;
var previous_pant_color;

var previous_hand_raised_current_user_id; //The user id of current user. This will be set if this user raised hand in any other auctions. (After raising hand in one auction user goes to the another auction, then their socket_id changes as the auction changes, so there is need to check that user in that specific auction.)
var previous_hand_raised_current_user_image;


var check_user_presence_flag=false; //flag to check whether user is already present in socketMap

//listen to the server at port 4000
//app.listen(process.env.PORT || port_number);
//app.listen(port_number);
app.listen(process.env.PORT || port_number, function () {
	console.log('Listening at Server Localhost:' + port_number);

});

//now connect mysql database
connection.connect(function (error) {
	if (error) {
		console.log('Error establishing connection to Database');
		console.log(error);
		//return false;
	} else {
		console.log('Connection established to Database');
		console.log('connected as id ' + connection.threadId);
	}
});

// on server started we can load our client.html page
function handler(req, res) {
	//fs.readFile(__dirname + '/client.html', function (err, data) {
	fs.readFile(__dirname + '/index.php', function (err, data) {
		if (err) {
			//console.log(err);
			res.writeHead(500);
			return res.end('Error loading index.php');
		}
		res.writeHead(200);
		res.end(data);
	});
}

//create custom namespace 'bidding_process' for bidding process. we can create different namespace for different functionalities in a single system
var io_bidding = io.of('/bidding_process');
//console.log("IO_BIDDING:");
//console.log(io_bidding);


// for very first time timezone update
	var site_time_zone = '';
	var _bid_time
	var site_info = connection.query('SELECT * from emts_site_settings');
	site_info
		.on("result", function (site_data) {
			site_time_zone = site_data.timezone;
			_bid_time=site_data.bid_time;
			_bid_increment=site_data.bid_price_increment;
			_reset_time=site_data.auction_reset_time;

		});

//Now run cron scheduler to run this script in every 5 seconds
new CronJob('*/5 * * * * *', function () {
	// console.log('-------------------------RoomsCountStart---------------------');
	// console.log(roomsCount);
	// console.log(auction_room_connected);
	// console.log('-------------------------RoomsCountEnd---------------------');
	// for every tme update of site timezone
	
	var site_info_time = connection.query('SELECT timezone from emts_site_settings');
	   site_info_time
		.on("result", function (site_time_data) {
		site_time_zone = site_time_data.timezone;
		});

	//console.log('You will see this message every 5 second');
	// perform the database query operation to
	 var current_date = Moment().tz(site_time_zone).format("YYYY-MM-DD H:mm:ss");
	
	//console.log('current_date ' + current_date);
	
	
	//added by shiv
	//Make host live if the start date match with current date
	var select_host_auctions_to_started = connection.query("select id from `emts_host_auctions` WHERE `host_status` = '1' AND `start_date_time` <= '" + current_date + "'");
		select_host_auctions_to_started
		  .on("result", function (started_data) {
			  connection.query(" UPDATE `emts_host_auctions` SET `host_status` = '2' WHERE `id` = "+started_data.id +"");
			  //console.log("this is host data id "+JSON.stringify(started_data));
		  });
	
	
	
		var find_closed_auctions = connection.query('SELECT `P`.`id` as product_id, `P`.`shipping_charge` as shipping_charge, `HA`.`id` as auction_id FROM (`emts_products` P) JOIN `emts_auctions` A on `P`.`id`=`A`.`product_id` JOIN `emts_host_auctions` HA ON `A`.`host_id`=`HA`.`id` WHERE `P`.`auc_end_time` <= ? AND `P`.`auc_end_time` !=? AND P.status = ? ORDER BY A.order ASC,  P.auc_end_time ASC LIMIT 1', [current_date, '0000-00-00 00:00:00', 2], function (err, row, field) {
			if (err) {
				console.log('error occured while updating auction start end time : ' + err.message);
				throw err;
			} else if (row) {
				//console.log("Cronjob Running");
				//console.log("Total Closed Auctions :" + row.length);
				//console.log(find_closed_auctions.sql);
				//_bid_time = data.bid_time;


				if (row.length > 0) {
					var _product_id = row[0].product_id;
					var _auction_id = row[0].auction_id;

					// var _bid_time = '300'; //get this from database

					console.log("Closed Product and auction details :" + _auction_id + ' # ' + _product_id);
					//console.log("Total Closed Auctions :" + row.length);

					var new_product_data_arr = '';
					var new_product_img_data_arr = [];
					var new_custom_fields_arr = [];
					var update_product_affected_rows = '';
					var product_winner_id = 0;
					var product_won_amount = 0;
					var product_shipping_charge = 0; //shipping_charge;
					var remaining_products_count = 0;
					var price_discount_percent = 0;
					var np='';//for relisting the information of user
					var toinsert_product_images=[];
					var toinsert_product_meta_data=[];
					var new_product_id='';
					var toinsert_product_metadata=[];
					// var current_date = dateFormat(new Date(), "yyyy-mm-dd HH:MM:ss");
					var current_date=Moment().tz(site_time_zone).format("YYYY-MM-DD H:mm:ss");
					var bid_interval = 4; //time elapsed between ending one product and starting new product
					var auc_end_additional_time = parseInt(_bid_time) + bid_interval; //additional time in seconds for auction end time.
					//console.log("Current Date Time : " + current_date);

					var auction_close_affected_rows = 0;

					//set auction room connected variable by auction id
					auction_room_connected = _auction_id;

					//console.log("auction_room_connected_inside_cronjob" + auction_room_connected);

					//console.log("Current Date Time at the top : " + current_date);
					var counter = 0;
					//now find whether this auction is closed or not and only perform further operation if this is a valid auction which is about to close
					//console.log("++++++++++++++++ UPDATE Product Status to 3 ++++++++++++++++");
					//error make 3 from 2
					var update_product = connection.query("UPDATE emts_products SET `status` = 3 WHERE id ='" + _product_id + "'");
					//console.log("UPDATE emts_products SET `status` = 3 WHERE id ='" + _product_id + "'");
					update_product
					.on("error", function (error) {
						console.log("Error while updating auction current price :" + error.message);
						throw error;
					})
					.on("result", function (data) {
						//console.log('Product update successful for closing product. Connection Thread ID:' + connection.threadId);
						//console.log(data.affectedRows);
						update_product_affected_rows = data.affectedRows;
					})
					.on("end", function () {
						//console.log("++++++++++++++++ Start of 'Update Closed Product' Function ++++++++++++++++");

						//console.log("Total Numbers of affected rows: "+update_product_affected_rows);

						//now check whether product table is updated or not
						if (update_product_affected_rows == 1) {
							//console.log("++++++++++++++++++++++ Fetch New Product in Queue ++++++++++++++++++++++");
							//NOW Fetch All the Necessary Data from Database

							//fetch new product in queue
							var fetch_new_data = connection.query("SELECT `P`.`id` as product_id, `P`.`product_code`, `P`.`name` as product_name, `P`.`description`, `P`.`condition`, `P`.`brand`, `P`.`brand_name`, `P`.`brand_style`, `P`.`warranty`, `P`.`start_bid`, `P`.`package_weight`, `P`.`package_size`, `P`.`free_shipping`, `P`.`shipping_charge`, `P`.`retail_price`, `P`.`buy_now`, `P`.`buy_now_quantity`, `P`.`buy_now_price`, `P`.`seller_id`, `P`.`auc_start_time`, `P`.`auc_end_time`, `P`.`auc_current_price`, `M`.`name` as seller_name, `M`.`reg_date`, `M`.`is_login`, `HA`.`id` as host_id, `HA`.`host_name`, `HA`.`description`, `HA`.`host_terms`, `A`.`order` FROM (`emts_products` P) JOIN `emts_auctions` A ON `P`.`id`=`A`.`product_id` JOIN `emts_host_auctions` HA ON `A`.`host_id`=`HA`.`id` JOIN `emts_members` M ON `P`.`seller_id`=`M`.`id` WHERE `P`.`status` = '2' AND `HA`.`host_status` = '2' AND `HA`.`id` = " + _auction_id + " ORDER BY `A`.`order` ASC LIMIT 1");

							fetch_new_data
							.on("error", function (error) {
								console.log("Error while selecting auction data :" + err.message);
								throw err;
							})
							.on("result", function (pdata) {
								new_product_data_arr = pdata;
								//console.log('++++++++++++++ Product Data Fetched Successfully ++++++++++++++');
								//console.log(pdata);
								//setNewProductData(pdata);
							})
							.on("end", function () {
								//Now fetch product images of new product
								//console.log("SELECT `product_id`, `image` FROM (`emts_product_images`) WHERE `product_id` = '"+new_product_data_arr.product_id+"'");

								//if no product found emit auction closed message and close the auction
								if (new_product_data_arr == '') {
									//console.log('++++++++++++++ No Item Found in this Auction (Auction Product Finished) ++++++++++++++');
									//now update host auction
									//now check whether this user is a valid user or not
									var update_host_auction_to_closed = connection.query("UPDATE emts_host_auctions set `host_status` = '3', `end_date`=  '" + current_date + "' where id = '" + _auction_id + "'");
									// var update_host_auction_to_closed = connection.query("UPDATE emts_host_auctions set `host_status` = '3', where id = '" + _auction_id + "'");

									update_host_auction_to_closed
									.on("error", function (error) {
										console.log("Error while selecting product images data :" + error.message);
										throw error;
									})
									.on("result", function (auc_closed) {
										auction_close_affected_rows = auc_closed.affectedRows;
									})
									.on("end", function () {
										//console.log("auction_close_affected_rows :" + auction_close_affected_rows);

										//Now Find winner and add winner to database
										console.log("++++++++++++++++ Fetch Product Winner ("+_product_id+")++++++++++++++++");
										//var product_winner_query = connection.query("SELECT `user_id`, `bid_amt` FROM (`emts_user_bids`) WHERE `product_id` = '" + _product_id + "' AND `auction_id` = '" + _auction_id + "' ORDER BY `bid_amt` DESC, `bid_place_date` ASC LIMIT 1;");
										var product_winner_query = connection.query("SELECT `UB`.`user_id`,`UB`.`product_id`, `UB`.`bid_amt`, `P`.`shipping_charge` FROM (`emts_user_bids` UB) LEFT JOIN `emts_products` P ON `UB`.`product_id`=`P`.`id` WHERE `UB`.`product_id` = '" + _product_id + "' AND `UB`.`auction_id` = '" + _auction_id + "' ORDER BY `UB`.`bid_amt` DESC, `UB`.`bid_place_date` ASC LIMIT 1;");
										product_winner_query
										.on("error", function (error) {
											console.log("Error while selecting winner :" + error.message);
											throw error;
										})
										.on("result", function (winner) {
											//now push the product data into an array when it receives data
											//console.log("Product Winner : " + winner);
											product_winner_id = winner.user_id;
											product_won_amount = winner.bid_amt;
											product_shipping_charge = winner.shipping_charge;

											//console.log('++++++++++++++ Product Shipping Charge found  ++++++++++++++' + product_shipping_charge);

											//console.log(imgdata);
											//console.log('++++++++++++++ Product Winner selected ++++++++++++++');
										})
										.on("end", function () {
											//add auction winner if winner is found
											if (product_winner_id != 0) {
												//insert auction winner to sales order table

												connection.query("INSERT INTO emts_sales_order (user_id,product_id,product_cost,shipping_charge,product_type,order_datetime) values( " + product_winner_id + ",'" + _product_id + "'," + product_won_amount + "," + product_shipping_charge + ",'auction','" + current_date + "');",
													function (err, results, field) {
													if (err) {
														console.log("error :" + err.message);
														throw err;
													}
												});
											}
											else{	
												//relisting the item if no bid has been placed
												var endedproducts=connection.query("SELECT * from emts_products where id='"+ _product_id+"'");
												endedproducts
												.on("error", function (error) {
													console.log("Error while selecting winner :" + error.message);
													throw error;
												})
												.on("result", function (data) {
													np=data;
												})
												.on("end", function () {
													console.log('We are inside relsiting');
													console.log(_product_id);
													var product_code=(new Date().getTime('Y-m-d'))+np.seller_id;
													var auc_end_time='0000-00-00 00:00:00';
													var auc_start_time='0000-00-00 00:00:00';
													var update_date='0000-00-00 00:00:00';
													var today=new Date();
													var date = today.getFullYear()+'-'+(today.getMonth()+1)+'-'+today.getDate();
													var time = today.getHours() + ":" + today.getMinutes() + ":" + today.getSeconds();
													var post_date = date+' '+time;	
													var status=1;
													connection.query("INSERT INTO emts_products values(NULL,'" + product_code + "','" + np.cat_id + "','" + np.sub_cat_id + "','" + np.seller_id +"','" + np.name +"','" + np.description +"','" + np.condition +"','" + np.brand +"','" + np.brand_name +"','" + np.brand_style +"','" + np.warranty +"','" + np.start_bid +"','" + np.buy_now +"','" + np.retail_price +"','" + np.buy_now_price +"','" + np.buy_now_quantity +"','" + np.package_weight +"','" + np.package_size +"','" + np.free_shipping +"','" + np.shipping_charge + "','" + np.order_quantity +"','" + post_date + "','" + update_date + "','" + auc_start_time+ "','" + np.auc_current_price + "','" + auc_end_time+ "','" + status + "','" + np.winner_notified+ "','" +np.id + "');",
													function (err, result, field) {
														if (err) {
															console.log("error :" + err.message);
															throw err;
															}
														else{
															new_product_id=result.insertId;
															/**
															 * [After data is inserted to Products we insert into product_images and meta products]
															 * inserting to product_images and meta_products
															 */
																var product_images = connection.query("SELECT image FROM (emts_product_images)  WHERE product_id = '" + _product_id + "'");
																	product_images
																	.on("error", function (error) {
																		console.log("Error while selecting winner :" + error.message);
																		throw error;
																	})
																	.on("result", function (prodimages) {
																	
																				   row =     [new_product_id,prodimages.image];
																		       	   toinsert_product_images.push(row);
																			
																	})
																	.on("end", function () {
																		if(toinsert_product_images.length>0)
																		{
																			var sql = "INSERT INTO emts_product_images (product_id, image) VALUES ?";
																			connection.query(sql, [toinsert_product_images], function(err) {
																				    if (err) {
																				    	console.log("error :" + err.message);
																						throw err;
																				    }

																			});

																		}
																		

																	});	


																	/**
																	 * [product_meta_data description] start of select data from old product from emts_meta_product and inserting to a new row with new product id
																	 * @type {[sql]}
																	 */
																	console.log('*********nn'+new_product_id);
																	var product_meta_data = connection.query("SELECT meta_fields_id,value FROM (emts_meta_products)  WHERE product_id = '" + _product_id + "'");
																	product_meta_data
																	.on("error", function (error) {
																		console.log("Error while selecting winner :" + error.message);
																		throw error;
																	})
																	.on("result", function (meta_products) {
																		// (prodimages);
																		
																				
																				   rows =     [new_product_id,meta_products.meta_fields_id,meta_products.value];
																		       	   toinsert_product_metadata.push(rows);
																		       	   // console.log(toinsert_product_metadata);
																		       	 
																			
																	})
																	.on("end", function () {
																		if(toinsert_product_metadata.length>0)
																		{
																		var sql = "INSERT INTO emts_meta_products (product_id,meta_fields_id, value) VALUES ?";
																			connection.query(sql, [toinsert_product_metadata], function(err) {
																				    if (err) {
																				    	console.log("error :" + err.message);
																						throw err;
																				    }

																			});
																		}


																	});	
																	
															}
													});
												})
												
											}/* closing of relisting the item*/

											//emit to client to inform that there is no more item in auction.
											io_bidding.in(auction_room_connected).emit('auction_item_finished', {
												'aid' : _auction_id,
												'pid' : _product_id,
												'product_winner_id' : product_winner_id,
												'product_won_amount' : product_won_amount,
											});
										});
									});
								} else {
									//product found
									//console.log("++++++++++++++++ Fetch New Products Images ++++++++++++++++");
									var fetch_product_images = connection.query("SELECT `product_id`, `image` FROM (`emts_product_images`) WHERE `product_id` = '" + new_product_data_arr.product_id + "'");
									fetch_product_images
									.on("error", function (error) {
										console.log("Error while selecting product images data :" + error.message);
										throw error;
									})
									.on("result", function (imgdata) {
										//now push the product data into an array when it receives data asynchronously
										new_product_img_data_arr.push(imgdata.image);
									
									})
									.on("end", function () {
										////console.log("Product Images Data : "+new_product_img_data_arr);
										//now fetch custom fields of this fields
										//its good idea to wrap this in a function and store the result in a variable
										//console.log("++++++++++++++++ Fetch Product Custom Fields ++++++++++++++++");
										var fetch_custom_fields = connection.query("SELECT `MP`.`meta_fields_id`, `MP`.`value`, `MF`.`type`, `MF`.`name` FROM (`emts_meta_products` MP) LEFT JOIN `emts_meta_fields` MF ON `MP`.`meta_fields_id`=`MF`.`id` WHERE `MP`.`product_id` = '" + new_product_data_arr.product_id + "' AND `MF`.`form_field_type` = 'custom'");
										fetch_custom_fields
										.on("error", function (error) {
											console.log("Error while selecting product images data :" + error.message);
											throw error;
										})
										.on("result", function (field_data) {
											new_custom_fields_arr.push(field_data);
											//console.log(field_data);
										})
										.on("end", function () {
											//Now calculate the numbers of auctions remaining
											var items_remaining_query = connection.query("SELECT COUNT(product_id) as remaining_products FROM emts_products P JOIN emts_auctions A ON P.id=A.product_id WHERE A.host_id='" + _auction_id + "' AND P.status='2'");
											items_remaining_query
											.on("error", function (error) {
												console.log("Error while calculating remaining product :" + error.message);
												throw error;
											})
											.on("result", function (product_count) {
												//now push the product data into an array when it receives data
												//console.log("Product Count : " + product_count.remaining_products);
												remaining_products_count = product_count.remaining_products - 1;
												//console.log(imgdata);
												//console.log('++++++++++++++ Product Count Fetched ++++++++++++++');
											})
											.on("end", function () {
												/*Now find winner
												console.log("++++++++++++++++ Fetch Product Winner ++++++++++++++++");
												var product_winner_query = connection.query("SELECT `user_id`, `bid_amt` FROM (`emts_user_bids`) WHERE `product_id` = '" + _product_id + "' AND `auction_id` = '" + _auction_id + "' ORDER BY `bid_amt` DESC, `bid_place_date` ASC LIMIT 1;");
*/
												var product_winner_query = connection.query("SELECT `UB`.`user_id`, `UB`.`bid_amt`, `P`.`shipping_charge` FROM (`emts_user_bids` UB) LEFT JOIN `emts_products` P ON `UB`.`product_id`=`P`.`id` WHERE `UB`.`product_id` = '" + _product_id + "' AND `UB`.`auction_id` = '" + _auction_id + "' ORDER BY `UB`.`bid_amt` DESC, `UB`.`bid_place_date` ASC LIMIT 1;");
												product_winner_query
												.on("error", function (error) {
													console.log("Error while selecting winner :" + error.message);
													throw error;
												})
												.on("result", function (winner) {
													/*now push the product data into an array when it receives data
													console.log("Product Winner : " + winner);*/
													product_winner_id = winner.user_id;
													product_won_amount = winner.bid_amt;
													product_shipping_charge = winner.shipping_charge;

													//console.log('++++++++++++++ Product Winner selected ++++++++++++++');
												})
												.on("end", function () {
													
													// current_date = dateFormat(new Date(), "yyyy-mm-dd HH:MM:ss");
													var current_date=Moment().tz(site_time_zone).format("YYYY-MM-DD H:mm:ss");
													if (product_winner_id != 0) {
														//insert auction winner to sales order table
														connection.query("INSERT INTO emts_sales_order (user_id,product_id,product_cost,shipping_charge,product_type) values( " + product_winner_id + ",'" + _product_id + "'," + product_won_amount + "," + product_shipping_charge + ",'auction');",

														function (err, results, field) {
															if (err) {
																console.log("error :" + err.message);
																throw err;
															}
														});
													}
													else{
																var endedproducts=connection.query("SELECT * from emts_products where id='"+ _product_id+"'");
												endedproducts
												.on("error", function (error) {
													console.log("Error while selecting winner :" + error.message);
													throw error;
												})
												.on("result", function (data) {
													np=data;
												})
												.on("end", function () {
													console.log('We are inside relsiting');
													console.log(_product_id);
													var product_code=(new Date().getTime('Y-m-d'))+np.seller_id;
													var auc_end_time='0000-00-00 00:00:00';
													var auc_start_time='0000-00-00 00:00:00';
													var update_date='0000-00-00 00:00:00';
													var today=new Date();
													var date = today.getFullYear()+'-'+(today.getMonth()+1)+'-'+today.getDate();
													var time = today.getHours() + ":" + today.getMinutes() + ":" + today.getSeconds();
													var post_date = date+' '+time;	
													var status=1;
													connection.query("INSERT INTO emts_products values(NULL,'" + product_code + "','" + np.cat_id + "','" + np.sub_cat_id + "','" + np.seller_id +"','" + np.name +"','" + np.description +"','" + np.condition +"','" + np.brand +"','" + np.brand_name +"','" + np.brand_style +"','" + np.warranty +"','" + np.start_bid +"','" + np.buy_now +"','" + np.retail_price +"','" + np.buy_now_price +"','" + np.buy_now_quantity +"','" + np.package_weight +"','" + np.package_size +"','" + np.free_shipping +"','" + np.shipping_charge + "','" + np.order_quantity +"','" + post_date + "','" + update_date + "','" + auc_start_time+ "','" + np.auc_current_price + "','" + auc_end_time+ "','" + status + "','" + np.winner_notified+ "','" +np.id + "');",
													function (err, result, field) {
														if (err) {
															console.log("error :" + err.message);
															throw err;
															}
														else{
															new_product_id=result.insertId;
															/**
															 * [After data is inserted to Products we insert into product_images and meta products]
															 * inserting to product_images and meta_products
															 */
																var product_images = connection.query("SELECT image FROM (emts_product_images)  WHERE product_id = '" + _product_id + "'");
																	product_images
																	.on("error", function (error) {
																		console.log("Error while selecting winner :" + error.message);
																		throw error;
																	})
																	.on("result", function (prodimages) {
																	
																		// (prodimages);
																			
																			// var row=[];
																					
																				   row =     [new_product_id,prodimages.image];
																		       	   toinsert_product_images.push(row);
																			
																	})
																	.on("end", function () {
																		if(toinsert_product_images.length>0)
																		{
																			var sql = "INSERT INTO emts_product_images (product_id, image) VALUES ?";
																			connection.query(sql, [toinsert_product_images], function(err) {
																				    if (err) {
																				    	console.log("error :" + err.message);
																						throw err;
																				    }

																			});

																		}
																		

																	});	


																	/**
																	 * [product_meta_data description] start of select data from old product from emts_meta_product and inserting to a new row with new product id
																	 * @type {[sql]}
																	 */
																	console.log('*********nn'+new_product_id);
																	var product_meta_data = connection.query("SELECT meta_fields_id,value FROM (emts_meta_products)  WHERE product_id = '" + _product_id + "'");
																	product_meta_data
																	.on("error", function (error) {
																		console.log("Error while selecting winner :" + error.message);
																		throw error;
																	})
																	.on("result", function (meta_products) {		
																				   rows =     [new_product_id,meta_products.meta_fields_id,meta_products.value];
																		       	   toinsert_product_metadata.push(rows);
																		       	   // console.log(toinsert_product_metadata);		
																	})
																	.on("end", function () {
																		  console.log(toinsert_product_metadata);
																		  if(toinsert_product_metadata.length>0)
																		  {
																		  		var sql = "INSERT INTO emts_meta_products (product_id,meta_fields_id, value) VALUES ?";
																			connection.query(sql, [toinsert_product_metadata], function(err) {
																				    if (err) {
																				    	console.log("error :" + err.message);
																						throw err;
																				    }

																			});
																		  }
																	});	
																	
															}
													});
												})
												
													}

													//now calculate new current date time
													// current_date = dateFormat(new Date(), "yyyy-mm-dd HH:MM:ss");
													var current_date=Moment().tz(site_time_zone).format("YYYY-MM-DD H:mm:ss");
													//Now update new products start and end time
													//console.log("++++++++++++++ Update New Product Start andEnd Dates ++++++++++++++");
													connection.query("UPDATE emts_products SET `auc_start_time`= DATE_ADD('" + current_date + "', INTERVAL " + bid_interval + " SECOND),  `auc_end_time` = DATE_ADD('" + current_date + "', INTERVAL " + auc_end_additional_time + " SECOND) WHERE id =" + new_product_data_arr.product_id + ";",
														function (err, results, field) {
														if (err) {
															console.log('error occured while updating auction start end time' + err.message);
															throw err;
														}
													});

													//now push the product data into an array when it receives data
													//Now prepare outputs to be sent to the clients
													price_discount_percent = (new_product_data_arr.retail_price > 0) ? parseInt((new_product_data_arr.retail_price - new_product_data_arr.start_bid) * 100 / new_product_data_arr.retail_price) : 0;
													//console.log("Discount Percent : " + price_discount_percent);

													//console.log(current_date);
													var auc_end_date_str = (((new Date(Date.parse(current_date))).getTime()) / 1000) + auc_end_additional_time;
													//console.log("auc_end_date_str : "+ auc_end_date_str);

													if (connectionsArray.length) {
														var interval = setInterval(function () {
															//console.log('Bar : ', counter);
															counter++;
															if (counter == 1) {
																//First of all emit auction closed event
																io_bidding.in(auction_room_connected).emit('auction_closed', {
																	'aid' : _auction_id
																});
																//console.log("First Step");
															} else if (counter == parseInt(bid_interval / 2)) {
																//console.log("Second Step");
																io_bidding.in(auction_room_connected).emit('new_item_coming_soon', {
																	'pid' : new_product_data_arr.product_id,
																	'aid' : _auction_id
																});
															} else if (counter >= bid_interval) {
																//console.log("Third Step");
																clearInterval(interval);
																//console.log("auction_room_connected : " + auction_room_connected);
																//io_bidding.in(auction_room_connected).emit('display_new_auction_product', {
																io_bidding.in(auction_room_connected).emit('display_new_auction_product', {
																	'product_data' : new_product_data_arr,
																	'product_img_data' : new_product_img_data_arr,
																	'custom_fields' : new_custom_fields_arr,
																	'aid' : _auction_id,
																	'remaining_items' : remaining_products_count,
																	'price_discount_percent' : price_discount_percent,
																	'total_users' : roomsCount[_auction_id],
																	'product_winner_id' : product_winner_id,
																	'product_won_amount' : product_won_amount,
																	'total_bids' : 0,
																	'auction_end_time' : auc_end_date_str,
																	'timer_time' : auc_end_additional_time,
																	'current_date_time' : current_date,
																});
															}
														}, 1000);
													}
												});
											});
										});
									}); //End OF Callback of fetch images of new product
								}
							}); //End OF Callback to fetch new product in queue
						} else {
							//console.log("++++++++++++++++++ unable to update closed product ++++++++++++++++++");
						}
					}); //End of end callback of update closed product query
				}
			}
		});
	}, null, true , 'Asia/Kathmandu');

//io_bidding = io.of('/bidding_process'); //create custom namespace 'bidding_process'. we can create multiple namespace for different functionalities

// creating a new websocket to keep the content updated without any AJAX request
io_bidding.on('connection', function (socket) {
		// console.log('\033[2J');
	console.log('Number of connections:' + connectionsArray.length);
	
	console.log('-------------------------RoomsCountStart---------------------');
	console.log("RoomsCount : ");
	console.log( roomsCount );
	console.log("Auction Room Connected : ");
	console.log( auction_room_connected );
	console.log('-------------------------RoomsCountEnd---------------------');
	
	var position_array = ['1','2','3','4','5','6','7','8','9','10','11','12', '13','14','15','16','17','18','19','20','21','22','23','24','25','26','27','28','29','30','31','32','33','34','35','36','37','38','39','40','41','42','43','44','45','46','47','48','49','50','51','52','53','54','55','56','57','58','59','60','61','62','63','64','65','66','67','68','69','70','71','72','73','74','75','76','77','78','79','80','81','82','83','84','85','86','87','88','89','90','91','92','93','94','95','96','97','98','99','100','101','102','103','104','105','106','107','108','109','110','111','112','113','114','115','116','117','118','119','120','121','122','123','124','125','126','127','128','129','130','131','132','133','134','135','136','137','138','139','140','141','142','143','144','145','146','147','148','149','150','151','152','153','154','156','157','158','159','160','161','162','163','164','165','166','167','168','169'];
	
		//console.log("CONNECTED.....");


	//now send server time to all the connected socket
		setInterval(function () {
			var time_to_seconds = (parseInt((new Date()).getTime() / 1000));
			if (time_to_seconds % 5 == 0) {
				socket.emit('server_date_time', {
					'current_date_time' : time_to_seconds
				});
				//since this code runs for all the connected sockets, i have used socket.emit only to emit to this particular socket.
			}
		}, 1000);

	//var auction_room_connected = '';
	socket.on('auction_room', function (data) {
		console.log('we are in auction join room');
		auction_room_connected = data.aid;
		socket.join(auction_room_connected);
		
			//update roomsCount in this room

		//console.log('New Socket Opened with auction room id :' + auction_room_connected + ' and socket id : ' + socket.id);
	});
	//console.log(auction_room_connected);
	
	/* find if the user is connected already to socket*/
	socket.on("is_user_connected_already",function(data)
	{
		var msg='no';
				for (var k in socketMap) {
					if (socketMap.hasOwnProperty(k)) {
						var str = JSON.stringify(socketMap[k], null, 4); // (Optional) beautiful indented output.
							if (parseInt(data.auction_room) === parseInt(socketMap[k].aid)) {
								if (parseInt(data.uid) == parseInt(socketMap[k].uid)) {
											 msg='yes';
									}
							}
					}
				}
				console.log('------->check if user connected already----->'+msg);
				socket.emit("already_connected", {
								'msg':msg
				});
				
			});

	/********************************************************
	* client emits the event if the user is connected already
	* only emit socket value to the respective client and no broadcast is done as user is already connected
	*/
		socket.on("user_connected_already", function (data) {
		// 	if ((auction_room_connected in roomsCount)) {
		// 	//now check whether this is unique user or not and make changes to array if it id unique array
		// 	roomsCount[auction_room_connected] = roomsCount[auction_room_connected] + 1;
		
		
		
				for (var k in socketMap) {

				if (socketMap.hasOwnProperty(k)) {
					var str = JSON.stringify(socketMap[k], null, 4); // (Optional) beautiful indented output.
					//console.log("Key is " + k + ", value is" + str);
					if (parseInt(auction_room_connected) === parseInt(socketMap[k].aid)) {
						if ( parseInt(socketMap[k].uid)!=undefined) {
							
							console.log('############User is already connected earlier##############');
							socket.emit("user_connected_response", {
								'position' : socketMap[k].position,
								'new_user_id' : socketMap[k].uid,
								'aid' : auction_room_connected,
								'totalUsers' : roomsCount[auction_room_connected],
								'avatar':socketMap[k].avatar,
								'color':socketMap[k].color
							});
							if(parseInt(socketMap[k].uid)===parseInt(data.uid))
							{
								var nposition = socketMap[k].position;
								var nnew_user_id = socketMap[k].uid;
								var ntotalUsers = roomsCount[auction_room_connected];
								var navatar=socketMap[k].avatar;
								var ncolor=socketMap[k].color;
								delete socketMap[socketMap[k].id];
								console.log('!!!!!!!!!!!!!!!!!Deleted Old socket!!!!!!!!!!!! ');

							}
						// 	socketMap[socket.id] = {
						// 		'position' : socketMap[k].position;
						// 		'new_user_id' : socketMap[k].uid,
						// 		'aid' : auction_room_connected,
						// 		'avatar':socketMap[k].avatar,
						// 		'color':socketMap[k].color
						// };

						}else {
							console.log('We found no user id');
						}
					}
					}
				}		
			

						socketMap[socket.id] = {
								'position' : nposition,
								'new_user_id' : nnew_user_id,
								'aid' : auction_room_connected,
								'avatar':navatar,
								'color':ncolor
						};	
						console.log('********************new socket mapped with socket id = '+socketMap[socket.id]+'**********************');
		});
	
	/**
	 * if client is a new connection to the socket the event is emitted to the server by client
	 * 
	 * @param  {[type]} data) {											connectionsArray.push(socket);												if ((auction_room_connected in roomsCount)) {						roomsCount[auction_room_connected] [description]
	 * @return {[type]}       [description]
	 */
	socket.on("user_connected", function (data) {
		console.log('****We are inside user_connected response****');
		if ((auction_room_connected in roomsCount)) {
		console.log('total number of user are '+roomsCount[auction_room_connected]);
			//now check whether this is unique user or not and make changes to array if it id unique array
			roomsCount[auction_room_connected] = roomsCount[auction_room_connected] + 1;
						console.log('total number of user are '+roomsCount[auction_room_connected]);
			//console.log('Auction Room with ID ' + auction_room_connected + ' Found');
		} else {
			roomsCount[auction_room_connected] = 1;
			//console.log('Auction Room with ID ' + auction_room_connected + ' Initialized');
		}
		
		user_id = data.uid;
		if(user_id==previous_hand_raised_bidder)
				hand_raised_status=false; 
		//console.log("+++++++++++++++++++++++++++USER CONNECTED DATA++++++++++++++++++", data);
		//console.log(JSON.stringify(data));
	
		//push new connection to connectionArray
		connectionsArray.push(socket);

		//console.log('################connectionsArray##############');
		// console.log('+_+_+_+_+_+'+data.avatar);
		
		// console.log("<<<<<<<<<<<<<<<<<<<< USER CONNECTED >>>>>>>>>>>>>>>>>>>>>>>");
	
		// console.log("Total numbers of users connected in Auction Room " + auction_room_connected + ' :' + roomsCount[auction_room_connected]);
		// console.log(data);
		
		//Generating the random seats for the users connected at the specific auction
		users_seat_position = Math.floor((Math.random() * position_array.length) + 0);
	
		// var here_user_id = String(user_id);
		
		// console.log("USER ID: " + JSON.stringify(user_id));

		var auction_room = data.auction_room;
		var user_position = position_array[users_seat_position];
		
		
		//This function takes care of all the sockets connected to the auctions
		function user_connected_mapping(user_id, auction_room, user_position) {
				console.log('~~~~~~~~~~~~~~We are in user_connected_mapping function ~~~~~~~~~~~~~~~~~');
			// for (var k in socketMap) {
			// 	if (socketMap.hasOwnProperty(k)) {
			// 		var str = JSON.stringify(socketMap[k], null, 4); // (Optional) beautiful indented output.
			// 		//console.log("Key is " + k + ", value is" + str);
			// 		if (parseInt(auction_room) === parseInt(socketMap[k].aid)) {
			// 			if (parseInt(user_id) == parseInt(socketMap[k].uid)) {
						
			// 				console.log("broadcasting to remove user if already present " + socketMap[socket.id].uid);
			// 				socket.broadcast.to(socketMap[k].aid).emit("hide_unwanted_image", {
			// 					'position' : socketMap[k].position,
			// 					'new_user_id' : socketMap[k].uid
			// 				});

			// 					delete socketMap[socketMap[k].id];
			// 			}
						
			// 		}
			// 	}
			// }

			socketMap[socket.id] = {
				'uid' : user_id,
				'aid' : auction_room,
				'position' : user_position,
				'avatar':data.avatar,
				'color':data.color,
				'pant_color':data.pant_color
			};
			console.log(socketMap);
			console.log('########### SOCKET ID: ' + socket.id);

			socket.emit("hand_raise_emit_data", {
				'position_array' : socketMap[socket.id].position,
				'new_user_id' : socketMap[socket.id].uid,
				'aid':socketMap[socket.id].aid,
				'avatar':socketMap[socket.id].avatar,
				'color':socketMap[socket.id].color,
				'pant_color': socketMap[socket.id].pant_color
			});
			
			

			for (var k in socketMap) {
				if (socketMap.hasOwnProperty(k)) {
					var str = JSON.stringify(socketMap[k], null, 4); // (Optional) beautiful indented output.
					//console.log("Key is " + k + ", value is" + str);
					if (parseInt(auction_room_connected) === parseInt(socketMap[k].aid)) {
						
						socket.emit("user_connected_response", {
							'position' : socketMap[k].position,
							'new_user_id' : socketMap[k].uid,
							'aid' : auction_room_connected,
							'totalUsers' : roomsCount[auction_room_connected],
							'avatar':socketMap[k].avatar,
							'color':socketMap[k].color,
							'pant_color':socketMap[k].pant_color,
						});
					}
				}
			}

// make have flaw looj proper
			socket.broadcast.to(auction_room_connected).emit("user_connected_response", {
				'position' : socketMap[socket.id].position,
				'new_user_id' : socketMap[k].uid,
				'aid' : auction_room_connected,
				'totalUsers' : roomsCount[auction_room_connected],
				'avatar':socketMap[k].avatar,
				'color':socketMap[k].color,
				'pant_color':socketMap[k].pant_color,
			});
			console.log("all user socket emitted..");
			//console.log("END OF SOCKET PRINTING!! ");
			//console.log("Before deleting items: " + position_array);
			position_array.splice(users_seat_position, 1);
		}

		//It's check that shows when to call the function for rendering the users after validating the specific user at the auction.
			
		if (Object.keys(socketMap).length == 0) {
		if (JSON.stringify(user_id) != JSON.stringify(null) && user_id != " " && user_id != "undefined") {
				user_connected_mapping(user_id, auction_room, user_position);
			}
		} else {
			// console.log(socketMap);
			 mapuserifnotpresent='no';
			if (JSON.stringify(user_id) != JSON.stringify(null) && user_id != " " && user_id != "undefined") {
				
				console.log(socketMap);
				// console.log("From the else without zero..");
				for (var k in socketMap) {
					
					if (socketMap.hasOwnProperty(k)) {

						//console.log("From the else without zero..");
						if (parseInt(auction_room_connected) == parseInt(socketMap[k].aid)) {
							console.log("Inside the Auction Room Check..");
							// console.log(socketMap[k].uid);
							if (parseInt(user_id) == parseInt(socketMap[k].uid)) {
								console.log("***********************user already connected*******************");
								mapuserifnotpresent='no';
// console.log(user_position);
								// socketMap[socketMap[k].position]=user_position;
								socketMap[k].position=user_position;
								// delete socketMap[socketMap[k].id];
								// console.log('*****this is deleted socket'+socketMap[k].id );
								user_connected_mapping(user_id, auction_room_connected, user_position);
									
							}
							else{
								console.log('-------------second list of else socket-----------');
									console.log(socketMap);
								 mapuserifnotpresent='yes';

						}
						}
						else{
							console.log('out of auction room');
							mapuserifnotpresent='yes';
						}

					}
				}
				//This function is called whenever there is  check_user_presenrce_flag is false
				// if (!check_user_presence_flag) {

				// 	//console.log("Calling the check_user_presence_flag function!!");
				// 	user_connected_mapping(user_id, auction_room, user_position);
				// }
					console.log(mapuserifnotpresent+' '+user_id,' '+auction_room+' '+user_position);
				if(mapuserifnotpresent=='yes') user_connected_mapping(user_id, auction_room, user_position);
			}
			
			//commented by suba sah

			// console.log("^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^  ");
			// socket.emit("user_connected_response", {'auction_room':data.aid, 'uid':data.uid, '':''});

			/*'position' : socketMap[k].position,
			'new_user_id' : socketMap[k].uid,
			'aid' : auction_room_connected,
			'totalUsers' : roomsCount[auction_room_connected],
			'avatar':socketMap[k].avatar,*/
			
		}
		
		//console.log("socketMap :");
		//console.log(socketMap);

		//console.log(data);
		//console.log("roomsCount[auction_room_connected] : " + roomsCount[auction_room_connected]);
		//console.log('New User Connected #  Room ID:' + data.auction_room + ' # User ID: ' + data.uid + ' # Socket ID:' + socket.id);
	});
	

	io_bidding.emit("push_connected_users_initially", {
		'connected_users' : roomsCount,
		"roomsCount[auction_room_connected] : " : roomsCount[auction_room_connected],
	});
	
	
	
	
	//receive bid placed event from client
	socket.on('bid_placed', function (data) {
		console.log('------------  BID PLACED OPERATION STARTED -----------');
		console.log(socketMap[socket.id]);
		if(socketMap[socket.id]===undefined)
		{
			console.log('this is our error handler');
			socket.emit('bidding_error', {
				'message' : 'You are not allowed to bid from this browser.'
			});
			return;
		}
		// (sockt.id)
		//console.log("Bid Place Data:");
		//console.log(data);
		//console.log("socketCount : " + socketCount);
		//return false;
		// assign all the data to local variables
		var auc_current_price_new = '';
		var additional_time = '';
		var product_data_arr = [];

		var price_discount_percent_new = '';
		var total_bids_placed = 0;
		var user_id = 0; //this holds the user id fetched from database
		var winner_userid=false;
		var _auction_id = data.aid;
		var _product_id = data.pid;
		var _user_id = data.uid;
		var _bid_amount = data.bid_amount;
		var _bid_increment_new = '';
		var _remaining_time = data.remaining_time;
	
		// var current_date = dateFormat(new Date(), "yyyy-mm-dd HH:MM:ss");
		var current_date=Moment().tz(site_time_zone).format("YYYY-MM-DD H:mm:ss");
		//console.log("Current Date Time : " + current_date);

		auction_room_connected = _auction_id;

		//first of all verify user
		if (_user_id == 'undefined' || _user_id == '' || _user_id == 0) {
			socket.emit('bidding_error', {
				'message' : 'Invalid User'
			});
			return;
		} else if (_product_id == 'undefined' || _product_id == '' || _product_id == 0) {
			socket.emit('bidding_error', {
				'message' : 'Invalid Product'
			});
			return;
		} else if (_bid_amount == 'undefined' || _bid_amount == '' || _bid_amount == 0) {
			socket.emit('bidding_error', {
				'message' : 'Invalid Bid Amount'
			});
			return;
		}
		/*else if (_remaining_time == 'undefined' || _remaining_time=='' || _remaining_time<=0){
		socket.emit('bidding_error',{'message':'This auction is no more live.'});
		return;
		}*/
		
		// console.log("SELECT `id`, `user_id`, `bid_amt` FROM (`emts_user_bids`) WHERE `product_id` = '" + _product_id + "' AND `auction_id` = '" + _auction_id + "' ORDER BY `bid_amt` DESC, `bid_place_date` ASC LIMIT 1;");
	
		var previous_highest_bidder = connection.query("SELECT `id`, `user_id`, `bid_amt` FROM (`emts_user_bids`) WHERE `product_id` = '" + _product_id + "' AND `auction_id` = '" + _auction_id + "' ORDER BY `bid_amt` DESC, `bid_place_date` ASC LIMIT 1;");
		previous_highest_bidder
		  .on("result", function (bidsdata) {
		  	winner_userid=bidsdata.user_id
		  })
		    .on("end", function (bidsdata) {
		 

			 // var old_winner_data = bidsdata;
			 // console.log(bidsdata);
			 console.log('*************************************************************************'); 
			 //console.log(bidsdata.user_id);
			 //console.log(bidsdata.user_id + '=================================' + _user_id);
			 
			// console.log('****************************************************************************');
			 
			 if(winner_userid == _user_id){
				socket.emit('bidding_error', {
					'message' : 'You are already a winner. You cannot place bid'
				});
				//console.log('after emit');
				return false;
			}else{
				

				console.log('starte a bidding proicess');
				//now check whether this user is a valid user or not
			var sql_check_member = connection.query('SELECT id from emts_members where id =' + _user_id);
			sql_check_member
			.on("error", function (error) {
				console.log(error);
				socket.emit('bidding_error', {
					'message' : 'Error Occured'
				});
			})
			.on("result", function (user_data) {
				user_id = user_data.id;
				//console.log("Users Data : " + user_data);
			})
			.on("end", function () {
				if (user_id == _user_id) {
					// console.log("User Exists");
	
					//NOW CHECK PRODUCT PART AND MAKE UPDATES
					//console.log('------------  STARTED TO CHECK PRODUCT -----------');
					var product_data = connection.query('SELECT retail_price, auc_current_price, auc_end_time, status from emts_products where id =' + _product_id);
					//console.log(product_data);
					product_data
					.on('error', function (error) {
						console.log(error);
						socket.emit('bidding_error', {
							'message' : 'No such product found'
						});
						return;
					})
					.on('result', function (pdata) {
						product_data_arr = pdata;
						//console.log(pdata.auc_end_time);
						//console.log('connected as id ' + connection.threadId);
					})
					.on('end', function () {
					var get_bid_increament = connection.query("SELECT increament FROM `emts_bid_increament` where "+ _bid_amount +" >= min AND "+ _bid_amount +" <= max");
					get_bid_increament.on("result",function(increament_data){			
						if(increament_data.increament > 0 )
						{	
						_bid_increment_new = increament_data.increament;
						}else{
						_bid_increment_new = _bid_increment;	
						}
					})
					.on('end', function () {	//console.log(product_data_arr);
						//now check whether product is a valid product or not (product exists or not)
						//check whether this product is live or not
						//check whether bid amount is equal to current bid amount or not
						if (product_data_arr) {
							if (product_data_arr.status == 2) {
								if (product_data_arr.auc_current_price == _bid_amount) {
									//insert bid value to the user_bids table
									connection.query("insert into emts_user_bids (user_id,auction_id,product_id,bid_amt) values( " + _user_id + ",'" + _auction_id + "'," + _product_id + ",'" + _bid_amount + "');",
										function (err, results, field) {
										if (err) {
											console.log("error :" + err.message);

											throw err;
										}
									});
		
									//now calculate current price of this product
									auc_current_price_new = parseInt(_bid_increment_new) + parseInt(_bid_amount);
									price_discount_new = parseInt(product_data_arr.retail_price) - parseInt(auc_current_price_new);
	
									//console.log("New Discount : " + price_discount_new);
	
									//now update product table
									//connection.query("UPDATE emts_products SET `auc_current_price` = " + auc_current_price_new + " WHERE id ='" + _product_id + "';",
									connection.query("UPDATE emts_products SET `auc_current_price` = ? WHERE id = ?", [auc_current_price_new, _product_id], function (err, results, field) {
										if (err) {
											console.log("Error while updating auction current price :" + err.message);
											throw err;
										}
									});
	
									//now fetch total numbers of bids placed
									var count_product_bids_query = connection.query("SELECT COUNT(product_id) as total_bids FROM emts_user_bids WHERE product_id='" + _product_id + "'");
	
									count_product_bids_query
									.on("error", function (error) {
										console.log("Error while calculating prodcuts bids :" + error.message);
										throw error;
									})
									.on("result", function (bids_count) {
										//now push the product data into an array when it receives data
										//console.log("Bids Count : " + bids_count.total_bids);
	
										total_bids_placed = bids_count.total_bids;
	
										//console.log(imgdata);
										//console.log('++++++++++++++ Product Bids Count Fetched ++++++++++++++');
									})
									.on("end", function () {
	
										//now check whether reset time is reached or not and reset time if reset time is reached
										console.log('Auction Remaining Time : ' + parseInt(_remaining_time) + ' ### Auction Reset Time :' + parseInt(_reset_time))
										if ((parseInt(_remaining_time) > 0) && (parseInt(_remaining_time) < parseInt(_reset_time))) {
											//reset auction timer to reset time
	

											//Now Calculate Additional Time
											additional_time = parseInt(_reset_time) - parseInt(_remaining_time);
											//console.log("Current Time :" + current_date);
											//console.log("Additional Time : " + additional_time);
											var parsedDate = new Date(Date.parse(current_date));
											var newEndDate = dateFormat(new Date(parsedDate.getTime() + (1000 * _reset_time)), "yyyy-mm-dd HH:MM:ss");
											//var newEndDate = dateFormat(new Date(new Date(Date.parse(current_date)).getTime() + (1000 * _reset_time)),"yyyy-mm-dd HH:MM:ss");
											//get seconds value of enddate time
											var newEndDateStr = (new Date(Date.parse(newEndDate)).getTime()) / 1000;
											//console.log("New End Date in seconds: " + newEndDateStr);
											//console.log("New End Date: " + newEndDate);
	
											//Emit data to clients
											//console.log("namespace :");
											//console.log(io_bidding);
											console.log("auction_room_connected :" + auction_room_connected);
											io_bidding.in(auction_room_connected).emit('update_auc_end_time', {
												'new_show_time' : _reset_time,
												//'new_end_time' : newEndDate,
												'new_end_time' : newEndDateStr,
											});
	
											//Now Update Database
											//console.log("UPDATE emts_products SET `auc_end_time` = '"+newEndDate+"' WHERE id ='" + _product_id + "';");
											connection.query("UPDATE emts_products SET `auc_end_time` = '" + newEndDate + "' WHERE id ='" + _product_id + "';",
												function (err, results, field) {
												if (err) {
													console.log("Error while updating auc end time:" + err.message);
													throw err;
												} else {
													console.log("Database Updated Successfully.");
												}
											});
										}
	
										//now push the product data into an array when it receives data
										//Now prepare outputs to be sent to the clients
	
										//THERE IS DIFFERENCE BETWEEN socket.emit AND io.sockets.emit.
										//the first one (socket.emit) sends response to only one(requesting) client
										//the second one (io.sockets.emit) sends response to all the open connections.
	
										price_discount_percent_new = (product_data_arr.retail_price > 0) ? parseInt((product_data_arr.retail_price - _bid_amount) * 100 / product_data_arr.retail_price) : 0;
										//console.log("auction_room_connected :" + auction_room_connected);
										//console.log("price_discount_percent_new :" + price_discount_percent_new);
										
										
										io_bidding.in(auction_room_connected).emit('bidding_success', {
											'message' : 'Bid Placed Successfully',
											'auc_current_price' : auc_current_price_new,
											'pid' : _product_id,
											'uid' : _user_id,
											'aid' : _auction_id,
											'total_bids_placed' : total_bids_placed,
											'price_discount_percent_new' : price_discount_percent_new
										});
										//console.log('++++++++++++ BID PLACE OPERATION COMPLETED SUCCESSFULLY +++++++++++++++');
										
										//console.log("************** Start of Hand Raising Process *****************");
										console.log('()()()()()()()()'+hand_raised_status)
										if (hand_raised_status===true) {
											//console.log(" NEW USER ID: from bid_broadcast: from if part " + _user_id);
											// previous_hand_raised_user_id  = data.new_user_id;
											//console.log(" PREVIOUS HAND RAISED COUNT  " + previous_hand_raised_bidder);
											//console.log(" HAND_RAISED_COUNT in if  " + hand_raised_status);
											console.log('This is socket id'+socketMap[socket.id]);
											console.log('This is socket id'+dupmap[socket.id]);
											if (previous_hand_raised_bidder == _user_id) {
																
												var img = socketMap[socket.id].avatar;
												var users_handsup_image = img.replace("_down_", "_up_");
												
												console.log("MMMMMMMMMMMMMMMMMMM users_handsup_image" + users_handsup_image);
												console.log(socketMap);
												io_bidding.in(socketMap[socket.id].aid).emit("hand_raise_emit",{
													'position':socketMap[socket.id].position,
													'new_user_id':socketMap[socket.id].uid,
													'avatar':users_handsup_image,
													'aid':socketMap[socket.id].aid,
													'color':previous_user_color,
													'pant_color':previous_user_pant,	

												});	
												previous_user_color=previous_user_color;
												previous_hand_raised_bidder = _user_id; 
												hand_raised_status = true;
												
											} else {
												
												// console.log('hey look ur face'+socketMap[socket.id]);
												var img = socketMap[socket.id].avatar;
												console.log('this is images'+img);
												var users_handsup_image = img.replace("_down_", "_up_");
												 // var prevcolor =socketMap[socket.id].color;
												console.log("DDDDDDDDDDDDDDDDDD users_handsdown_prev_image" + hand_down_broadcast_image);
												 	console.log(socketMap);
												io_bidding.in(socketMap[socket.id].aid).emit("hand_raise_emit",{
													'position':socketMap[socket.id].position,
													'new_user_id':socketMap[socket.id].uid,
													'avatar':users_handsup_image,
													'aid':socketMap[socket.id].aid,
													'color':socketMap[socket.id].color,
													'pant_color':socketMap[socket.id].pant_color
												});
												
												//console.log("DDDDDDDDDDDDDD hand_down_broadcast_image" + hand_down_broadcast_image);
											
												//Uncommented by Suba
												io_bidding.in(socketMap[socket.id].aid).emit("hand_down_broadcast", {
													'new_user_id' : previous_hand_raised_bidder,
													'avatar':hand_down_broadcast_image,
													'color':previous_user_color,
													'pant_color':previous_user_pant

												});
													hand_down_broadcast_image =img;
												//End of the uncomment
													previous_hand_raised_bidder = _user_id; 
													previous_user_color=socketMap[socket.id].color;
												previous_hand_raised_current_user_id = socketMap[socket.id].uid;
												previous_hand_raised_current_user_image=socketMap[socket.id].avatar;
												
												hand_raised_status = true;
												
												
												
											}
											
											console.log("IF previous_hand_raised_current_user_id");
											console.log(previous_hand_raised_current_user_id);
								
										} else {
											
											//console.log(" NEW USER ID: from bid_broadcast: from else part" +data.bidder_user_id);
											//console.log("bid_broadcast from the else part::: ");
											
											//console.log("########################PREVIOUS_HAND_RASISED_BIDDER_#########")
											
											// current user if previous user for upcoming biddinbg process
											previous_hand_raised_bidder = _user_id; 
										
											
											for (var k in socketMap){
												if (socketMap.hasOwnProperty(k)) {
													
													if(parseInt(data.aid)==parseInt(socketMap[k].aid)){
														if(parseInt(data.uid)==parseInt(socketMap[k].uid)){
																	console.log("!&%$%^HAND_DOWN_BROADCAST_IMAGE&%$#@^",socketMap[k].avatar);
															hand_down_broadcast_image = socketMap[k].avatar;
															aucid=data.aid;
															previous_user_color=socketMap[k].color;
															previous_user_pant=socketMap[k].pant_color;
																													}
													}
												}
													var users_handsup_image = socketMap[socket.id].avatar.replace("_down_", "_up_");
											}
					
										console.log('^^^^^^^^^^^^^^^^^'+users_handsup_image);
											
											//previous_hand_raised_current_user_image = '';
											
											// io_bidding.in(socketMap[socket.id].aid).emit("hand_down_broadcast", {
											// 	'position' : socketMap[socket.id].position,
											// 	'new_user_id' : previous_hand_raised_current_user_id,
											// 	'avatar':previous_hand_raised_current_user_image	
											// });
											
											io_bidding.in(_auction_id).emit("hand_raise_emit", {
												'position' : socketMap[socket.id].position,
												'new_user_id' : socketMap[socket.id].uid,
												'avatar': users_handsup_image,
												'aid' : aucid,
												'color':socketMap[socket.id].color,
												'pant_color':socketMap[socket.id].pant_color
											});
								
											hand_raised_status = true;
											
											// console.log("ELSE previous_hand_raised_current_user_id");
											// console.log(previous_hand_raised_current_user_id);
										}
									});
								} else {
									//console.log('Invalid Bid Amount');
									socket.emit('bidding_error', {
										'message' : 'Invalid Bid Amount.'
									});
									return;
								}
							} else {
								socket.emit('bidding_error', {
									'message' : 'This product is no more live.'
								});
								return;
							}
						} else {
							socket.emit('bidding_error', {
								'message' : 'This product does not exists.'
							});
							return;
						}
					});
				});
					//console.log('++++++++++++ END INVOKED +++++++++++++++');
				} else {
					socket.emit('bidding_error', {
						'message' : 'No such user found'
					});
					//console.log("Such User doesnot exists");
				}
			});
				
				
					
			}
		})
		.on("error",function(error){
			console.log('This is user find error');	
			//console.log("SELECT `user_id`, `bid_amt` FROM (`emts_user_bids`) WHERE `product_id` = '" + _product_id + "' AND `auction_id` = '" + _auction_id + "' ORDER BY `bid_amt` DESC, `bid_place_date` ASC LIMIT 1;");  
		});
		
			//console.log('****************************************************************************');
			 
			
			
		
		
		
	});
	
	
	//Listener to broadcast the hand down when needed.	
	socket.on('hand_down_broadcast', function (data) {
		//hand_raised_status = false;
		//previous_hand_raised_current_user_image = '';
		
		console.log("HAND_DOWN_BROADCAST LISTENER IN SERVER:::: " +data.new_user_id);
		//console.log("11111111111111111111HAND_DOWN_BROADCAST_IMAGE11111111111111111111:",data.avatar);

		io_bidding.in(socketMap[socket.id].aid).emit("hand_down_broadcast",{
			'new_user_id':data.new_user_id,
			'avatar':data.avatar,
			'color': data.color,
			'pant_color':data.pant_color
		});
		
	});
	
	

	socket.on('new_chat_message', function (data) {
		//console.log(data);
		if (data.aid != '' && data.sender_id != '' && data.message != '') {
			// var current_date = dateFormat(new Date(), "yyyy-mm-dd HH:MM:ss");
			var current_date=Moment().tz(site_time_zone).format("YYYY-MM-DD H:mm:ss");
			var message = data.message;
			message = message.replace(/[^a-zA-Z ]/g, '');
			if(message != ''){
				var insert_chat = connection.query("INSERT INTO emts_chat (host_id,user_id,message,date) values( " + data.aid + ",'" + data.sender_id + "','" + message + "','" + current_date + "');");
				
				//io_bidding = io.of('/bidding_process');
				//console.log(io_bidding);
				
				io_bidding.in(data.aid).emit("broadcast_chat_message", {
					"sender_name" : data.sender_name,
					"sender_image" : data.sender_image,
					"message" : data.message,
					//"sql" : insert_chat.sql
				});
			}
		}
	});

	socket.on('disconnect', function () {
		console.log('\033[2J');
		console.log('****************** Disconnect Invoked ************************');
		//console.log("DISCONNECTED SOCKET DATA... " + JSON.stringify(socketMap[socket.id]));
		//console.log("socketMap.length :" + Object.keys(socketMap).length);
		//console.log("ConenctionArray.length :" + Object.keys(connectionsArray).length);
		console.log(socketMap);
		//This is when there is no socketMap defined in the fuction(user_connected_mapping).
		if (socketMap[socket.id] === undefined) {
			console.log("%%%%%%%%%%%%%%%% socketMap is not found %%%%%%%%%%%%%%%%%%%%");
			delete socketMap[socket.id];
			console.log("broadcasting to remove the user's from the specific auction_room  " );
			if (roomsCount[auction_room_connected]>0) {
			//now check whether this is unique user or not and make changes to array if it id unique array
			roomsCount[auction_room_connected] = roomsCount[auction_room_connected] - 1;
			//console.log('Auction Room with ID ' + auction_room_connected + ' Found');
			} else {
			roomsCount[auction_room_connected] = 0;
			//console.log('Auction Room with ID ' + auction_room_connected + ' Initialized');
			}		
			// socket.broadcast.to(socketMap[socket.id].aid).emit("hide_unwanted_image", {
			// 					'position' : socketMap[socket.id].position,
			// 					'new_user_id' : socketMap[socket.id].uid
			// 				});
		} else {
			//The specific user at the specific auction is deleted and broadcasted to all the user's at that acution.
			
			var socketIndex = connectionsArray.indexOf(socket);
			//console.log('socketID = %s got disconnected', socketIndex);
			if (~socketIndex) {
				connectionsArray.splice(socketIndex, 1);
			}
			
			for (var k in socketMap) {
				//console.log("From the else without zero..");
				if (socketMap.hasOwnProperty(k)) {
					//console.log("From the else without zero..");
					
					if (parseInt(socketMap[socket.id].aid) == parseInt(socketMap[k].aid)) {
						//console.log("Inside the Auction Room Check..");
						if (parseInt(socketMap[socket.id].uid) == parseInt(socketMap[k].uid)) {
							//console.log("From user comparison..");
							position_array.splice(socketMap[socket.id].position, 0, socketMap[socket.id].position);
							//now check whether this is unique user or not and make changes to array if it id unique array
							if (roomsCount[auction_room_connected]>0) {
			//now check whether this is unique user or not and make changes to array if it id unique array
							roomsCount[auction_room_connected] = roomsCount[auction_room_connected] - 1;
							//console.log('Auction Room with ID ' + auction_room_connected + ' Found');
							} else {
							roomsCount[auction_room_connected] = 0;
							//console.log('Auction Room with ID ' + auction_room_connected + ' Initialized');
							}	
							//console.log('Auction Room with ID ' + auction_room_connected + ' Found');
						
							console.log("broadcasting to remove the user's from the specific auction_room " + socketMap[socket.id].uid);
							socket.broadcast.to(socketMap[socket.id].aid).emit("hide_unwanted_image", {
								'position' : socketMap[socket.id].position,
								'new_user_id' : socketMap[socket.id].uid
							});
						}
					}
				}
			}
			//After checking the user's at the specific auction, then there is need to leave the socketMap and delete the specific socketMap
			//leave socket
			socket.leave(socketMap[socket.id].aid);
			
			//decrease roomscouint value
			// roomsCount[socketMap[socket.id].aid] = roomsCount[socketMap[socket.id].aid] - 1;
			
			//delete socket data
			delete socketMap[socket.id];
				console.log(socketMap);
		}
		
		console.log('****************** End of Disconnect Function ************************');
	});

	//console.log('A new socket is connected!');
	//console.log(JSON.stringify(socketMap));
	
	//console.log(connectionsArray);
});