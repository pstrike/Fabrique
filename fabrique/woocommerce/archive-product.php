<?php
/**
 * The Template for displaying product archives, including the main shop page which is a post type archive
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/archive-product.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you (the theme developer).
 * will need to copy the new files to your theme to maintain compatibility. We try to do this.
 * as little as possible, but it does happen. When this occurs the version of the template file will.
 * be bumped and the readme will list any important changes.
 *
 * @see 	    http://docs.woothemes.com/document/template-structure/
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     2.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

$sidebar = fabrique_mod( 'shop_sidebar' );
$sidebar_position = fabrique_mod( 'shop_sidebar_position' );
$sidebar_select = fabrique_mod( 'shop_sidebar_select' );
$sidebar_fixed = fabrique_mod( 'shop_sidebar_fixed' );
$content_class = 'fbq-content';
$content_class .= ( fabrique_mod( 'page_title' ) ) ? ' fbq-content--with-header' : ' fbq-content--no-header';
$container_class = ( fabrique_mod( 'shop_full_width' ) ) ? 'fbq-container--fullwidth' : 'fbq-container';

get_header('shop'); ?>
	<?php
		/**
		 * woocommerce_before_main_content hook
		 *
		 * @hooked woocommerce_output_content_wrapper - 10 (outputs opening divs for the content)
		 * @hooked woocommerce_breadcrumb - 20
		 *
		 * Remove Breadcrumb and Remove loop start
		 * do_action( 'woocommerce_before_main_content' );
		 */
	?>
	<div class="<?php echo esc_attr( $content_class ); ?>">
		<div class="fbq-content-wrapper">


			<?php if ( apply_filters( 'woocommerce_show_page_title', true ) ) : ?>
				<?php
					// Replace all WooCommerce Breadcrumb and Page Title by Theme default page title.
					// Remove action of description and replace in function 'archive_title_options'
					get_template_part( 'templates/archive-title' );
				?>
			<?php endif; ?>

			<div class="<?php echo esc_attr( $container_class ); ?>">
				<main id="main" class="<?php echo esc_attr( fabrique_main_page_class( $sidebar, $sidebar_position ) ); ?> blueprint-inactive">
					<div class="fbq-shop">
					<?php if ( have_posts() ) : ?>

						<div class="fbq-products-nav">
							<?php
								/**
								 * woocommerce_before_shop_loop hook
								 *
								 * @hooked woocommerce_result_count - 20
								 * @hooked woocommerce_catalog_ordering - 30
								 */
								do_action( 'woocommerce_before_shop_loop' );
							?>
						</div>

						<?php woocommerce_product_loop_start(); ?>

							<?php woocommerce_product_subcategories(); ?>

							<?php while ( have_posts() ) : the_post(); ?>

								<?php
									/**
									 * woocommerce_shop_loop hook.
									 *
									 * @hooked WC_Structured_Data::generate_product_data() - 10
									 */
									do_action( 'woocommerce_shop_loop' );
								?>

								<?php wc_get_template_part( 'content', 'product' ); ?>

							<?php endwhile; // end of the loop. ?>

						<?php woocommerce_product_loop_end(); ?>

						<?php
							/**
							 * woocommerce_after_shop_loop hook
							 *
							 * @hooked woocommerce_pagination - 10
							 */
							do_action( 'woocommerce_after_shop_loop' );
						?>

					<?php elseif ( ! woocommerce_product_subcategories( array( 'before' => woocommerce_product_loop_start( false ), 'after' => woocommerce_product_loop_end( false ) ) ) ) : ?>

						<?php
							/**
							 * woocommerce_no_products_found hook.
							 *
							 * @hooked wc_no_products_found - 10
							 */
							do_action( 'woocommerce_no_products_found' );
						?>

					<?php endif; ?>
					</div>
				</main>

				<?php if ( $sidebar ) : ?>
					<aside class="<?php echo esc_attr( fabrique_sidebar_class( $sidebar_position, $sidebar_fixed ) ); ?>" itemscope="itemscope" itemtype="http://schema.org/WPSideBar">
						<?php fabrique_template_sidebar_background(); ?>
						<div class="fbq-widgets">
				  <?php if ( is_active_sidebar( $sidebar_select ) ) : ?>
					<ul class="fbq-widgets-list">
					  <?php dynamic_sidebar( $sidebar_select ); ?>
					</ul>
				  <?php endif; ?>
				</div>
					</aside>
				<?php endif ; ?>

			</div>

		</div>
	</div>
	<?php
		/**
		 * woocommerce_after_main_content hook
		 *
		 * @hooked woocommerce_output_content_wrapper_end - 10 (outputs closing divs for the content)
		 * Remove loop end
		 * do_action( 'woocommerce_after_main_content' );
		 */
	?>

<?php get_footer( 'shop' ); ?>
