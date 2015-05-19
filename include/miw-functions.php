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
        $total_field = MIW_TOTAL_UPLOAD_FIELD_OPTION;
        $prefix_opt = MIW_UPLOAD_OPTION_PREFIX;


        ob_start();
        $output = "";
        $inc = 1;
        if ($total_field > 0) {
            for ($i = 1; $i <= $total_field; $i++) {

                $name = $prefix_opt . $i; //widget name
                
                $imgURL = "";
                if (isset($instance[$name])) {
                    $imgURL = $instance[$name];
                }
                $linkImage = "";
                if (isset($instance["link_" . $name])) {
                    $linkImage = $instance["link_" . $name];
                }

                $linkTarget = "";
                if (isset($instance["target_" . $name])) {
                    $linkTarget = $instance["target_" . $name];
                }


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
