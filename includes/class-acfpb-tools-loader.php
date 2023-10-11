<?php
/**
 * Adds tools to the ACF → Tools dashboard page.
 *
 * @package ACF_Power_Boost
 */

defined( 'ABSPATH' ) || exit;

/**
 * ACFPB_Tools_Loader
 */
class ACFPB_Tools_Loader {
	/**
	 * Adds hooks that power the plugins features.
	 *
	 * @return void
	 */
	public function add_hooks() {
		// Add an ACF admin tool after the ACF admin page is loaded.
		add_action( 'acf/include_admin_tools', array( $this, 'add' ), 11 );
		// Backwards compatibility, the hook was renamed.
		add_action( 'load-custom-fields_page_acf-tools', array( $this, 'add' ), 11 );
	}

	/**
	 * Registers our tool with ACF. Adds boxes to the ACF → Tools dashboard
	 * page.
	 *
	 * @return void
	 */
	public function add() {
		include_once dirname( __FILE__ ) . '/class-acfpb-tool-local-groups.php';
		acf_register_admin_tool( 'ACFPB_Tool_Local_Groups' );

		//include_once dirname( __FILE__ ) . '/class-acfpb-tool-key-generator.php';
		//acf_register_admin_tool( 'ACFPB_Tool_Key_Generator' );
	}
}
