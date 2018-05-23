<?php
/**
 * @link    https://github.com/tronsha/wp-lightbox-plugin
 * @since   1.1.8
 * @package wp-lightbox-plugin
 */

defined( 'ABSPATH' ) or die( 'No script kiddies please!' );

?>
<div class="wrap">
	<h1>
		Lightbox
	</h1>
	<form method="post" action="options.php">
		<?php settings_fields( 'mpcx_lightbox' ); ?>
		<?php $lightbox_options = get_option( 'mpcx_lightbox' ); ?>
		<input type="hidden" name="mpcx_lightbox[version]" value="<?php echo $lightbox_options['version']; ?>">
		<table class="form-table">
			<tr>
				<th scope="row">
					<label for="mpcx_lightbox_lightbox">Lightbox:</label>
				</th>
				<td>
					<select id="mpcx_lightbox_lightbox" name="mpcx_lightbox[lightbox]">
						<option value="lightbox" <?php selected( $lightbox_options['lightbox'], 'lightbox' ); ?>>Lightbox2</option>
						<option value="fancybox" <?php selected( $lightbox_options['lightbox'], 'fancybox' ); ?>>fancyBox3</option>
					</select>
				</td>
			</tr>
			<tr>
				<th scope="row">
					<label for="mpcx_lightbox_title"><?php _e( 'Title', 'mpcx-lightbox' ); ?>:</label>
				</th>
				<td>
					<select id="mpcx_lightbox_title" name="mpcx_lightbox[title]">
						<option value="0" <?php selected( $lightbox_options['title'], 0 ); ?>><?php _e( 'Disabled', 'mpcx-lightbox' ); ?></option>
						<option value="1" <?php selected( $lightbox_options['title'], 1 ); ?>><?php _e( 'Title', 'mpcx-lightbox' ); ?></option>
						<option value="2" <?php selected( $lightbox_options['title'], 2 ); ?>><?php _e( 'Description', 'mpcx-lightbox' ); ?></option>
						<option value="3" <?php selected( $lightbox_options['title'], 3 ); ?>><?php _e( 'Caption', 'mpcx-lightbox' ); ?></option>
					</select>
				</td>
			</tr>
		</table>
		<h2 class="title"><?php _e( 'Gallery', 'mpcx-lightbox' ); ?></h2>
		<table class="form-table">
			<tr>
				<th scope="row">
					<label for="mpcx_lightbox_gallery"><?php _e( 'Disable', 'mpcx-lightbox' ); ?>:</label>
				</th>
				<td>
					<input type="checkbox" id="mpcx_lightbox_gallery" name="mpcx_lightbox[gallery]" value="1"<?php checked( $lightbox_options['gallery'], 1 ); ?> />
					<p class="description" id="mpcx_lightbox_gallery-description"><?php printf( __( 'Disabled lightbox support for gallery.', 'mpcx-lightbox' ) ); ?></p>
				</td>
			</tr>
		</table>
		<h2 class="title"><?php _e( 'Standalone Images', 'mpcx-lightbox' ); ?></h2>
		<table class="form-table">
			<tr>
				<th scope="row">
					<label for="mpcx_lightbox_standalone"><?php _e( 'Disable', 'mpcx-lightbox' ); ?>:</label>
				</th>
				<td>
					<input type="checkbox" id="mpcx_lightbox_standalone" name="mpcx_lightbox[standalone]" value="1"<?php checked( $lightbox_options['standalone'], 1 ); ?> />
					<p class="description" id="mpcx_lightbox_standalone-description"><?php printf( __( 'Disabled lightbox support for standalone images.', 'mpcx-lightbox' ) ); ?></p>
				</td>
			</tr>
			<tr>
				<th scope="row">
					<label for="mpcx_lightbox_ajax"><?php _e( 'Title', 'mpcx-lightbox' ); ?>:</label>
				</th>
				<td>
					<input type="checkbox" id="mpcx_lightbox_ajax" name="mpcx_lightbox[ajax]" value="1"<?php checked( $lightbox_options['ajax'], 1 ); ?> />
					<p class="description" id="mpcx_lightbox_ajax-description"><?php printf( __( 'Activates ajax for title support of standalone images.', 'mpcx-lightbox' ) ); ?></p>
				</td>
			</tr>
		</table>
		<h2 class="title">Justified Gallery</h2>
		<table class="form-table">
			<tr>
				<th scope="row">
					<label for="mpcx_lightbox_justified"><?php _e( 'Enable', 'mpcx-lightbox' ); ?>:</label>
				</th>
				<td>
					<input type="checkbox" id="mpcx_lightbox_justified" name="mpcx_lightbox[justified]" value="1"<?php checked( $lightbox_options['justified'], 1 ); ?> />
				</td>
			</tr>
			<tr>
				<th scope="row">
					<label for="mpcx_lightbox_justified_height"><?php _e( 'Row Height', 'mpcx-lightbox' ); ?>:</label>
				</th>
				<td>
					<input type="number" min="0" id="mpcx_lightbox_justified_height" name="mpcx_lightbox[justified_height]" value="<?php echo $lightbox_options['justified_height']; ?>" />
					<p class="description" id="mpcx_lightbox_justified_height-description"><?php printf( __( 'The preferred height of rows in pixel.', 'mpcx-lightbox' ) ); ?></p>
				</td>
			</tr>
			<tr>
				<th scope="row">
					<label for="mpcx_lightbox_justified_margins"><?php _e( 'Margins', 'mpcx-lightbox' ); ?>:</label>
				</th>
				<td>
					<input type="number" min="0" id="mpcx_lightbox_justified_margins" name="mpcx_lightbox[justified_margins]" value="<?php echo $lightbox_options['justified_margins']; ?>" />
					<p class="description" id="mpcx_lightbox_randomize_margins-description"><?php printf( __( 'Decide the margins between the images.', 'mpcx-lightbox' ) ); ?></p>
				</td>
			</tr>
			<tr>
				<th scope="row">
					<label for="mpcx_lightbox_justified_captions"><?php _e( 'Captions', 'mpcx-lightbox' ); ?>:</label>
				</th>
				<td>
					<input type="checkbox" id="mpcx_lightbox_justified_captions" name="mpcx_lightbox[justified_captions]" value="1"<?php checked( $lightbox_options['justified_captions'], 1 ); ?> />
					<p class="description" id="mpcx_lightbox_randomize_captions-description"><?php printf( __( 'Decide if you want to show the caption or not, that appears when your mouse is over the image.', 'mpcx-lightbox' ) ); ?></p>
				</td>
			</tr>
			<tr>
				<th scope="row">
					<label for="mpcx_lightbox_justified_randomize"><?php _e( 'Randomize', 'mpcx-lightbox' ); ?>:</label>
				</th>
				<td>
					<input type="checkbox" id="mpcx_lightbox_justified_randomize" name="mpcx_lightbox[justified_randomize]" value="1"<?php checked( $lightbox_options['justified_randomize'], 1 ); ?> />
					<p class="description" id="mpcx_lightbox_randomize_height-description"><?php printf( __( 'Automatically randomize or not the order of photos.', 'mpcx-lightbox' ) ); ?></p>
				</td>
			</tr>
		</table>
		<?php submit_button(); ?>
	</form>
</div>
<style>

    table.disabled tr {
        display: none;
    }

    table.disabled tr:first-child {
        display: block;
    }

</style>
<script type="text/javascript">

    var $standalone = jQuery('#mpcx_lightbox_standalone');
    var $standaloneTable = $standalone.parents('table');

    function toggleStandalone() {
        if (true === $standalone.is(':checked')) {
            $standaloneTable.addClass('disabled');
        } else {
            $standaloneTable.removeClass('disabled');
        }
    }

    $standalone.on('click', function() {
        toggleStandalone();
    });

    var $justified = jQuery('#mpcx_lightbox_justified');
    var $justifiedTable = $justified.parents('table');

    function toggleJustified() {
        if (true === $justified.is(':checked')) {
            $justifiedTable.removeClass('disabled');
        } else {
            $justifiedTable.addClass('disabled');
        }
    }

    $justified.on('click', function() {
        toggleJustified();
    });

    jQuery(document).ready(function() {
        toggleStandalone();
        toggleJustified();
    });

</script>
