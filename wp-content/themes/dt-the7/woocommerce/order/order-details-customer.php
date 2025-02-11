<?php
/**
 * Order Customer Details
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/order/order-details-customer.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://woo.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 8.7.0
 */

/**
 * Important! Strings with the7mk2 textdomain.
 */

defined( 'ABSPATH' ) || exit;

$show_shipping = ! wc_ship_to_billing_address_only() && $order->needs_shipping_address();
?>
<header><h4><?php esc_html_e( 'Customer Details', 'the7mk2' ); ?></h4></header>

<table class="shop_table customer_details">
	<?php if ( $order->get_billing_email() ) : ?>
		<tr>
			<th><?php esc_html_e( 'Email:', 'the7mk2' ); ?></th>
			<td><?php echo esc_html( $order->get_billing_email() ); ?></td>
		</tr>
	<?php endif; ?>

	<?php if ( $order->get_billing_phone() ) : ?>
		<tr>
			<th><?php esc_html_e( 'Phone:', 'the7mk2' ); ?></th>
			<td><?php echo esc_html( $order->get_billing_phone() ); ?></td>
		</tr>
	<?php endif; ?>

	<tr>
		<th><?php esc_html_e( 'Billing Address', 'the7mk2' ); ?></th>
		<td><?php echo wp_kses_post( $order->get_formatted_billing_address( esc_html__( 'N/A', 'the7mk2' ) ) ); ?></td>

		<?php
		/**
		 * Action hook fired after an address in the order customer details.
		 *
		 * @since 8.7.0
		 * @param string $address_type Type of address (billing or shipping).
		 * @param WC_Order $order Order object.
		 */
		do_action( 'woocommerce_order_details_after_customer_address', 'billing', $order );
		?>
	</tr>

	<?php if ( $show_shipping ) : ?>
		<tr>
			<th><?php esc_html_e( 'Shipping Address', 'the7mk2' ); ?></th>
			<td>
				<?php echo wp_kses_post( $order->get_formatted_shipping_address( esc_html__( 'N/A', 'the7mk2' ) ) ); ?>

				<?php if ( $order->get_shipping_phone() ) : ?>
					<br><p class="woocommerce-customer-details--phone"><?php echo esc_html( $order->get_shipping_phone() ); ?></p>
				<?php endif; ?>

				<?php
				/**
				 * Action hook fired after an address in the order customer details.
				 *
				 * @since 8.7.0
				 * @param string $address_type Type of address (billing or shipping).
				 * @param WC_Order $order Order object.
				 */
				do_action( 'woocommerce_order_details_after_customer_address', 'shipping', $order );
				?>
			</td>
		</tr>
	<?php endif; ?>

	<?php do_action( 'woocommerce_order_details_after_customer_details', $order ); ?>

</table>

