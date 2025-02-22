<?php
/**
 * Login form
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/global/form-login.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see         https://woocommerce.com/document/template-structure/
 * @package     WooCommerce\Templates
 * @version     9.2.0
 */

 /**
 * Important! Strings with the7mk2 textdomain.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

if ( is_user_logged_in() ) {
	return;
}

?>
<form class="woocommerce-form woocommerce-form-login login" method="post" <?php echo ( $hidden ) ? 'style="display:none;"' : ''; ?>>

	<?php do_action( 'woocommerce_login_form_start' ); ?>

	<?php
	if ( $message ) {
		echo '<div class="log-message">' . wpautop( wptexturize( $message ) ) . '</div>';
	}
	?>
	<p class="form-row form-row-first name-row">
	    <span class="screen-reader-text"><?php esc_html_e( 'Required', 'the7mk2' ); ?></span>
		<input type="text" class="input-text" name="username" id="username" autocomplete="username" placeholder="<?php esc_attr_e( 'Username or email *', 'the7mk2' ); ?>" required aria-required="true" />
    </p>
	<p class="form-row form-row-last password-row">
		<span class="screen-reader-text"><?php esc_html_e( 'Required', 'the7mk2' ); ?></span>
		<input class="input-text" type="password" name="password" id="password" autocomplete="current-password" placeholder="<?php esc_attr_e( 'Password *', 'the7mk2' ); ?>" required aria-required="true" />
    </p>
    <div class="clear"></div>

	<?php do_action( 'woocommerce_login_form' ); ?>

    <p class="form-row">
		<?php wp_nonce_field( 'woocommerce-login', 'woocommerce-login-nonce' ); ?>
			<input type="submit" class="button" name="login" value="<?php esc_attr_e( 'Login', 'the7mk2' ); ?>" />
    </p>
		<input type="hidden" name="redirect" value="<?php echo esc_url( $redirect ) ?>" />
		<label for="rememberme" class="inline">
			<input name="rememberme" type="checkbox" id="rememberme" value="forever" /> <?php esc_html_e( 'Remember me', 'the7mk2' ); ?>
		</label>
    <p class="lost_password">
		<a href="<?php echo esc_url( wp_lostpassword_url() ); ?>"><?php esc_html_e( 'Lost your password?', 'the7mk2' ); ?></a>
    </p>

    <div class="clear"></div>

	<?php do_action( 'woocommerce_login_form_end' ); ?>

</form>
