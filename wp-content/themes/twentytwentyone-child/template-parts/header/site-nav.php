<?php
/**
 * Displays the site navigation.
 *
 * @package WordPress
 * @subpackage Twenty_Twenty_One
 * @since Twenty Twenty-One 1.0
 */

?>

<?php if ( has_nav_menu( 'primary' ) ) : ?>
	
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.2/css/bootstrap.min.css">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
	<nav id="site-navigation" class="primary-navigation" aria-label="<?php esc_attr_e( 'Primary menu', 'twentytwentyone' ); ?>">
		<div class="menu-button-container">
			<button id="primary-mobile-menu" class="button" aria-controls="primary-menu-list" aria-expanded="false">
				<span class="dropdown-icon open"><?php esc_html_e( 'Menu', 'twentytwentyone' ); ?>
					<?php echo twenty_twenty_one_get_icon_svg( 'ui', 'menu' ); // phpcs:ignore WordPress.Security.EscapeOutput ?>
				</span>
				<span class="dropdown-icon close"><?php esc_html_e( 'Close', 'twentytwentyone' ); ?>
					<?php echo twenty_twenty_one_get_icon_svg( 'ui', 'close' ); // phpcs:ignore WordPress.Security.EscapeOutput ?>
				</span>
			</button><!-- #primary-mobile-menu -->
		</div><!-- .menu-button-container -->
		<?php
		wp_nav_menu(
			array(
				'theme_location'  => 'primary',
				'menu_class'      => 'menu-wrapper',
				'container_class' => 'primary-menu-container',
				'items_wrap'      => '<ul id="primary-menu-list" class="%2$s">%3$s<li><button type="button" class="btn btn-dark dropdown-toggle" data-toggle="modal" data-target="#cartModal"><i class="fa fa-shopping-cart" style="font-size:36px;float:right"></i></button><span>'.do_shortcode("[woocommerce_cart_icon]").'</span></li></ul>',
				'fallback_cb'     => false,
			)
		);
		?>

<div class="modal fade" id="cartModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header border-bottom-0">
                    <h5 class="modal-title" id="exampleModalLabel">
                        Your Shopping Cart
                    </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <table class="table table-image">
                        <thead>
                            <tr>
                                <th scope="col"></th>
                                <th scope="col">Product</th>
                                <th scope="col">Price</th>
                                <th scope="col">Qty</th>
                                <th scope="col">Total</th>
                                <th scope="col">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            global $woocommerce;
                            $items = $woocommerce->cart->get_cart();
                            //echo '<pre>';
                            //print_r($items);
                            foreach ($items as $cart_item_key => $cart_item) {
                                // gets the product object
                                ///print_r($cart_item['product_id']);
                                $product = $cart_item['data'];
                                $product_id = $cart_item['product_id'];

                            ?>
                                <tr>
                                    <td class="w-25">
                                        <?php $url = wp_get_attachment_url(get_post_thumbnail_id($product->ID)); ?>
                                        <img class="img-fluid img-thumbnail" alt="Sheep" src="<?php echo $product->get_image(); ?>
                                    </td>
                                    <td><?php echo $product->get_name(); ?></td>
                                    <td><?php echo '$' . $product->get_price(); ?></td>
                                    <td><?php echo $cart_item['quantity'] ?></td>
                                    <td><?php echo '$' . $cart_item['line_subtotal']; ?></td>
                                    <td>
                                    <a href=" #" class="btn btn-danger btn-sm">
                                        <i class="fa fa-times"></i>
                                        </a>
                                    </td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                    <div class="d-flex justify-content-end">
                        <h5>Total: <span class="price text-success"><?php echo '$' . WC()->cart->subtotal; ?></span></h5>
                    </div>
                </div>
                <div class="modal-footer border-top-0 d-flex justify-content-between">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-success">Checkout</button>
                </div>
            </div>
        </div>
    </div>

	</nav><!-- #site-navigation -->
<?php endif; ?>
