<?php
add_shortcode( 'post_gallery_lite', 'post_gallery_lite_short_code' );

function post_gallery_lite_short_code( $atts ) {
    global $post;
    global $post_gallery_lite;
    global $post_gallery_lite_attributes;
    global $post_gallery_lite_original_attributes;

    $post_gallery_lite_original_attributes = $atts;

    $post_gallery_lite_attributes = shortcode_atts(array(
        'template' => 'default',
    ), $post_gallery_lite_original_attributes);

    $ids = post_gallery_lite_unserialize($post->ID);
    $post_gallery_lite = post_gallery_lite_fetch_images($ids);

    // don't try to render an empty gallery
    if (empty($post_gallery_lite)) {
        return '';
    }

    ob_start();
    post_gallery_lite_render_template($post_gallery_lite_attributes['template']);
    return ob_get_clean();
}
