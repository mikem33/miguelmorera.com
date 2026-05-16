<?php
    /* Template Name: Flexible Content */
    __( 'Flexible Content', 'prometheus' ); // Template Name translation
    get_header();
    $additional_header_classes = 'flex space';
    include(locate_template('includes/page-header.php'));
?>

<?php while (have_posts()) : the_post(); ?>
    <section class="block-columns" data-bg-color="var(--main-page-color)" data-type="dark" data-scroll>
        <?php 
            if (have_rows('content_blocks')) : 
                $rows = get_field('content_blocks');
                // echo '<pre>';
                // var_dump($rows);
                // echo '</pre>';

                foreach ($rows as $row_data) :
                    $columns         = $row_data['columns'];
                    $css_classes_row = (!empty($row_data['css_classes_row']) ? ' '.$row_data['css_classes_row'] : '');
                    
                    if ($columns == '2') {
                        $layout = 'half';
                    }
                    
                    $content = $row_data['text_block'];
            ?>
                <div class="block grid flex<?php echo $css_classes_row; ?>">
                    
                    <?php foreach ($content as $block) : ?>
                        <?php 
                            $block_data = $block['content'][0];
                            if ($block_data['acf_fc_layout'] == 'image') {
                                $css_classes = 'block-column--image '.$layout;
                            } elseif ($block_data['acf_fc_layout'] == 'video') {
                                $css_classes = 'block-column--video '.$layout;
                            } elseif ($block_data['acf_fc_layout'] == 'wysiwyg_editor') {
                                $css_classes = 'block-column--text section space '.$layout;
                            }
                            $css_classes_block = (!empty($block['css_classes_block']) ? ' '.$css_classes.' '.$block['css_classes_block'] : ' '.$css_classes); 
                        ?>
                        <article class="block-column grid__item<?php echo $css_classes_block; ?>">
                            <?php 
                                if ($block_data['acf_fc_layout'] == 'wysiwyg_editor') :
                            ?>
                                <div class="content">
                                    <?php echo $block_data['text_content']; ?>
                                </div> <!--  /.content -->
                            <?php elseif ($block_data['acf_fc_layout'] == 'image') : ?>
                                <?php $image = $block_data['image']; ?>
                                <img src="<?php echo $image['sizes']['item-thumbnail']; ?>" width="<?php echo $image['sizes']['item-thumbnail-width']; ?>" height="<?php echo $image['sizes']['item-thumbnail-height']; ?>" srcset="<?php echo $image['sizes']['item-thumbnail-little']; ?> 480w, <?php echo $image['sizes']['item-thumbnail-medium']; ?> 640w, <?php echo $image['sizes']['item-thumbnail']; ?> 960w" sizes="auto" alt="<?php _e('Imagen','prometheus'); ?>" />
                            <?php elseif ($block_data['acf_fc_layout'] == 'video') : ?>
                                <div class="content" style="background-image: url('<?php echo $block_data['fallback_image']; ?>');">
                                    <?php if ( !$detect->isMobile() || !$detect->isTablet() ) : ?>
                                        <video autoplay loop poster="<?php echo $block_data['fallback_image']; ?>" playsinline muted>
                                            <source src="<?php echo $block_data['video']; ?>" type="video/mp4">
                                        </video>
                                    <?php endif; ?>
                                </div> <!--  /.content -->
                            <?php endif; ?>
                        </article>
                    <?php endforeach; ?>
                </div> <!--  /.content -->
            <?php endforeach;  ?>
        <?php endif; ?>
    </section> <!--  /.works__list -->
<?php endwhile; ?>

<?php get_footer(); ?>