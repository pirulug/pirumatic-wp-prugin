<?php // Pirumatic - Register Settings

if (!defined('ABSPATH'))
	exit;

function pirumatic_register_settings() {


	// register_setting( $option_group, $option_name, $sanitize_callback )
	register_setting('pirumatic_options_general', 'pirumatic_options_general', 'pirumatic_validate_general');

	// add_settings_section( $id, $title, $callback, $page )
	add_settings_section('settings_general', 'General settings', 'pirumatic_section_general', 'pirumatic_options_general');

	// add_settings_field( $id, $title, $callback, $page, $section, $args )
	add_settings_field('library', 'Library', 'pirumatic_callback_select', 'pirumatic_options_general', 'settings_general', array('id' => 'library', 'section' => 'general', 'label' => esc_html__('', 'pirumatic')));
	add_settings_field('disable_block_styles', 'Block Styles', 'pirumatic_callback_checkbox', 'pirumatic_options_general', 'settings_general', array('id' => 'disable_block_styles', 'section' => 'general', 'label' => esc_html__('Disable the Pirumatic block stylesheet on the frontend', 'pirumatic')));
	add_settings_field('null_reset_options', 'Reset Options', 'pirumatic_callback_reset', 'pirumatic_options_general', 'settings_general', array('id' => 'null_reset_options', 'section' => 'general', 'label' => esc_html__('Restore default options', 'pirumatic')));
	add_settings_field('null_rate_plugin', 'Rate Plugin', 'pirumatic_callback_rate', 'pirumatic_options_general', 'settings_general', array('id' => 'null_rate_plugin', 'section' => 'general', 'label' => esc_html__('Show support with a 5-star rating &raquo;', 'pirumatic')));
	add_settings_field('null_show_support', 'Show Support', 'pirumatic_callback_support', 'pirumatic_options_general', 'settings_general', array('id' => 'null_show_support', 'section' => 'general', 'label' => esc_html__('Show support with a small donation&nbsp;&raquo;', 'pirumatic')));

	// Prism
	register_setting('pirumatic_options_prism', 'pirumatic_options_prism', 'pirumatic_validate_prism');

	add_settings_section('settings_prism', 'Prism.js settings', 'pirumatic_section_prism', 'pirumatic_options_prism');

	add_settings_field(
		'prism_theme',
		'Theme',
		'pirumatic_callback_select',
		'pirumatic_options_prism',
		'settings_prism',
		array(
			'id'      => 'prism_theme',
			'section' => 'prism',
			'label'   => esc_html__('Prism theme', 'pirumatic'))

	);

	add_settings_field('line_highlight', 'Line Highlight', 'pirumatic_callback_checkbox', 'pirumatic_options_prism', 'settings_prism', array('id' => 'line_highlight', 'section' => 'prism', 'label' => esc_html__('Enable', 'pirumatic') . ' <a target="_blank" rel="noopener noreferrer" href="https://prismjs.com/plugins/line-highlight/">' . esc_html__('Line Highlight', 'pirumatic') . '</a>'));
	add_settings_field('line_numbers', 'Line Numbers', 'pirumatic_callback_checkbox', 'pirumatic_options_prism', 'settings_prism', array('id' => 'line_numbers', 'section' => 'prism', 'label' => esc_html__('Enable', 'pirumatic') . ' <a target="_blank" rel="noopener noreferrer" href="https://prismjs.com/plugins/line-numbers/">' . esc_html__('Line Numbers', 'pirumatic') . '</a>'));
	add_settings_field('show_language', 'Show Language', 'pirumatic_callback_checkbox', 'pirumatic_options_prism', 'settings_prism', array('id' => 'show_language', 'section' => 'prism', 'label' => esc_html__('Enable', 'pirumatic') . ' <a target="_blank" rel="noopener noreferrer" href="https://prismjs.com/plugins/show-language/">' . esc_html__('Show Language', 'pirumatic') . '</a>'));
	add_settings_field('copy_clipboard', 'Copy to Clipboard', 'pirumatic_callback_checkbox', 'pirumatic_options_prism', 'settings_prism', array('id' => 'copy_clipboard', 'section' => 'prism', 'label' => esc_html__('Enable', 'pirumatic') . ' <a target="_blank" rel="noopener noreferrer" href="https://prismjs.com/plugins/copy-to-clipboard/">' . esc_html__('Copy to Clipboard', 'pirumatic') . '</a>'));
	add_settings_field('command_line', 'Command Line', 'pirumatic_callback_checkbox', 'pirumatic_options_prism', 'settings_prism', array('id' => 'command_line', 'section' => 'prism', 'label' => esc_html__('Enable', 'pirumatic') . ' <a target="_blank" rel="noopener noreferrer" href="https://prismjs.com/plugins/command-line/">' . esc_html__('Command Line', 'pirumatic') . '</a>'));
	add_settings_field('singular_only', 'Limit to Posts', 'pirumatic_callback_checkbox', 'pirumatic_options_prism', 'settings_prism', array('id' => 'singular_only', 'section' => 'prism', 'label' => esc_html__('Limit to Posts and Pages', 'pirumatic')));

	add_settings_section('settings_prism_code', 'Code Escaping', 'pirumatic_section_prism_code', 'pirumatic_options_prism');

	add_settings_field('filter_content', 'Post Content', 'pirumatic_callback_select', 'pirumatic_options_prism', 'settings_prism_code', array('id' => 'filter_content', 'section' => 'prism', 'label' => esc_html__('Escape code for post content in the Admin Area', 'pirumatic')));
	add_settings_field('filter_excerpts', 'Post Excerpts', 'pirumatic_callback_select', 'pirumatic_options_prism', 'settings_prism_code', array('id' => 'filter_excerpts', 'section' => 'prism', 'label' => esc_html__('Escape code for post excerpts in the Admin Area', 'pirumatic')));
	add_settings_field('filter_comments', 'Post Comments', 'pirumatic_callback_select', 'pirumatic_options_prism', 'settings_prism_code', array('id' => 'filter_comments', 'section' => 'prism', 'label' => esc_html__('Escape code for post comments in the Admin Area', 'pirumatic')));


	// Highlight
	register_setting('pirumatic_options_highlight', 'pirumatic_options_highlight', 'pirumatic_validate_highlight');

	add_settings_section('settings_highlight', 'Highlight.js settings', 'pirumatic_section_highlight', 'pirumatic_options_highlight');

	add_settings_field('highlight_theme', 'Theme', 'pirumatic_callback_select', 'pirumatic_options_highlight', 'settings_highlight', array('id' => 'highlight_theme', 'section' => 'highlight', 'label' => esc_html__('Highlight theme', 'pirumatic')));
	add_settings_field('init_javascript', 'Init Script', 'pirumatic_callback_textarea', 'pirumatic_options_highlight', 'settings_highlight', array('id' => 'init_javascript', 'section' => 'highlight', 'label' => esc_html__('Init script for Highlight.js (required)', 'pirumatic')));
	add_settings_field('noprefix_classes', 'No Prefixes', 'pirumatic_callback_checkbox', 'pirumatic_options_highlight', 'settings_highlight', array('id' => 'noprefix_classes', 'section' => 'highlight', 'label' => esc_html__('Support no-prefix class names', 'pirumatic')));
	add_settings_field('singular_only', 'Limit to Posts', 'pirumatic_callback_checkbox', 'pirumatic_options_highlight', 'settings_highlight', array('id' => 'singular_only', 'section' => 'highlight', 'label' => esc_html__('Limit to Posts and Pages', 'pirumatic')));

	add_settings_section('settings_highlight_code', 'Code Escaping', 'pirumatic_section_highlight_code', 'pirumatic_options_highlight');

	add_settings_field('filter_content', 'Content', 'pirumatic_callback_select', 'pirumatic_options_highlight', 'settings_highlight_code', array('id' => 'filter_content', 'section' => 'highlight', 'label' => esc_html__('Escape code for post content in the Admin Area', 'pirumatic')));
	add_settings_field('filter_excerpts', 'Excerpts', 'pirumatic_callback_select', 'pirumatic_options_highlight', 'settings_highlight_code', array('id' => 'filter_excerpts', 'section' => 'highlight', 'label' => esc_html__('Escape code for post excerpts in the Admin Area', 'pirumatic')));
	add_settings_field('filter_comments', 'Comments', 'pirumatic_callback_select', 'pirumatic_options_highlight', 'settings_highlight_code', array('id' => 'filter_comments', 'section' => 'highlight', 'label' => esc_html__('Escape code for post comments in the Admin Area', 'pirumatic')));


	// Plain
	register_setting('pirumatic_options_plain', 'pirumatic_options_plain', 'pirumatic_validate_plain');

	add_settings_section('settings_plain', 'Code Escaping', 'pirumatic_section_plain', 'pirumatic_options_plain');

	add_settings_field('filter_content', 'Content', 'pirumatic_callback_select', 'pirumatic_options_plain', 'settings_plain', array('id' => 'filter_content', 'section' => 'plain', 'label' => esc_html__('Escape code for post content in the Admin Area', 'pirumatic')));
	add_settings_field('filter_excerpts', 'Excerpts', 'pirumatic_callback_select', 'pirumatic_options_plain', 'settings_plain', array('id' => 'filter_excerpts', 'section' => 'plain', 'label' => esc_html__('Escape code for post excerpts in the Admin Area', 'pirumatic')));
	add_settings_field('filter_comments', 'Comments', 'pirumatic_callback_select', 'pirumatic_options_plain', 'settings_plain', array('id' => 'filter_comments', 'section' => 'plain', 'label' => esc_html__('Escape code for post comments in the Admin Area', 'pirumatic')));


	// Advanced
	register_setting('pirumatic_options_advanced', 'pirumatic_options_advanced', 'pirumatic_validate_advanced');

	add_settings_section('settings_advanced', 'Advanced Settings', 'pirumatic_section_advanced', 'pirumatic_options_advanced');

	add_settings_field('custom_style', 'Custom CSS', 'pirumatic_callback_textarea', 'pirumatic_options_advanced', 'settings_advanced', array('id' => 'custom_style', 'section' => 'advanced', 'label' => esc_html__('Optional CSS to include on all pages (do *not* include &lt;style&gt; tags)', 'pirumatic')));

}
