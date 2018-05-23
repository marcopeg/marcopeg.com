<?php
add_action( 'admin_enqueue_scripts', 'post_gallery_lite_enqueue_admin_scripts' );
add_action( 'add_meta_boxes', 'post_gallery_lite_register_meta_box' );
add_action( 'save_post', 'post_gallery_lite_post_save' );

function post_gallery_lite_register_meta_box() {

    if (post_gallery_lite_is_disabled()) {
        return;
    }

    add_meta_box(
        'post_gallery_lite_post_meta_box',
        'PostGalleryLite',
        'post_gallery_lite_meta_box_content',
        'post'
    );
}

function post_gallery_lite_meta_box_content() {
    global $post;
    if (!empty($post->ID)) {
        $cache_fname = POST_GALLERY_LITE_FNAME . '_update';
        $cache_value = post_gallery_lite_unserialize_to_string($post->ID);
        echo '<div id="post-gallery-lite"></div>';
        echo '<input type="hidden" id="' . $cache_fname . '" name="' . $cache_fname . '" value="' . $cache_value . '" />';
        echo '<script>jQuery("#post-gallery-lite").postGalleryLite({ postId: "' . $post->ID . '", cacheField: "#' . $cache_fname . '"})</script>';
    }
}

function post_gallery_lite_enqueue_admin_scripts() {
    $css_url = plugins_url( 'admin/css/post-gallery-lite.css', POST_GALLERY_LITE_ROOT );
    $script_url = plugins_url( 'admin/js/post-gallery-lite.js', POST_GALLERY_LITE_ROOT );
    wp_enqueue_script( 'post-gallery', $script_url, array('jquery', 'jquery-ui-sortable'), POST_GALLERY_LITE_VERSION );
    wp_enqueue_style( 'post-gallery', $css_url, array(), POST_GALLERY_LITE_VERSION);
}

// forces to save the updated photo gallery serialization string
function post_gallery_lite_post_save( $post_id ) {
    $next_ids = $_POST[POST_GALLERY_LITE_FNAME . '_update'];
    $ids = post_gallery_lite_explode_ids($next_ids);
    post_gallery_lite_serialize($post_id, $ids);
}
