<?php

/**
 * Text unfold 
 * @fullstackwp
 */

use Elementor\Core\Utils\Version;

if (!defined('ABSPATH')) {
    exit;
}

final class FSWP_text_unfold_addon
{

    protected $registered_elements;

    const Version = '1.0';

    const MINIMUM_ELEMENTOR_VERSION = '2.0.0';

    const MINIMUM_PHP_VERSION = '6.0';

    public function __construct()
    {
        add_action('init', array($this, 'init'));
    }

    // public function is_compatible()
    // {
    //    if( !did_action('elementor/loaded')){
    //     add_action('admin_notices' , function(){

    //     })
    //    }
    // }

    public function init()
    {
        // if ($this->is_compatible()) {
        add_action('elementor/widgets/register', array($this, 'fswp_register_new_widget'));
        add_action('elementor/elements/categories_registered', array($this, 'fswp_register_widget_category'));
        add_action('elementor/frontend/after_enqueue_scripts', array($this, 'fswp_enqueue_widget_styles_scripts'));
        // }
    }

    function fswp_register_new_widget($widgets_manager)
    {
        $directories = scandir(FSWP_ELT_TEXT_UNFOLD_PLUGIN_PATH . 'includes/widgets/');
        foreach ($directories as $directory) {
            if ($directory !== '.' && $directory !== '..') {
                $widget_files = (FSWP_ELT_TEXT_UNFOLD_PLUGIN_PATH . 'includes/widgets/' . $directory);
                if (file_exists($widget_files)) {
                    require_once $widget_files;
                    $widget = basename($widget_files, '.php');
                    $widgets_manager->register_widget_type(new $widget);
                }
            }
        }
    }

    function fswp_register_widget_category($elements_manager)
    {
        $elements_manager->add_category(
            'fswp-widget',
            [
                'title' => esc_html__('FSWP Widget', 'text-unfold'),
            ]
        );
    }

    function fswp_enqueue_widget_styles_scripts()
    {
        wp_enqueue_style('fswp-elt-text-unfold-style', FSWP_ELT_TEXT_UNFOLD_PLUGIN_URL . 'assets/css/style.css', array(), FSWP_ELT_TEXT_UNFOLD_VERSION, 'all');
        wp_enqueue_script('fswp-elt-text-unfold-script', FSWP_ELT_TEXT_UNFOLD_PLUGIN_URL . 'assets/js/script.js', array('jquery'), FSWP_ELT_TEXT_UNFOLD_VERSION, true);
    }
}

new FSWP_text_unfold_addon();
