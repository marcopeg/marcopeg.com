<?php
if ( function_exists("register_field_group") ) {
	register_field_group(array (
		'id' => 'acf_youtube-video',
		'title' => 'YouTube Video',
		'fields' => array (
			array (
				'key' => 'field_584e7de166f89',
				'label' => 'YouTube ID:',
				'name' => 'youtube_id',
				'type' => 'text',
				'required' => 1,
				'default_value' => '',
				'placeholder' => '',
				'prepend' => '',
				'append' => '',
				'formatting' => 'none',
				'maxlength' => '',
			),
		),
		'location' => array (
			array (
				array (
					'param' => 'post_format',
					'operator' => '==',
					'value' => 'video',
					'order_no' => 0,
					'group_no' => 0,
				),
			),
		),
		'options' => array (
			'position' => 'acf_after_title',
			'layout' => 'default',
			'hide_on_screen' => array (
			),
		),
		'menu_order' => 0,
	));
}
