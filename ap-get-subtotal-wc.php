<?php

/**
 * Plugin Name:       adrianpajares.com - Get Subtotal Cart
 * Plugin URI:        https://adrianpajares.com/
 * Description:       Plugin to get the subtotal in cart. Shotcode: [ap_get_subtotal]
 * Version:           1.0
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
		__( 'Your section description', 'td_ap_tools' ), 
		'ap_tools_settings_section_callback', 
		'pluginPage'
	);

	add_settings_field( 
		'ap_tools_text_field_0', 
		__( 'Settings field description', 'td_ap_tools' ), 
		'ap_tools_text_field_0_render', 
		'pluginPage', 
		'ap_tools_pluginPage_section' 
	);


}


function ap_tools_text_field_0_render(  ) { 

	$options = get_option( 'ap_tools_settings' );
	?>
	<input type='text' name='ap_tools_settings[ap_tools_text_field_0]' value='<?php echo $options['ap_tools_text_field_0']; ?>'>
	<?php

}


function ap_tools_settings_section_callback(  ) { 

	echo __( 'This section description', 'td_ap_tools' );

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


function shortcode_ap_cart_subtotal() {

    global $woocommerce;
    $sub = $woocommerce->cart->subtotal;

    $options = get_option( 'ap_tools_settings' );
	$fsquantity = $options['ap_tools_text_field_0'];

    return $sub / $fsquantity * 100;

}
add_shortcode('ap_get_subtotal', 'shortcode_ap_cart_subtotal');