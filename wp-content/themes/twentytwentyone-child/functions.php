<?php
/* Child theme generated with WPS Child Theme Generator */

if (!function_exists('b7ectg_theme_enqueue_styles')) {
    add_action('wp_enqueue_scripts', 'b7ectg_theme_enqueue_styles');

    function b7ectg_theme_enqueue_styles()
    {
        wp_enqueue_style('parent-style', get_template_directory_uri() . '/style.css');
        wp_enqueue_style('child-style', get_stylesheet_directory_uri() . '/style.css', array('parent-style'));
    }
}


//apply discount based on category using coupon
/**add_action( 'woocommerce_before_calculate_totals', 'wc_auto_add_coupons_categories_based', 10, 1 );
function wc_auto_add_coupons_categories_based( $cart_object ) {

    // HERE define your product categories and your coupon code
    $categories = array('5-offers','offers');
    $coupon = '6VNXP3CT';

    if ( is_admin() && ! defined( 'DOING_AJAX' ) )
        return;

    // Initialising variables
    $has_category = false;

    //  Iterating through each cart item
    foreach ( $cart_object->get_cart() as $cart_item ) {
        // If a cart item belongs to a product category
        if( has_term( $categories, 'product_cat', $cart_item['product_id'] ) ){
            $has_category = true; // Set to true
            break; // stop the loop
        }
    }

    // If conditions are matched add the coupon discount
    if( $has_category && ! $cart_object->has_discount( $coupon )){
        // Apply the coupon code
        $cart_object->add_discount( $coupon );

        // Optionally display a message 
        wc_add_notice( __('my message goes here'), 'notice');
    } 
    // If conditions are not matched and coupon has been appied
    elseif( ! $has_category && $cart_object->has_discount( $coupon )){
        // Remove the coupon code
        $cart_object->remove_coupon( $coupon );

        // Optionally display a message 
        wc_add_notice( __('my warning message goes here'), 'alert');
    }
}**/


add_action('woocommerce_cart_calculate_fees', 'discount_based_on_total', 25, 1);
function discount_based_on_total($cart)
{

    if (is_admin() && !defined('DOING_AJAX')) return;
    /**$10 discount on cart total>$100 */
    $total = $cart->cart_contents_total;

    // $10 discount on cart total if cart total >100
    if ($total >= 100) {
        $discount = 10;
        $cart->add_fee(__('discount', 'woocommerce'), -$discount);
    }


    // $20 charge on cart total if cart total<100
    if ($total < 100) {
        $charge = 20;
        $cart->add_fee(__('charge', 'woocommerce'), +$charge);
    }



    /**$5 discount if category '5-offers' or 'offers'  */
    // Initialising variables
    $has_category = false;
    $categories = array('5-offers', 'offers');
    //  Iterating through each cart item
    foreach (WC()->cart->get_cart() as $cart_item) {
        // If a cart item belongs to a product category
        if (has_term($categories, 'product_cat', $cart_item['product_id'])) {
            $has_category = true; // Set to true
            break; // stop the loop
        }
    }
    // Applying discount
    if ($has_category) {
        // Discount calculation (Drop the per item qty price)
        $price = 5;
        $cart->add_fee(__('category-discount', 'woocommerce'), -$price);
    }
}


/*
 * Shortcode for WooCommerce Cart Icon for Menu Item
 */
add_shortcode('woocommerce_cart_icon', 'woo_cart_icon');
function woo_cart_icon()
{
    ob_start();

    $cart_count = WC()->cart->cart_contents_count; // Set variable for cart item count
    $cart_url = wc_get_cart_url();  // Set variable for Cart URL

    echo '<a class="menu-item cart-contents" href="' . $cart_url . '" title="Cart" style="color:white;">';

    if ($cart_count > 0) {

        echo '<span class="cart-contents-count">' . $cart_count . '</span>';
    }

    echo '</a>';


    return ob_get_clean();
}

/*
 * Filter with AJAX When Cart Contents Update
 */
add_filter('woocommerce_add_to_cart_fragments', 'woo_cart_icon_count');
function woo_cart_icon_count($fragments)
{

    ob_start();

    $cart_count = WC()->cart->cart_contents_count;
    $cart_url = wc_get_cart_url();
    echo '<a class="cart-contents menu-item" href="' . $cart_url . '" title="View Cart">';

    if ($cart_count > 0) {

        echo '<span class="cart-contents-count">' . $cart_count . '</span>';
    }
    echo '</a>';
    $fragments['a.cart-contents'] = ob_get_clean();

    return $fragments;
}

/**show cart icon on navigation menu
add_filter( 'wp_nav_menu_items', 'your_custom_menu_item');
function your_custom_menu_item ($items)
{
    $items .= '<li><i class="fa fa-shopping-cart" style="font-size:36px">'.do_shortcode("[woocommerce_cart_icon]").'</i></li>';
    return $items;
}*/

add_action('wp_footer', 'cart_icon_click_script');
function cart_icon_click_script()
{
?>
   

    <script>
        $('.remove-item').click(function() {
            $.ajax({
                type: "POST",
                url: '<?php echo admin_url('admin-ajax.php'); ?>',
                data: {
                    action: 'remove_item_from_cart',
                    'cart_item_key': String($(this).data('cart-item-key'))
                }
            });
        });
    </script>
<?php
}

function remove_item_from_cart()
{
    $cart_item_key = $_POST['cart_item_key'];
    if ($cart_item_key) {
        WC()->cart->remove_cart_item($cart_item_key);
        return true;
    }
    return false;
}
add_action('wp_ajax_remove_item_from_cart', 'remove_item_from_cart');
add_action('wp_ajax_nopriv_remove_item_from_cart', 'remove_item_from_cart');
