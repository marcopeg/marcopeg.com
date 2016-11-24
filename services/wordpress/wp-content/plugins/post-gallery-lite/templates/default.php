<?php
global $post_gallery_lite;
global $post_gallery_lite_original_attributes;

// Define template's attributes
$atts = shortcode_atts(array(
    'lightbox-group' => 'post-gallery-lite',
), $post_gallery_lite_original_attributes);

// Include template's css
$css_url = plugins_url( 'templates/default.css', POST_GALLERY_LITE_ROOT );
wp_enqueue_style( 'post-gallery-lite-template-default', $css_url, array(), POST_GALLERY_LITE_VERSION);
?>

<ul class="post-gallery-lite post-gallery-lite--default">
<?php foreach ( $post_gallery_lite as $image ): ?>
    <li class="post-gallery-lite__item post-gallery-lite__item--default">
        <a href="<?php echo $image['src'] ?>" data-lightbox="<?php echo $atts['lightbox-group'] ?>">
            <img src="<?php echo $image['thumb'] ?>" />
        </a>
    </li>
<?php endforeach; ?>
</ul>
