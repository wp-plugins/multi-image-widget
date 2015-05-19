<?php
/*
 * Widget => Appearence -> widgets
 * Ref : for slider: http://www.jssor.com/download-bootstrap-carousel-slider-example.html
 */

// Creating the widget 
class miw_image_widget extends WP_Widget {

    function __construct() {

        parent::__construct(
// Base ID of your widget
                'miw_multi_image_widget',
// Widget name will appear in UI
                __('Multi image widget', 'miw'),
// Widget description
                array('description' => __('Multi image widget for uploading the multiple image.', 'miw'),)
        );
    }

// Creating widget front-end
// This is where the action happens
    public function widget($args, $instance) {
        $title = apply_filters('widget_title', $instance['title']);
// before and after widget arguments are defined by themes
        //Call the class :functions
        $objFun = new miw_functions();

        echo $args['before_widget'];
        if (!empty($title))
            echo $args['before_title'] . $title . $args['after_title'];

        /*
         * widget type  :
         * Value : linear : in this way,images are showing one by one.
         * slider: crousel slider will be shown.
         */
        $widget_type = "";
        if (isset($instance['widget_type'])) {
            $widget_type = $instance['widget_type'];
        }

        if ($widget_type == "slider") {
            ?>
            <div id="owl-demo" class="owl-carousel owl-theme"> 
                <?php
                echo $objFun->miw_generate_list_loop($instance, "div");
                ?>
            </div>     
            <?php
        } else {
            ?>
            <!-- 
            @shankaranand , Expert in wordpress programming
            Email me : shankranand.mca@gmail.com : subject: Multi image upload plugin
            -->   
            <div class="miw-container">
                <ul class="miw">
                    <?php
                    echo $objFun->miw_generate_list_loop($instance, "li");
                    ?>
                </ul>    
            </div>
            <?php
        }//else part end.
        //after widget.
        echo $args['after_widget'];
    }

// Widget Backend 
    public function form($instance) {

        $title = "";
        if (isset($instance['title'])) {
            $title = $instance['title'];
        }

        $widget_type = "";
        if (isset($instance['widget_type'])) {
            $widget_type = $instance['widget_type'];
        }
// Widget admin form
        ?>
        <div class="mycustom-widget">
            <p>
                <label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:'); ?></label> 
                <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo esc_attr($title); ?>" />
            </p>

            <!-- Widget type : slider / simple -->  
            <p>
                <label for="<?php echo $this->get_field_id('widget_type'); ?>"><?php _e('Widget Type:'); ?></label> 
                <select class="widefat" id="<?php echo $this->get_field_id('widget_type'); ?>" name="<?php echo $this->get_field_name('widget_type'); ?>">
                    <option value="linear" <?php echo ($widget_type == "linear") ? "selected" : ""; ?> ><?php echo __( 'Linear Image', 'miw' );?></option>
                    <option value="slider" <?php echo ($widget_type == "slider") ? "selected" : ""; ?> ><?php echo __( 'Slider Image', 'miw' );?></option>
                </select>    
            </p> 

            <p><?php echo __( 'You can upload maximum 10 image', 'miw' );?></p>
           <!--
           Current running value of the : Next uploaded value , current uploaded value.
           -->
           <input type="hidden" class="miw_current_running_value" data-current="" data-next="" value="1">
            <?php
            /*
             * Get total upload field option and show the 1st field option. 
             * Remaining will be shown when click on "Add More " button.
             * MIW_TOTAL_UPLOAD_FIELD_OPTION : start from 1
             * MIW_UPLOAD_OPTION_PREFIX      : Add the prefix
             */
            $total_field = MIW_TOTAL_UPLOAD_FIELD_OPTION;
            $prefix_opt = MIW_UPLOAD_OPTION_PREFIX;
            /*
             * To know how many images are uploaded.so that when click on "Add More" button then new upload field will be visible.
             */
            $add_more = "";

            if ($total_field > 0) {
                for ($i = 1; $i <= $total_field; $i++) {
                    $widget_name = $prefix_opt . $i; //widget name
                    $widget_name_next = $prefix_opt . "" . ($i + 1);
                    /*
                     * widget value from db
                     */
                    $imgURL = "";
                    if (isset($instance[$widget_name])) {
                        $imgURL = $instance[$widget_name];

                        if (empty($imgURL) AND $add_more == "") {
                            $add_more = $widget_name;
                        }
                    }
                    //link of the image
                    $linkImg = "";
                    if (isset($instance["link_" . $widget_name])) {
                        $linkImg = $instance["link_" . $widget_name];
                    }
                    //open in windows.
                    $linktarget = "_self";
                    if (isset($instance["target_" . $widget_name])) {
                        $linktarget = $instance["target_" . $widget_name];
                    }
                    ?>
                    <div class="miw-<?php echo ($i % 2 == 0) ? "even" : "odd"; ?>">
                        <!--
                        Feature : 1st image is everything on so that anyone can upload the image . 
                        For adding more image, you need to click on "Add More" button.
                        -->

                        <div data-nextval="<?php echo $widget_name_next; ?>" class="upload-file-container upload-button-<?php echo $widget_name;
                echo (empty($imgURL) AND $i != 1) ? ' mycustom_off' : ' mycustom_on'; ?> ">
                            <!-- <label for="<?php echo $this->get_field_id($widget_name); ?>"><?php _e('Upload File'); ?></label>  -->
                            <input data-nextval="<?php echo $widget_name_next; ?>" class="upload_image_button  button button-primary widget-control-save" name="<?php echo $widget_name; ?>"  type="button" value="Select an Image <?php echo $i; ?>" />
                        </div> 


                        <div class="field-options-<?php echo $widget_name;
                echo (empty($imgURL)) ? ' mycustom_off' : ' mycustom_on'; ?>">  
                            <figure class="upload-thumb">
                                <img src="<?php echo $imgURL; ?>" class="uploaded_img <?php echo $widget_name; ?>" />
                                <img class="delete del-<?php echo $widget_name; ?>" data-val="<?php echo $widget_name; ?>" src="<?php echo MIW__PLUGIN_URL; ?>assets/images/Delete.png" alt="delete" />
                                <input type="hidden" name="<?php echo $this->get_field_name($widget_name); ?>" class="<?php echo $widget_name; ?>" id="<?php echo $this->get_field_id($widget_name); ?>" value="<?php echo $imgURL; ?>" />
                            </figure>
                            <!-- Link of this image  --> 
                            <div class="upload-link upload-link-<?php echo $widget_name; ?>">
                                <label for="<?php echo $this->get_field_id("link_" . $widget_name); ?>"><?php _e('Link'); ?></label> 
                                <input type="url" name="<?php echo $this->get_field_name("link_" . $widget_name); ?>" id="<?php echo $this->get_field_id("link_" . $widget_name); ?>" value="<?php echo $linkImg; ?>" />
                            </div>

                            <!-- open in tab  --> 
                            <div class="miw-container-loop-last upload-link upload-link-<?php echo $widget_name; ?>">
                                <label for="<?php echo $this->get_field_id("target_" . $widget_name); ?>"><?php _e('Target Link'); ?></label> 
                                <select class="widefat open-in-link" name="<?php echo $this->get_field_name("target_" . $widget_name); ?>" id="<?php echo $this->get_field_id("target_" . $widget_name); ?>">
                                    <option value="_self" <?php echo ($linktarget == "_self") ? "selected" : ""; ?>  ><?php echo __( 'Stay in Window', 'miw' );?></option>
                                    <option value="_blank" <?php echo ($linktarget == "_blank") ? "selected" : ""; ?> ><?php echo __( 'Open New Window', 'miw' );?></option>
                                </select>
                            </div>

                        </div>

                    </div>
                    <?php
                }//end for loop.
            }//count condition > 0 
            ?>
            <a href="javascript:void(0);" class="addmore button button-primary" data-val="<?php echo $add_more; ?>" ><?php echo __( 'Add More.', 'miw' );?></a>   
        </div>   
        <?php
    }

// Updating widget replacing old instances with new
    public function update($new_instance, $old_instance) {
        $instance = array();
        $instance['title'] = (!empty($new_instance['title']) ) ? $new_instance['title'] : '';
        $instance['widget_type'] = (!empty($new_instance['widget_type']) ) ? $new_instance['widget_type'] : '';
        /*
         * other values
         */
        $total_field = MIW_TOTAL_UPLOAD_FIELD_OPTION;
        $prefix_opt = MIW_UPLOAD_OPTION_PREFIX;

        if ($total_field > 0) {
            for ($i = 1; $i <= $total_field; $i++) {
                $widget_name = $prefix_opt . $i; //widget name

                $instance[$widget_name] = (!empty($new_instance[$widget_name]) ) ? $new_instance[$widget_name] : '';
                $instance['link_' . $widget_name] = (!empty($new_instance['link_' . $widget_name]) ) ? $new_instance['link_' . $widget_name] : '';
                $instance['target_' . $widget_name] = (!empty($new_instance['target_' . $widget_name]) ) ? $new_instance['target_' . $widget_name] : '';
            }
        }
        return $instance;
    }

}

// Class wpb_widget ends here
// Register and load the widget
function miw_initialize_widget() {
    register_widget('miw_image_widget');
}
add_action('widgets_init', 'miw_initialize_widget');
