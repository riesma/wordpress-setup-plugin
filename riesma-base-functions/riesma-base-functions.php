<?php
/*
Plugin Name: Riesma base functions
	Version: 1.0.0
	Plugin URI: http://riesma.nl/
	Description: Adding Riesma's base functions.

Author: Richard van Aalst
	Author URI: http://riesma.nl/
	License: GPL v3

Copyright (C) 2012 Richard van Aalst
	This program is free software: you can redistribute it and/or modify
	it under the terms of the GNU General Public License as published by
	the Free Software Foundation, either version 3 of the License, or
	(at your option) any later version.

	This program is distributed in the hope that it will be useful,
	but WITHOUT ANY WARRANTY; without even the implied warranty of
	MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
	GNU General Public License for more details.

	You should have received a copy of the GNU General Public License
	along with this program.  If not, see <http://www.gnu.org/licenses/>.

Usage
	Edit this php file for setting the post types, admin menu etc.

	This plugin uses the Bones theme <http://themble.com/bones/> translations,
	therefore it's recommended to use that as your base theme.
	Even without this plugin it is!

TODO
		1a.	Create xml to edit settings instead of editing this php file?
	X	1b.	Create admin pages to edit settings instead of editing php/xml files
		2.	Write own translation? Falling back to Bones for now.
		3.	More...? Of course there is!

More information
	register_post_type	http://codex.wordpress.org/Function_Reference/register_post_type
	register_taxonomy	http://codex.wordpress.org/Function_Reference/register_taxonomy
	custom meta boxes	https://github.com/jaredatch/Custom-Metaboxes-and-Fields-for-WordPress
*/



class Riesma_Functions {

	/**
	 * Set domain for translations.
	*/
	// WordPress default translations
	private $translation_domain = 'default';
	// Riesma translations
	//private $translation_domain = 'riesma';

	/**
	 * Class constructor
	*/
	function __construct() {

		// Add post type 'Products'
		add_action('init', array(&$this, 'riesma_add_posttype_products'));

		// Order admin menu items
		add_filter('custom_menu_order', create_function('', 'return true;'));
		add_filter('menu_order', 'riesma_order_admin_menu_items');

		// Remove admin menu items
		add_action('admin_menu', 'riesma_remove_admin_menu_items');
	}



