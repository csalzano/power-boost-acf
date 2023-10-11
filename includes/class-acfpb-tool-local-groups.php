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

			// vars.
			$this->name  = 'local-groups';
			$this->title = __( 'Local Groups', 'power-boost-acf' );
		}

		/**
		 *  This function will output the metabox HTML
		 *
		 *  @return  void
		 */
		public function html() {

			// Take any PHP loaded group and bring it into the editor.
			$groups = acf_get_local_field_groups()

			?><p>
			<?php

				printf(
					'<p>%s</p>',
					esc_html__( 'Save local field groups defined in PHP to the database so they can be edited in the dashboard.', 'power-boost-acf' )
				);

			?>
			</p><div class="acf-fields">
			<?php

			acf_render_field_wrap(
				array(
					'label'   => __( 'Type', 'power-boost-acf' ),
					'type'    => 'radio',
					'name'    => 'key_type',
					'layout'  => 'horizontal',
					'choices' => array(
						'field' => __( 'Field', 'power-boost-acf' ),
						'group' => __( 'Group', 'power-boost-acf' ),
					),
				)
			);

			acf_render_field_wrap(
				array(
					'label'  => __( 'Key', 'power-boost-acf' ),
					'type'   => 'text',
					'name'   => 'generated_key',
					'prefix' => false,
				)
			);

			?>
			</div>
			<script type="text/javascript">
				function generate_key()
				{
					var radios = document.getElementsByName('key_type');
					for(i = 0; i < radios.length; i++) {
						if(radios[i].checked) {
							document.getElementById('generated_key').value = acf.uniqid(radios[i].value + '_');
						}
					}					
				}
			</script>
			<p class="acf-submit">
				<button type="button" name="action" class="button button-primary" value="generate" onclick="generate_key()"><?php esc_html_e( 'Generate Key', 'power-boost-acf' ); ?></button>
			</p>
			<?php

		}
	}
}
