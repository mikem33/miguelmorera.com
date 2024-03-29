<?php
/*
Plugin Name: MU Custom Post Types
Plugin URI: http://www.miguelmorera.com
Description: MU-Plugin for Custom Post Types. Based on Van Patten Media code. (http://www.vanpattenmedia.com/)
Author: Miguel Morera
Version: 1.0
Author URI: https://www.miguelmorera.com/
*/
/**
 *
 * Register post types
 *
 */

if ( !post_type_exists('mm_work') ) {
    function register_mm_work_type() {
        $slug = 'trabajos';
        $label_singular = __( 'Work', 'miguelmorera' );
        $label_plural   = __( 'Works', 'miguelmorera' );
        register_post_type(
            'mm_work',
            array(
                'label'           => $label_plural,
                'description'     => '',
                'menu_icon'       => 'dashicons-hammer',
                'menu_position'   => 4,
                'public'          => true,
                'show_ui'         => true,
                'show_in_menu'    => true,
                'capability_type' => 'post',
                'hierarchical'    => false,
                'query_var'       => true,
                'has_archive'     => false,
                'show_in_rest'    => true,
                'rewrite' => array(
                    'slug'       => $slug,
                    'with_front' => false,
                ),
                'supports' => array(
                    'title',
                    'editor',
                    'revisions',
                    'thumbnail',
                    'custom-fields',
                ),
                'labels' => array (
                    'name'               => $label_plural,
                    'singular_name'      => $label_singular,
                    'menu_name'          => $label_plural,
                    'all_items'          => __( 'All ', 'miguelmorera' ) . $label_plural,
                    'add_new'            => __( 'Add New', 'miguelmorera' ),
                    'add_new_item'       => __( 'Add New ', 'miguelmorera' ) . $label_singular,
                    'edit'               => __( 'Edit', 'miguelmorera' ),
                    'edit_item'          => __( 'Edit ', 'miguelmorera' ) . $label_singular,
                    'new_item'           => __( 'New ', 'miguelmorera' ). $label_singular,
                    'view'               => __( 'View ', 'miguelmorera' ) . $label_singular,
                    'view_item'          => __( 'View ', 'miguelmorera' ) . $label_singular,
                    'search_items'       => __( 'Search ', 'miguelmorera' ) . $label_plural,
                    'not_found'          => __( 'No ', 'miguelmorera' ) . $label_plural . ' Found',
                    'not_found_in_trash' => __( 'No ', 'miguelmorera' ) . $label_plural . ' Found in Trash',
                    'parent'             => __( 'Parent ', 'miguelmorera' ) . $label_singular,
                )
            )
        );
    }
    add_action('init', 'register_mm_work_type');
}
if ( !post_type_exists('mm_comic') ) {
    function register_mm_comic_type() {
        $label_singular = __( 'Comic', 'miguelmorera' );
        $label_plural   = __( 'Comics', 'miguelmorera' );
        register_post_type(
            'mm_comic',
            array(
                'label'           => $label_plural,
                'description'     => '',
                'menu_icon'       => 'dashicons-format-status',
                'menu_position'   => 5,
                'public'          => true,
                'show_ui'         => true,
                'show_in_menu'    => true,
                'capability_type' => 'post',
                'hierarchical'    => false,
                'query_var'       => true,
                'has_archive'     => false,
                'show_in_rest'    => true,
                'rewrite' => array(
                    'slug'       => 'comics',
                    'with_front' => false,
                ),
                'supports' => array(
                    'title',
                    'editor',
                    'comments',
                    'revisions',
                    'thumbnail',
                    'custom-fields',
                ),
                'labels' => array (
                    'name'               => $label_plural,
                    'singular_name'      => $label_singular,
                    'menu_name'          => $label_plural,
                    'all_items'          => __( 'All ', 'miguelmorera' ) . $label_plural,
                    'add_new'            => __( 'Add New', 'miguelmorera' ),
                    'add_new_item'       => __( 'Add New ', 'miguelmorera' ) . $label_singular,
                    'edit'               => __( 'Edit', 'miguelmorera' ),
                    'edit_item'          => __( 'Edit ', 'miguelmorera' ) . $label_singular,
                    'new_item'           => __( 'New ', 'miguelmorera' ). $label_singular,
                    'view'               => __( 'View ', 'miguelmorera' ) . $label_singular,
                    'view_item'          => __( 'View ', 'miguelmorera' ) . $label_singular,
                    'search_items'       => __( 'Search ', 'miguelmorera' ) . $label_plural,
                    'not_found'          => __( 'No ', 'miguelmorera' ) . $label_plural . ' Found',
                    'not_found_in_trash' => __( 'No ', 'miguelmorera' ) . $label_plural . ' Found in Trash',
                    'parent'             => __( 'Parent ', 'miguelmorera' ) . $label_singular,
                )
            )
        );

        register_taxonomy(
            'mm_comic_category',
            'mm_comic',
            array(
                // Label should be plural and L10n ready.
                'label'             => __( 'Comic Categories', 'miguelmorera' ),
                'show_admin_column' => true,
                'show_in_rest'      => true,
                'hierarchical'      => true,
                'rewrite'           => array(
                    'slug' => 'comics-category',
                    'with_front' => false
                ),
            )
        );
    }
    add_action('init', 'register_mm_comic_type');
}

