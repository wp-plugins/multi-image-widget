/* 
 * js file.
 */
var upload_image_button = false;
jQuery(document).ready(function($) {

    var miw_uploader;
    var widgetid;
    var widgetname;
    var next_upload_btn;

    $('.miw_upload_image').live("click", function(e) {
        e.preventDefault();
        /*
         *Initialize the two variable : widgetid and widgetname
         *Because it is used to identify the unique field with unique widget. 
         */
        widgetid = $(this).data('widgetid');
        widgetname = $(this).data('widgetname');
        next_upload_btn = $(this).data('next_uploadedbtn');

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
            var width = attachment.width;
            var height = attachment.height;
            // alert(widgetid+""+widgetname+imgurl);
            //************* Add values to the : widget : field :**************
            $("img." + widgetid + "" + widgetname).attr('src', imgurl);
            $("input." + widgetid + "" + widgetname).val(imgurl);
            $("div." + widgetid + "" + widgetname).removeClass("miw_off");
            $("div." + widgetid + "" + widgetname).removeClass("miw_on");
            $(".miw_addmore").attr("data-nextbtn", next_upload_btn);

            //************* Add values to the : widget : field :END **************
        });

        //Open the uploader dialog
        miw_uploader.open();

    });


    /*
     *When click on the Add More button. 
     */
    $('.miw_addmore').live("click", function(e) {

        var widgetid = $(this).attr("data-widgetid");
        var widgetname = $(this).attr("data-nextbtn");

        $("div.upload_btn-" + widgetid + "" + widgetname).removeClass("miw_off");
        $("div.upload_btn-" + widgetid + "" + widgetname).addClass("miw_on");
    });
    /*
     *When click on the "Delete" button :complete
     */
    $(".delete").live('click', function() {
        var delete_field = $(this).attr("data-val");

        $("img." + delete_field).attr("src", "");  //first blank this image
        $("input." + delete_field).val(""); //blank this value
        
    });

//Below dom ready 
});
