<?php
    /**
    Metadata : Open Graph, Twitter Card, Dublin Core
    **/

    function multi_metadata() {

        global $post;

        // 404s and empty archives or searches have no post to describe.
        if ( is_404() || ! $post ) {
            return;
        }

        $fname = get_the_author_meta('first_name', $post->post_author);
        $lname = get_the_author_meta('last_name', $post->post_author);
        $author = trim( "$fname $lname" );
        $site_lang = get_bloginfo('language');
        $description = pr_meta_description();
        $categories = implode( ', ', wp_list_pluck( get_the_category($post->ID), 'name' ) );

        if (has_post_thumbnail($post->ID)) {
            $image = wp_get_attachment_image_url(get_post_thumbnail_id($post->ID), 'full');
        } else {
            $image = get_stylesheet_directory_uri().'/assets/images/default-thumbnail.jpg';
        }

        /*If not a Single Page*/
        if ( !is_single() || is_home() ) { ?>
            <meta name="DC.Title" content="<?php the_title_attribute(); ?>">
            <meta name="DC.Publisher" content="<?php echo esc_attr(get_bloginfo('name')); ?>">
            <meta name="DC.Language" scheme="UTF-8" content="<?php echo esc_attr($site_lang); ?>">
            <meta property="og:title" content="<?php the_title_attribute(); ?>" />
        <?php }

        /*If is a Single Page*/
        if ( is_single() ) {    ?>
            <meta property="og:title" content="<?php the_title_attribute(); ?>" />
            <?php if (!empty($description)) { ?>
                <meta property="og:description" content="<?php echo esc_attr($description); ?>" />
            <?php } ?>
            <meta property="og:type" content="article" />
            <meta property="og:url" content="<?php echo esc_url(get_permalink()); ?>" />
            <meta property="og:image" content="<?php echo esc_url($image); ?>">
            <meta property="og:site_name" content="<?php echo esc_attr(get_bloginfo('name')); ?>" />
            <meta name="twitter:card" content="summary_large_image" />
            <meta name="twitter:url" content="<?php echo esc_url(get_permalink()); ?>" />
            <meta name="twitter:title" content="<?php the_title_attribute(); ?>" />
            <?php if (!empty($description)) { ?>
                <meta name="twitter:description" content="<?php echo esc_attr($description); ?>" />
            <?php } ?>
            <meta name="twitter:image" content="<?php echo esc_url($image); ?>" />
            <?php $twitter_id = '';
            if (!empty($twitter_id) ){ ?>
                <meta name="twitter:site" content="<?php echo esc_attr($twitter_id); ?>" />
                <meta name="twitter:creator" content="<?php echo esc_attr($twitter_id); ?>" />
            <?php } if ( $author ) { ?>
                <meta name="DC.Creator" content="<?php echo esc_attr($author); ?>">
            <?php }
            if ($categories) { ?>
                <meta name="DC.Subject" content="<?php echo esc_attr($categories); ?>">
            <?php }
            if (!empty($description)) { ?>
                <meta name="DC.Description" content="<?php echo esc_attr($description); ?>">
            <?php } ?>
            <meta name="DC.Identifier" content="<?php echo esc_url(get_permalink()); ?>">
            <meta name="DC.Date" content="<?php the_time('Y-m-d'); ?>">
            <meta name="DC.Title" content="<?php the_title_attribute(); ?>">
            <meta name="DC.Publisher" content="<?php echo esc_attr(get_bloginfo('name')); ?>">
            <meta name="DC.Language" scheme="UTF-8" content="<?php echo esc_attr($site_lang); ?>">
        <?php }
    }
    add_action( 'wp_head', 'multi_metadata' );
?>
