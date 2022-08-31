<?php
/**
 * The template for displaying demo plugin content.
 *
 * Override this template by copying it to yourtheme/dc-product-vendor/emails/plain/customer-answer.php
 *
 * @author 		WC Marketplace
 * @package 	dc-product-vendor/Templates
 * @version   0.0.1
 */
 
 
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
global $WCMp;
$answer = isset( $answer ) ? $answer : '';
$product_id = isset( $product_id ) ? $product_id : '';
$product = wc_get_product($product_id);
echo $email_heading . "\n\n"; 
echo sprintf(  __('Your question had been noted and answered by the vendor : %s', 'dc-woocommerce-multi-vendor'), $answer ); 
echo '\n\n';
echo sprintf( __('Kindly check if the reply is up to your satisfaction : %s', 'dc-woocommerce-multi-vendor'), esc_url($product->get_permalink()) ); 
echo '\n\n';
echo apply_filters( 'wcmp_email_footer_text', get_option( 'wcmp_email_footer_text' ) );