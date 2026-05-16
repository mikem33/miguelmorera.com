<?php
    function prometheus_scripts() {
        global $release;
        // Set false if you want to load on the <head>.
        if (!is_admin()) {
            wp_enqueue_style( 'miguelmorera-style', get_stylesheet_uri(), array(), '1.00', 'all' );
            wp_deregister_script('jquery');
            wp_enqueue_script( 'jquery', '//code.jquery.com/jquery-3.4.1.min.js', array(), $release, true );
            if (is_page_template('page-templates/template-home.php')) {
                wp_enqueue_script( 'home-scripts', get_template_directory_uri() . '/assets/javascript/home.min.js', array('jquery'), $release, true );
            }
            if (is_page_template('page-templates/template-contact.php') || is_single() || is_404()) {
                wp_enqueue_script( 'form-scripts', get_template_directory_uri() . '/assets/javascript/form.min.js', array('jquery'), $release, true );
            }
            wp_enqueue_script( 'javascript', get_template_directory_uri() . '/assets/javascript/javascript.min.js', array('jquery'), $release, true );
            if ( is_single() && get_option( 'thread_comments' ) ) { 
                wp_enqueue_script( 'comment-reply' );
            }
        }
    }
    add_action( 'wp_enqueue_scripts', 'prometheus_scripts' );
?>