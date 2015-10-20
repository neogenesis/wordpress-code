<?php

$path = $_SERVER['DOCUMENT_ROOT'];

include_once $path . '/wp-config.php';
include_once $path . '/wp-load.php';
include_once $path . '/wp-includes/wp-db.php';
include_once $path . '/wp-includes/pluggable.php';

if ( $_FILES[ 'csv' ][ 'size' ] > 0) { 
    //get the csv file 
    $file = $_FILES[ 'csv' ][ 'tmp_name' ];
    $handle = fopen( $file, "r" ); 
    $ctr = 0;
    //loop through the csv file and insert into database 
    do { 
        if ( $data[0] ) {
            $variation_id = get_id_by_sku( $data[0] );
            $_retailer_price = $data[1];
            $_minimum_quantity = $data[2];
            $_retailer_price_sale = $data[3];
            if ( isset( $variation_id ) ) {
                if ( isset( $_retailer_price ) ) {
                    update_post_meta( $variation_id, '_retailer_price', stripslashes( $_retailer_price ) );
                }
                if ( isset( $_retailer_price_sale ) ) {
                    update_post_meta( $variation_id, '_retailer_price_sale', stripslashes( $_retailer_price_sale ) );
                }
                if ( isset( $_minimum_quantity ) ) {
                    update_post_meta( $variation_id, '_minimum_quantity', stripslashes( $_minimum_quantity ) );
                }
                $ctr++;
            }
        }  
    } while ( $data = fgetcsv( $handle, 1000, ",", "'") ); 
    // 

    //redirect 
    header( 'Location: variation-custom-import.php?success=1&count='. $ctr); 
    die; 

} 
function get_id_by_sku( $sku ) {

    global $wpdb;

    $id = $wpdb->get_var( $wpdb->prepare( "SELECT post_id FROM $wpdb->postmeta WHERE meta_key='_sku' AND meta_value='%s' LIMIT 1", $sku ) );

    if ( $id ) return $id;// WC_Product( $product_id );

    return null;
}
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd"> 
<html xmlns="http://www.w3.org/1999/xhtml"> 
<head> 
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" /> 
<title>Import a CSV File for Custom Fields in Variation by Niel</title> 
</head> 

<body> 

<?php if (!empty($_GET['success'])) { echo "<b>Your file has been imported.</b><br><br>"; } //generic success notice ?> 

<form action="" method="post" enctype="multipart/form-data" name="form1" id="form1"> 
  Choose your file: <br /> 
  <input name="csv" type="file" id="csv" /> <br/>
  <input type="submit" name="Submit" value="Submit" /> 
</form> 
<p><em>Note: SKU, Retail Price, Minimum Quantity, Retail Sale Price</em></p>  
</body> 
</html> 