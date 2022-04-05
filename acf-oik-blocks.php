<?php
/**
 * Plugin Name: acf-oik-blocks
 * Plugin URI: https://www.oik-plugins.com/oik-plugins/acf-oik-blocks
Description: Playing with ACF blocks with oik
Version: 0.0.1
Author: bobbingwide
Author URI: https://www.bobbingwide.com/about-bobbing-wide
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Copyright 2019, 2022 Bobbing Wide (email : herb@bobbingwide.com )

This program is free software; you can redistribute it and/or modify
it under the terms of the GNU General Public License version 2,
as published by the Free Software Foundation.

You may NOT assume that you can use any other version of the GPL.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

The license for this software can likely be found here:
http://www.gnu.org/licenses/gpl-2.0.html

 */

add_action( 'acf/init', 'acf_oik_blocks_init');

/**
 *
 * Note: acf_register_block() is just a wrapper to acf_register_block_type()
 */
function acf_oik_blocks_init() {
	acf_register_block_type(array(
		'name'              => 'block-count',
		'title'             => __('Block count'),
		'description'       => __('Displays the block count'),
		//'render_template'   => 'template-parts/blocks/block-count/block-count.php',
		'render_callback'   => 'acf_oik_blocks_callback',
		'category'          => 'formatting',
		'icon'              => 'admin-comments',
		'keywords'          => array( 'block', 'count', 'acf' ),
	));

	$args = [ 'name' => 'paypal',
	          'title' => __('PayPal', 'act-oik-blocks'),
	          'description' => 'PayPal button for WordPress with ACF',
	          'render_callback'   => 'acf_oik_blocks_paypal',
			'icon' => 'money',
		'category' => 'widget',
		'keywords' => ['payment', 'acf', 'oik' ]
	];

	$ok = acf_register_block( $args );
	//print_r( $ok );

}

/**
 * Displays the Block Count field for the current post.
 *
 * @param   array $block The block settings and attributes.
 * @param   string $content The block inner HTML (empty).
 * @param   bool $is_preview True during AJAX preview.
 * @param   (int|string) $post_id The post ID this block is saved to.
 */
function acf_oik_blocks_callback( $block, $content, $is_preview, $post_id  ) {
	bw_trace2();
	echo "Block count: ";
	$block_count = get_field( '_block_count', $post_id );
	echo $block_count;
}

/**
 * PayPal block
 *
 * This code uses oik's [paypal] shortcode to do the heavy lifting.
 * This function gets the value of each field from the block
 * and passes it to the shortcode.
 * The shortcode generates the HTML, which is echoed by this function.
 *
 *
 * @param   array $block The block settings and attributes.
 * @param   string $content The block inner HTML (empty).
 * @param   bool $is_preview True during AJAX preview.
 * @param   (int|string) $post_id The post ID this block is saved to.
 */
function acf_oik_blocks_paypal( $block, $content, $is_preview, $post_id  ) {
	bw_trace2();
	bw_backtrace();
	//echo "PayPal";
	//print_r( $block );
	//print_r( $content );
	oik_require( 'shortcodes/oik-paypal.php');
	$atts = [];
	$atts['type'] = get_field( 'type');
	$atts['amount'] = get_field( 'amount');
	$atts['productname'] = get_field('product_name');
	$atts['sku'] = get_field( 'product_sku');
	$atts['shipadd'] = get_field( 'shipping_address_required');
	//print_r( $atts );
	$html = bw_pp_shortcodes( $atts );
	echo $html;
}