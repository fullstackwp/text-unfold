<?php
/**
 * Text unfold 
 * @fullstackwp
 */
if (!defined('ABSPATH')) {
    exit;
}

final class FSWP_text_unfold_addon
{

    protected $registered_elements;

    function __construct()
    {
        add_action('init', array($this, 'init'));
    }

    public function is_compatible()
    {
        $is_elementor_active = class_exists( 'Elementor\Plugin' );
        add_action('admin_notices', function () use ($is_elementor_active) {
            if (!$is_elementor_active) {
            ?>
                <div class="notice notice-error is-dismissible">
                    <p><?php esc_html_e('<b>Elementor</b> is not installed', 'text-unfold'); ?></p>
                </div>
            <?php
            }
        });
        return $is_elementor_active;
    }

    public function init()
    {
        if ($this->is_compatible()) {
            add_action('elementor/widgets/register', array($this, 'register_new_widget'));
            add_action('elementor/elements/categories_registered', array($this, 'register_widget_category'));
            add_action('elementor/frontend/after_enqueue_scripts', array($this, 'enqueue_widget_styles_scripts'));
        }
    }

    function register_new_widget($widgets_manager)
    {
        $directories = scandir(FSWP_ELT_TEXT_UNFOLD_PLUGIN_PATH . 'includes/widgets/');
        foreach ($directories as $directory) {
            $widget_files = FSWP_ELT_TEXT_UNFOLD_PLUGIN_PATH . 'includes/widgets/' . $directory . '/' . $directory . '.php';
            if (file_exists($widget_files)) {
                require_once $widget_files;
                $widgets_manager->register_widget_type(new $directory);
            }
        }
    }

    function register_widget_category($elements_manager)
    {
        $elements_manager->add_category(
            'fswp-widget',
            [
                'title' => esc_html__('FSWP Widget', 'text-unfold'),
            ]
        );
    }

    function enqueue_widget_styles_scripts()
    {
        wp_enqueue_style('fswp-elt-text-unfold-style', FSWP_ELT_TEXT_UNFOLD_PLUGIN_URL . 'assets/css/style.css', array(), FSWP_ELT_TEXT_UNFOLD_VERSION, 'all');
        wp_enqueue_script('fswp-elt-text-unfold-script', FSWP_ELT_TEXT_UNFOLD_PLUGIN_URL . 'assets/js/script.js', array('jquery'), FSWP_ELT_TEXT_UNFOLD_VERSION, true);
    }
}

new FSWP_text_unfold_addon();
