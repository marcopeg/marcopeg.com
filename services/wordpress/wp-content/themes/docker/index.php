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


    <?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
    <div class="post-list-item">
        <div class="container-fluid">
            <div class="row">
                <div class="col-xs-2">
                    <time class="post-date">
                        <span class="post-date__month"><?php the_time('F') ?></span>
                        <span class="post-date__day"><?php the_time('j') ?></span>
                        <span class="post-date__year"><?php the_time('Y') ?></span>
                    </time>
                </div>
                <div class="col-xs-10">
                    <div class="post-list-item__author">
                        <?php the_author_full_name() ?>
                    </div>
                    <h2 class="post-list-item__headline">
                        <a href="<?php echo esc_url( get_permalink() )?>"><?php the_title(); ?></a>
                    </h2>
                    <div class="post-list-item__content">
                        <?php is_single() ? the_content() : the_excerpt() ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
	<?php endwhile; endif;?>

<?php get_footer();
