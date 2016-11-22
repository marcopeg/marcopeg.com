<?php

function postGallery_register_meta_box() {
    add_meta_box(
        'postGallery_post_meta_box',
        'PhotoGallery',
        'postGallery_meta_box_content',
        'post'
    );
}

function postGallery_meta_box_content() {
    echo '<div id="postGallery_app"></div>';
    echo '<script>jQuery("#postGallery_app").postGallery({ postId: "' . $_GET['post'] . '"})</script>';
}

function postGallery_enqueue_scripts() {
    $scriptUrl = get_template_directory_uri() . '/inc/post-gallery/functions.js';
    wp_enqueue_script( 'custom-gallery-logic', $scriptUrl );
}


function postGallery_add_images() {
    $post_id = $_POST['post_id'];
    $gallery = explode(',', get_post_meta($post_id, 'post_gallery')[0]);
    $gallery = array_merge($gallery, $_POST['ids']);
    $gallery = array_unique($gallery, SORT_NUMERIC);
    $gallery = implode(',', $gallery);

    $update = update_post_meta($post_id, 'post_gallery', $gallery);
    wp_die();
}

function postGallery_get_images() {
    $post_id = $_POST['post_id'];
    $ids = explode(',', get_post_meta($post_id, 'post_gallery')[0]);
    $gallery = [];

    foreach ( $ids as $id ) {
        if ( !empty($id) ) {
            $attachment = [
                'id' => $id,
                'thumb' => wp_get_attachment_thumb_url($id),
            ];
            array_push($gallery, $attachment);
        }
    }

    echo json_encode($gallery, JSON_UNESCAPED_SLASHES);
    wp_die();
}

function postGallery_del_image() {
    $post_id = $_POST['post_id'];
    $ids = explode(',', get_post_meta($post_id, 'post_gallery')[0]);
    $gallery = [];

    foreach ( $ids as $id ) {
        if ( !empty($id) && $id != $_POST['image_id'] ) {
            array_push($gallery, $id);
        }
    }

    $gallery = implode(',', $gallery);
    update_post_meta($post_id, 'post_gallery', $gallery);
    wp_die();
}

add_action( 'admin_enqueue_scripts', 'postGallery_enqueue_scripts' );
add_action( 'add_meta_boxes', 'postGallery_register_meta_box' );

# Ajax methods
add_action( 'wp_ajax_postGallery_getImages', 'postGallery_get_images' );
add_action( 'wp_ajax_postGallery_addImages', 'postGallery_add_images' );
add_action( 'wp_ajax_postGallery_delImage', 'postGallery_del_image' );
