<?php 
    get_header();
    $page_header_style = 'hero';
    $additional_header_classes = 'flex space';
    include(locate_template('includes/page-header.php'));
?>

<?php if (have_posts()) : ?>
    <?php while (have_posts()) : the_post(); ?>
        <article id="content" class="article article--single post section space" data-bg-color="#ffffff" data-type="light" data-scroll>
            <div class="wrapper">
                <?php the_content(); ?>
            </div> <!--  /.wrapper -->
        </article><!-- .post -->
        <?php comments_template(); ?>
    <?php endwhile; wp_reset_postdata(); ?>
<?php endif; ?>

<?php get_footer(); ?>