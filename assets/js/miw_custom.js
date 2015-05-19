/* 
 * js file.
 */
var upload_image_button = false;
jQuery(document).ready(function($) {

    var miw_uploader;
    $('.upload_image_button').live("click", function(e) {
        e.preventDefault();
        /*
         * This variable is used to show the other field option : like :upload lin,uploaded image and it's redirecting option.
         */
        var formfieldID_current = jQuery(this).attr("name");
        /*
         *Next uploaded button field option: 
         */
        var data_nextval = $(this).attr("data-nextval");
        /*
         *uplaod the current and next value to the hidden value so that we can use it once image have been uploaded. 
         */
        $(".miw_current_running_value").attr("data-current",formfieldID_current);
        $(".miw_current_running_value").attr("data-next",data_nextval);
        //If the uploader object has already been created, reopen the dialog
        if (miw_uploader) {
            miw_uploader.open();
            return;
        }
        //Extend the wp.media object
        miw_uploader = wp.media.frames.file_frame = wp.media({
            title: 'Multi Image upload option',
            button: {
                text: 'Upload Image'
            },
            multiple: false
        });

        //When a file is selected, grab the URL and set it as the text field's value
        miw_uploader.on('select', function() {
            attachment = miw_uploader.state().get('selection').first().toJSON();
            /*
             *Image attribute : imageurl , width and height 
             */
            var imgurl = attachment.url;
            var width  = attachment.width;
            var height = attachment.height;
           
           /*
            *Getting the current and next value. 
            */
           
            var formfieldID_current =$(".miw_current_running_value").attr("data-current");
            var data_nextval        =$(".miw_current_running_value").attr("data-next");
        
        //image attribute information.
            jQuery("img." + formfieldID_current).attr("src", imgurl);
            jQuery("img." + formfieldID_current).attr("width",width);
            jQuery("img." + formfieldID_current).attr("height",height);
            
            jQuery("input[type=hidden]." + formfieldID_current).val(imgurl);
            //enable div also 
            $(".field-options-" +formfieldID_current).removeClass("mycustom_off");
            $(".field-options-" +formfieldID_current).addClass("mycustom_on");
            /*
             *Update the nextval value to the :addmore: button 
             */
            $(".addmore").attr("data-val",data_nextval);//alert(data_nextval);
            
        });

        //Open the uploader dialog
        miw_uploader.open();

    });

    /*
     *When click on the "addmore" then we will provide the new button. 
     */
    $(".addmore").live('click', function() { //alert("test");
        var click_btn = $(this).attr("data-val");//alert(click_btn);
        $(".upload-button-" + click_btn).removeClass("mycustom_off");
        $(".upload-button-" + click_btn).addClass("mycustom_on");

    });

    /*
     *When click on the "Delete" button :complete
     */
    $(".delete").live('click', function() {
        var delete_field = $(this).attr("data-val");

        $("img." + delete_field).attr("src", "");  //first blank this image
        $("img." + delete_field).css("display", "none"); //hide this image 
        $("input." + delete_field).val(""); //blank this value
        $(".upload-link-"+delete_field).css("display", "none"); //hide this link and open new window link also.
        $(".del-"+delete_field).css("display", "none"); //disable delete button :current
    });

//Below dom ready 
});
