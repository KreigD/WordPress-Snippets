<?php
// Add replacement parts (upsells) tab to product pages
add_filter( 'woocommerce_product_tabs', 'replacement_parts_tab' );
function replacement_parts_tab( $tabs ) {
  global $product;
  $upsells = $product->get_upsell_ids();
  // if no upsells, do nothing
  if ( empty($upsells) ) {
    return $tabs;
  }
  // remove upsells from default position
  remove_action( 'woocommerce_after_single_product_summary', 'woocommerce_upsell_display', 15 );

  // build new tab
  $tabs['replacement_tab'] = array(
    'title' => __( 'Replacement Parts', 'woocommerce' ),
    'priority' => 50,
    'callback' => 'show_replacement_content'
  );
  return $tabs;
}
function show_replacement_content() {
  woocommerce_upsell_display();
}