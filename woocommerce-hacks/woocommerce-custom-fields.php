<?php

//Display Fields
add_action( 'woocommerce_product_after_variable_attributes', 'variable_fields', 10, 3 );
//JS to add fields for new variations
add_action( 'woocommerce_product_after_variable_attributes_js', 'variable_fields_js' );
//Save variation fields 
//As of WooCommerce 2.4.4
add_action( 'woocommerce_save_product_variation', 'save_variable_fields', 10, 1 );

/**
 * Create new fields for variations
 *
*/
function variable_fields( $loop, $variation_data, $variation ) {
?>
	<tr>
		<td>
			<?php
			// Retailer Price
			woocommerce_wp_text_input( 
				array( 
					'id'          => '_retailer_price['.$loop.']', 
					'label'       => __( 'Retailer Price', 'woocommerce' ), 
					'placeholder' => '0',
					'data_type' => 'price',
					'wrapper_class' => 'form-row form-row-first',
					/*'desc_tip'    => 'true',
					'description' => __( 'Enter retailer price', 'woocommerce' ),*/
					'value'       => get_post_meta( $variation->ID, '_retailer_price', true )
				)
			);
			?>
		</td>
	</tr>
	<tr>
		<td>
			<?php
			// Retailer Sale Price
			woocommerce_wp_text_input( 
				array( 
					'id'          => '_retailer_price_sale['.$loop.']', 
					'label'       => __( 'Retailer Sale Price', 'woocommerce' ), 
					'placeholder' => '0',
					'data_type' => 'price',
					'wrapper_class' => 'form-row form-row-last',
					/*'desc_tip'    => 'true',
					'description' => __( 'Enter retailer sale price', 'woocommerce' ),*/
					'value'       => get_post_meta( $variation->ID, '_retailer_price_sale', true )
				)
			);
			?>
		</td>
	</tr>
	<tr>
		<td>
			<?php
			// Minimum Quantity for Retailer
			woocommerce_wp_text_input( 
				array( 
					'id'          => '_minimum_quantity['.$loop.']', 
					'label'       => __( 'Minimum Quantity for Retailer', 'woocommerce' ), 
					'desc_tip'    => 'true',
					'description' => __( 'Enter the minimum quantity for retailers', 'woocommerce' ),
					'value'       => get_post_meta( $variation->ID, '_minimum_quantity', true ),
					'custom_attributes' => array(
									'step' 	=> 'any',
									'min'	=> '1'
								) 
				)
			);
			?>
		</td>
	</tr>
<?php
}

/**
 * Create new fields for new variations
 *
*/
function variable_fields_js() {
?>
	<tr>
		<td>
			<?php
			// Text Field
			woocommerce_wp_text_input( 
				array( 
					'id'          => '_retailer_price[ + loop + ]', 
					'label'       => __( 'Retailer Price', 'woocommerce' ), 
					'placeholder' => '0',
					'data_type' => 'price',
					'wrapper_class' => 'form-row form-row-first',
					/*'desc_tip'    => 'true',
					'description' => __( 'Enter retailer price', 'woocommerce' ),*/
					'value'       => ''
				)
			);
			?>
		</td>
	</tr>
	<tr>
		<td>
			<?php
			// Text Field
			woocommerce_wp_text_input( 
				array( 
					'id'          => '_retailer_price_sale[ + loop + ]', 
					'label'       => __( 'Retailer Sale Price', 'woocommerce' ), 
					'placeholder' => '0',
					'data_type' => 'price',
					'wrapper_class' => 'form-row form-row-last',
					/*'desc_tip'    => 'true',
					'description' => __( 'Enter retailer sale price', 'woocommerce' ),*/
					'value'       => ''
				)
			);
			?>
		</td>
	</tr>
	<tr>
		<td>
			<?php
			// Number Field
			woocommerce_wp_text_input( 
				array( 
					'id'                => '_minimum_quantity[ + loop + ]', 
					'label'             => __( 'Minimum Quantity for Retailer', 'woocommerce' ), 
					'desc_tip'          => 'true',
					'description'       => __( 'Enter the custom number here.', 'woocommerce' ),
					'value'             => '',
					'custom_attributes' => array(
									'step' 	=> 'any',
									'min'	=> '1'
								) 
				)
			);
			?>
		</td>
	</tr>
<?php
}

/**
 * Save new fields for variations
 *
*/
function save_variable_fields( $post_id ) {
	if (isset( $_POST['variable_sku'] ) ) :

		$variable_sku          = $_POST['variable_sku'];
		$variable_post_id      = $_POST['variable_post_id'];
		
		// Retailer Price
		$_retailer_price = $_POST['_retailer_price'];
		for ( $i = 0; $i < sizeof( $variable_sku ); $i++ ) :
			$variation_id = (int) $variable_post_id[$i];
			if ( isset( $_retailer_price[$i] ) ) {
				update_post_meta( $variation_id, '_retailer_price', stripslashes( $_retailer_price[$i] ) );
			}
		endfor;

		// Retailer Sale Price
		$_retailer_price_sale = $_POST['_retailer_price_sale'];
		for ( $i = 0; $i < sizeof( $variable_sku ); $i++ ) :
			$variation_id = (int) $variable_post_id[$i];
			if ( isset( $_retailer_price_sale[$i] ) ) {
				update_post_meta( $variation_id, '_retailer_price_sale', stripslashes( $_retailer_price_sale[$i] ) );
			}
		endfor;
		
		// Minimum Quantity for Retailer
		$_minimum_quantity = $_POST['_minimum_quantity'];
		for ( $i = 0; $i < sizeof( $variable_sku ); $i++ ) :
			$variation_id = (int) $variable_post_id[$i];
			if ( isset( $_retailer_price[$i] ) ) {
				update_post_meta( $variation_id, '_minimum_quantity', stripslashes( $_minimum_quantity[$i] ) );
			}
		endfor;
		
	endif;
}