	/**
	 * Add post type 'Products' including taxonomies
	*/
	public function riesma_add_posttype_products() {

		global $translation_domain;
		$domain = $translation_domain;

		/**
		 * Add custom post type
		*/
		// Identifier of the Custom Type
		register_post_type('products',
			array(
				'labels' => array(
					// Name of the Custom Type group
					'name'               => __('Producten', $domain),
					// Name of individual Custom Type item
					'singular_name'      => __('Product', $domain),
					// All Items menu item
					'all_items'          => __('Alle producten', $domain),
					// Add New menu item
					'add_new'            => __('Nieuw product', $domain),
					// Add New display title
					'add_new_item'       => __('Nieuw product toevoegen', $domain),
					// Edit dialog
					'edit'               => __('Bewerken', $domain),
					// Edit display title
					'edit_item'          => __('Product bewerken', $domain),
					// New display title
					'new_item'           => __('Nieuw product', $domain),
					// View display title
					'view_item'          => __('Product bekijken', $domain),
					// Search Custom Type title
					'search_items'       => __('Producten zoeken', $domain),
					// No Entries Yet dialog
					'not_found'          => __('Geen producten gevonden.', $domain),
					// Nothing in the Trash dialog
					'not_found_in_trash' => __('Geen producten gevonden in de prullenbak.', $domain),
					// ?
					'parent_item_colon'  => __('', $domain)
				),
				// Custom Type Description
				'description'         => __('Products post type.', $domain),
				// Show in the admin panel
				'public'              => true,
				// ?
				'publicly_queryable'  => true,
				// ?
				'exclude_from_search' => false,
				// Show in the admin panel
				'show_ui'             => true,
				// Allow vars to be used for querying post-type
				'query_var'           => true,
				// Icon of menu item
				'menu_icon'           => get_stylesheet_directory_uri().'/library/img/products-icon.png',
				// Rename the URL slug
				'rewrite'             => array('slug' => 'products', 'with_front' => false),
				// Rename the archive URL slug
				'has_archive'         => 'products',
				// ?
				'capability_type'     => 'post',
				// ?
				'hierarchical'        => false,
				// Enable all options in the post editor
				'supports'            => array('title', 'editor', 'author', 'thumbnail', 'excerpt', 'trackbacks', 'custom-fields', 'comments', 'revisions', 'sticky')
			)
		);


		/**
		 * Add custom taxonomy as categories
		 *
		 * When using the name 'Categories' (en_US) or 'Categorieën' (nl_NL), only use 'label'.
		 * (For en_US and nl_NL (with Dutch language installed),
		 *  WordPress automatically provides translated labels)
		 * When using a custom name, (e.g. 'Locations'), use 'labels'.
		*/
		register_taxonomy('products_category',
			// Change to the name of register_post_type
			array('products'),
			array(
				// Name of the Custom Taxonomy
				'label' => __('Categorieën', $domain),
				/*
				// Extended options
				'labels' => array(
					// Name of the Custom Taxonomy group
					'name'              => __('Categorieën', $domain),
					// Name of individual Custom Taxonomy item
					'singular_name'     => __('Categorie', $domain),
					// Add New Custom Taxonomy title and button
					'add_new_item'      => __('Nieuwe categorie toevoegen', $domain),
					// Edit Custom Taxonomy page title
					'edit_item'         => __('Categorie bewerken', $domain),
					// Update Custom Taxonomy button in Quick Edit
					'update_item'       => __('Categorie bijwerken', $domain),
					// Search Custom Taxonomy button
					'search_items'      => __('Categorieën zoeken', $domain),
					// All Custom Taxonomy title in taxonomy's panel tab
					'all_items'         => __('Alle categorieën', $domain),
					// New Custom Taxonomy title in taxonomy's panel tab
					'new_item_name'     => __('Nieuwe categorie naam', $domain)
					// Custom Taxonomy Parent in taxonomy's panel select box
					'parent_item'       => __('Categorie hoofd', $domain),
					// Custom Taxonomy Parent title with colon
					'parent_item_colon' => __('Categorie hoofd:', $domain),
				),
				*/
				// Hierachy: true = categories, false = tags
				'hierarchical'      => true,
				// Available in admin panel
				'public'            => true,
				// Show in the admin panel
				'show_ui'           => true,
				// Show in the menus admin panel
				'show_in_nav_menus' => true,
				// Allow vars to be used for querying taxonomy
				'query_var'         => true,
				// Rename the URL slug
				'rewrite'           => array('slug' => 'product-categories', 'with_front' => true)
			)
		);


		/**
		 * Add custom taxonomy as tags
		 *
		 * When using the name 'Tags', only use 'label'.
		 * (For en_US and nl_NL (with Dutch language installed),
		 *  WordPress automatically provides translated labels)
		 * When using a custom name, (e.g. 'Locations'), use 'labels'.
		*/
		*/
		register_taxonomy('products_tag',
			// Change to the name of register_post_type
			array('products'),
			array(
				// Name of the Custom Taxonomy
				'label' => __('Tags', $domain),
				/*
				'labels' => array(
					// Name of the Custom Taxonomy group
					'name'              => __('Tags', $domain),
					// Name of individual Custom Taxonomy item
					'singular_name'     => __('Tag', $domain),
					// Add New Custom Taxonomy title and button
					'add_new_item'      => __('Nieuwe tag toevoegen', $domain),
					// Edit Custom Taxonomy page title
					'edit_item'         => __('Tag bewerken', $domain),
					// Update Custom Taxonomy button in Quick Edit
					'update_item'       => __('Tag bijwerken', $domain),
					// Search Custom Taxonomy button
					'search_items'      => __('Tags zoeken', $domain),
					// All Custom Taxonomy title in taxonomy's panel tab
					'all_items'         => __('Alle tags', $domain),
					// New Custom Taxonomy title in taxonomy's panel tab
					'new_item_name'     => __('Nieuwe tag naam', $domain)
				),
				*/
				// Hierachy: true = categories, false = tags
				'hierarchical'      => false,
				// Available in admin panel
				'public'            => true,
				// Show in the admin panel
				'show_ui'           => true,
				// Show in the menus admin panel
				'show_in_nav_menus' => true,
				// Allow vars to be used for querying taxonomy
				'query_var'         => true,
				// Rename the URL slug
				'rewrite'           => array('slug' => 'product-tags', 'with_front' => true)
			)
		);


		/**
		 * Add WordPress' default taxonomies to custom post type
		*/
		// Categories
		//register_taxonomy_for_object_type('category', 'products');
		// Tags
		//register_taxonomy_for_object_type('post_tag', 'products');

	} // riesma_add_posttype_products



	/**
	 * Order admin menu items
	*/
	public function riesma_order_admin_menu_items($menu) {
		$ordered_menu = array(
			'index.php',
				'separator1',
			'edit.php?post_type=page',
			'edit.php',
		//	'edit.php?post_type=custom',
				'separator2',
			'edit-comments.php',
			'upload.php',
			'link-manager.php',
				'separator-last',
			'themes.php',
			'plugins.php',
			'users.php',
			'profile.php',
			'tools.php',
			'options-general.php'
		);

		array_splice($menu, 1, 0, $ordered_menu);
		return array_unique($menu);
	} // riesma_order_admin_menu_items



	/**
	 * Remove admin menu items
	*/
	public function riesma_remove_admin_menu_items() {

		/* When logged in as admin. */
		if (is_admin()) {
			//remove_menu_page('edit.php?post_type=page');
			//remove_menu_page('edit.php');
		//	remove_menu_page('edit.php?post_type=custom');
			//remove_menu_page('edit-comments.php');
			//remove_menu_page('upload.php');
			//remove_menu_page('link-manager.php');
			//remove_menu_page('themes.php');
			//remove_menu_page('plugins.php');
			//remove_menu_page('users.php');
			//remove_menu_page('tools.php');
			//remove_menu_page('options-general.php');
		}

		/* When not logged in as admin. */
		else {
			//remove_menu_page('edit.php?post_type=page');
			//remove_menu_page('edit.php');
			//remove_menu_page('edit-comments.php');
		//	remove_menu_page('edit.php?post_type=custom');
			//remove_menu_page('upload.php');
			//remove_menu_page('link-manager.php');
			//remove_menu_page('profile.php');
			//remove_menu_page('tools.php');
		}
	} // riesma_remove_admin_menu_items

} // Riesma_Functions

// Instantiate the class
//global $Riesma_Functions;
$Riesma_Functions = new Riesma_Functions();



?>