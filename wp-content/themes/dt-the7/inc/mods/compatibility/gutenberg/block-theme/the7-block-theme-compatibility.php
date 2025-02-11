<?php
/**
 * The7 block theme compatibility class.
 *
 * @since   12.0.0
 * @package The7
 */

namespace The7\Mods\Compatibility\Gutenberg\Block_Theme;

defined( 'ABSPATH' ) || exit;

/**
 * Class The7_Block_Theme_Compatibility
 */
class The7_Block_Theme_Compatibility {

	const FSE_VERSION_OPTION = 'the7_fse_version';

	/**
	 * Instance.
	 *
	 * @access public
	 * @static
	 * @var The7_Block_Theme_Compatibility
	 */
	public static $instance = null;

	/**
	 * Instance.
	 * Ensures only one instance of the plugin class is loaded or can be loaded.
	 *
	 * @return The7_Block_Theme_Compatibility An instance of the class.
	 * @access public
	 * @static
	 */
	public static function instance() {
		if ( self::$instance === null ) {
			self::$instance = new self();
			self::$instance->bootstrap();
		}

		return self::$instance;
	}

	/**
	 * Bootstrap module.
	 */
	public function bootstrap() {
		if ( the7_is_gutenberg_theme_mode_active() ) {
			add_action( 'init', [ $this, 'add_pattern_categories' ] );
			add_action( 'init', [ $this, 'register_block_styles' ] );
			add_action( 'wp_enqueue_scripts', [ $this, 'enqueue_styles' ] );
			add_action( 'enqueue_block_editor_assets', [ $this, 'enqueue_styles' ] );

			The7_FSE_Font_Manager::instance()->init();
			add_action( 'import_end', [ $this, 'on_import' ] );
		} else {
			remove_theme_support( 'block-templates' );
		}

		$this->maybe_transform_the7_in_to_block_theme();
	}

	/**
	 * @param \The7_Content_Importer $importer Importer instance.
	 *
	 * @return void
	 */
	public function on_import( $importer ) {
		if ( ! $importer->fetch_attachments && ! $importer->get_filtered_post_id() ) {
			$this->set_fse_version( PRESSCORE_FSE_VERSION );
		}
	}

	/**
	 * @return void
	 */
	public function enqueue_styles() {
		the7_register_style(
			'the7-fse-styles',
			PRESSCORE_THEME_URI . '/css/compatibility/gutenberg/global.css'
		);
		wp_enqueue_style( 'the7-fse-styles' );
	}

