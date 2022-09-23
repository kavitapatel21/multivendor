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
/**add_shortcode('woocommerce_cart_icon', 'woo_cart_icon');
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
}*/

/*
 * Filter with AJAX When Cart Contents Update
 */
/**add_filter('woocommerce_add_to_cart_fragments', 'woo_cart_icon_count');
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
}*/

/**show cart icon on navigation menu
add_filter( 'wp_nav_menu_items', 'your_custom_menu_item');
function your_custom_menu_item ($items)
{
    $items .= '<li><i class="fa fa-shopping-cart" style="font-size:36px">'.do_shortcode("[woocommerce_cart_icon]").'</i></li>';
    return $items;
}*/

//change cart quantity
function ajax_my_cart_qty()
{
    global $woocommerce;
    // Set item key as the hash found in input.qty's name
    $cart_item_key = $_POST['hash'];
    $quantity = $_POST['quantity'];
    $product_key = $_POST['product_key'];
    // Get the array of values owned by the product we're updating
    $threeball_product_values = WC()->cart->get_cart_item($cart_item_key);
    // Get the quantity of the item in the cart
    //echo '<pre>';
    //print_r($threeball_product_values);
    $threeball_product_quantity = apply_filters('woocommerce_stock_amount_cart_item', apply_filters('woocommerce_stock_amount', preg_replace("/[^0-9\.]/", '', filter_var($_POST['quantity'], FILTER_SANITIZE_NUMBER_INT))), $cart_item_key);

    // Update cart validation
    $passed_validation  = apply_filters('woocommerce_update_cart_validation', true, $cart_item_key, $threeball_product_values, $threeball_product_quantity);

    // Update the quantity of the item in the cart
    if ($passed_validation) {
        WC()->cart->set_quantity($cart_item_key, $threeball_product_quantity, true);
    }
    $response = array();
    if (WC()->cart->is_empty()) {
        $response['msg'] = '<h3>No cart item found</h3>';
    }
    $product = wc_get_product($threeball_product_values['product_id']);
    //print_r($product);
    $price = $product->get_price();
    $price = (int) $quantity * $price;
    //echo $price;
    $response['product_total'] = $price;
    $response['cart_total'] = WC()->cart->get_subtotal();
    $response['product_key'] = $product_key;
    $response['quantity'] = $quantity;
    echo json_encode($response);
    die();
}
add_action('wp_ajax_my_cart_qty', 'ajax_my_cart_qty');
add_action('wp_ajax_nopriv_my_cart_qty', 'ajax_my_cart_qty');


function mini_cart_data_callback()
{
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
                <div class="modal-body" id="modal-body">
                    <?php
                    global $woocommerce;
                    $items = $woocommerce->cart->get_cart();
                    //echo '<pre>';
                    // print_r($items);
                    if ($items) {
                    ?>
                        <form class="woocommerce-cart-form" action="http://localhost/multivendor/cart/" method="post">
                            <table class="shop_table shop_table_responsive cart woocommerce-cart-form__contents" cellspacing="0">
                                <?php
                                foreach ($items as $cart_item_key => $cart_item) {
                                    // gets the product object
                                    $product = $cart_item['data'];
                                    $product_id = $cart_item['product_id'];
                                ?>
                                    <tbody class="menu-product-id-<?php echo $cart_item['key']; ?>">
                                        <tr class="woocommerce-cart-form__cart-item cart_item">

                                            <td class="product-remove">
                                                <a href="http://localhost/multivendor/cart/?remove_item=<?php echo $cart_item['key']; ?>&amp;" class="remove" aria-label="Remove this item" data-product_id="<?php echo $cart_item['key']; ?>" data-product_sku="">×</a>
                                            </td>
                                            <td class="product-thumbnail">
                                                <?php $url = wp_get_attachment_url(get_post_thumbnail_id($product->ID)); ?>
                                                <a href="<?php echo get_permalink($product_id); ?>">
                                                    <img width="450" height="450" src="<?php echo $product->get_image(); ?></a>
                                            </td>

                                            <td class=" product-name" data-title="Product">
                                                    <a href="<?php echo get_permalink($product_id); ?>"><?php echo $product->get_name(); ?></a>
                                            </td>
                                            <td class="product-price" data-title="Price">
                                                <span class="woocommerce-Price-amount amount"><bdi><span class="woocommerce-Price-currencySymbol">$</span><?php echo $product->get_price(); ?></bdi></span>
                                            </td>
                                            <td class="product-quantity" data-title="Quantity">
                                                <div class="quantity">
                                                    <label class="screen-reader-text" for="quantity_6322e1bda483b">offer-product quantity</label>
                                                    <input type="number" id="quantity_6322e1bda483b" product_key="<?php echo $cart_item['key']; ?>" class="input-text qty text" step="1" min="0" max="" name="cart[<?php echo $cart_item['key'] ?>][qty]" value="<?php echo $cart_item['quantity']; ?>" title="Qty" size="4" placeholder="" inputmode="numeric" autocomplete="off">
                                                </div>
                                            </td>
                                            <td class="product-subtotal" data-title="Subtotal">
                                                <span class="woocommerce-Price-amount amount"><bdi><span class="woocommerce-Price-currencySymbol">$</span><?php echo $cart_item['line_subtotal']; ?></bdi></span>
                                            </td>
                                        </tr>

                                        <div id="loading" style="display: none;">
                                            <h4>Please Wait...</h4>
                                        </div>
                                    </tbody>
                                <?php } ?>
                            </table>
                            <div class=" d-flex justify-content-end">
                                <h5>Total: <span class="price text-success"><?php echo '$' . WC()->cart->subtotal; ?></span></h5>
                            </div>
                        <?php } else {
                        ?>
                            <h3>No cart item found</h3>
                        <?php
                    } ?>
                        </form>
                </div>
                <div id="message"></div>
                <div id="msg" style="display: none;">
                    <h3>No cart item found</h3>
                </div>
            </div>
        </div>
    </div>
<?php
    wp_die();
}
add_action('wp_ajax_mini_cart_data', 'mini_cart_data_callback');
add_action('wp_ajax_nopriv_mini_cart_data', 'mini_cart_data_callback');

