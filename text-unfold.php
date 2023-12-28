<?php

/**
 * Plugin Name:            Text Unfold For Elementor
 * Description:            Simplest text unfold widget for elementor
 * Version:                1.0.0
 * Text Domain:            text-unfold
 * Author:                 fullstackwp
 * Author URI:             https://www.fullstack-wp.com/
 * Lisence:                GPLv2 or later
 * Lisence URI:            https://opensource.org/licenses/GPL-3.0
 * Requires at least:      6.0
 * Requires PHP:           7.0
 * Tested up to:           6.3.1
 * Elementor tested up to: 3.18.3
 */

if (!defined('ABSPATH')) {
    exit;
}

define('FSWP_ELT_TEXT_UNFOLD_VERSION', '1.0.0');

define('FSWP_ELT_TEXT_UNFOLD_PLUGIN_PATH', trailingslashit(plugin_dir_path(__FILE__)));

define('FSWP_ELT_TEXT_UNFOLD_PLUGIN_URL', trailingslashit(plugins_url('/',  __FILE__)));

define('FSWP_ELT_CLASS', 'fswp-elt--');

require_once(FSWP_ELT_TEXT_UNFOLD_PLUGIN_PATH . '/includes/class-text-unfold-addon.php');
require_once(FSWP_ELT_TEXT_UNFOLD_PLUGIN_PATH . '/includes/helper-function.php');
