<?php
/**
 * Tools tab template.
 *
 * @package The7/Dev/Templates
 */

defined( 'ABSPATH' ) || exit;
?>
<h2>Tools</h2>
<?php
$tools_message = get_transient( 'the7-dev-tools-message' );
if ( $tools_message ) {
	echo '<div class="the7-dev-tools-message the7-dashboard-notice the7-notice notice inline notice-info">' . wp_kses_post( $tools_message ) . '</div>';
	delete_transient( 'the7-dev-tools-message' );
}
?>
<form action="<?php echo esc_url( admin_url( 'admin-post.php' ) ); ?>" method="post">
	<?php wp_nonce_field( 'the7-dev-tools' ); ?>
	<input type="hidden" name="action" value="the7_use_dev_tool">

	<table class="form-table">
		<tbody>

		<tr>
			<th scope="row">Run DB migration</th>
			<td>
				<?php
				$migrations = array_slice( array_reverse( array_keys( \The7_Install::get_update_callbacks() ) ), 0, 10 );
				?>
				<select name="migration">
					<?php
					foreach ( $migrations as $migration ) {
						printf( '<option value="%1$s">%1$s</option>', esc_attr( $migration ) );
					}
					?>
				</select>
				<button type="submit" class="button" name="tool" value="run_migration">Migrate</button>

				<p class="description">
					<span style="color: red">Warning: Please backup your database before migrating.</span>
				</p>
			</td>
		</tr>

		<?php if ( the7_is_gutenberg_theme_mode_active() ) : ?>

		<tr><th scope="row"></th><td><div><div><hr></div></div></td></tr>

		<tr>
			<th scope="row">Change theme.json version</th>
			<td>
				<select name="themejson_version">
					<?php
					$json_versions = glob( get_template_directory() . '/fse/versions/*', GLOB_ONLYDIR );
					if ( is_array( $json_versions ) ) {
						$the7_compat_obj = The7\Mods\Compatibility\Gutenberg\Block_Theme\The7_Block_Theme_Compatibility::instance();
						$current_version = '';
						if ( $the7_compat_obj->fse_version_exists() ) {
							$current_version = $the7_compat_obj->get_fse_version();
						}
						foreach ( $json_versions as $version ) {
							$version = str_replace( 'v', '', basename( $version ) );
							echo '<option value="' . esc_attr( $version ) . '"' . selected( $version, $current_version ) . '>' . esc_html( $version ) . '</option>';
						}
					} else {
						?>
						<option value="">--none--</option>
						<?php
					}
					?>
				</select>
				<button type="submit" class="button" name="tool" value="change_themejson_version">Change</button>
				<p class="description">
					<span style="color: red">Warning: This will override current theme.json file.</span>
				</p>
			</td>
		</tr>

		<tr><th scope="row"></th><td><div><div><hr></div></div></td></tr>

		<tr>
			<th scope="row">FSE style fonts</th>
			<td>
				<button type="submit" class="button" name="tool" value="trigger_fse_styles_font_download">Refresh</button>
			</td>
		</tr>

		<?php endif; ?>

		<?php if ( function_exists( 'the7_generate_shortcode_css' ) ) : ?>

		<tr><th scope="row"></th><td><div><div><hr></div></div></td></tr>

		<tr>
			<th scope="row">Regenerate shortcodes CSS</th>
			<td>
				<button type="submit" class="button" name="tool" value="regenerate_shortcodes_css">Regenerate CSS</button>
			</td>
		</tr>

		<?php endif; ?>

		<?php if ( function_exists( 'of_get_option' ) ) : ?>

		<tr><th scope="row"></th><td><div><div><hr></div></div></td></tr>

		<tr>
			<th scope="row">Restore theme options</th>
			<td>
				<button type="submit" class="button" name="tool" value="delete_all_theme_options_backups">Delete all backups</button>
				<select name="theme_options_backup">
					<option value="">--none--</option>
					<?php
					$backup_records = The7_Options_Backup::get_records();
					foreach ( $backup_records as $backup ) {
						$backup_name = str_replace( 'the7-theme-options-backup-', '', $backup );
						echo '<option value="' . esc_attr( $backup ) . '">' . esc_html( $backup_name ) . '</option>';
					}
					?>
				</select>
				<button type="submit" class="button" name="tool" value="restore_theme_options_from_backup">Restore options</button>
				<p class="description">
					<span style="color: red">Warning: This will reset your Theme Options.</span>
				</p>
			</td>
		</tr>

		<?php endif; ?>

		<?php if ( class_exists( '\The7_Core\Mods\Post_Type_Builder\Post_Type_Builder' ) ) : ?>

			<tr><th scope="row"></th><td><div><div><hr></div></div></td></tr>

			<tr>
				<th scope="row">"Post Type Builder" data</th>
				<td>
					<button type="submit" class="button" name="tool" value="delete_post_type_builder_data">Delete</button>
				</td>
			</tr>

		<?php endif ?>

		</tbody>
	</table>

</form>
