<?php

/**
 * Plugin Name:       adrianpajares.com - Get Subtotal Cart
 * Plugin URI:        https://adrianpajares.com/
 * Description:       Plugin to get the subtotal in cart. Shotcode: [ap_get_subtotal]
 * Version:           1.0
 * Author:            adrianpajares.com
 * License:           MIT
 */

function shortcode_ap_cart_subtotal() {

    echo WC()->cart->get_subtotal();

}
add_shortcode('ap_get_subtotal', 'shortcode_ap_cart_subtotal');
