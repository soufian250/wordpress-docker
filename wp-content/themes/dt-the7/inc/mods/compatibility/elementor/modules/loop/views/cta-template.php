<?php

use Elementor\TemplateLibrary\Source_Local;
use The7\Mods\Compatibility\Elementor\Widgets\Loop_Scroller as Loop_ScrollerAlias;
use The7\Mods\Compatibility\Elementor\Widgets\Posts_Loop;
use The7\Mods\Compatibility\Elementor\Widgets\Slider_Loop;
use The7\Mods\Compatibility\Elementor\Widgets\Slider;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
?>

<?php
$template = 'tmpl-%s-cta';
$name = sprintf( $template, Slider::WIDGET_NAME );
?>
<script type="text/template" id="<?php echo $name;?>">
    <style>
        /* Hide empty view, until Shadow DOM stying has loaded. */
        .e-loop-empty-view__box,
        .elementor-swiper-button,
        .swiper-pagination {
            opacity: 0;
        }
    </style>
    <div class="e-loop-empty-view__box e-loop-empty-view__box--active">
        <div class="e-loop-empty-view__box-inner">
            <img src="<?php echo ELEMENTOR_ASSETS_URL . 'images/information.svg'; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>" />
            <div class="e-loop-empty-view__box-title">
				<?php echo esc_html__( 'The7 Slider starts with a template.', 'the7mk2' ); ?>
            </div>
            <div class="e-loop-empty-view__box-description">
				<?php
				echo esc_html__( 'Either choose an existing template or create a new one and use it as the template in the slide.', 'the7mk2' );
				$link = admin_url( Source_Local::ADMIN_MENU_SLUG . '&elementor_library_type=' . The7\Mods\Compatibility\Elementor\Modules\Slider\Module::DOCUMENT_TYPE );
				?>
            </div>
            <a href="<?php echo $link ?>" target="_blank" class="e-loop-empty-view__box-cta">
		        <?php echo esc_html__( 'Create/Edit slide template', 'the7mk2' ); ?>
            </a>
        </div>
    </div>
    <div class="elementor-swiper-button elementor-swiper-button-prev" tabindex="0" role="button" aria-label="Previous slide">
        <svg aria-hidden="true" class="e-font-icon-svg e-eicon-chevron-left" viewBox="0 0 1000 1000" width="1" height="1" xmlns="http://www.w3.org/2000/svg"><path d="M646 125C629 125 613 133 604 142L308 442C296 454 292 471 292 487 292 504 296 521 308 533L604 854C617 867 629 875 646 875 663 875 679 871 692 858 704 846 713 829 713 812 713 796 708 779 692 767L438 487 692 225C700 217 708 204 708 187 708 171 704 154 692 142 675 129 663 125 646 125Z"></path></svg>
        <span class="elementor-screen-only">Previous</span>
    </div>
    <div class="elementor-swiper-button elementor-swiper-button-next" tabindex="0" role="button" aria-label="Next slide">
        <svg aria-hidden="true" class="e-font-icon-svg e-eicon-chevron-right" viewBox="0 0 1000 1000" width="1" height="1" xmlns="http://www.w3.org/2000/svg"><path d="M696 533C708 521 713 504 713 487 713 471 708 454 696 446L400 146C388 133 375 125 354 125 338 125 325 129 313 142 300 154 292 171 292 187 292 204 296 221 308 233L563 492 304 771C292 783 288 800 288 817 288 833 296 850 308 863 321 871 338 875 354 875 371 875 388 867 400 854L696 533Z"></path></svg>
        <span class="elementor-screen-only">Next</span>
    </div>
    <div class="swiper-pagination swiper-pagination-clickable swiper-pagination-bullets">
        <span class="swiper-pagination-bullet swiper-pagination-bullet-active" tabindex="0" role="button" aria-label="Go to slide 1"></span>
        <span class="swiper-pagination-bullet" tabindex="0" role="button" aria-label="Go to slide 2"></span>
        <span class="swiper-pagination-bullet" tabindex="0" role="button" aria-label="Go to slide 3"></span>
    </div>
</script>

