<?php
/*
 * All the functions file .
 */

class miw_functions {

    function __construct() {
        ;
    }

    /*
     * This function is used to generate all the uploaded image list: in list of : li tag.
     */

    function miw_generate_list_loop($instance, $tag = "li") {
        /*
         * Get total upload field option and show the 1st field option. 
         * Remaining will be shown when click on "Add More " button.
         * MIW_TOTAL_UPLOAD_FIELD_OPTION : start from 1
         * MIW_UPLOAD_OPTION_PREFIX      : Add the prefix
         */
        
        ob_start();
        $output = "";
        $inc = 1;
        $fieldarr = unserialize(MIW_FIELD_OPTION_ARR); //print_r($instance);
        if (count($fieldarr)) {
            foreach ($fieldarr as $field) {
                $widgetname = $field;

                /*                 * ************** Get value from database */
                $imgURL = $instance["image_" . $widgetname];
                $linkImage = $instance["link_" . $widgetname];
                $linkTarget = $instance["target_" . $widgetname];


                if (!empty($imgURL)) {
                    ?>
                    <?php echo ($tag == "li") ? '<li class="miw-loop">' : "<div class='item miw-slider-loop'>"; ?>

                    <?php echo $this->miw_is_anchor_added($linkImage, $linkTarget); ?>
                    <img class="miw-img" src="<?php echo $imgURL; ?>" alt="image" />
                    <?php echo $this->miw_is_anchor_close($linkImage); ?>
                    <?php echo ($tag == "li") ? '</li>' : "</div>"; ?>
                    <?php
                }
            }
        }
        $output = ob_get_contents();
        ob_get_clean();
        return $output;
    }

    /*
     * This function is used to add the anchor tag.
     */

    function miw_is_anchor_added($linkhref, $linkTarget = "") {

        $output = "";
        if (!empty($linkhref)) {

            $linkTarget_text = (empty($linkTarget)) ? "" : 'target="' . $linkTarget . '"';

            $output .='<a ' . $linkTarget_text . ' class="miw-link" href="' . $linkhref . '">';
        }
        return $output;
    }

    /*
     * This function is used to close the anchor tag.
     */

    function miw_is_anchor_close($linkhref) {

        $output = "";
        if (!empty($linkhref)) {
            $output = "</a>";
        }
        return $output;
    }

}
