<?php

/**
 * Text Unfold For Elementor
 * @fullstackwp
 */


if (!defined('ABSPATH')) exit; // Exit if accessed directly

final class FSWP_ELT_text_unfold_addon
{
    protected static $instance = null;

    protected $registered_elements = [];

    const Version = '1.1.0';

    const MINIMUM_ELEMENTOR_VERSION = '2.0.0';

    const MINIMUM_PHP_VERSION = '6.0';

    const MINIMUM_WP_VERSION = '6.0';

    public static function instance()
    {
        if (is_null(self::$instance)) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    public function __construct()
    {
        add_action('init', [$this, 'init']);
    }

    /**
     * Init plugin.
     * */
    public function init()
    {
        if ($this->is_compatible()) {
            add_action('elementor/widgets/register', [$this, 'register_widgets']);
            add_action('elementor/elements/categories_registered', [$this, 'register_widget_category']);
            add_action('elementor/frontend/after_enqueue_scripts', [$this, 'enqueue_widget_assets']);
        }
    }

    /**
     * Check if plugin is compatible with current environment.
     * 
     * @return bool True if compatible, False otherwise.
     * */
    public function is_compatible()
    {
        // Check if Elementor installed.
        if (!did_action('elementor/loaded')) {
            add_action('admin_notices', function () {
?>
                <div class="notice notice-error is-dismissible">
                    <p><?php echo sprintf(esc_html__('%s is not installed.', 'text-unfold'), '<strong>' . esc_html__('Elementor', 'text-unfold') . '</strong>'); ?></p>
                </div>
            <?php
            });
            return false;
        }

        // Check if Elementor version is compatible.
        if (version_compare(ELEMENTOR_VERSION, self::MINIMUM_ELEMENTOR_VERSION, '<')) {
            add_action('admin_notices', function () { ?>
                <div class="notice notice-error is-dismissible">
                    <p><?php echo sprintf(esc_html__('%s is not compatible with your version of Elementor. Minimum required version is %s.', 'text-unfold'), '<strong>' . esc_html__('Text Unfold For Elementor', 'text-unfold') . '</strong>', esc_html__(self::MINIMUM_ELEMENTOR_VERSION, 'text-unfold')); ?></p>
                </div>
            <?php });
            return false;
        }

        // Check if PHP version is compatible.
        if (version_compare(PHP_VERSION, self::MINIMUM_PHP_VERSION, '<')) {
            add_action('admin_notices', function () { ?>
                <div class="notice notice-error is-dismissible">
                    <p><?php echo sprintf(esc_html__('%s is not compatible with your version of PHP. Minimum required version is %s.', 'text-unfold'), '<strong>' . esc_html__('Text Unfold For Elementor', 'text-unfold') . '</strong>', esc_html__(self::MINIMUM_PHP_VERSION, 'text-unfold')); ?></p>
                </div>
            <?php });
            return false;
        }

        // Check if WordPress version is compatible.
        if (version_compare(get_bloginfo('version'), self::MINIMUM_WP_VERSION, '<')) {
            add_action('admin_notices', function () { ?>
                <div class="notice notice-error is-dismissible">
                    <p><?php echo sprintf(esc_html__('%s is not compatible with your version of WordPress. Minimum required version is %s.', 'text-unfold'), '<strong>' . esc_html__('Text Unfold For Elementor', 'text-unfold') . '</strong>', esc_html__(self::MINIMUM_WP_VERSION, 'text-unfold')); ?></p>
                </div>
<?php });
            return false;
        }

        return true;
    }

    /**
     * Register the widgets.
     * 
     * @param \Elementor\Widgets_Manager $widgets_manager
     * */
    public function register_widgets($widgets_manager)
    {

        $widgetDirectory = FSWP_ELT_TEXT_UNFOLD_PLUGIN_PATH . 'includes/widgets/';

        //Get all the files in the widgets directory
        $widgetFiles = glob($widgetDirectory . '*.php');
        foreach ($widgetFiles as $widgetFile) {
            require_once($widgetFile);
            $widget_class = basename($widgetFile, '.php');

            // Check if the widget class is readable and exists
            if (is_readable($widgetFile) && class_exists($widget_class)) {

                // Instantiate the widget class and register it with Elementor
                $widgetInstance = new $widget_class();
                if ($widgetInstance instanceof \Elementor\Widget_Base) {
                    $widgets_manager->register($widgetInstance);
                }
            }
        }
    }

    /**
     * Register the widget category.
     * 
     * @param \Elementor\Elements_Manager $elements_manager
     * */
    public function register_widget_category($elements_manager)
    {
        $elements_manager->add_category(
            'fswp-widget',
            [
                'title' => esc_html__('FSWP Widget', 'text-unfold'),
                'icon' => 'fa fa-plug',
            ]
        );
    }

    /**
     * Enqueue the widget assets.
     * */
    public function enqueue_widget_assets()
    {
        wp_enqueue_style('fswp-elt-text-unfold-style', FSWP_ELT_TEXT_UNFOLD_PLUGIN_URL . 'assets/css/style.css', [], FSWP_ELT_TEXT_UNFOLD_VERSION, 'all');
        wp_enqueue_script('fswp-elt-text-unfold-script', FSWP_ELT_TEXT_UNFOLD_PLUGIN_URL . 'assets/js/script.js', ['jquery'], FSWP_ELT_TEXT_UNFOLD_VERSION, true);
    }
}

new FSWP_ELT_text_unfold_addon();
