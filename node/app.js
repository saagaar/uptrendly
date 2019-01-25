var http = require('http');
var mysql = require('mysql');

/**
 *used for reading writing file system
 **/
var fs = require('fs');
var app = http.createServer(handler);
var io = require('socket.io').listen(app, {
		log : false,
		//log : true,
	});
var contentType = 'text/html';
var Moment = require('moment-timezone');
/**
*	handler for http package
**/
function handler(req, res) {
	console.log(__dirname);
	
	fs.readFile(__dirname + '/../index.php', function (err, data) {
		if (err) {
			// console.log(err);
			res.writeHead(500);
			return res.end('Error loading index.php');
		}
		res.writeHead(200,{ 'Content-Type': contentType });
		res.end(data,'utf-8');
	});
}
/*All global variables initialize here*/
var port_number=8000;
var current_chat_room='';
var roomsCount = {}; //an object that holds the numbers of users in each room
var socketMap = {}; //an object that holds information of users, socket and room(aid)
var user_id=0;
var receiver_id=0;
var site_time_zone = '';

/**
 * listening to socket port for receiving data from client
 */
app.listen(process.env.PORT || port_number, function () {
	// console.log('Listening at Server Localhost:' + port_number);

});

/**
 *	mysql connection string
 **/
var connection = mysql.createConnection({
  host     : 'localhost',
  user     : 'root',
  password : 'emts123',
  database : 'emts_uptrendly'
});

/*GEt site settings data*/
	var site_info = connection.query('SELECT * from emts_site_settings');
	site_info
		.on("result", function (site_data) {

			site_time_zone = site_data.timezone;

		});
	


/**
 *	Connecting mysql database
**/
connection.connect(function (error) {
	if (error) {
		// console.log('Error establishing connection to Database');
		// console.log(error);
		//return false;
	} else {
		// console.log('Connection established to Database');
		// console.log('Mysql Connected as id ' + connection.threadId);
	}
});

