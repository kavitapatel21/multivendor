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
    $('.remove').click(function() {
        //alert('hello');
        var productid = $(this).attr('data-product_id');
        //alert(productid);
        jQuery.ajax({
            url: '<?php echo admin_url('admin-ajax.php'); ?>',
            type: 'post',
            dataType: 'json',
            data: {
                'action': 'remove_item_from_cart',
                'product_id': productid
            },
            success: function(response) {
                //alert("Removed successfully");
                //$(document.body).trigger('wc_fragments_refreshed');
                window.location.href = '<?php echo wc_get_cart_url(); ?>';
            }
        });
    });


    //Update cart quantity
    $(document).on('click', '.qty', function(e) {
        e.preventDefault();
        var item_hash = $(this).attr('name').replace(/cart\[([\w]+)\]\[qty\]/g, "$1");
        var item_quantity = $(this).val(); 
        var currentVal = parseFloat(item_quantity);
        $.ajax({
            type: 'POST',
            url: '<?php echo admin_url('admin-ajax.php'); ?>',
            data: {
                action: 'my_cart_qty',
                hash: item_hash,
                quantity: currentVal
            },
            success: function(response) {
                //jQuery(document.body).trigger('added_to_cart', [response.fragments, response.cart_hash, $thisbutton]);
                //alert('Update successfully');
                window.location.href = '<?php echo wc_get_cart_url(); ?>';
                //jQuery(document.body).trigger('update_checkout');
            }
        });
    });
</script>