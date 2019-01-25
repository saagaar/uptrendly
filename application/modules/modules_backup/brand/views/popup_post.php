<script src="https://platform.instagram.com/en_US/embeds.js"></script>
<div class="modal fade" id="myModal" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="user_profile_pop">
      <div class="up_container">
        

          <div class="plugin_sec" id="plugin_sec">
                
          </div>
          <div class="up_detail" >
            <div class="up_desc" style="display: block;">
              <p style="white-space: pre"></p>
            </div>
            <div class="up_stat">
              <ul>
                <li class="col-sm-4 no-pad-sides">
                  <h2>
                    <span>
                      Views
                    </span>
                  <div id="views">  0 </div>
                  </h2>
                </li>
                <li class="col-sm-4 no-pad-sides">
                  <h2>
                    <span>
                      Likes
                    </span>
                    <div id="likes">  0 </div>
                  </h2>
                </li>
                <li class="col-sm-4 no-pad-sides">
                  <h2>
                    <span>
                      Comments
                    </span>
                   <div id="comments"> 0 </div>
                  </h2>
                </li>
              </ul>
              <div class="clearfix"></div>
            </div>
          </div>              
        </div>
      </div>
    </div>

  </div>

</div>

<script type="text/javascript">
	
	 $(document).on('click','.modalprofile',function(){
    $('#myModal').modal();
    var url=$(this).data('url')
    var media=$(this).data('media');
    if(media=='youtube')
    {
      var iframe='<iframe width="500" height="315" src="https://www.youtube.com/embed/'+url+'" frameborder="0" allowfullscreen></iframe>';
     var desc=$(this).data('description');
     var likes=$(this).data('likes');
     var views=$(this).data('views');
     var comments=$(this).data('comments');
     $('#myModal').find('.plugin_sec').html(iframe);
     $('#myModal').find('.up_desc p').html(desc);
      $('#myModal').find('.up_stat').removeClass('hidden');
     $('#myModal').find('#views').html(views);
     $('#myModal').find('#comments').html(comments);
     $('#myModal').find('#likes').html(likes);
    }
    if(media=='facebook')
    {
   
      $.ajax({
        url:embed_posturl,
        dataType:'html',
        data:{url:url,mediatype:'facebook'},
        method:'get',
        success:function(data){
          $('#myModal').find('.plugin_sec').html(data);
          $('#myModal').find('.up_desc p').html('');
          $('#myModal').find('.up_stat').addClass('hidden');
          FB.XFBML.parse();
        }
       })
    }
    if(media=='twitter')
    {
      
       $.ajax({
        url:'https://publish.twitter.com/oembed?url='+url+'&omit_script=true',
        dataType:'jsonp',
        // data:{url:url},
        method:'get',
        success:function(data){
          console.log(data);
          
          $('#myModal').find('.plugin_sec').html(data.html);
          $('#myModal').append('<script async src="//platform.twitter.com/widgets.js" charset="utf-8">'); 
          $('#myModal').find('.up_desc p').html('');
          $('#myModal').find('.up_stat').addClass('hidden');
        }
       })
    }
    if(media=='instagram')
    {
    	$('#myModal').find('.plugin_sec').html('');
    	// alert(url);
    	$.ajax({
        url:'https://api.instagram.com/oembed?url='+url,
        dataType:'jsonp',
        // data:{url:url},
        method:'get',
        success:function(data){
          console.log(data);
          
          $('#myModal').find('.plugin_sec').html(data.html);
          instgrm.Embeds.process();
          // $('#myModal').find('.plugin_sec').append('<script async src="//platform.twitter.com/widgets.js" charset="utf-8">'); 
          $('#myModal').find('.up_desc p').html('');
          $('#myModal').find('.up_stat').addClass('hidden');
        }
       })
    }
    
  })
</script>