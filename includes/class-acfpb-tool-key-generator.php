<?php
/**
 * Creates field and group IDs for use when editing ACF group PHP files.
 *
 * @package ACF_Power_Boost
 */

defined( 'ABSPATH' ) || exit;

if ( class_exists( 'ACF_Admin_Tool' ) ) {
	/**
	 * ACF_Tool_Key_Generator
	 */
	class ACFPB_Tool_Key_Generator extends ACF_Admin_Tool {

		/**
		 *  This function will initialize the admin tool
		 *
		 *  @return  void
		 */
		public function initialize() {
			$this->name  = 'key-generator';
			$this->title = __( 'Key Generator', 'power-boost-acf' );
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
			<h2 class="acf-postbox-title"><?php esc_html_e( 'Key Generator', 'power-boost-acf' ); ?></h2>
			<div class="acf-tip"><i tabindex="0" class="acf-icon acf-icon-help acf-js-tooltip" title="<?php esc_attr_e( 'Field and group keys are needed when editing ACF group PHP files. Provided by Power Boost for ACF.', 'power-boost-acf' ); ?>"></i></div>
		</div>
		<div class="acf-postbox-inner">
			<div class="acf-fields">
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
			</div>
			<?php
		}
	}
}
