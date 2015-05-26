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
            <div id="owl-demo" class="owl-carousel owl-theme miw-slider"> 
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
                <ul class="miw miw-linear">
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
                    <option value="linear" <?php echo ($widget_type == "linear") ? "selected" : ""; ?> ><?php echo __('Linear Image', 'miw'); ?></option>
                    <option value="slider" <?php echo ($widget_type == "slider") ? "selected" : ""; ?> ><?php echo __('Slider Image', 'miw'); ?></option>
                </select>    
            </p> 

            <p><?php echo __('You can upload maximum 10 image', 'miw'); ?></p>

            <?php
            /*
             * Variable description.
             * $inc : it is used to identify the first field.
             * $fieldarr = it is used to know,how many options.
             * $widgetid = it is used to identify the widget id i.e widget number.
             * $next_uploaded_btn = it is used to show the next uploaded button when click on the "Add More" button.
             */

            $nxt_upload_btn = "";
            $nxt_upload_btn_addmore = "";

            $widgetid = $this->id;
            $inc = 1;


            $inc_nxtbtn = 0; //$i is used to show  the next value .

            $fieldarr = unserialize(MIW_FIELD_OPTION_ARR);
            if (count($fieldarr)) {
                for($fi=0;$fi < count($fieldarr);$fi++) {
                    $widgetname = $fieldarr[$fi];

                    /*                     * ************** Get value from database */
					$imgURL ="";
					$link   ="";
					$target ="";
					
					if(isset($instance["image_" . $widgetname]))
                        $imgURL = $instance["image_" . $widgetname];
					
					if(isset($instance["link_" . $widgetname]))
                    $link = $instance["link_" . $widgetname];
					
					if(isset($instance["target_" . $widgetname]))
                    $target = $instance["target_" . $widgetname];
                    /*************** Get value from database END */
                    /*
                     * Next uploaded button
                     * Functionality of selecting image.
                     *        Currently:              2:  [Upload button] 
                     *                  1:     [AddMore] /----\3: [Nextbutton once doneUploadbutton] 
                     * Note: Add more(1) have the next uploaded(3) button record.
                     *       Next uploaded button have the nextuploaded button(3) record.
                     */

                    if (empty($imgURL) AND empty($nxt_upload_btn_addmore)) {
                        $nxt_upload_btn_addmore = $fieldarr[$inc_nxtbtn];
                    }
//                    $inc_nxtbtn = intval($inc_nxtbtn) + 1; //increment
                        $next_inc = intval($fi) + 1;
                    $nxt_upload_btn = @$fieldarr[$next_inc];
                    ?>   
                    <!-- Loop start here -->     
                    <div class="miw-container">
                        <!--
                        1: Now first button is on and rest will off.
                        2: Suppose two button have upload the image then next 3rd button in on and other is off . Same as viceversa. 
                        3: When click on Add more then we will show the div whose class (upload_btn-widgetidwidgetname) .
                        -->
                        <!-- upload button  -->
                        <div class="upload-file-container  <?php echo ($inc == 1|| !empty($imgURL) ) ? 'miw_on' : 'miw_off'; ?> upload_btn-<?php echo $widgetid . $widgetname; ?> " >
                            <input data-next_uploadedbtn="<?php echo $nxt_upload_btn; ?>" data-widgetid="<?php echo $widgetid; ?>" data-widgetname="<?php echo $widgetname; ?>" type="button" class="miw_upload_image button-primary button" value="Upload image">
                        </div>   
                        <!-- upload image,link and target  -->
                        <div class="miw-button-attribute <?php echo $widgetid . $widgetname; ?> <?php echo (!empty($imgURL)) ? "miw_on" : "miw_off"; ?> ">

                            <div class="miw-image">
                                <figure class="upload-thumb">
                                <!--
                                How to identify the image
                                1: widget id + widgetname => complete key.
                                --> 
                                <img src="<?php echo $imgURL; ?>" class="uploaded_img <?php echo $widgetid . $widgetname; ?>" alt="image"  />
                                <img class="delete" data-val="<?php echo $widgetid.$widgetname; ?>" src="<?php echo MIW__PLUGIN_URL; ?>assets/images/Delete.png" alt="delete" />
                                <input class="<?php echo $widgetid . $widgetname; ?>" type="hidden" name='<?php echo $this->get_field_name("image_" . $widgetname); ?>' id='<?php echo $this->get_field_id("image_" . $widgetname); ?>'  value="<?php echo $imgURL; ?>">
                                </figure> 
                            </div> 

                            <div class="miw-link upload-link">
                                <label for="<?php echo $this->get_field_id("link_" . $widgetname); ?>"><?php _e('Link'); ?></label> 
                                <input type="url" name='<?php echo $this->get_field_name("link_" . $widgetname); ?>' id='<?php echo $this->get_field_id("link_" . $widgetname); ?>'  value="<?php echo $link; ?>">
                            </div> 

                            <div class="miw-target miw-container-loop-last upload-link">
                               <label for="<?php echo $this->get_field_id("target_".$widgetname); ?>"><?php _e('Target Link'); ?></label>   
                                <select class="widefat open-in-link" name='<?php echo $this->get_field_name("target_" . $widgetname); ?>' id='<?php echo $this->get_field_id("target_" . $widgetname); ?>'>
                                    <option value="_self" <?php echo ($target == "_self") ? "selected='selected'" : ""; ?> >Open in same window</option>
                                    <option value="_target" <?php echo ($target == "_target") ? "selected='selected'" : ""; ?> >Opne in new window</option>
                                </select>    
                            </div> 

                        </div>
                        <!-- upload image,link and target END  -->
                    </div>    
                    <!-- Loop END here -->
                    <?php
                    ++$inc;
                }
            }
            ?>
            <a href="javascript:void(0);" class="button miw_addmore" data-widgetid="<?php echo $widgetid; ?>" data-nextbtn="<?php echo $nxt_upload_btn_addmore; ?>" >Add More</a>  

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
        $fieldarr = unserialize(MIW_FIELD_OPTION_ARR);
        if (count($fieldarr)) {
            foreach ($fieldarr as $field) {
                $widgetname = $field;
                $instance["image_" . $widgetname] = (!empty($new_instance["image_" . $widgetname]) ) ? $new_instance["image_" . $widgetname] : '';
                $instance["link_" . $widgetname] = (!empty($new_instance["link_" . $widgetname]) ) ? $new_instance["link_" . $widgetname] : '';
                $instance["target_" . $widgetname] = (!empty($new_instance["target_" . $widgetname]) ) ? $new_instance["target_" . $widgetname] : '';
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
