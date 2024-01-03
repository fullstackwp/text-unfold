<?php
/**
 * Text unfold 
 * @fullstackwp
 */

use Elementor\Core\Utils\Version;

if (!defined('ABSPATH')) {
    exit;
}

final class FSWP_ELT_text_unfold_addon
{

    protected $registered_elements;

    const Version = '1.0';

    const MINIMUM_ELEMENTOR_VERSION = '2.0.0';

    const MINIMUM_PHP_VERSION = '6.0';

    public function __construct()
    {
        add_action('init', array($this, 'init'));
    }

    public function init()
    {
        if ($this->is_compatible()) {
            add_action('elementor/widgets/register', [$this, 'fswp_register_new_widget']);
            add_action('elementor/elements/categories_registered', [$this, 'fswp_register_widget_category']);
            add_action('elementor/frontend/after_enqueue_scripts', [$this, 'fswp_enqueue_widget_styles_scripts']);
        }
    }

    public function is_compatible()
    {
        if (!did_action('elementor/loaded')) {
            add_action('admin_notices', function () {
            ?>
                <div class="notice notice-error is-dismissible">
                <p><?php echo sprintf( esc_html("%s is not installed.", "text-unfold"), '<strong>'.esc_html( "Elementor" , "text-unfold" ).'</strong>'); ?></p>
                </div>
            <?php
            });
            return false;
        }
        
        if( version_compare( ELEMENTOR_VERSION , self::MINIMUM_ELEMENTOR_VERSION , '<')){
            add_action('admin_notices', function () {
            ?>
                <div class="notice notice-error is-dismissible">
                    <p><?php echo sprintf( esc_html("Elementor version %s or greater is required.", "text-unfold"), self::MINIMUM_ELEMENTOR_VERSION); ?></p>

                </div>
            <?php
            });
            return false;
        }

        if( version_compare( PHP_VERSION , self::MINIMUM_PHP_VERSION , '<')){
            add_action('admin_notices', function () {
            ?>
                <div class="notice notice-error is-dismissible">
                    <p><?php echo sprintf( esc_html("PHP version %s or greater is required.", "text-unfold"), self::MINIMUM_PHP_VERSION); ?></p>

                </div>
            <?php
            });
            return false;
        }

        return true;
    }

    function fswp_register_new_widget($widgets_manager)
    {
        $widgetDirectory = FSWP_ELT_TEXT_UNFOLD_PLUGIN_PATH . 'includes/widgets/';
        // Get all PHP files in the specified directory
        $widgetFiles = glob($widgetDirectory . '*.php');
        foreach ($widgetFiles as $widgetFile) {
            $widgetClassName = basename($widgetFile, '.php');
            // Check if the file is a valid PHP class file
            require_once $widgetFile;
            // Check if the file is a valid PHP class file
            if (is_readable($widgetFile) && class_exists($widgetClassName)) {
                // Instantiate the widget class and register it with Elementor
                $widgetInstance = new $widgetClassName();
                
                if ($widgetInstance instanceof \Elementor\Widget_Base) {
                    $widgets_manager->register_widget_type($widgetInstance);
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

new FSWP_ELT_text_unfold_addon();
