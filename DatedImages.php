<?php
/*
Plugin Name: Dated Images
Plugin URI: http://therealcarlos.com/dated-images-plugin/
Description: Show and Hide images with specific ranges of dates.
Version: 1.0
Author: Carlos Moreira
Author URI: http://therealcarlos.com/
*/

add_action('init', 'dicm_buttons');
function dicm_buttons()
{
    wp_print_scripts('jquery');
    wp_print_scripts('jquery-ui-core');
    wp_print_scripts('jquery-ui-datepicker');
    wp_enqueue_style('plugin_name-admin-ui-css',
        'http://code.jquery.com/ui/1.9.2/themes/base/jquery-ui.css',
        false,
        1,
        false);
    wp_enqueue_script('media-upload');
    wp_enqueue_script('thickbox');
    add_filter("mce_external_plugins", "dicm_add_buttons");
    add_filter('mce_buttons', 'dicm_register_buttons');

}

function dicm_add_buttons($plugin_array)
{
    $plugin_array['dicm'] = plugins_url('mygallery_plugin.js', __FILE__);
    return $plugin_array;
}

function dicm_register_buttons($buttons)
{
    array_push($buttons, 'dropcap', 'showrecent'); // dropcap' , 'recentposts
    return $buttons;
}

class DateImage
{

    public function __construct()
    {
        add_shortcode('DateImage', array($this, 'init'));
    }

    private function imgSrc($src, $link = "")
    {
        if ($link !== "") {
            return "<a href='" . $link . "'><img src=" . $src . " /></a>";
        }
        return "<img src=" . $src . " />";
    }

    public function init($atts)
    {
        // extract the attributes into variables
        extract(shortcode_atts(array(
            'src' => '',
            'end_date' => '',
            'start_date' => ''
        ), $atts));

        if(empty($atts['src'])){
            return "[**DateImage Error, No Image Set**]";
        }

        $start_date = date_create($atts['start_date']);
        $end_date = date_create($atts['end_date']);

        $today = new DateTime('now');
        $today = date_create($today->format('Y-m-d'));

        if (!empty($atts['end_date']) && !empty($atts['start_date'])) {
            if (is_object($start_date) && is_object($end_date)) {


                if ($today >= $start_date && $today <= $end_date) {
                    return "<img src=" . $atts['src'] . " />";
                }
            } else {
                return "[Please Check Image Date(s) Format]";
            }
        } elseif (!empty($atts['end_date'])) {

            if (is_object($end_date)) {

                if ($today > $end_date) {
                    return "";
                }
                return "<img src=" . $atts['src'] . " />";
            }

        } elseif (!empty($atts['start_date'])) {
            if (is_object($start_date)) {
                if ($today >= $start_date) {
                    return "<img src=" . $atts['src'] . " />";
                }
                return "";
            }
        }

        return "";
    }
}

$dateImage = new DateImage();