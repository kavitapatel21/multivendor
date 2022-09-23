<?php

/**
 * Displays the site navigation.
 *
 * @package WordPress
 * @subpackage Twenty_Twenty_One
 * @since Twenty Twenty-One 1.0
 */

?>

<?php if (has_nav_menu('primary')) : ?>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <nav id="site-navigation" class="primary-navigation" aria-label="<?php esc_attr_e('Primary menu', 'twentytwentyone'); ?>">
        <div class="menu-button-container">
            <button id="primary-mobile-menu" class="button" aria-controls="primary-menu-list" aria-expanded="false">
                <span class="dropdown-icon open"><?php esc_html_e('Menu', 'twentytwentyone'); ?>
                    <?php echo twenty_twenty_one_get_icon_svg('ui', 'menu'); // phpcs:ignore WordPress.Security.EscapeOutput 
                    ?>
                </span>
                <span class="dropdown-icon close"><?php esc_html_e('Close', 'twentytwentyone'); ?>
                    <?php echo twenty_twenty_one_get_icon_svg('ui', 'close'); // phpcs:ignore WordPress.Security.EscapeOutput 
                    ?>
                </span>
            </button><!-- #primary-mobile-menu -->
        </div><!-- .menu-button-container -->
        <?php
        //do_shortcode('[CONTACT-US-FORM]');
        wp_nav_menu(
            array(
                'theme_location'  => 'primary',
                'menu_class'      => 'menu-wrapper',
                'container_class' => 'primary-menu-container',
                'items_wrap'      => '<ul id="primary-menu-list" class="%2$s">%3$s<li><button type="button" class="btn btn-dark dropdown-toggle" id="popup"><i class="fa fa-shopping-cart" style="font-size:36px;float:right"></i></button><span></span></li></ul>',        
                'fallback_cb'     => false,
            )
        );
        ?>      
    </nav><!-- #site-navigation -->
<?php endif; ?>