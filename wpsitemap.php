<?php

/**
 * The site map file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * Dashboard. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              http://wordpress.org/plugins/wpsitemap
 * @since             1.0.0
 * @package           WP_Sitemap
 *
 * @wordpress-plugin
 * Plugin Name:       WP Sitemap
 * Plugin URI:        http://wordpress.org/plugins/wpsitemap
 * Description:       It is a wordpress sitemap plugin. Use shortcode [sitemap type="post"], [sitemap type="page"]
 * Version:           1.0.0
 * Author:            Dipto Paul
 * Author URI:        http://webprojectbd.blogspot.com/
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

// CSS file call
function wpsitemap_add_stylesheet() {

	wp_enqueue_style( 'wp-sitemap-style', plugins_url( '/css/wp-sitemap.css', __FILE__ ), false);
}
add_action('wp_head', 'wpsitemap_add_stylesheet');

// Widget support
add_filter( 'widget_text', 'shortcode_unautop');
add_filter( 'widget_text', 'do_shortcode');

// Sitemap Shortcode

function wpsitemap_post_shortcode($atts){
	extract( shortcode_atts( array(
		'type' => 'post',
		'number' => -1,
		'order' => 'DESC',
		'cat' => '',
		'cat_name' => '',
		'author' => '',
		'year' => '',
		'month' => '',
		'ignore_sticky' => 1,
		'offset' => '',
		'style' => '1',
		
	), $atts, 'sitemap' ) );
	
    $q = new WP_Query(
        array(
			'posts_per_page' => $number, 
			'post_type' => $type,
			'order' => $order,
			'cat' => $cat,
			'category_name' => $cat_name,
			'author' => $author,
			'year' => $year,
			'monthnum' => $month,
			'ignore_sticky_posts' => $ignore_sticky,
			'offset' => $offset,
		));		
		
		
	$list = '<div id="wp_sitemap"><ul id="wp_sitemap_item" class="wpsstyle-'.$style.'">';
	while($q->have_posts()) : $q->the_post();
		$idd = get_the_ID();
		$list .= '<li><a href="'.get_permalink().'">'.get_the_title().'</a></li>';        
	endwhile;
	$list.= '</ul></div>';
	wp_reset_query();
	return $list;
}
add_shortcode('sitemap', 'wpsitemap_post_shortcode');	


/**
	Full Shortcode [sitemap type="post" style="1" number="-1" order="DESC" cat=""/cat_name="" author="" year="" month="" ignore_sticky="1" offset=""]
*/

?>
