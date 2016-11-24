<?php
$gallery_ids = post_gallery_lite_unserialize($post->ID);
$gallery_images = post_gallery_lite_fetch_images($gallery_ids);
?>
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
                <h2 class="post-list-item__headline post-list-item__headline--nomargin">
                    <a href="<?php echo esc_url( get_permalink() )?>"><?php the_title(); ?></a>
                </h2>
                <div class="post-list-item__content">
                    <?php foreach ( $gallery_images as $image ) : ?>
                        <img src="<?php echo $image['thumb'] ?>" width="40" height="40" />
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </div>
</div>