//remove item from cart
function remove_item_from_cart()
{
    global $woocommerce;
    $id = $_POST['product_id'];

    $woocommerce->cart->remove_cart_item($id);
    $response = array();
    if (WC()->cart->is_empty()) {
        $response['msg'] = '<h3>No cart item found</h3>';
    }

    $response['cart_total'] = WC()->cart->get_subtotal();
    echo json_encode($response);
    //return WC()->cart->calculate_totals();
    //return woocommerce_cart_totals();
    wp_die();
}
add_action('wp_ajax_remove_item_from_cart', 'remove_item_from_cart');
add_action('wp_ajax_nopriv_remove_item_from_cart', 'remove_item_from_cart');


//apply coupon automatically
add_action('wp_ajax_apply_custom_coupon', 'apply_coupon_cart_values');
add_action('wp_ajax_nopriv_apply_custom_coupon', 'apply_coupon_cart_values');
function apply_coupon_cart_values()
{
    // previously created coupon
    $coupon_code = $_POST['coupon_code'];
    echo $coupon_code;

    global $woocommerce; 
    WC()->cart->remove_coupons();
    $ret = WC()->cart->add_discount( $coupon_code ); 
    //wc_print_notices();
    wc_clear_notices();
    $response = array('return' => $ret); 
    echo json_encode($response);
    //print_r($response); 
    wp_die();
}

add_action('init', 'custom_coupon');
function custom_coupon()
{
    /**
     * Create a coupon programatically
     */
    $coupon_code = 'UNIQUECODE'; // Code
    $amount = '10'; // Amount
    $discount_type = 'fixed_cart'; // Type: fixed_cart, percent, fixed_product, percent_product
    if (!wc_get_coupon_id_by_code('UNIQUECODE')) {
        $coupon = array(
            'post_title' => $coupon_code,
            'post_content' => '',
            'post_status' => 'publish',
            'post_author' => 1,
            'post_type' => 'shop_coupon'
        );
        $new_coupon_id = wp_insert_post($coupon);
        // Add meta
        update_post_meta($new_coupon_id, 'discount_type', $discount_type);
        update_post_meta($new_coupon_id, 'coupon_amount', $amount);
        update_post_meta($new_coupon_id, 'individual_use', 'no');
        update_post_meta($new_coupon_id, 'product_ids', '');
        update_post_meta($new_coupon_id, 'exclude_product_ids', '');
        update_post_meta($new_coupon_id, 'usage_limit', '');
        update_post_meta($new_coupon_id, 'expiry_date', '');
        update_post_meta($new_coupon_id, 'apply_before_tax', 'yes');
        update_post_meta($new_coupon_id, 'free_shipping', 'no');
    }
}
