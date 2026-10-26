<?php
    /**
     * Function for register a sidebar.
     */
    if (function_exists('register_sidebar')) {
        register_sidebar(array(
            'name' => __('Sidebar Widgets','prometheus'),
            'id'   => 'sidebar-widgets',
            'description'   => __( 'These are widgets for the sidebar.','prometheus'),
            'before_widget' => '<div id="%1$s" class="widget %2$s">',
            'after_widget'  => '</div>',
            'before_title'  => '<h2>',
            'after_title'   => '</h2>'
        ));
    }

    /**
     * Tell to Wordpress to look for custom theme language file.
     */
    function prometheus_lang(){
        load_theme_textdomain( 'prometheus', get_stylesheet_directory() . '/languages' );
    }
    add_action('after_setup_theme', 'prometheus_lang');

    /**
     * Function for enable thumbnails generation and custom sizes.
     */
    add_theme_support('post-thumbnails');
    add_image_size('item-thumbnail', 960, 600, true);
    add_image_size('item-thumbnail-medium', 640, 400, true);
    add_image_size('item-thumbnail-little', 480, 300, true);

    /**
     * Function to get responsive images on post thumbnails with custom created sizes.
     * @param  integer  $post_id    Post ID to get thumbnail.
     * @param  string   $size       Name of the thumbnail to get.
     * @param  string   $class      Add class to the image.
     * @param  string   $echo       It is for echo or returned the image value.
     * @return string
     */
    function pr_post_thumbnail($post_id, $size = 'item-thumbnail', $class = '', $echo = true) {
        $thumbnail = wp_get_attachment_image_src( get_post_thumbnail_id( $post_id ), $size )[0];
        $thumbnail_medium = wp_get_attachment_image_src( get_post_thumbnail_id( $post_id ), $size . '-medium' )[0];
        $thumbnail_little = wp_get_attachment_image_src( get_post_thumbnail_id( $post_id ), $size . '-little' )[0];
        
        if ($thumbnail) {
            $image  = '<img src="' . $thumbnail . '"';
            $image .= ( $thumbnail_medium && $thumbnail_little ?  ' srcset="' : '' ); // open srcset
            $image .= ( $thumbnail_little ? $thumbnail_little . ' 480w' : '' );
            $image .= ( $thumbnail_medium && $thumbnail_little ? ', ' : '' );
            $image .= ( $thumbnail_medium ? $thumbnail_medium . ' 640w' : '' );
            $image .= ( $thumbnail_medium && $thumbnail_little ? ', ' : '' );
            $image .= ( $thumbnail ? $thumbnail . ' 960w' : '' );
            $image .= ( $thumbnail_medium && $thumbnail_little ?  '"' : '' ); // close srcset
            $image .= ( $class ? ' class="' . esc_attr($class) . '"' : '' );
            $image .= ' sizes="500px" alt="' . get_the_title($post_id) . '" />';
        } else {
            $thumbnail = get_stylesheet_directory_uri().'/assets/images/default-thumbnail.jpg';
            $image = '<img src="' . $thumbnail . '" alt="' . get_the_title($post_id) . '" />';
        }

        if ($echo == true) {
            echo $image;
        } else {
            return $image;
        }
    }

    /**
     * Function to enable wide images support on Gutenberg.
     */
    function pr_wide_images_setup() {
        add_theme_support( 'align-wide' );
    }
    add_action( 'after_setup_theme', 'pr_wide_images_setup' );

    /**
     * Create default menu spaces.
     */
    function pr_register_my_menus() {
        register_nav_menus(
            array(
              'header-menu' => __('Header Menu', 'prometheus'),
              'footer-menu' => __('Footer Menu', 'prometheus')
            )
        );
    }
    add_action( 'init', 'pr_register_my_menus' );

    /**
     * Determine the text of the 'Read more'
     * @param  string   $more_link          The original link of the full post.
     * @param  string   $more_link_text     The original text of the link to the full post.
     * @return string
     */
    function pr_more_link($more_link, $more_link_text) {
        return str_replace($more_link_text, __('Read more &raquo;', 'prometheus'), $more_link);
    }
    add_filter('the_content_more_link', 'pr_more_link', 10, 2);

    /**
     * Meta description text for the head tag.
     */
    function pr_meta_description() {
        global $post;
        if (is_singular()) {
            $page_id = $post->ID;
            $page_header_text = get_field('page_header_stuff', $page_id)['page_header_text'] ?? '';
            if ($page_header_text){
                $post_content = $page_header_text;
            } else {
                $post_content = $post->post_content;
            }
            $post_content = strip_tags($post_content);
            $post_content = strip_shortcodes($post_content);
            $post_content = str_replace(array("\n", "\r", "\t"), ' ', $post_content);
            $post_content = str_replace(array('"'), '', $post_content);
            $excerpt = (strlen($post_content) > 300) ? '...' : '';
            $post_content = mb_substr($post_content, 0, 300, 'utf8');
            $post_content = preg_replace('/\s+/', ' ', $post_content);
            $post_content = trim($post_content, ' ');
            $post_content = $post_content.$excerpt;
            return $post_content;
        }
        if (is_home()) {
            return get_bloginfo('description');
        }
        if (is_category()) {
            $cat_content = strip_tags(category_description());
            return $cat_content;
        }
    }
    add_action( 'wp_head', 'pr_meta_description');

    /**
     * Shorten paragraph function.
     * @param  string   $paragraph  The original text
     * @param  integer  $characters The number of characters to show
     * @return string               The result string.
     */
    function shortenParagraph($paragraph, $characters) {
        if (strlen($paragraph) <= $characters) {
            return $paragraph;
        } else {
            $newParagraph = mb_substr($paragraph, 0, $characters).'...';
            return $newParagraph;
        }
    }

    /**
     * Add custom classes to the previous and next pagination links.
     */
    function next_posts_link_attributes() { return 'class="button button--next"'; }
    function previous_posts_link_attributes() { return 'class="button button--previous"'; }
    add_filter('next_posts_link_attributes', 'next_posts_link_attributes');
    add_filter('previous_posts_link_attributes', 'previous_posts_link_attributes');

    /**
     * Adds a responsive embed wrapper around oEmbed content
     * Filters the oEmbed process to run the responsive_embed() function
     */
    if(!function_exists('video_content_filter')) {
        function video_content_filter($content) {

            // Search for an iframe.
            $pattern = '/<iframe.*?src=".*?(vimeo|youtu\.?be).*?".*?<\/iframe>/';
            preg_match_all($pattern, $content, $matches);

            foreach ($matches[0] as $match) {
                $wrappedframe = '<div class="responsive-video"><div class="content">' . $match . '</div></div>';
                $content = str_replace($match, $wrappedframe, $content);
            }
            return $content;
        }
        // Filter posts 'the_content'.
        add_filter( 'the_content', 'video_content_filter' );

    }

    /**
     * Add reading time for posts.
     */
    function reading_time() {
        $content = get_post_field( 'post_content' );
        $word_count = str_word_count( strip_tags( $content ) );
        $readingtime = ceil($word_count / 200);

        $totalreadingtime = $readingtime . __(' min. de lectura', 'prometheus');

        return $totalreadingtime;
    }

    /**
     * Head GTM // Google Analytics.
     */
    add_action( 'wp_head', 'pr_google_analytics_head', 10 );
    
    function pr_google_analytics_head() { ?>
        <!-- Google tag (gtag.js) -->
        <script async src="https://www.googletagmanager.com/gtag/js?id=G-HMHB9H4R0C"></script>
        <script>
          window.dataLayer = window.dataLayer || [];
          function gtag(){dataLayer.push(arguments);}
          gtag('js', new Date());
        
          gtag('config', 'G-HMHB9H4R0C');
        </script>
    <?php }

    /**
     * Get Page ID by Slug.
     */
    function get_page_id_by_slug($page_slug) {
        $page = get_page_by_path($page_slug);
        if ($page) {
            return $page->ID;
        } else {
            return null;
        }
    }

    global $detect;
    $detect = new Mobile_Detect;

    add_filter( 'wpcf7_load_js', '__return_false' );
    add_filter( 'wpcf7_load_css', '__return_false' );

    /**
     * Disable automatic image scale.
     */
    add_filter( 'big_image_size_threshold', '__return_false' );

?>