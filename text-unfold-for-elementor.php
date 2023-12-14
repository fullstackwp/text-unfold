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
 * Elementor tested up to: 3.16.5
 */
 
if( !defined( 'ABSPATH' ) ) {
    exit;
}
if ( !defined('FSWP_ELT_TEXT_UNFOLD_TEXT_DOMAIN')){
    define( 'FSWP_ELT_TEXT_UNFOLD_TEXT_DOMAIN' , 'text-unfold' );
}

if ( !defined('FSWP_ELT_TEXT_UNFOLD_VERSION')){
    define( 'FSWP_ELT_TEXT_UNFOLD_VERSION' , '1.0.0' );
}

if ( !defined('FSWP_ELT_TEXT_UNFOLD_PLUGIN_PATH')){
    define( 'FSWP_ELT_TEXT_UNFOLD_PLUGIN_PATH' , trailingslashit( plugin_dir_path(__FILE__) ) );

}

if ( !defined('FSWP_ELT_TEXT_UNFOLD_PLUGIN_URL')){
    define( 'FSWP_ELT_TEXT_UNFOLD_PLUGIN_URL', trailingslashit(plugins_url( '/' ,  __FILE__) ) );
}


if ( !defined('FSWP_ELT_CLASS')){
    define( 'FSWP_ELT_CLASS' , 'fswp-elt--' );
}


require_once( FSWP_ELT_TEXT_UNFOLD_PLUGIN_PATH . '/includes/class-text-unfold-addon.php');