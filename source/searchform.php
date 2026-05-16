<form method="get" id="searchform" class="flex mm__form" action="<?php bloginfo('url'); ?>/">
    <fieldset class="fieldset fieldset--text">
        <label for="s" class="label"><?php _e('Introduce tu búsqueda','prometheus'); ?></label>
        <input type="text" id="s" name="s" placeholder="<?php _e('Introduce tu búsqueda','prometheus'); ?>" value="<?php the_search_query(); ?>">
    </fieldset>
    <button class="button button--white-blue button--filled button--icon button--search" type="submit">
        <span><?php _e('Buscar', 'prometheus'); ?></span>
        <svg width="15" height="15" class="ico"><use xlink:href="#ico-circle-arrow" /></svg>
    </button>
</form>