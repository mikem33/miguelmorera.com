<?php get_header(); ?>
    <div class="wrapper">
        <header>
            <h1 class="page-title"><?php _e('Resultados de Búsqueda para', 'prometheus'); ?> &ldquo;<?php the_search_query(); ?>&rdquo;</h1>
        </header><!-- .page-title -->
            <?php if (have_posts()) : ?>
                <?php while (have_posts()) : the_post(); ?>
                    <article id="post-<?php the_ID(); ?>" class="post">

                        <li>
                            <h3><a href="<?php the_permalink() ?>" rel="bookmark" title="Enlace permanente a <?php the_title_attribute(); ?>"><?php the_title(); ?></a></h3>
                            <?php the_excerpt(); ?>
                        </li>

                    </article>
                <?php endwhile; ?>
                <nav>
                    <p><?php posts_nav_link('&nbsp;&bull;&nbsp;'); ?></p>
                </nav>
            <?php else : ?>
                <article class="post">
                    <h1><?php _e('No se ha encontrado.', 'prometheus'); ?></h1>
                    <p><?php _e('Lo sentimo pero el recurso solicitado no se encuentra.', 'prometheus'); ?></p>
                    <?php get_search_form(); ?>
                </article>
            <?php endif; ?>

        </section><!-- .container -->
    </div><!-- .wrapper -->

<?php get_footer(); ?>