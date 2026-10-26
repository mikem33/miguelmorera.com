<?php 
    /**
     * Custom Navigation
     * Based on Bill Erirckson custom pagination.
     * @author Bill Erickson
     * @see https://www.billerickson.net/custom-pagination-links/
     *
     */
    function pr_navigation() {
        $post_type = get_post_type();
        $nav_classes = 'nav--pagination';
        switch ($post_type) {
            case 'post':
                $nav_classes = $nav_classes.' pagination--white-red';
                break;
            default:
                $nav_classes = $nav_classes.' pagination--dark-grey';
                break;
        }
        $settings = array(
            'count' => 6,
            'prev_text' => '<svg width="10" height="17" class="ico"><use xlink:href="#ico-chevron" /></svg>',
            'next_text' => '<svg width="10" height="17" class="ico"><use xlink:href="#ico-chevron" /></svg>'
        );
        global $wp_query;
        $current = max( 1, get_query_var( 'paged' ) );
        $total = $wp_query->max_num_pages;
        $links = array();
        // Offset for next link
        if( $current < $total ) { $settings['count']--; }
        // Previous
        if( $current > 1 ) {
            $settings['count']--;
            $links[] = pr_navigation_link( $current - 1, ' nav__link--prev', $settings['prev_text'] );
        }
        // Current
        $links[] = pr_navigation_link( $current, 'current' );
        // Next Pages
        for( $i = 1; $i < $settings['count']; $i++ ) {
            $page = $current + $i;
            if( $page <= $total ) {
                $links[] = pr_navigation_link( $page );
            }
        }
        // Next
        if( $current < $total ) {
            $links[] = pr_navigation_link( $current + 1, ' nav__link--next', $settings['next_text'] );
        }
        echo '<nav class="'.$nav_classes.'" role="navigation">';
            echo join( '', $links );
        echo '</nav>';
    }

    /**
     * Navigation Link
     * Based on Bill Erickson pagination.
     * @author Bill Erickson
     * @see https://www.billerickson.net/custom-pagination-links/
     *
     * @param int $page
     * @param string $class
     * @param string $label
     * @return string $link
     */
    function pr_navigation_link( $page = false, $class = '', $label = '' ) {
        if( !$page ) { return; }
        $classes = array( 'nav__link' );
        if( !empty( $class ) ) { 
            $classes[] = $class;
        }
        $classes = array_map( 'esc_attr', $classes );
        $label = $label ? $label : $page;
        $link = esc_url_raw( get_pagenum_link( $page ) );
        return '<a class="' . join ( ' ', $classes ) . '" href="' . $link . '">' . $label . '</a>';
    }
?>