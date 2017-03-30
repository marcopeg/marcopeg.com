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
            <div class="col-xs-9">
                <div class="post-list-item__author">
                    <?php the_author_full_name() ?>
                </div>
                <h2 class="post-list-item__headline">
                    <a href="<?php echo esc_url( get_permalink() )?>" title="<?php the_title(); ?>">
                        <?php the_title(); ?>
                    </a>
                </h2>
                <div class="post-list-item__content">
                    <?php is_single() ? the_content() : the_excerpt() ?>
                </div>
            </div>
            <div class="col-xs-1">
                <a href="<?php echo esc_url( get_permalink() )?>" title="<?php the_title(); ?>">
                    <img src="<?php echo get_template_directory_uri() . '/images/link.png' ?>" alt="External Link" class="img-responsive" />
                </a>
            </div>
        </div>
    </div>
</div>
