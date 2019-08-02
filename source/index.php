<?php 
    get_header();
    $additional_header_classes = 'flex space';
    include(locate_template('includes/page-header.php'));
?>

<section class="posts__list posts__section section space" data-bg-color="#f45a5a" data-type="dark" data-scroll>
    <div class="content">
    <?php while (have_posts()) : the_post(); ?>
        <article id="post-<?php the_ID(); ?>" class="post post--item item">
            <figure>
                <a href="<?php the_permalink(); ?>">
                    <?php the_post_thumbnail('full'); ?>
                </a>
            </figure>
            <h2 class="title beta"><a href="<?php the_permalink() ?>" rel="bookmark" title="<?php _e('Permanent link to','miguelmorera'); ?> <?php the_title_attribute(); ?>"><?php the_title(); ?></a></h2>
            <div class="meta">
                <time datetime="<?php echo date(DATE_W3C); ?>" pubdate><?php the_time('j M, Y') ?></time>
                <span class="reading-time"><?php echo reading_time(); ?></span>
            </div> <!--  /.meta -->
            <div class="content">
                <?php the_excerpt(); ?>
            </div><!-- .post-content -->
            <a href="<?php the_permalink(); ?>" class="item__link">
                <svg width="7" height="12" class="ico"><use xlink:href="#ico-chevron" /></svg>
                <span><?php _e( 'Continue reading', 'miguelmorera' ); ?></span>
            </a>
        </article><!-- .post .post--item .item -->
    <?php endwhile; ?>
    </div> <!--  /.content -->

    <nav class="navigation">
        <div class="next-posts"><?php next_posts_link(__('Página Siguiente &raquo;', 'miguelmorera')) ?></div>
        <div class="prev-posts"><?php previous_posts_link(__('&laquo; Página Anterior', 'miguelmorera')) ?></div>
    </nav>

</section> <!--  /.works__list -->

<?php get_footer(); ?>