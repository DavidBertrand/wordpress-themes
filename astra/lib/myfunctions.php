add_action( 'woocommerce_before_calculate_totals', 'misha_recalc_price' );
 
function misha_recalc_price( $cart_object ) {
    foreach ( $cart_object->get_cart() as $hash => $value ) {
        $value['data']->set_price( 10 );
    }
}
