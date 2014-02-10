<?php
/**
 * Plugin Name: Content Shortcodes
 * Plugin URI: http://binaryorganic.com/content-shortcodes
 * Description: Content Shortcodes creates a custom post type to organize repeatable content that can be embedded into your site using Wordpress shortcodes. Never deal with widgets for repeatable content again.
 * Version: 1.0
 * Author: binary/organic
 * Author URI: http://binaryorganic.com
 * License: GPL2
 */

/*  Copyright 2014  binary/organic  (email : contact@binaryorganic.com)

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License, version 2, as 
    published by the Free Software Foundation.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/





/*==========  Create Custom Post Type  ==========*/


add_action( 'init', 'content_shortcodes' );

function content_shortcodes() {
	$labels = array(
	    'name'               => 'Content Shortcodes',
	    'singular_name'      => 'Content Shortcode',
	    'add_new'            => 'Add New',
	    'add_new_item'       => 'Add New Content Shortcode',
	    'edit_item'          => 'Edit Content Shortcode',
	    'new_item'           => 'New Content Shortcode',
	    'all_items'          => 'All Content Shortcodes',
	    'view_item'          => 'View Content Shortcode',
	    'search_items'       => 'Search Content Shortcodes',
	    'not_found'          => 'No Content Shortcodes found',
	    'not_found_in_trash' => 'No Content Shortcodes found in Trash',
	    'parent_item_colon'  => '',
	    'menu_name'          => 'Shortcodes'
	  );

	$args = array(
	    'labels'             => $labels,
	    'public'             => true,
	    'publicly_queryable' => false,
	    'show_ui'            => true,
	    'show_in_menu'       => true,
	    'query_var'          => true,
	    'rewrite'            => array( 'slug' => 'Content Shortcode' ),
	    'capability_type'    => 'post',
	    'has_archive'        => true,
	    'hierarchical'       => false,
	    'menu_position'      => 5,
	    'supports'           => array( 'title', 'editor', 'author' ),
	    'capability_type' => 'post',
	    'taxonomies' => array('Shortcode Category',),
	    'not-found' => 'No Categories Found'
	  );

	register_post_type( 'content_shortcode', $args );
}
	




/*==========  Create Category  ==========*/


add_action( 'init', 'build_taxonomies', 0 );  

function build_taxonomies() {  
    register_taxonomy( 'shortcode_cat', 'content_shortcode', array( 
    	'show_admin_column' => true, 
    	'hierarchical' => false, 
    	'label' => 'Categories',
    	'singuler_name' => 'Category',
    	'all-items' => 'All Categories',
    	'edit-item' => 'Edit Category',
    	'view-item' => 'View Category',
    	'update-item' => 'Update Cateogry',
    	'add_new_item' => 'Add new Category',
    	'new_item_name' => 'New Category',
    	'menu_name' => 'Categories'
    	) 
    );  
};





/*==========  Create Shortcodes  ==========*/


add_action( 'init', 'register_content_shortcode');

function register_content_shortcode(){
   	add_shortcode('content-shortcode', 'content_shortcode');
}

function content_shortcode($atts, $content = null) {
    extract( shortcode_atts( array('post_id'  => '1'), $atts ) );

    $post = get_post($post_id); 
	$content = $post->post_content;

    return $content;
    
}





/*==========  Custom Columns for Admin List-View  ==========*/


add_filter('manage_posts_columns', 'posts_columns_id', 5);
add_action('manage_posts_custom_column', 'posts_custom_id_columns', 5, 2);

function posts_columns_id($defaults){
    $defaults['wps_post_id'] = __('ID');
    return $defaults;
}

function posts_custom_id_columns($column_name, $id){
        if($column_name === 'wps_post_id'){
                echo $id;
    }
}