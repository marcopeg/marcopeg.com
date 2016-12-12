<?php get_header(); ?>
<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
    <div class="post">


        <div class="post__headline">
            <a href="<?php echo esc_url( get_permalink() )?>">
                <?php if (custom_field_has_value('image')): ?>
                    <img src="<?php the_custom_field('image') ?>" alt="panic" width="150" height="150" class="aligncenter size-thumbnail wp-image-32 img-circle" />
                <?php endif; ?>
                <h1><?php the_title(); ?></h1>
                <?php if (custom_field_has_value('subtitle')): ?>
                    <h2><?php the_custom_field('subtitle') ?></h2>
                <?php endif; ?>
            </a>
        </div>


        <div class="post__info">
                <span class="post__date">
                    <?php the_time('F') ?>
                    <?php the_time('j') ?>,
                    <?php the_time('Y') ?>
                </span>
                <span class="post__author">
                    by, <b><?php the_author_full_name() ?></b>
                </span>
        </div>

        <div class="post__content">
            <?php the_content() ?>
        </div>

        <?php if ( comments_open() || get_comments_number() ) : ?>
            <div class="post__comments">
                <?php comments_template() ?>
            </div>
        <?php endif; ?>
    </div>
<?php endwhile; endif;?>



<a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="btn btn-secondary-outline btn-lg post__close-btn">
    X
</a>
<?php get_footer();