<?php
$name = sprintf( $template, Slider_Loop::WIDGET_NAME );
?>
<script type="text/template" id="<?php echo $name;?>">
	<style>
        /* Hide empty view, until Shadow DOM stying has loaded. */
        .e-loop-empty-view__box,
        .elementor-swiper-button,
        .swiper-pagination {
            opacity: 0;
        }
	</style>
	<div class="e-loop-empty-view__box e-loop-empty-view__box--active">
		<div class="e-loop-empty-view__box-inner">
			<img src="<?php echo ELEMENTOR_ASSETS_URL . 'images/information.svg'; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>" />
			<div class="e-loop-empty-view__box-title">
				<?php echo esc_html__( 'The7 Loop Slider starts with a template.', 'the7mk2' ); ?>
			</div>
			<div class="e-loop-empty-view__box-description">
				<?php
				echo esc_html__( 'Either choose an existing template or create a new one and use it as the main item for your loop.', 'the7mk2' );
				?>
			</div>
			<a href="#" class="e-loop-empty-view__box-cta">
				<?php echo esc_html__( 'Create a template', 'the7mk2' ); ?>
			</a>
		</div>
	</div>
	<div class="elementor-swiper-button elementor-swiper-button-prev" tabindex="0" role="button" aria-label="Previous slide">
		<svg aria-hidden="true" class="e-font-icon-svg e-eicon-chevron-left" viewBox="0 0 1000 1000" width="1" height="1" xmlns="http://www.w3.org/2000/svg"><path d="M646 125C629 125 613 133 604 142L308 442C296 454 292 471 292 487 292 504 296 521 308 533L604 854C617 867 629 875 646 875 663 875 679 871 692 858 704 846 713 829 713 812 713 796 708 779 692 767L438 487 692 225C700 217 708 204 708 187 708 171 704 154 692 142 675 129 663 125 646 125Z"></path></svg>
		<span class="elementor-screen-only">Previous</span>
	</div>
	<div class="elementor-swiper-button elementor-swiper-button-next" tabindex="0" role="button" aria-label="Next slide">
		<svg aria-hidden="true" class="e-font-icon-svg e-eicon-chevron-right" viewBox="0 0 1000 1000" width="1" height="1" xmlns="http://www.w3.org/2000/svg"><path d="M696 533C708 521 713 504 713 487 713 471 708 454 696 446L400 146C388 133 375 125 354 125 338 125 325 129 313 142 300 154 292 171 292 187 292 204 296 221 308 233L563 492 304 771C292 783 288 800 288 817 288 833 296 850 308 863 321 871 338 875 354 875 371 875 388 867 400 854L696 533Z"></path></svg>
		<span class="elementor-screen-only">Next</span>
	</div>
	<div class="swiper-pagination swiper-pagination-clickable swiper-pagination-bullets">
		<span class="swiper-pagination-bullet swiper-pagination-bullet-active" tabindex="0" role="button" aria-label="Go to slide 1"></span>
		<span class="swiper-pagination-bullet" tabindex="0" role="button" aria-label="Go to slide 2"></span>
		<span class="swiper-pagination-bullet" tabindex="0" role="button" aria-label="Go to slide 3"></span>
	</div>
</script>

<?php
$name = sprintf( $template, Posts_Loop::WIDGET_NAME );
$source = Elementor\Plugin::$instance->templates_manager->get_source( 'local' );
$templates = $source->get_items( [ 'type' => 'loop-item' ] );
$items = wp_list_pluck( $templates, 'title', 'template_id' );

?>
<script type="text/template" id="<?php echo $name;?>">

    <style>
        /* Hide empty view, until Shadow DOM stying has loaded. */
        .e-loop-empty-view__box,
        .elementor-swiper-button,
        .swiper-pagination {
            opacity: 0;
        }
    </style>
    <div class="e-loop-empty-view__box e-loop-empty-view__box--active">
        <div class="e-loop-empty-view__box-inner">
            <img src="<?php echo ELEMENTOR_ASSETS_URL . 'images/information.svg'; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>" />
            <div class="e-loop-empty-view__box-title">
				<?php echo esc_html__( 'The7 Masonry & Grid Loop starts with a template.', 'the7mk2' ); ?>
            </div>
            <div class="e-loop-empty-view__box-description">
				<?php
				echo esc_html__( 'Either choose an existing template or create a new one and use it as the main item for your loop.', 'the7mk2' );
				?>
            </div>
            <a href="#" class="e-loop-empty-view__box-cta">
				<?php echo esc_html__( 'Create a template', 'the7mk2' ); ?>
            </a>
        </div>
    </div>
    <div class="e-loop-empty-view__box">
        <div class="e-loop-empty-view__box-inner"></div>
    </div>
    <div class="e-loop-empty-view__box">
        <div class="e-loop-empty-view__box-inner"></div>
    </div>
</script>


<?php
$name = sprintf( $template, Loop_ScrollerAlias::WIDGET_NAME );
?>
<script type="text/template" id="<?php echo $name;?>">
    <style>
        /* Hide empty view, until Shadow DOM stying has loaded. */
        .e-loop-empty-view__box,
        .elementor-swiper-button,
        .swiper-pagination {
            opacity: 0;
        }
    </style>
    <div class="e-loop-empty-view__box e-loop-empty-view__box--active">
        <div class="e-loop-empty-view__box-inner">
            <img src="<?php echo ELEMENTOR_ASSETS_URL . 'images/information.svg'; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>" />
            <div class="e-loop-empty-view__box-title">
                <?php echo esc_html__( 'The7 Loop Scroller starts with a template.', 'the7mk2' ); ?>
            </div>
            <div class="e-loop-empty-view__box-description">
                <?php
                echo esc_html__( 'Either choose an existing template or create a new one and use it as the main item for your loop.', 'the7mk2' );
                ?>
            </div>
            <a href="#" class="e-loop-empty-view__box-cta">
                <?php echo esc_html__( 'Create a template', 'the7mk2' ); ?>
            </a>
        </div>
    </div>
</script>