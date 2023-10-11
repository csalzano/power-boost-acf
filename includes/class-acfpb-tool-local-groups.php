<?php
/**
 * Saves local field groups defined in PHP to the database so they can be
 * edited in the dashboard.
 *
 * @package ACF_Power_Boost
 */

defined( 'ABSPATH' ) || exit;

if ( class_exists( 'ACF_Admin_Tool' ) ) {
	/**
	 * ACFPB_Tool_Local_Groups
	 */
	class ACFPB_Tool_Local_Groups extends ACF_Admin_Tool {

		/**
		 *  This function will initialize the admin tool
		 *
		 *  @return  void
		 */
		public function initialize() {
			$this->name  = 'local-groups';
			$this->title = __( 'Local Groups', 'power-boost-acf' );
		}

		/**
		 *  This function will output the metabox HTML
		 *
		 *  @return  void
		 */
		public function html() {
			if ( ! wp_script_is( 'acfpb-tools' ) ) {
				wp_enqueue_style( 'acfpb-tools' );
			}
			// Take any PHP loaded group and bring it into the editor.
			acf_enable_filter( 'local' );
			$field_groups = acf_get_local_field_groups();
			?>
		<div class="acf-postbox-header">
			<h2 class="acf-postbox-title"><?php esc_html_e( 'Local Groups', 'power-boost-acf' ); ?></h2>
			<div class="acf-tip"><i tabindex="0" class="acf-icon acf-icon-help acf-js-tooltip" title="<?php esc_attr_e( 'Save local field groups defined in PHP to the database so they can be edited in the dashboard. Provided by Power Boost for ACF.', 'power-boost-acf' ); ?>"></i></div>
		</div>
		<div class="acf-postbox-inner">
			<div class="acf-fields">
			<?php

			// Select Field Groups.
			$choices      = array();
			//$field_groups = acf_get_internal_post_type_posts( 'acf-field-group' );

			if ( $field_groups ) {
				foreach ( $field_groups as $field_group ) {
					$choices[ $field_group['key'] ] = esc_html( $field_group['title'] );
				}
			}

			acf_render_field_wrap(
				array(
					'label'   => __( 'Select Field Groups', 'acf' ),
					'type'    => 'checkbox',
					'name'    => 'keys',
					'prefix'  => false,
					//'value'   => $selected,
					'toggle'  => true,
					'choices' => $choices,
				)
			);

			?>
			</div>
			<p class="acf-submit">
				<button type="button" name="action" class="acf-btn acf-button-primary" value="localize"><?php esc_html_e( 'Save to Database', 'power-boost-acf' ); ?></button>
			</p>
		</div>
			<?php

		}
	}
}
