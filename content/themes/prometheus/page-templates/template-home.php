<?php
    /* Template Name: Home */
    __( 'Home', 'prometheus' ); // Template Name translation
    get_header();
    $page_header_style = 'hero';
    $additional_header_classes = 'flex space';
    include(locate_template('includes/page-header.php'));
?>

<section class="home__articles home__section items section space" id="content" data-bg-color="#f45a5a" data-type="dark" data-scroll>
    <header class="section__header wrapper">
        <h3 class="title"><?php _e('De vez en cuando me gusta escribir algunos artículos...', 'prometheus'); ?></h3>
    </header> <!--  /.section__header -->
    <div class="items__container wrapper">
        <?php
            $home_posts_args = array(
                'post_type' => 'post',
                'order' => 'DESC',
                'posts_per_page' => 2,
                'orderby' => 'date'
            );
            $home_posts_query = new WP_Query($home_posts_args);
            while ($home_posts_query->have_posts()) : 
                $home_posts_query->the_post();
        ?>
        <article class="article item">
            <figure>
                <a href="<?php the_permalink(); ?>">
                    <?php pr_post_thumbnail(get_the_ID()); ?>
                </a>
            </figure>
            <h2 class="title beta"><a href="<?php the_permalink() ?>" rel="bookmark" title="<?php _e('Enlace permanente a','prometheus'); ?> <?php the_title_attribute(); ?>"><?php the_title(); ?></a></h2> <!--  /.title .beta-->
            <div class="meta">
                <time datetime="<?php echo date(DATE_W3C); ?>" pubdate><?php the_time('j M, Y') ?></time>
                <span class="reading-time"><?php echo reading_time(); ?></span>
            </div> <!--  /.meta -->
            <div class="content">
                <?php 
                    $page_header_stuff =  get_field('page_header_stuff', get_the_ID());
                    echo $page_header_stuff['page_header_text'];
                ?>
            </div> <!--  /.content -->
            <a href="<?php the_permalink(); ?>" class="item__link">
                <svg width="7" height="12" class="ico"><use xlink:href="#ico-chevron" /></svg>
                <span><?php _e('Continue reading', 'prometheus'); ?></span>
            </a>
        </article><!-- /.article .item -->
        <?php endwhile; wp_reset_postdata(); ?>
    </div> <!--  /.items__container -->
    <a href="<?php echo get_permalink(38); ?>" class="button button--white-red button--filled button--icon">
        <span><?php _e('Ver más posts', 'prometheus'); ?></span>
        <svg width="15" height="15" class="ico"><use xlink:href="#ico-circle-arrow" /></svg>
    </a>
</section> <!--  /.home__articles .home__section -->

<section class="home__comics home__section items section space" data-scroll data-type="light" data-bg-color="#ffe42b">
    <header class="section__header wrapper">
        <h3 class="title"><?php _e('...o dibujar algunos cómics.','prometheus'); ?></h3> <!--  /.title -->
    </header> <!--  /.section__header -->
    <div class="items__container wrapper">
        <?php
            $home_comics_args = array(
                'post_type' => 'mm_comic',
                'order' => 'DESC',
                'posts_per_page' => 2,
                'orderby' => 'date'
            );
            $home_comics_query = new WP_Query($home_comics_args);
            while ($home_comics_query->have_posts()) : 
                $home_comics_query->the_post();
        ?>
        <article class="comic item">
            <figure>
                <a href="<?php the_permalink(); ?>">
                    <?php pr_post_thumbnail(get_the_ID()); ?>
                </a>
            </figure>
            <h2 class="title beta"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2> <!--  /.title .beta-->
            <div class="meta">
                <time datetime="<?php echo date(DATE_W3C); ?>" pubdate><?php the_time('j M, Y') ?></time>
                <div class="categories">
                <?php 
                    $count = 0;
                    $get_terms = wp_get_post_terms(get_the_ID(), 'mm_comic_category'); 
                    $total_terms = count($get_terms);
                    foreach ($get_terms as $term) :
                ?>
                    <p>
                        <a href="<?php echo get_term_link($term->term_id ); ?>">
                            <?php echo $term->name; ?>
                        </a>
                        <?php echo ($total_terms > 1 && $count < $total_terms - 1 ? ',':''); ?>
                    </p>
                <?php $count++; endforeach; ?>
                </div> <!--  /.categories -->
            </div> <!--  /.meta -->
            <div class="content">
                <?php 
                    $page_header_stuff =  get_field('page_header_stuff', get_the_ID());
                    echo $page_header_stuff['page_header_text'];
                ?>
            </div> <!--  /.content -->
            <a href="<?php the_permalink(); ?>" class="item__link">
                <svg width="7" height="12" class="ico"><use xlink:href="#ico-chevron" /></svg>
                <span><?php _e('Leer cómic', 'prometheus'); ?></span>
            </a>
        </article> <!--  /.comic .item -->
        <?php endwhile; ?>
    </div> <!--  /.content -->
    <a href="<?php echo get_permalink(40); ?>" class="button button--dark-grey-brown button--filled button--icon">
        <span><?php _e('Ver más cómics', 'prometheus'); ?></span>
        <svg width="15" height="15" class="ico"><use xlink:href="#ico-circle-arrow" /></svg>
    </a>
</section> <!--  /.home__comics home__section section space -->

<?php get_footer(); ?>