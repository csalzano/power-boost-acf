<?php
/**
 * Power Boost for Advanced Custom Fields
 *
 * @package ACF_Power_Boost
 */

defined( 'ABSPATH' ) || exit;

/**
 * Plugin Name: Power Boost for ACF
 * Description: Add-on for Advanced Custom Fields. ACF features I cannot live without.
 * Plugin URI: https://github.com/csalzano/power-boost-acf
 * Author: Corey Salzano
 * Author URI: https://breakfastco.xyz/
 * Version 1.0.0
 * Text Domain: power-boost-acf
 * License: GPLv2
 */

if ( ! defined( 'ACF_POWER_BOOST_PLUGIN_PATH' ) ) {
	define( 'ACF_POWER_BOOST_PLUGIN_PATH', __FILE__ );
}
if ( ! defined( 'ACF_POWER_BOOST_PLUGIN_VERSION' ) ) {
	define( 'ACF_POWER_BOOST_PLUGIN_VERSION', '1.0.0' );
}

add_filter( 'admin_footer_text', 'acfpb_add_group_id_to_footer' );
/**
 * Adds the current ACF field group ID to the dashboard footer text.
 *
 * @param  string $text The thank you footer text.
 * @return string
 */
function acfpb_add_group_id_to_footer( $text ) {
	$post_type = 'acf-field-group';
	if ( ! acf_is_screen( $post_type ) ) {
		return;
	}
	global $post_type_object;
	if ( empty( $post_type_object->name ) || $post_type !== $post_type_object->name ) {
		return $text;
	}
	global $post;
	if ( empty( $post->post_name ) ) {
		return $text;
	}

	return preg_replace( '/\.<\/span>$/', ' ' . $post->post_name . '.</span>', $text );
}

require_once __DIR__ . '/includes/class-acfpb-tools-loader.php';
$tools = new ACFPB_Tools_Loader();
$tools->add_hooks();
