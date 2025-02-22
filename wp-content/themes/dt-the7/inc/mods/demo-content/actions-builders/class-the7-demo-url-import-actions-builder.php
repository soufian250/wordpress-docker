<?php
/**
 * @package The7
 */

defined( 'ABSPATH' ) || exit;

/**
 * The7_Demo_Url_Import_Actions_Builder class.
 */
class The7_Demo_Url_Import_Actions_Builder extends The7_Demo_Actions_Builder_Base {

	/**
	 * @return void
	 */
	protected function init() {
		if ( empty( $this->external_data['the7_post_url'] ) ) {
			$this->add_nothing_to_import_error();

			return;
		}

		$provided_url = $this->sanitize_url( $this->external_data['the7_post_url'] );

		// Which demo to import?
		$demo_host  = parse_url( $provided_url, PHP_URL_HOST );
		$demos_raw  = the7_demo_content()->get_raw_demos();
		$demos_urls = array_column( $demos_raw, 'link', 'id' );
		arsort( $demos_urls );
		foreach ( $demos_urls as $demo_id => $demo_link ) {
			if ( strpos( $provided_url, $demo_link ) !== false ) {
				$demo = $this->setup_demo( $demo_id );
				break;
			}
		}

		if ( $demo === null ) {
			$this->add_invalid_url_error( $provided_url );

			return;
		}

		if ( ! $demo->import_allowed() ) {
			$this->add_demo_import_not_allowed_error( $demo );

			return;
		}

		$this->setup_starting_text(
			sprintf(
				// translators: %s: resource url.
				esc_html( _x( 'Importing %s ...', 'admin', 'the7mk2' ) ),
				'<code>' . esc_html( $provided_url ) . '</code>'
			)
		);
	}

	/**
	 * @return void
	 */
	protected function setup_data() {
		$demo = $this->demo();

		$actions = [];
		if ( ! $demo->plugins()->is_plugins_active() ) {
			$actions[] = 'install_plugins';
		}
		$actions[] = 'download_package';
		$actions[] = 'add_the7_dashboard_settings';
		if ( in_array( 'dt-the7-core', $demo->required_plugins, true ) ) {
			$actions[] = 'import_post_types_builder_data';
		}
		$actions[]           = 'clear_importer_session';
		$actions[]           = 'import_by_url';
		$users               = [];
		$plugins_to_install  = array_keys( $demo->plugins()->get_plugins_to_install() );
		$plugins_to_activate = array_keys( $demo->plugins()->get_inactive_plugins() );
		$demo_id             = $demo->id;
		$provided_url        = $this->sanitize_url( $this->external_data['the7_post_url'] );
		$import_type         = 'url_import';

		$this->localize_the7_import_data(
			compact(
				'actions',
				'users',
				'plugins_to_install',
				'plugins_to_activate',
				'demo_id',
				'provided_url',
				'import_type'
			)
		);
	}

	/**
	 * @param string $url Url.
	 */
	protected function add_invalid_url_error( $url ) {
		$text = sprintf(
			// translators: %s: resource url.
			'<p>' . esc_html_x( 'Cannot find demo that match provided url %s.', 'admin', 'the7mk2' ) . '</p>',
			'<code>' . esc_html( $url ) . '</code>'
		);
		$text .= sprintf(
			'<a href="%s">%s</a>',
			the7_demo_content()->admin_url(),
			esc_html_x( 'Go back.', 'admin', 'the7mk2' )
		);

		$this->add_error( $text );
	}

	/**
	 * @param The7_Demo $demo Demo.
	 *
	 * @return void
	 */
	protected function add_demo_import_not_allowed_error( $demo ) {
		$text  = wp_kses_post( '<p>' . $demo->get_elementor_pro_requierements_text() . '</p>' );
		$text .= sprintf(
			'<a href="%s">%s</a>',
			the7_demo_content()->admin_url(),
			esc_html_x( 'Go back.', 'admin', 'the7mk2' )
		);

		$this->add_error( $text );
	}

	/**
	 * @param string $url Url.
	 *
	 * @return bool|string
	 */
	protected function sanitize_url( $url ) {
		return remove_query_arg( 'utm_source', $url );
	}
}
