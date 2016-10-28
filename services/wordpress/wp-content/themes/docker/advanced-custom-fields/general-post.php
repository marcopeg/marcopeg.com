<?php
if (function_exists("register_field_group")) {
	register_field_group(array (
		'id' => 'acf_articles-fields',
		'title' => 'General Post',
		'fields' => array (
			array (
				'key' => 'field_58134e3e26090',
				'label' => 'Image',
				'name' => 'image',
				'type' => 'image',
				'save_format' => 'url',
				'preview_size' => 'thumbnail',
				'library' => 'all',
			),
			array (
				'key' => 'field_58134e6426091',
				'label' => 'Subtitle',
				'name' => 'subtitle',
				'type' => 'text',
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
					'param' => 'post_type',
					'operator' => '==',
					'value' => 'post',
					'order_no' => 0,
					'group_no' => 0,
				),
			),
		),
		'options' => array (
			'position' => 'side',
			'layout' => 'default',
			'hide_on_screen' => array (
			),
		),
		'menu_order' => 0,
	));
}
