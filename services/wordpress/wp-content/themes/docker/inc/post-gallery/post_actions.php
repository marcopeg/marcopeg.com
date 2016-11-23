<?php

add_action( 'admin_enqueue_scripts', 'post_gallery_enqueue_scripts' );
add_action( 'add_meta_boxes', 'post_gallery_register_meta_box' );

function post_gallery_register_meta_box() {
    add_meta_box(
        'post_gallery_post_meta_box',
        'PhotoGallery',
        'post_gallery_meta_box_content',
        'post'
    );
}

function post_gallery_meta_box_content() {
    global $post;
    if (!empty($post->ID)) {
        echo '<div id="post-gallery"></div>';
        echo '<script>jQuery("#post-gallery").postGallery({ postId: "' . $post->ID . '"})</script>';
    }
}

function post_gallery_enqueue_scripts() {
    $version = time();
    $cssUrl = get_template_directory_uri() . '/inc/post-gallery/post-gallery.css';
    $scriptUrl = get_template_directory_uri() . '/inc/post-gallery/post-gallery.js';

    wp_enqueue_script( 'post-gallery', $scriptUrl, array('jquery', 'jquery-ui-sortable'), $version );
    wp_enqueue_style( 'post-gallery', $cssUrl, array(), $version);
}