	/**
	 * @return void
	 */
	public function register_block_styles() {
		// register_block_style(
		// 'core/button',
		// [
		// 'name'  => 'accent-2',
		// 'label' => __( 'Accent 2', 'the7mk2' ),
		// ]
		// );
		register_block_style(
			'core/button',
			[
				'name'  => 'style-6',
				'label' => __( 'Link', 'the7mk2' ),
			]
		);
		register_block_style(
			'core/button',
			[
				'name'  => 'style-1',
				'label' => __( 'XS', 'the7mk2' ),
			]
		);
		register_block_style(
			'core/button',
			[
				'name'  => 'style-2',
				'label' => __( 'S', 'the7mk2' ),
			]
		);
		register_block_style(
			'core/button',
			[
				'name'  => 'style-3',
				'label' => __( 'M', 'the7mk2' ),
			]
		);
		register_block_style(
			'core/button',
			[
				'name'  => 'style-4',
				'label' => __( 'L', 'the7mk2' ),
			]
		);
		register_block_style(
			'core/button',
			[
				'name'  => 'style-5',
				'label' => __( 'XL', 'the7mk2' ),
			]
		);

		register_block_style(
			'core/navigation',
			[
				'name'         => 'default',
				'label'        => __( 'Default', 'the7mk2' ),
				'is_default'   => true,
				'inline_style' => '
					.wp-block-navigation {
						--wp-navigation-submenu-gap: 5px;
					}
					.wp-block-navigation .wp-block-navigation__submenu-container {
						margin-top: var(--wp-navigation-submenu-gap);
					}
					.wp-block-navigation .wp-block-navigation__submenu-container:before {
						content: "";
						height: var(--wp-navigation-submenu-gap);
						width: 100%;
						position: absolute;
						top: calc(-1px - var(--wp-navigation-submenu-gap));
						left: 0;
					}
					.wp-block-navigation:has(.is-menu-open) .wp-block-navigation__submenu-container {
						margin-top: 0;
					}
					.wp-block-navigation:has(.is-menu-open) .wp-block-navigation__submenu-container:before {
						content: none;
					}

					.wp-block-navigation.is-style-underline,
					.wp-block-navigation.is-style-elastic {
						--wp-navigation-submenu-gap: 10px;
					}
					.wp-block-navigation.is-style-underline .wp-block-navigation-item__content:hover,
					.wp-block-navigation.is-style-underline .is-menu-open .wp-block-navigation-item__content:hover,
					.wp-block-navigation.is-style-elastic .wp-block-navigation-item__content:hover,
					.wp-block-navigation.is-style-elastic .is-menu-open .wp-block-navigation-item__content:hover {
						color: inherit !important;
					}
					.wp-block-navigation.is-style-underline.has-hover .wp-block-navigation__submenu-container .wp-block-navigation-item__content:hover,
					.wp-block-navigation.is-style-elastic.has-hover .wp-block-navigation__submenu-container .wp-block-navigation-item__content:hover {
						color: var(--wp-navigation-hover, initial) !important;
					}
					.wp-block-navigation.is-style-underline.has-submenu-hover .wp-block-navigation__submenu-container .wp-block-navigation-item__content:hover,
					.wp-block-navigation.is-style-elastic.has-submenu-hover .wp-block-navigation__submenu-container .wp-block-navigation-item__content:hover {
						color: var(--wp-navigation-submenu-hover, initial) !important;
					}
				',
			]
		);

		register_block_style(
			'core/navigation',
			[
				'name'         => 'underline',
				'label'        => __( 'Underline', 'the7mk2' ),
				'inline_style' => '
					.wp-block-navigation.is-style-underline .wp-block-navigation-item__content {
						position: relative;
					}
					.wp-block-navigation.is-style-underline .wp-block-navigation-item__content:after {
						content: "";
						position: absolute;
						width: auto;
						height: 2px;
						background: var(--wp-navigation-hover, currentColor);
						left: 0;
						right: 0;
						bottom: -2px;
						opacity: 0;
						transition: opacity .1s;
					}
					.wp-block-navigation.is-style-underline .wp-block-navigation-item__content:hover:after {
						opacity: 1;
					}
					.wp-block-navigation.is-style-underline.has-submenu-hover  .is-menu-open .wp-block-navigation-item__content:after {
    					background: var(--wp-navigation-submenu-hover, currentColor);
					}
					.wp-block-navigation.is-style-underline .wp-block-navigation__submenu-container .wp-block-navigation-item__content.wp-block-navigation-item__content:after {
						content: none;
					}
				',
			]
		);

		register_block_style(
			'core/navigation',
			[
				'name'         => 'elastic',
				'label'        => __( 'Elastic', 'the7mk2' ),
				'inline_style' => '
					.wp-block-navigation.is-style-elastic .wp-block-navigation-item__content {
						position: relative;
					}
					.wp-block-navigation.is-style-elastic .wp-block-navigation-item__content:after {
						content: "";
						position: absolute;
						width: auto;
						height: 2px;
						background: var(--wp-navigation-hover, currentColor);
						left: 50%;
						right: 50%;
						bottom: -2px;
						opacity: 0;
						translate3d(0, 0, 0);
						transition: left .3s cubic-bezier(.175,.885,.32,1.275), right .3s cubic-bezier(.175,.885,.32,1.275), opacity .3s ease;
					}
					.wp-block-navigation.is-style-elastic .wp-block-navigation-item__content:hover:after {
						left: 0;
						right: 0;
						opacity: 1;
					}
					.wp-block-navigation.is-style-elastic.has-submenu-hover  .is-menu-open .wp-block-navigation-item__content:after {
    					background: var(--wp-navigation-submenu-hover, currentColor);
					}
					.wp-block-navigation.is-style-elastic .wp-block-navigation__submenu-container .wp-block-navigation-item__content.wp-block-navigation-item__content:after {
						content: none;
					}

					.wp-block-navigation.is-style-elastic .wp-block-navigation__submenu-container,
					.wp-block-navigation.is-style-elastic .wp-block-navigation__submenu-container .wp-block-navigation-item__content {
						transition-duration: .2s !important;
					}
				',
			]
		);
	}

