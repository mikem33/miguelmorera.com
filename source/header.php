<!DOCTYPE html>
<?php include('includes/page-data.php'); ?>
<html <?php echo get_language_attributes(); ?> style="--main-page-color: <?php echo $page_bg_color; ?>;" data-main-color="<?php echo $page_bg_color; ?>">
    <head>
        <meta http-equiv="Content-Type" content="<?php bloginfo( 'html_type' ); ?>; charset=<?php bloginfo( 'charset' ); ?>">
        <?php if ( is_front_page() ) : ?>
            <title><?php bloginfo( 'name' ); ?> - <?php bloginfo( 'description' ); ?></title>
        <?php elseif ( is_single() ) : ?>
            <title><?php wp_title('-',true,'right'); ?><?php bloginfo('name'); ?></title>
        <?php else : ?>
            <title><?php wp_title('-',true,'right'); ?><?php bloginfo('name'); ?></title>
        <?php endif; ?>
        <meta name="description" content="<?php echo pr_meta_description(); ?>">
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
        <meta name="viewport" content="width=device-width, initial-scale=1">
            
        <link rel="alternate" type="text/xml" title="<?php bloginfo( 'name' ); ?> RSS 0.92 Feed" href="<?php bloginfo( 'rss_url' ); ?>">
        <link rel="alternate" type="application/atom+xml" title="<?php bloginfo( 'name' ); ?> Atom Feed" href="<?php bloginfo( 'atom_url' ); ?>">
        <link rel="alternate" type="application/rss+xml" title="<?php bloginfo( 'name' ); ?> RSS 2.0 Feed" href="<?php bloginfo( 'rss2_url' ); ?>">
        <link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">
        <?php wp_head(); ?>
        <?php if (get_field('custom_css')) : ?>
            <style type="text/css"><?php echo get_field('custom_css', $page_id); ?></style>
        <?php endif; ?>
    </head>
    <body <?php body_class(); ?>>
        <?php
            if ( function_exists( 'wp_body_open' ) ) {
                wp_body_open();
            }
        ?>
        <header class="header flex" data-header-type="<?php echo $page_header_type; ?>">
            <?php
                // On the front page home.js fades these in.
                $logo_classes = ( is_front_page() ? 'logo hide-item' : 'logo' );
                $hide_item = ( is_front_page() ? ' hide-item' : '' );
            ?>
            <a href="<?php echo home_url(); ?>" class="<?php echo $logo_classes; ?>" title="Miguel Morera" aria-label="Miguel Morera">
                <svg><use xlink:href="#logo" /></svg>
            </a>
            <button class="toggle-nav<?php echo $hide_item; ?>" data-alt-text="<?php _e('Cerrar','prometheus'); ?>">
                <span class="text"><?php _e('Menú','prometheus'); ?></span>
                <span class="toggle-nav__hamburger">
                    <span></span>
                </span>
            </button>
        </header> <!--  /.header -->
        <main class="main" role="main">
            <div class="nav section space">
                <div class="content">
                    <?php $menuParameters = array(
                        'menu'            => 16,
                        'container'       => 'nav',
                        'container_class' => 'nav__items',
                        'echo'            => false,
                        'items_wrap'      => '%3$s',
                        'depth'           => 0,
                    ); ?>
                    <?php echo strip_tags(wp_nav_menu( $menuParameters ), '<nav>,<a>' ); ?>
                </div> <!--  /.content -->
                <p class="nav__colophon">&copy; 2010 - <?php echo date('Y'); ?> Miguel Morera</p>
            </div> <!--  /.nav .section .space -->