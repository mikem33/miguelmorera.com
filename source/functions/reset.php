<?php
    // Remove Emoji Icons.
    remove_action('wp_head', 'print_emoji_detection_script', 7);
    remove_action('wp_print_styles', 'print_emoji_styles');

    // Removing the style on html tag for the user bar.
    function my_filter_head() { remove_action('wp_head', '_admin_bar_bump_cb'); }
    add_action('get_header', 'my_filter_head');

    // Deregister OEmbed for remote posts embedding.
    function my_deregister_scripts(){ wp_deregister_script( 'wp-embed' ); }
    add_action( 'wp_footer', 'my_deregister_scripts' );

    // Remove WP version from head
    remove_action('wp_head', 'wp_generator');

    // Remove version from RSS
    add_filter('the_generator', '__return_empty_string');

    // Swap the WP version in scripts and styles for the file's timestamp,
    // so the version is not exposed but the browser still sees URL changes.
    function shapeSpace_remove_version_scripts_styles($src) {
        if (strpos($src, 'ver=') === false) return $src;

        $src  = remove_query_arg('ver', $src);
        $path = parse_url($src, PHP_URL_PATH);
        if (!$path) return $src;

        $roots = array(
            array(parse_url(WP_CONTENT_URL, PHP_URL_PATH), untrailingslashit(WP_CONTENT_DIR)),
            array(parse_url(site_url(), PHP_URL_PATH), untrailingslashit(ABSPATH)),
        );

        foreach ($roots as $root) {
            list($base, $dir) = $root;
            if (strpos($path, $base . '/') !== 0) continue;
            $file = $dir . substr($path, strlen($base));
            if (is_file($file)) return add_query_arg('ver', filemtime($file), $src);
        }

        return $src;
    }
    add_filter('style_loader_src', 'shapeSpace_remove_version_scripts_styles', 9999);
    add_filter('script_loader_src', 'shapeSpace_remove_version_scripts_styles', 9999);
?>