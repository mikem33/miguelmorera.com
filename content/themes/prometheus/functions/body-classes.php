<?php
    // Customising the classes on the body_class function.    
    function my_class_names($classes) {  
        global $wp_query;
        global $post;
      
        $arr = array();
        $arr[] = 'no-touch';
        
        if (is_page()) {
            $page_slug = $post->post_name;
            $page_id = get_the_ID();
            $page_template_slug = str_replace(array('page-templates/', '.php'), '', get_page_template_slug($page_id));
            $arr[] = 'page__'. $page_template_slug .' page__' . $page_slug;
        }  
        
        if (is_home()) {
            $arr[] = 'page__articles';
        }

        if (is_single()) {  
            $post_id = $wp_query->get_queried_object_id();
            $arr[] = 'single post-id-' . $post_id;
            if (get_post_type() == 'post') {
                $arr[] = 'single--article';
            } elseif (get_post_type() == 'mm_work') {
                $arr[] = 'single--work';
            } elseif (get_post_type() == 'mm_comic') {
                $arr[] = 'single--comic';
            } elseif (get_post_type() == 'mm_dev_post') {
                $arr[] = 'single--dev-post';
            } elseif (get_post_type() == 'mm_diary') {
                $arr[] = 'single--diary';
            }
        }

        if (is_404()) {
            $arr[] = 'page__404';
        }

        if ( is_admin_bar_showing() ) {
            $arr[] = 'showing-admin-bar';
        }
        
        if (is_user_logged_in()) {
            $arr[] = 'logged-in';
        }
        
        return $arr;
    }
    
    add_filter('body_class','my_class_names');
?>