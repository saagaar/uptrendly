$("#addreport").validate({
        submitHandler: function(form) {
           
           form.submit();
        },
        errorElement: "div",
        rules: {
            
            page_like: {
                required: true,
                digits:true   
                
            },
            profile_like: {
                required: true,
                  digits:true      
            },
            instagram_like: {
                required: true,
                 digits:true
            },
            page_comment: {
                required: true,
                digits:true
            },
            profile_comment: {
                required: true,
                 digits:true
            },
            instagram_comment: {
                required: true,
                digits:true
            },
            page_share: {
                required: true,
                 digits:true
            },
            profile_share: {
                required: true,
                digits:true
            },
           
        },
        
    });//formid validate