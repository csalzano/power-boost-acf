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
		 * Return an array of keys that have been selected in the export tool.
		 * Copied from advanced-custom-fields-pro/includes/admin/tools/class-acf-admin-tool-export.php
		 *
		 * @return array|bool
		 */
		public function get_selected_keys() {
			$key_names = array( 'keys', 'post_type_keys', 'taxonomy_keys' );
			$all_keys  = array();

			foreach ( $key_names as $key_name ) {
				if ( $keys = acf_maybe_get_POST( $key_name ) ) {
					$all_keys = array_merge( $all_keys, (array) $keys );
				} elseif ( $keys = acf_maybe_get_GET( $key_name ) ) {
					$keys     = str_replace( ' ', '+', $keys );
					$keys     = explode( '+', $keys );
					$all_keys = array_merge( $all_keys, (array) $keys );
				}
			}

			if ( ! empty( $all_keys ) ) {
				return $all_keys;
			}

			return false;
		}

		/**
		 * Returns the JSON data for given $_POST args.
		 * Copied from advanced-custom-fields-pro/includes/admin/tools/class-acf-admin-tool-export.php
		 *
		 * @return array|bool
		 */
		public function get_selected() {
			$selected = $this->get_selected_keys();
			$json     = array();

			if ( ! $selected ) {
				return false;
			}

			foreach ( $selected as $key ) {
				$post_type = acf_determine_internal_post_type( $key );
				$post      = acf_get_internal_post_type( $key, $post_type );

				if ( empty( $post ) ) {
					continue;
				}

				if ( 'acf-field-group' === $post_type ) {
					$post['fields'] = acf_get_fields( $post );
				}

				$post   = acf_prepare_internal_post_type_for_export( $post, $post_type );
				$json[] = $post;
			}

			return $json;
		}

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

			?>
		<div class="acf-postbox-header">
			<h2 class="acf-postbox-title"><?php esc_html_e( 'Local Groups', 'power-boost-acf' ); ?></h2>
			<div class="acf-tip"><i tabindex="0" class="acf-icon acf-icon-help acf-js-tooltip" title="<?php esc_attr_e( 'Save local field groups defined in php or json to the database so they can be edited in the dashboard. Provided by Power Boost for ACF.', 'power-boost-acf' ); ?>"></i></div>
		</div>
		<div class="acf-postbox-inner">
			<div class="acf-fields">
			<?php

			// Select Field Groups.
			$choices = array();
			// The local setting is turned off on the Tools page.
			acf_enable_filter( 'local' );
			$field_groups = acf_get_local_field_groups();
			acf_disable_filter( 'local' );
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
					'toggle'  => true,
					'choices' => $choices,
				)
			);

			?>
			</div>
			<p class="acf-submit">
				<button type="submit" name="action" class="acf-btn acf-button-primary" value="localize"><?php esc_html_e( 'Save to Database', 'power-boost-acf' ); ?></button>
			</p>
		</div>
			<?php

		}

		/**
		 * This function will run when the tool's form is submitted.
		 *
		 * @return void
		 */
		public function submit() {
			if ( 'localize' !== acf_maybe_get_POST( 'action' ) ) {
				return;
			}
			$group_ids = $this->get_selected_keys();
			// The local setting is turned off on the Tools page.
			acf_enable_filter( 'local' );
			$exportable = $this->get_selected();
			acf_disable_filter( 'local' );

			// validate.
			if ( false === $exportable || empty( $exportable ) ) {
				return acf_add_admin_notice( __( 'No field groups selected', 'power-boost-acf' ), 'warning' );
			}

			// Save each field group to the database.
			foreach ( $exportable as $field_group ) {
				acf_update_field_group( $field_group );
			}
		}
	}
}
