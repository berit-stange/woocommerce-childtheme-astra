<?php
add_action( 'wp_enqueue_scripts', 'edge_enqueue_styles' );
function edge_enqueue_styles() {
	wp_enqueue_style( 'parent-style', get_template_directory_uri() . '/style.css' );
}


// SALES BADGE
add_filter( 'woocommerce_sale_flash', 'misha_change_on_sale_badge', 99, 3 );
function misha_change_on_sale_badge( $badge_html, $post, $product ) {
	if( $product->is_type( 'variable' ) ){ // variable products
		$percentages = array();
		$prices = $product->get_variation_prices();
		foreach( $prices[ 'price' ] as $id => $price ){
			// if sale price == regular price, it means no sale right now, skip the loop iteration
			if( $prices[ 'regular_price' ][ $id ] === $prices[ 'sale_price' ][ $id ] ) {
				continue;
			}
			// array of all variations percentages
			$percentages[] = ( $prices[ 'regular_price' ][ $id ] - $prices[ 'sale_price' ][ $id ] ) / $prices[ 'regular_price' ][ $id ] * 100;
		}
		$percentage = "UP TO " . round( max( $percentages ) ) . '%';
	} else { // simple products
		$percentage = round( ( $product->get_regular_price() - $product->get_sale_price() ) / $product->get_regular_price() * 100 ) . '%';
	}
	return '<span class="onsale">- ' . $percentage . '</span>';
}



?>
