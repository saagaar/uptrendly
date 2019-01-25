jQuery(document).ready(function($) {

    //function to check all the messages in batch by check box
    $("#msg_all").click(function() {
            $(".msg_row").prop("checked", $("#msg_all").prop("checked"))
        })
        //end of check in batch function


    $("#btnGo").click(function() {
        $("#adminInboxForm").validate({
            submitHandler: function(form) {

                var option_conversation_actions = $("#conversationAction").val();

                if (option_conversation_actions == '') {
                    $('#mail_error').html('<div class="bg-danger" style="display:block;"><strong>Warning! </strong>Select action<p class="text-success"></p></div>');
                    //alert("Please select more action"); 
                    return false;
                } else if ($(".msg_row:checkbox:checked").length > 0) {
                    form.submit();
                } else {
                    $('#mail_error').html('<div class="bg-danger" style="display:block;"><strong>Warning! </strong>Select message<p class="text-success"></p></div>');
                    //alert('Please select message'); 
                    return false;
                }
            }
        }); //formid validate
    }); //formid validate

    $("#btnConversationGo").click(function() {
        $("#adminInboxForm").validate({
            submitHandler: function(form) {

                var option_conversation_actions = $("#conversationAction").val();

                if (option_conversation_actions == '') {
                    $('#mail_error').html('<div class="bg-danger" style="display:block;"><strong>Warning! </strong>Select action<p class="text-success"></p></div>');
                    //alert("Please select more action"); 
                    return false;
                }
                form.submit();
            }
        }); //formid validate
    }); //formid validate



});