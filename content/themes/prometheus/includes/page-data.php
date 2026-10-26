<?php
    $post_type = get_post_type();
    // Custom post types take their color and header type from their listing page.
    $page_parent_id = null;
    switch ($post_type) {
        case 'mm_work':
            $page_parent_id = get_page_id_by_slug('trabajos');
            break;
        case 'mm_comic':
            $page_parent_id = get_page_id_by_slug('comics');
            break;
        case 'mm_dev_post':
            $page_parent_id = get_page_id_by_slug('blog-desarrollo');
            break;
        case 'mm_diary':
            $page_parent_id = get_page_id_by_slug('diario');
            break;
    }

    if (is_home()) {
        $page_id = get_option('page_for_posts', true);
    } else {
        $page_id = get_the_ID();
    }

    $settings_page_id = ($page_parent_id && !is_home()) ? $page_parent_id : $page_id;
    $page_bg_color = get_field('main_page_color', $settings_page_id);
    $page_header_type = get_field('main_header_type', $settings_page_id);
?>
