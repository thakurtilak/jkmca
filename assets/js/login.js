/**
 * Created by Dharmendra.thakur on 01/09/18.
 */

$(document).ready(function(){
    //alert('YES');
    $("#login").validate({
        /*submitHandler: function(form) {
            return false;
            //$(form).submit();
        },*/
        rules:{
            username:{
                required:true
            },
            password:{
                required:true
            }
        },
        messages:{
            username:{
                required: "Username can't be empty"
            },
            password:{
                required:"password can't be empty"
            }
        }
    });
});