	/**
	 * Register pattern categories
	 *
	 * @return void
	 */
	public function add_pattern_categories() {
		register_block_pattern_category(
			'dt-the7_page',
			[
				'label'       => _x( 'Pages', 'Block pattern category', 'the7mk2' ),
				'description' => _x( 'A collection of full page layouts. ', 'Block pattern category', 'the7mk2' ),
			]
		);
	}

	/**
	 * @return void
	 */
	public function maybe_transform_the7_in_to_block_theme() {
		if ( the7_is_gutenberg_theme_mode_active() && ! wp_is_block_theme() ) {
			$this->copy_block_theme_files();
		} elseif ( ! the7_is_gutenberg_theme_mode_active() && wp_is_block_theme() ) {
			$this->delete_block_theme_files();
		}
	}

	/**
	 * @return bool
	 */
	public function copy_block_theme_files() {
        $this->delete_block_theme_files();
		$filesystem = the7_get_filesystem();
		if ( is_wp_error( $filesystem ) ) {
			return false;
		}

		$dir  = get_template_directory();
		$version = $this->get_fse_version();
		$from    = "{$dir}/fse/versions/v{$version}";
		copy_dir( $from, $dir );

		wp_get_theme()->cache_delete();

		return true;
	}

	/**
	 * Get FSE version. Note. On theme update we should save the version of the current FSE files. On demo import it is enought to delete
	 *
	 * @return string
	 */
	public function get_fse_version() {
		$version = get_site_transient( self::FSE_VERSION_OPTION );

		return $this->is_valid_version( $version ) ? $version : PRESSCORE_FSE_VERSION;
	}

	/**
	 * Check if FSE version exists.
	 *
	 * @return bool
	 */
	public function fse_version_exists() {
		return get_site_transient( self::FSE_VERSION_OPTION ) !== false;
	}

	/**
	 * Set FSE version and copy files.
	 *
	 * @param string $version only digits and dot as a separator
	 *
	 * @return bool
	 */
	public function set_fse_version( $version ) {
		if ( $this->is_valid_version( $version ) ) {
            set_site_transient( self::FSE_VERSION_OPTION, $version );
            $this->copy_block_theme_files();
			return true;
		}
		return false;
	}

	private function is_valid_version( $version ) {
		return preg_match( '/^\d+(\.\d+)*$/', $version );
	}

	public function delete_fse_version() {
        delete_site_transient( self::FSE_VERSION_OPTION );
	}

	/**
	 * @return bool
	 */
	public function delete_block_theme_files() {
		$filesystem = the7_get_filesystem();
		if ( is_wp_error( $filesystem ) ) {
			return false;
		}

		$dir             = get_template_directory();
		$files_to_remove = [
			'theme.json',
			'templates',
			'parts',
			'patterns',
		];
		foreach ( $files_to_remove as $file ) {
			$file_path = $dir . '/' . $file;

			if ( $filesystem->exists( $file_path ) ) {
				$filesystem->delete( $file_path, true );
			}
		}
		wp_get_theme()->cache_delete();

		return true;
	}
}
