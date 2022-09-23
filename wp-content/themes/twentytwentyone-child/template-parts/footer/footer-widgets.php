<?php

/**
 * Displays the footer widget area.
 *
 * @package WordPress
 * @subpackage Twenty_Twenty_One
 * @since Twenty Twenty-One 1.0
 */


if (is_active_sidebar('sidebar-1')) : ?>

    <aside class="widget-area">
        <?php dynamic_sidebar('sidebar-1'); ?>
    </aside><!-- .widget-area -->

<?php endif; ?>
<script src="https://code.jquery.com/jquery-2.2.3.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>
<script>
    //remove product from cart on click (x) inside popup modal
    //$('.remove').click(function() {
    $(document).on('click', ".remove", function() {
        var product_id = $(this).attr('data-product_id');
        jQuery.ajax({
            url: '<?php echo admin_url('admin-ajax.php'); ?>',
            type: 'post',
            dataType: 'json',
            data: {
                'action': 'remove_item_from_cart',
                'product_id': product_id
            },
            success: function(response) {
                console.log(response);
                jQuery('.menu-product-id-' + product_id).remove();
                $("#message").html(response);
                $('.text-success').html('$' + response.cart_total);
                if (response.msg) {
                    $('#msg').show();
                    $('div.d-flex h5').hide();
                }
               
                //window.location.href = '<?php echo wc_get_cart_url(); ?>';
            }
        });
        return false;
    });

    //Update cart quantity
    $(document).on('click', '.qty', function() {
        //alert('here');
        var item_hash = $(this).attr('name').replace(/cart\[([\w]+)\]\[qty\]/g, "$1");
        var item_quantity = $(this).val();
        var currentVal = parseFloat(item_quantity);
        var product_key = $(this).attr('product_key');
        $.ajax({
            type: 'POST',
            url: '<?php echo admin_url('admin-ajax.php'); ?>',
            dataType: 'json',
            data: {
                action: 'my_cart_qty',
                hash: item_hash,
                quantity: currentVal,
                product_key: product_key
            },
            beforeSend: function() {
                jQuery('#loading').show();
            },
            success: function(data) {
                //alert(data.quantity);
                if (data.quantity == 0) {
                    $('tbody.menu-product-id-' + product_key + ' tr').remove();
                }
                $('tbody.menu-product-id-' + product_key + ' tr td.product-subtotal').html('$' + data.product_total);
                $('.text-success').html('$' + data.cart_total);
                if (data.msg) {
                    $('#msg').show();
                    $('div.d-flex h5').hide();
                }
                console.log('success');
                jQuery('#loading').hide();
                $('.woocommerce-cart-form button[type="submit"]').click();
            }
        });
    });

    //$('.btn').on('click', function() {
    $(document).on('click', ".btn", function() {
        $.ajax({
            url: '<?php echo admin_url('admin-ajax.php'); ?>',
            type: 'post',
            data: {
                action: 'mini_cart_data',
            },
            success: function(response) {
                //console.log('success');
                $(response).modal();
            }
        });
    });

    //Apply custom coupon
    $(document).on('click', "#apply_custom_coupon", function() {
        var coupon_code = $('#custom_coupon').val();
        //alert(coupon_code);
        $.ajax({
            url: '<?php echo admin_url('admin-ajax.php'); ?>',
            type: 'post',
            //dataType: 'json',
            data: {
                action: 'apply_custom_coupon',
                coupon_code : coupon_code,
            },
            success: function(response) {
                console.log('success');
                $('div.woocommerce-notices-wrapper').hide();
                $('.woocommerce-cart-form button[type="submit"]').click();
            }
        });
    });
</script>