<?php
// Automatically enqueue the gallery at the end of the post
add_filter( 'the_content', 'post_gallery_lite_enqueue_gallery' );
function post_gallery_lite_enqueue_gallery($content) {

    if (post_gallery_lite_is_disabled()) {
        return $content;
    }

    if (strpos($content, '[post_gallery_lite') !== false) {
        return $content;
    } else {
        return $content . '[post_gallery_lite]';
    }
}
