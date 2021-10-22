<?php

/**
 * Plugin Name:       adrianpajares.com - Get Percentage (Cart Subtotal/Free Shipping)
 * Plugin URI:        https://adrianpajares.com/
 * Description:       Plugin to get the subtotal in cart and define free shipping quantity. You can modify the free shipping quantity at setting page. Shotcodes: [ap_get_subtotal] [ap_get_fsquantity] [ap_get_display] [ap_get_per]
 * Version:           3.0
 * Author:            adrianpajares.com
 * License:           MIT
 */

add_action( 'admin_menu', 'ap_tools_add_admin_menu' );
add_action( 'admin_init', 'ap_tools_settings_init' );


function ap_tools_add_admin_menu(  ) { 

	add_options_page( 'AP Tools', 'AP Tools', 'manage_options', 'ap_tools', 'ap_tools_options_page' );

}


function ap_tools_settings_init(  ) { 

	register_setting( 'pluginPage', 'ap_tools_settings' );

	add_settings_section(
		'ap_tools_pluginPage_section', 
		__( 'In this page you can modify some useful data.', 'td_ap_tools' ), 
		'ap_tools_settings_section_callback', 
		'pluginPage'
	);

	add_settings_field( 
		'ap_tools_text_field_0', 
		__( 'Free Shipping Quantity', 'td_ap_tools' ), 
		'ap_tools_text_field_0_render', 
		'pluginPage', 
		'ap_tools_pluginPage_section' 
	);


}


function ap_tools_text_field_0_render(  ) { 

	$options = get_option( 'ap_tools_settings' );
	?>
	<input type='number' name='ap_tools_settings[ap_tools_text_field_0]' value='<?php echo $options['ap_tools_text_field_0']; ?>'>
	<?php

}


function ap_tools_settings_section_callback(  ) { 

	echo __( 'If you have some question, please contact with us at adrian@adrianpajares.com', 'td_ap_tools' );

}


function ap_tools_options_page(  ) { 

		?>
		<form action='options.php' method='post'>

			<h2>AP Tools</h2>

			<?php
			settings_fields( 'pluginPage' );
			do_settings_sections( 'pluginPage' );
			submit_button();
			?>

		</form>
		<?php

}

function shortcode_ap_cart_per() {

    global $woocommerce;
    $sub = $woocommerce->cart->subtotal;

    $options = get_option( 'ap_tools_settings' );
	$fsquantity = $options['ap_tools_text_field_0'];

    return $sub / $fsquantity * 100;

}
add_shortcode('ap_get_per', 'shortcode_ap_cart_per');


function shortcode_ap_cart_subtotal() {

    global $woocommerce;
    $sub = $woocommerce->cart->subtotal;

    return $sub;

}
add_shortcode('ap_get_subtotal', 'shortcode_ap_cart_subtotal');


function shortcode_ap_cart_fsquantity() {

    $options = get_option( 'ap_tools_settings' );
	$fsquantity = $options['ap_tools_text_field_0'];

    return $fsquantity;

}
add_shortcode('ap_get_fsquantity', 'shortcode_ap_cart_fsquantity');

function shortcode_ap_cart_display() {

    global $woocommerce;
    $sub = $woocommerce->cart->subtotal;

    $options = get_option( 'ap_tools_settings' );
	$fsquantity = $options['ap_tools_text_field_0'];

    return $sub .' € / '. $fsquantity .' €';

}
add_shortcode('ap_get_display', 'shortcode_ap_cart_display');