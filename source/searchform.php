<form method="get" id="searchform" class="flex" action="<?php bloginfo('url'); ?>/">
    <input type="text" id="s" name="s" placeholder="<?php _e('Introduce tu búsqueda','prometheus'); ?>" value="<?php the_search_query(); ?>">
    <button class="button button--white-blue button--filled button--icon button--search" type="submit">
        <span><?php _e('Buscar', 'prometheus'); ?></span>
        <svg width="15" height="15" class="ico"><use xlink:href="#ico-circle-arrow" /></svg
    </button>
    
</form>