<form action="" method="post" enctype="multipart/form-data" name="form1" id="form1"> 
  Choose your file for product level: <br /> 
  <input name="csv_p" type="file" id="csv_p" /> <br/>
  Choose your file for variation: <br /> 
  <input name="csv_v" type="file" id="csv_v" /> <br/>
  <input type="submit" name="Submit" value="Submit" /> 
</form> 
<?php

if ( $_FILES[ 'csv_v' ][ 'size' ] > 0 && $_FILES[ 'csv_p' ][ 'size' ] > 0) { 
    //get the csv file 
    $products = $_FILES[ 'csv_p' ][ 'tmp_name' ];
    $variations = $_FILES[ 'csv_v' ][ 'tmp_name' ];
    $file = 'mapped-variation.csv';
    $fp_products = fopen( $products, "r" ); 
    $fp_variations = fopen( $variations, "r" );
    $fp_csv = fopen( $file , "w" ) or die("Unable to open file!");
    $ctr = 0;
    $product_posts = array();
    // loop to get all products in the memory
    do { 
        if ( $data[0] ) {
            $post_id = $data[1];
            if ( isset( $post_id ) ) {
            	$product_posts[ $post_id ] = $data[0];
        	}
        }  
    } while ( $data = fgetcsv( $fp_products, 1000, ",", "\"") ); 
    echo '<pre>';
    print_r( $product_posts );
    echo '</pre>';
    if ( $fp_csv ) {
   		do { 
	        if ( $data[0] ) {
	        	$index = array_search( $data[0], $product_posts );
	        	if( $index ) {
	        		echo 'Found ' . $data[0] . '<br/>';
		        	$data[1] = $index;
		        	fputcsv( $fp_csv, $data );
	        	}
	        }  
	    } while ( $data = fgetcsv( $fp_variations, 1000, ",", "\"") );
	}
    // 
    fclose($fp_products);
    fclose($fp_variations);
    fclose($fp_csv);
    //redirect 
    //header( 'Location: ' . basename( $_SERVER['SCRIPT_FILENAME'] ) ); 
    die; 

} 