io.on('connection', function(socket) {  
    // console.log('Client to room connection test...');

    socket.on('connect_chat_room',function(data){
    	current_chat_room = data.bidid;
    	// console.log(current_chat_room);
   	console.log('^^^^^^^^^^^^^current user: '+data.sender_id+'^^^^^^^^^^^^^');
    	user_id=data.sender_id;
    	console.log("SELECT * FROM emts_product_bids b JOIN emts_products a ON b.product_id=a.id WHERE b.id='"+current_chat_room+"' and (b.user_id='"+user_id+"' OR a.brand_id='" + user_id + "')");
    	var sql="SELECT * FROM emts_product_bids b JOIN emts_products a ON b.product_id=a.id WHERE b.id='"+current_chat_room+"' and (b.user_id='"+user_id+"' OR a.brand_id='" + user_id + "')";
    	var check_if_user_allowed = connection.query(sql, function(err, result) {
    	console.log(result.length);
    	if(result.length>0)
    	{
		 	socket.join(current_chat_room);
		 	console.log('****************connnected to room:'+current_chat_room+' *******************');
    	}	
    	else
    	{
    		user_id=0;
    		console.log('Authorize error');
    		socket.emit('chat_init_error',{

    			bidid:current_chat_room,
    			error_message:'You are Not authroized to be here!!',

    		});
    	}
		});
    })
  
 socket.on("is_user_connected_already",function(data)
{

	// console.log('**************We are in testing if user already connected*******************');
	var msg='no';
			for (var k in socketMap) {
				if (socketMap.hasOwnProperty(k)) {
					var str = JSON.stringify(socketMap[k], null, 4); // (Optional) beautiful indented output.
					
						if (parseInt(data.bidid) === parseInt(socketMap[k].bidid)) {
							if (parseInt(data.sender_id) == parseInt(socketMap[k].sender_id)) {
										 msg='yes';
										 socketMap[socket.id] = 
										 {
											'sender_id' : data.sender_id,
											'bidid' : current_chat_room,
											'avatar':data.avatar,
										 };
								}
						}
				}
			}
			console.log('------->check if user connected already----->-->>'+roomsCount[current_chat_room]);
			
			console.log(socketMap);
			socket.emit("already_connected", 
			{
							'msg':msg,
							'user_count':roomsCount[current_chat_room]

			});
			
});

socket.on('connect_user_to_chatroom',function(data)
{
	console.log('**************we are insdite chat********');
	var currentuseravailable='no';
	var roomsCountavailable='no';
	for (var k in socketMap) 
	{
		if (socketMap.hasOwnProperty(k)) {
			var str = JSON.stringify(socketMap[k], null, 4); // (Optional) beautiful indented output.
			user_id=data.sender_id;
				if (parseInt(current_chat_room) === parseInt(socketMap[k].bidid)) 
				{
					roomsCountavailable	='yes';
					if (parseInt(data.sender_id) == parseInt(socketMap[k].sender_id))
					{
							 currentuseravailable='yes';
					}
				}
		}
	}

				
		if(roomsCountavailable=='no')
		{
			roomsCount[current_chat_room]=1;	
		}
		else{
				if(currentuseravailable=='no')
				{
					roomsCount[current_chat_room]=roomsCount[current_chat_room]+1;	
				}
		}
			
		if(roomsCount[current_chat_room]==2)
		{
			console.log('**************Inside online user status*********');
			socket.broadcast.to(current_chat_room).emit('user_status_available');
		}
		socketMap[socket.id] = 
		{
				'sender_id' : data.sender_id,
				'bidid' : current_chat_room,
				'avatar':data.avatar,
		};
console.log(socketMap);

	
	console.log('---------Room count from chatroom------------>>'+roomsCount[current_chat_room]);
		
});

/**
 * Instant messaging listner
 */
socket.on('send_instant_message',function(data)
{
	console.log(current_chat_room);
	console.log('***************Inside Message Sent***************');
	var message=data.message;
	var bidid=data.bidid;
	var sender_id=data.sender_id;
	current_date = Moment().tz(site_time_zone).format("YYYY-MM-DD H:mm:ss");
	var sql="SELECT b.id,b.status,a.id as product_id,md1.name as bidder_name,md1.user_id as bidder_id,md1.cover_image as bidder_image,md2.name as brand_name,md2.cover_image as brand_image ,md2.user_id as brand_id FROM emts_product_bids b JOIN emts_products a ON b.product_id=a.id left join emts_members_details md1 on (b.user_id=md1.user_id) left join emts_members_details md2 on(a.brand_id=md2.user_id) WHERE b.id='"+current_chat_room+"' limit 1";
    	var getuserdetails = connection.query(sql, function(err, row) {
    		if(err)
    		{
    			console.log('error occured while getting data : ' + err.message);
				throw err;
    		}
    		else
    		{
    			var bidder_id=row[0].bidder_id;
    			var brand_id=row[0].brand_id;
    			var status=row[0].status;
    			var product_id =row[0].product_id;
    			if(sender_id==bidder_id)
    			{
    				var name=row[0].bidder_name;
    				// var avatar=row[0].bidder_image;
    				var total_users=roomsCount[current_chat_room];
    				var receiver_id=brand_id;
    			}
    			if(brand_id==sender_id)
    			{
    				var name=row[0].brand_name;
    				// var avatar=row[0].bidder_image;
    				var total_users=roomsCount[current_chat_room];
    				var receiver_id=bidder_id;
    			}
    			console.log(sender_id+'-->'+name);	
    			connection.query("INSERT INTO emts_communication (bid_id, product_id, receiver_id, sender_id, message, messagedate, bid_status) VALUES ('"+current_chat_room+"', '"+product_id+"', '"+receiver_id+"', '"+sender_id+"','"+message+"','"+current_date+"', '"+status+"')",
				function (err, results, field) {
					if (err) {
						console.log('error occured while updating auction start end time' + err.message);
						throw err;
					}
				});

				io.in(current_chat_room).emit('message_sent',{name:name,avatar:data.avatar,message:message,total_users:total_users,sender_id:sender_id,receiver_id:receiver_id,time:current_date});
    			 
				console.log('***************Message Send Successfully***************');
    		}
    		
})
});
/*End of instant messaging listner*/

socket.on('manual_disconnect',function(){
	console.log('*****************Manual Disconnect**************');
	if (io.sockets.sockets[socket.id]) 
	{
    	io.sockets.sockets[socket.id].disconnect();
	}
});
socket.on('disconnect', function () 
	{
	console.log('******************Disconnect Invoked*****************');
	var ispresent='no';
	var roomsavailable='yes';
	socket.leave(current_chat_room);
	if(socketMap[socket.id]!==undefined)
	{

		user_id=socketMap[socket.id].sender_id;
		delete socketMap[socket.id];
		for (var k in socketMap) 
					{
						if (socketMap.hasOwnProperty(k)) {
							var str = JSON.stringify(socketMap[k], null, 4); // (Optional) beautiful indented output.
								if (parseInt(current_chat_room) == parseInt(socketMap[k].bidid)) 
								{	
										if (parseInt(user_id) == parseInt(socketMap[k].sender_id)) 
										{
												ispresent='yes';
										}
								}	
						}
					}
					 socket.broadcast.to(current_chat_room).emit('available_status_remove');
					if(ispresent=='no')
					{
						roomsCount[current_chat_room]=roomsCount[current_chat_room]-1;
					}	
					delete socket.id;
					console.log('*********************'+ispresent+'***********'+roomsCount[current_chat_room]);		
					console.log(socketMap);

	}
	else
	{
		console.log('-------down here------'+socket.id);
		console.log(current_chat_room);
				delete socketMap[socket.id];
				delete socket.id;
				console.log(socketMap);

				roomsCount[current_chat_room]=roomsCount[current_chat_room]-1;
			 	socket.broadcast.to(current_chat_room).emit('available_status_remove');
	}
	
});
});