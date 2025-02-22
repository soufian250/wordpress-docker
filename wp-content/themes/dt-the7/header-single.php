<?php
/**
 * Template part with actual header.
 *
 * @since 1.0.0
 *
 * @package The7\Templates
 */

defined( 'ABSPATH' ) || exit;

?><!DOCTYPE html>
<!--[if !(IE 6) | !(IE 7) | !(IE 8)  ]><!-->
<html <?php language_attributes(); ?> class="no-js">
<!--<![endif]-->
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>" />
	<?php if ( presscore_responsive() ) : ?>
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=0">
	<?php endif ?>
	<?php presscore_theme_color_meta(); ?>
	<link rel="profile" href="https://gmpg.org/xfn/11" />
	<?php
	wp_head();
	?>
</head>
<body id="the7-body" <?php body_class(); ?>>
<?php
wp_body_open();
do_action( 'presscore_body_top' );

$config = presscore_config();

$page_class = '';
if ( 'boxed' === $config->get( 'template.layout' ) ) {
	$page_class = 'class="boxed"';
}
?>

<div id="page" <?php echo $page_class; ?>>
	<a class="skip-link screen-reader-text" href="#content"><?php _e( 'Skip to content', 'the7mk2' ); ?></a>
<?php
if ( apply_filters( 'presscore_show_header', $config->get( 'header.show' ) ) ) {
	presscore_get_template_part( 'theme', 'header/header', str_replace( '_', '-', $config->get( 'header.layout' ) ) );
	presscore_get_template_part( 'theme', 'header/mobile-header' );
}

//block_template_part( 'header' );

if ( presscore_is_content_visible() && $config->get( 'template.footer.background.slideout_mode' ) ) {
	echo '<div class="page-inner">';
}
?>
