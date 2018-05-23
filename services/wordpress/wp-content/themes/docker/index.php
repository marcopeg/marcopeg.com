<?php get_header() ?>

    <div class="blog-intro">
        <h1 class="blog-intro__headline">
            <a href="<?php bloginfo('wpurl');?>"><?php echo get_bloginfo( 'name' ) ?></a>
        </h1>
        <?php if ( !is_single() ): ?>
        <div class="blog-intro__content">
            <?php echo html_entity_decode(get_bloginfo( 'description' )); ?>
        </div>
        <?php endif ?>
    </div>


    <?php
    // Render main loop with different templates based on post-format:
    if ( have_posts() ) {
        while ( have_posts() ) {
            the_post();
            $format = get_post_format($post->ID);
            if (empty($format)) {
                $format = 'default';
            }
            get_template_part('post-list/post-format', $format);
        }
        // add paging
        global $wp_query;
        if( $wp_query->max_num_pages > 1 ): ?>
        <div class="docker_paginate_links">
        <?php
          $big = 999999999; // need an unlikely integer
          echo paginate_links( array(
          	'base' => str_replace( $big, '%#%', esc_url( get_pagenum_link( $big ) ) ),
          	'format' => '?paged=%#%',
          	'current' => max( 1, get_query_var('paged') ),
          	'total' => $wp_query->max_num_pages,
          ) ); ?>
        </div>
        <?php
        endif;
    } ?>

<?php get_footer();
