<?php
/**
 * Single Product Up-Sells
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product/up-sells.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see         https://woocommerce.com/document/template-structure/
 * @package     WooCommerce\Templates
 * @version     9.6.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( $upsells ) : ?>

	<section class="up-sells upsells products">
		<?php
		$heading = apply_filters( 'woocommerce_product_upsells_products_heading', __( 'You may also like&hellip;', 'woocommerce' ) );

		if ( $heading ) :
			?>
			<h2><?php echo esc_html( $heading ); ?></h2>
		<?php endif; ?>

		<ul class="related-product cart-btn-below-img">

			<?php presscore_config()->set( 'product.preview.icons.show_cart', true ) ?>

			<?php foreach ( $upsells as $upsell ) : ?>

                <li>
				<?php
                    global $product;

					$product = wc_get_product( $upsell->get_id() );
					if ( $product->is_on_sale() ) :
						?>
                        <span class="onsale"></span>
					<?php
					endif;
					?>
                    <a class="product-thumbnail" href="<?php echo esc_url( $product->get_permalink() ); ?>">
						<?php echo $product->get_image(); ?>
                    </a>
                    <div class="product-content">
                        <a class="product-title" href="<?php echo esc_url( $product->get_permalink() ); ?>">
							<?php echo $product->get_name(); ?>
                        </a>

                        <span class="price"><?php echo $product->get_price_html(); ?></span>

						<?php
						if ( wc_review_ratings_enabled() ) {
							echo wc_get_rating_html( $product->get_average_rating() );
						}

						if ( presscore_config()->get( 'product.related.show_cart_btn' ) ) {
							echo '<div class="woo-buttons">' . dt_woocommerce_get_product_add_to_cart_icon() . '</div>';
						}
				?>
                    </div>

                </li>


			<?php endforeach; ?>

        </ul>

	</section>

<?php endif;

wp_reset_postdata();
