<?php 
    get_header(); 
    $additional_header_classes = 'flex space';
    include(locate_template('includes/page-header.php'));
?>
<section class="not-found__content section space" data-bg-color="#f45a5a" data-type="dark" data-scroll>
    <div class="wrapper">
        <article class="content">
            <h2 class="title alpha"><?php _e('¿Buscas algo en particular?','prometheus'); ?></h2>
            <?php get_search_form(); ?>
        </article>
    </div>
</section>

<?php get_footer(); ?>