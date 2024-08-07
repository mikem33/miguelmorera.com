        </main> <!--  /.main -->
        <footer class="footer space">
            <div class="wrapper">
                <div class="footer__logo">
                    <a href="<?php echo home_url(); ?>" class="logo--footer" title="<?php _e( 'Ir a la página inicial','prometheus' ); ?>" aria-label="<?php _e('Ir a la página inicial','prometheus'); ?>">
                        <svg><use xlink:href="#logo" /></svg>
                    </a>
                </div> <!--  /.footer__logo -->
                <?php 
                    $args = array(
                        'menu'            => 15,
                        'container'       => 'nav',
                        'container_class' => 'footer__nav',
                        'echo'            => false,
                        'items_wrap'      => '%3$s',
                        'depth'           => 0,
                    );
                    echo strip_tags( wp_nav_menu( $args ), '<nav>,<a>' );
                ?>
                <?php if ( get_field( 'network', 'option' ) ): ?>
                    <div class="footer__social-networks">
                        <?php while( has_sub_field( 'network', 'option' ) ) : ?>
                            <a href="<?php the_sub_field( 'network_url' ); ?>" title="<?php the_sub_field( 'network_slug' ); ?>" class="<?php the_sub_field( 'network_slug' ); ?>" target="_blank" rel="noopener"><svg><use xlink:href="#ico-<?php the_sub_field( 'network_slug' ); ?>" /></svg></a>
                        <?php endwhile; ?>
                    </div> <!--  /.footer__social-networks -->
                <?php endif; ?>
                <div class="colophon">
                    <p>&copy; 2010 - <?php echo date('Y'); ?> Miguel Morera</p>
                </div> <!--  /.colophon -->
            </div> <!--  /.wrapper -->
        </footer> <!--  /.footer -->
        <div class="alpha-warning space">
            <span><?php _e('Alpha', 'prometheus'); ?></span>
        </div> <!--  /.alpha-warning -->
        <?php wp_footer(); ?>
        <div class="nondisplayed">
            <?php echo file_get_contents(get_stylesheet_directory().'/assets/images/sprites.svg'); ?>
        </div><!-- /.nondisplayed -->
    </body>
</html>