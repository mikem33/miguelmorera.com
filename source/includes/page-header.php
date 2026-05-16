<?php
    if ($page_header_style == 'hero') {
        $additional_header_classes = 'page__header--hero '.$additional_header_classes;
    }

    include('page-data.php');
    $page_header_stuff = get_field('page_header_stuff', $page_id);
?>
<header class="page__header <?php echo $additional_header_classes; ?>" data-bg-color="<?php echo $page_bg_color; ?>" data-type="<?php echo $page_header_type; ?>" data-scroll>
    <div class="content">
        <?php if (is_archive()) : ?>
            <?php if (have_posts()) : ?>
                <?php 
                    $post = $posts[0]; // hack: set $post so that the_date() works
                    if (is_category()) : 
                ?>
                    <h1 class="title alpha">&ldquo;<?php single_cat_title(); ?>&rdquo;</h1>
                <?php elseif (is_tag()) : ?>
                    <h1 class="title alpha"><?php _e('Posts etiquetados con','prometheus'); ?> &ldquo;<?php single_tag_title(); ?>&rdquo;</h1>
                <?php elseif (is_day()) : ?>
                    <h1 class="title alpha"><?php _e('Archivo con fecha','prometheus'); ?> <?php the_time('F jS, Y'); ?></h1>
                <?php elseif (is_month()) : ?>
                    <h1 class="title alpha"><?php _e('Archivo de','prometheus'); ?> <?php the_time('F, Y'); ?></h1>
                <?php elseif (is_year()) : ?>
                    <h1 class="title alpha"><?php _e('Archivo del año','prometheus'); ?> <?php the_time('Y'); ?></h1>
                <?php elseif (is_author()) : ?>
                    <h1 class="title alpha"><?php _e('Archivo de autor','prometheus'); ?></h1>
                <?php elseif (isset($_GET['paged']) && !empty($_GET['paged'])) : ?>
                    <h1 class="title alpha"><?php _e('Archivo de blog','prometheus'); ?></h1>
                <?php endif; ?>
            <?php else : ?>
                <h1 class="title alpha"><?php _e('No hay resultados.','prometheus'); ?></h1> <!--  /.title alpha -->
            <?php endif; ?>
        <?php elseif (is_404()) : ?>
            <h1 class="title alpha"><?php _e('Página no encontrada','prometheus'); ?></h1> <!--  /.title alpha -->
        <?php
            elseif ($page_header_stuff['page_header_title']) :
        ?>
            <h1 class="title alpha<?php echo (is_front_page() ? ' hide-item':''); ?>"><?php echo $page_header_stuff['page_header_title']; ?></h1> <!--  /.title alpha -->
        <?php else : ?>
            <h1 class="title alpha"><?php echo get_the_title($page_id); ?></h1> <!--  /.title alpha -->
        <?php endif; ?>
        <?php if (!is_404() && $page_header_stuff) : ?>
            <?php echo $page_header_stuff['page_header_text']; ?>
        <?php elseif (is_404()) : ?>
            <p><?php _e('Lo sentimos pero la página que estabas buscando no se ha encontrado o no está disponible en este momento.','prometheus'); ?></p>
        <?php elseif (get_post_type() == 'mm_work') : ?>
            <p><?php echo get_field('work_subtitle', $page_id); ?></p>
        <?php endif; ?>
        <?php if (is_front_page()) : ?>
            <a href="<?php echo get_permalink(26); ?>" class="button button--white-purple button--filled button--icon hide-item">
                <span><?php _e('Ver mis trabajos', 'prometheus'); ?></span>
                <svg width="15" height="15" class="ico"><use xlink:href="#ico-circle-arrow" /></svg>
            </a>
        <?php endif; ?>
    </div> <!--  /.content -->
    <?php if ((get_post_type() == 'post' && is_single()) || get_post_type() == 'mm_dev_post' || get_post_type() == 'mm_diary') : ?>
        <div class="meta flex">
            <?php 
                $post_data = get_post($page_id);
                $author_id = $post_data->post_author; 
            ?>
            <div class="avatar">
                <?php echo get_avatar($author_id, 63); ?>
            </div> <!--  /.avatar -->
            <div class="content">
                <p class="author"><?php _e('Por','prometheus'); ?> <?php echo get_the_author_meta('display_name', $author_id); ?></p>
                <time datetime="<?php echo date(DATE_W3C); ?>" pubdate><?php the_time('j M, Y') ?></time>
                <span class="reading-time"><?php echo reading_time(); ?></span>
            </div> <!--  /.content -->
        </div> <!--  /.meta -->
    <?php endif; ?>
    <?php if ($page_header_style == 'hero') : ?>
        <?php if (is_single()) : ?>
            <?php if (has_post_thumbnail()) : ?>
                <figure class="bg-image alignfull">
                    <?php echo get_the_post_thumbnail($page_id, 'full', array('style'=>'object-position: '.$page_header_stuff['page_header_bg_image_pos'].';')); ?>
                </figure> <!--  /.alignfull -->
            <?php endif; ?>
        <?php endif; ?>
        <a href="#content" class="content-anchor">
            <svg width="20" height="20" class="ico"><use xlink:href="#ico-circle-chevron" /></svg>
        </a>
        <?php if (is_front_page()) : ?>
            <canvas class="header-circles hide-item"></canvas> <!--  /.header-circles -->
        <?php endif; ?>
    <?php endif; ?>
</header>