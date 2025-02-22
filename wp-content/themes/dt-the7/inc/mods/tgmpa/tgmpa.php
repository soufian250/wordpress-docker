<?php
/**
 * The7 TGM plugin module.
 *
 * @since 3.0.0
 * @package The7
 */

defined( 'ABSPATH' ) || exit;

if ( ! class_exists( 'Presscore_Modules_TGMPAModule', false ) ) :

	/**
	 * Presscore_Modules_TGMPAModule class.
	 */
	class Presscore_Modules_TGMPAModule {

		/**
		 * Execute module.
		 */
		public static function execute() {
			if ( ( defined( 'WP_CLI' ) && WP_CLI ) || is_admin() ) {
				self::init_the7_tgmpa();
			} else {
				return;
			}

			add_filter( 'pre_set_site_transient_update_plugins', [ __CLASS__, 'update_plugins_list' ], 99 );
			add_filter( 'site_transient_update_plugins', [ __CLASS__, 'update_plugins_list' ], 99 );
			add_action( 'tgmpa_register', [ __CLASS__, 'register_plugins_action' ] );

			// Allow to install plugins hidden with `protected_slug`.
			add_filter( 'presscore_tgmpa_module_plugins_list', [ __CLASS__, 'install_protected_plugins_filter' ], 20 );
		}

		/**
		 * Init The7 TGMPA.
		 */
		public static function init_the7_tgmpa() {
			global $the7_tgmpa;

			// Bail if $the7_tgmpa already registered.
			if ( is_a( $the7_tgmpa, 'The7_TGMPA' ) ) {
				return;
			}

			require_once dirname( __FILE__ ) . '/class-the7-tgm-plugin-activation.php';
			require_once dirname( __FILE__ ) . '/class-the7-tgmpa.php';
			require_once dirname( __FILE__ ) . '/class-the7-plugins-list-table.php';
		}

		/**
		 * Register TGMPA actions.
		 */
		public static function register_plugins_action() {
			$plugins = self::get_plugins_list_cache();
			if ( ! $plugins ) {
				$plugins = self::get_update_plugin_list();
				if ( is_wp_error( $plugins ) ) {
                    // Plugins list shouldn't be empty. For fun.
					$plugins = [
						[
							'name'     => 'WooCommerce',
							'slug'     => 'woocommerce',
							'required' => false,
						],
						[
							'name'     => 'Contact Form 7',
							'slug'     => 'contact-form-7',
							'required' => false,
						],
					];
				}
			}

			// Add these plugins just for auto activation purpose.
			$plugins[] = [
				'name'          => 'Elementor Pro',
				'slug'          => 'elementor-pro',
				'required'      => false,
				'activate_only' => true,
			];
			$plugins[] = [
				'name'          => 'PRO Elements',
				'slug'          => 'pro-elements',
				'required'      => false,
				'activate_only' => true,
				'aliases'       => [ 'elementor-pro' ],
			];

			$config = array(
				'id'           => 'the7_tgmpa',
				'menu'         => 'the7-plugins',
				'parent_slug'  => 'admin.php?page=the7-dashboard',
				'dismissable'  => true,
				'has_notices'  => true,
				'is_automatic' => true,
				'strings'      => array(
					'page_title'                      => __( 'The7 Plugins', 'the7mk2' ),
					'menu_title'                      => __( 'The7 Plugins', 'the7mk2' ),
					'installing'                      => __( 'Installing Plugin: %s', 'the7mk2' ),
					'oops'                            => __( 'Something went wrong with the plugin API.', 'the7mk2' ),
					'notice_can_install_required'     => _n_noop( 'This theme requires the following plugin: %1$s.', 'This theme requires the following plugins: %1$s.', 'the7mk2' ),
					'notice_can_install_recommended'  => _n_noop( 'This theme recommends the following plugin: %1$s.', 'This theme recommends the following plugins: %1$s.', 'the7mk2' ),
					'notice_cannot_install'           => false,
					'notice_can_activate_required'    => _n_noop( 'The following required plugin is currently inactive: %1$s.', 'The following required plugins are currently inactive: %1$s.', 'the7mk2' ),
					'notice_can_activate_recommended' => _n_noop( 'The following recommended plugin is currently inactive: %1$s.', 'The following recommended plugins are currently inactive: %1$s.', 'the7mk2' ),
					'notice_cannot_activate'          => false,
					'notice_ask_to_update'            => _n_noop( 'The following plugin needs to be updated to its latest version to ensure maximum compatibility with this theme: %1$s.', 'The following plugins need to be updated to their latest version to ensure maximum compatibility with this theme: %1$s.', 'the7mk2' ),
					'notice_cannot_update'            => false,
					'install_link'                    => _n_noop( 'Begin installing plugin', 'Begin installing plugins', 'the7mk2' ),
					'activate_link'                   => _n_noop( 'Activate installed plugin', 'Activate installed plugins', 'the7mk2' ),
					'return'                          => __( 'Return to Plugins Installer', 'the7mk2' ),
					'plugin_activated'                => __( 'Plugin activated successfully.', 'the7mk2' ),
					'complete'                        => __( 'All plugins installed and activated successfully. %s', 'the7mk2' ),
					'nag_type'                        => 'updated',
				),
			);

			self::register_plugins_with_the7_tgmpa( $plugins, $config );
		}

		/**
		 * Print inline js for the notice dismiss button.
		 */
		public static function print_inline_js_action() {
			?>
			<script type="text/javascript">
				jQuery(function($) {
					$('#setting-error-tgmpa .notice-dismiss').off().on('click.the7.tgmpa.dismiss', function(event) {
						location.href = $('#setting-error-tgmpa a.dismiss-notice').attr('href');
					});
				});
			</script>
			<?php
		}

		/**
		 * Register plugins with The7 TGMPA.
		 *
		 * @param array $plugins Plugins list.
		 * @param array $config TGMPA config.
		 */
		protected static function register_plugins_with_the7_tgmpa( $plugins, $config ) {
			the7_tgmpa( $plugins, $config );

			$the7_tgmpa_instance = The7_TGM_Plugin_Activation::get_instance();

			if ( $the7_tgmpa_instance && ! $the7_tgmpa_instance->is_tgmpa_complete() ) {
				add_action( 'admin_print_footer_scripts', array( __CLASS__, 'print_inline_js_action' ) );
			}
		}

		/**
		 * Fires on the page load.
		 *
		 * @param string $page_hook Page hook.
		 */
		public static function setup_hooks( $page_hook ) {
			add_action( 'load-' . $page_hook, array( __CLASS__, 'remove_update_filters' ) );
			add_action( 'load-' . $page_hook, array( __CLASS__, 'update_plugins_list_on_page_load' ) );
			add_action( "admin_print_styles-{$page_hook}", array( __CLASS__, 'print_inline_css' ) );
			add_action( "admin_print_scripts-{$page_hook}", array( __CLASS__, 'enqueue_scripts' ) );
		}

		/**
		 * This function prevents plugin update api modification, so tgmpa can do its job.
		 */
		public static function remove_update_filters() {
			$tags_to_wipe = array(
				'pre_set_site_transient_update_plugins',
				'update_api',
				'plugins_api',
			);

			// Wipe out filters.
			foreach ( $tags_to_wipe as $tag ) {
				remove_all_filters( $tag );
			}
		}

		/**
		 * Update plugins list on admin page load.
		 */
		public static function update_plugins_list_on_page_load() {
			self::update_plugins_list_once_in_10_minutes();
		}

		/**
		 * Print inline styles.
		 */
		public static function print_inline_css() {
			wp_add_inline_style(
				'the7-admin',
				'
		        .wrap iframe { display: none; }
		        #tgmpa-plugins .column-version p:nth-child(2) span { color: #71C671; font-weight: bold; }
		    '
			);
		}

		/**
		 * Enqueue admin scripts.
		 *
		 * @see the7_register_admin_scripts
		 */
		public static function enqueue_scripts() {
			wp_enqueue_script( 'the7-dashboard-plugins' );
		}

		/**
		 * Update plugins list.
		 *
		 * @param mixed $transient Plugins update transient..
		 *
		 * @return mixed
		 */
		public static function update_plugins_list( $transient ) {
			self::update_plugins_list_once_in_10_minutes();
			$transient = self::inject_plugins_update_information( $transient );

			return $transient;
		}

		/**
		 * Inject plguins update information into WP `update_plugins` transient.
		 *
		 * @param mixed $transient
		 *
		 * @return stdClass Plugin updates transient.
		 */
		protected static function inject_plugins_update_information( $transient ) {
			global $the7_tgmpa;

			if ( ! $the7_tgmpa ) {
				return $transient;
			}

			// Overcome "Manage WP" plugin ajax call.
			if ( empty( $the7_tgmpa->plugins ) ) {
				self::register_plugins_action();
			}

			if ( ! is_object( $transient ) ) {
				$transient           = new stdClass();
				$transient->response = [];
			}

			foreach ( $the7_tgmpa->plugins as $slug => $plugin ) {
				if ( ! $the7_tgmpa->is_the7_plugin( $slug ) ) {
					continue;
				}

				$file_path = $plugin['file_path'];
				$item      = [
					'id'            => $file_path,
					'slug'          => $slug,
					'plugin'        => $file_path,
					'new_version'   => $the7_tgmpa->get_installed_version( $slug ),
					'url'           => '',
					'package'       => '',
					'icons'         => [],
					'banners'       => [],
					'banners_rtl'   => [],
					'tested'        => '',
					'requires_php'  => '',
					'compatibility' => new stdClass(),
				];

				if ( ! $the7_tgmpa->is_plugin_updatetable( $slug ) ) {
					unset( $transient->response[ $file_path ] );
					$transient->no_update[ $file_path ] = (object) $item;
					continue;
				}

				$new_version         = $the7_tgmpa->get_plugin_minimum_version( $slug );
				$item['new_version'] = $new_version;

				$source = $the7_tgmpa->get_download_url( $slug );
				if ( $the7_tgmpa->plugin_has_multiple_versions( $slug ) ) {
					$source = $the7_tgmpa->add_plugin_version_query_arg( $source, $slug, $new_version );
				}
				$item['package'] = $source;

				if ( ! empty( $plugin['external_url'] ) ) {
					$item['url'] = $plugin['external_url'];
				}

				$optional_fields = [
					'icons',
					'tested',
					'requires_php',
				];
				foreach ( $optional_fields as $field ) {
					if ( isset( $plugin[ $field ] ) ) {
						$item[ $field ] = $plugin[ $field ];
					}
				}

				$transient->response[ $file_path ] = (object) $item;
			}

			return $transient;
		}

		/**
		 * Update and return plugins list.
		 *
		 * @uses The7_Remote_API
		 *
		 * @return array|WP_Error
		 */
		public static function get_update_plugin_list() {
			$plugins_list = self::get_plugins_list_cache();
			if ( defined( 'THE7_PREVENT_PLUGINS_UPDATE' ) && THE7_PREVENT_PLUGINS_UPDATE && $plugins_list ) {
				return $plugins_list;
			}

			$code            = presscore_get_purchase_code();
			$the7_remote_api = new The7_Remote_API( $code );

			$plugins_list = $the7_remote_api->check_plugins_list();
			if ( $plugins_list && ! is_wp_error( $plugins_list ) ) {
				// Set plugins source.
				foreach ( $plugins_list as $index => $info ) {
					if ( isset( $info['version'], $info['slug'] ) ) {
						$plugins_list[ $index ]['source'] = $the7_remote_api->get_plugin_download_url( $info['slug'] );
					}
				}

				$plugins_list = array_values( $plugins_list );

				// Store update info in db to use later in 'presscore_tgmpa_module_plugins_list' filter.
				self::set_plugins_list_cache( $plugins_list );
			}

			return $plugins_list;
		}

		/**
		 * Store plugins list.
		 *
		 * @param array $list Plugins list.
		 *
		 * @return bool
		 */
		public static function set_plugins_list_cache( $list = array() ) {
			return update_site_option( 'the7_plugins_list', $list );
		}

		/**
		 * Retrieve plugins list.
		 *
		 * @return array
		 */
		public static function get_plugins_list_cache() {
			$plugins = (array) get_site_option( 'the7_plugins_list', array() );

			return apply_filters( 'presscore_tgmpa_module_plugins_list', $plugins );
		}

		/**
		 * Delete plugins list.
		 *
		 * @return bool
		 */
		public static function delete_plugins_list_cache() {
			return delete_site_option( 'the7_plugins_list' );
		}

		/**
		 * @param array $plugins Plugins list.
		 *
		 * @return array
		 */
		public static function install_protected_plugins_filter( $plugins ) {
			if ( isset( $_POST['tgmpa_install_protected_plugins'] ) && wp_verify_nonce( $_POST['tgmpa_install_protected_plugins'], 'tgmpa_install_protected_plugins' ) ) {
				foreach ( $plugins as &$plugin ) {
					if ( isset( $plugin['protected_slug'] ) ) {
						$plugin['slug'] = $plugin['protected_slug'];
						unset( $plugin['protected_slug'] );
					}
				}
				unset( $plugin );
			}

			return $plugins;
		}

		/**
		 * @return void
		 */
		public static function print_protected_plugins_installation_form_field() {
			wp_nonce_field( 'tgmpa_install_protected_plugins', 'tgmpa_install_protected_plugins', false );
		}

		/**
		 * Update plugins list once in 10 minutes.
		 *
		 * @since 7.1.2
		 */
		protected static function update_plugins_list_once_in_10_minutes() {
			$ten_minutes        = MINUTE_IN_SECONDS * 10;
			$last_check_time    = (int) get_site_option( 'the7_plugins_last_check', 0 );
			$its_time_to_update = time() - $last_check_time > $ten_minutes;
			if ( $its_time_to_update ) {
				self::get_update_plugin_list();
				update_site_option( 'the7_plugins_last_check', time() );
			}
		}
	}

	/**
	 * Important to override this function before The7_TGM_Plugin_Activation class include!
	 * This maneuver prevents original class from loading and allow us to extend it in a subclass.
	 */
	if ( ! function_exists( 'load_tgm_plugin_activation' ) ) {

		/**
		 * Override TGMPA bootstrap function.
		 */
		function load_tgm_plugin_activation() {
			// Do nothing.
		}
	}

	Presscore_Modules_TGMPAModule::execute();

endif;