if ( !post_type_exists('mm_dev_post') ) {
    function register_mm_dev_post_type() {
        $slug = 'blog-desarrollo';
        $label_singular = __( 'Dev Post', 'miguelmorera' );
        $label_plural   = __( 'Dev Posts', 'miguelmorera' );
        register_post_type(
            'mm_dev_post',
            array(
                'label'           => $label_plural,
                'description'     => '',
                'menu_icon'       => 'dashicons-share-alt',
                'menu_position'   => 5,
                'public'          => true,
                'show_ui'         => true,
                'show_in_menu'    => true,
                'capability_type' => 'post',
                'hierarchical'    => false,
                'query_var'       => true,
                'has_archive'     => false,
                'show_in_rest'    => true,
                'rewrite' => array(
                    'slug'       => $slug,
                    'with_front' => false,
                ),
                'supports' => array(
                    'title',
                    'author',
                    'editor',
                    'comments',
                    'revisions',
                    'thumbnail',
                    'custom-fields',
                ),
                'labels' => array (
                    'name'               => $label_plural,
                    'singular_name'      => $label_singular,
                    'menu_name'          => $label_plural,
                    'all_items'          => __( 'All ', 'miguelmorera' ) . $label_plural,
                    'add_new'            => __( 'Add New', 'miguelmorera' ),
                    'add_new_item'       => __( 'Add New ', 'miguelmorera' ) . $label_singular,
                    'edit'               => __( 'Edit', 'miguelmorera' ),
                    'edit_item'          => __( 'Edit ', 'miguelmorera' ) . $label_singular,
                    'new_item'           => __( 'New ', 'miguelmorera' ). $label_singular,
                    'view'               => __( 'View ', 'miguelmorera' ) . $label_singular,
                    'view_item'          => __( 'View ', 'miguelmorera' ) . $label_singular,
                    'search_items'       => __( 'Search ', 'miguelmorera' ) . $label_plural,
                    'not_found'          => __( 'No ', 'miguelmorera' ) . $label_plural . ' Found',
                    'not_found_in_trash' => __( 'No ', 'miguelmorera' ) . $label_plural . ' Found in Trash',
                    'parent'             => __( 'Parent ', 'miguelmorera' ) . $label_singular,
                )
            )
        );

        register_taxonomy(
            'mm_dev_posts_category',
            'mm_dev_post',
            array(
                // Label should be plural and L10n ready.
                'label'             => __( 'Dev Posts Category', 'miguelmorera' ),
                'show_admin_column' => true,
                'show_in_rest'      => true,
                'hierarchical'      => true,
                'rewrite'           => array(
                    'slug' => 'categoria-posts-desarrollo',
                    'with_front' => false
                ),
            )
        );
    }
    add_action('init', 'register_mm_dev_post_type');
}

if ( !post_type_exists('mm_diary') ) {
    function register_mm_diary_type() {
        $slug = 'diario';
        $label_singular = __( 'Diary', 'miguelmorera' );
        $label_plural   = __( 'Diaries', 'miguelmorera' );
        register_post_type(
            'mm_diary',
            array(
                'label'           => $label_plural,
                'description'     => '',
                'menu_icon'       => 'dashicons-format-aside',
                'menu_position'   => 5,
                'public'          => true,
                'show_ui'         => true,
                'show_in_menu'    => true,
                'capability_type' => 'post',
                'hierarchical'    => false,
                'query_var'       => true,
                'has_archive'     => false,
                'show_in_rest'    => true,
                'rewrite' => array(
                    'slug'       => $slug,
                    'with_front' => false,
                ),
                'supports' => array(
                    'title',
                    'author',
                    'editor',
                    'comments',
                    'thumbnail',
                    'revisions',
                    'custom-fields',
                ),
                'labels' => array (
                    'name'               => $label_plural,
                    'singular_name'      => $label_singular,
                    'menu_name'          => $label_plural,
                    'all_items'          => __( 'All ', 'miguelmorera' ) . $label_plural,
                    'add_new'            => __( 'Add New', 'miguelmorera' ),
                    'add_new_item'       => __( 'Add New ', 'miguelmorera' ) . $label_singular,
                    'edit'               => __( 'Edit', 'miguelmorera' ),
                    'edit_item'          => __( 'Edit ', 'miguelmorera' ) . $label_singular,
                    'new_item'           => __( 'New ', 'miguelmorera' ). $label_singular,
                    'view'               => __( 'View ', 'miguelmorera' ) . $label_singular,
                    'view_item'          => __( 'View ', 'miguelmorera' ) . $label_singular,
                    'search_items'       => __( 'Search ', 'miguelmorera' ) . $label_plural,
                    'not_found'          => __( 'No ', 'miguelmorera' ) . $label_plural . ' Found',
                    'not_found_in_trash' => __( 'No ', 'miguelmorera' ) . $label_plural . ' Found in Trash',
                    'parent'             => __( 'Parent ', 'miguelmorera' ) . $label_singular,
                )
            )
        );
    }
    add_action('init', 'register_mm_diary_type');
}