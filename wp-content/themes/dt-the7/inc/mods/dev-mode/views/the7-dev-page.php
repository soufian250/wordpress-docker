<?php
/**
 * Main template for the dev page.
 *
 * @package The7/Dev/Templates
 */

defined( 'ABSPATH' ) || exit;

$dev_tab = 'tools';
if ( isset( $_GET['tab'] ) ) {
	$dev_tab = basename( wp_unslash( $_GET['tab'] ) );
}
?>
<nav class="nav-tab-wrapper">
	<?php
	$dev_tabs = [
		'tools'             => 'Tools',
		'install'           => 'Installation',
		'activation-log'    => 'Activation Log',
		'import-log'        => 'Import Log',
		'migrations-queued' => 'Migrations Queued',
	];
	foreach ( $dev_tabs as $tab_id => $tab_title ) {
		printf(
			'<a href="%1$s" class="nav-tab %2$s">%3$s</a>',
			esc_url( admin_url( 'admin.php?page=the7-dev&tab=' . $tab_id ) ),
			$tab_id === $dev_tab ? 'nav-tab-active' : '',
			esc_html( $tab_title )
		);
	}
	?>
</nav>
<div class="wrap">
	<?php get_template_part( 'inc/mods/dev-mode/views/tab', $dev_tab ); ?>
</div>
