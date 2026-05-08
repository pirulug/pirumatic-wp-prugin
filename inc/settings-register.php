<?php // Pirumatic - Register Settings

if (!defined('ABSPATH'))
	exit;

function pirumatic_register_settings() {


	// register_setting( $option_group, $option_name, $sanitize_callback )
	register_setting('pirumatic_options_general', 'pirumatic_options_general', 'pirumatic_validate_general');

	// add_settings_section( $id, $title, $callback, $page )
	add_settings_section('settings_general', esc_html__('Ajustes generales', 'pirumatic'), 'pirumatic_section_general', 'pirumatic_options_general');

	// add_settings_field( $id, $title, $callback, $page, $section, $args )
	add_settings_field('library', esc_html__('Librería', 'pirumatic'), 'pirumatic_callback_select', 'pirumatic_options_general', 'settings_general', array('id' => 'library', 'section' => 'general', 'label' => esc_html__('', 'pirumatic')));
	add_settings_field('disable_block_styles', esc_html__('Estilos de bloque', 'pirumatic'), 'pirumatic_callback_checkbox', 'pirumatic_options_general', 'settings_general', array('id' => 'disable_block_styles', 'section' => 'general', 'label' => esc_html__('Desactivar la hoja de estilos del bloque Pirumatic en el frontend', 'pirumatic')));
	add_settings_field('null_reset_options', esc_html__('Restablecer opciones', 'pirumatic'), 'pirumatic_callback_reset', 'pirumatic_options_general', 'settings_general', array('id' => 'null_reset_options', 'section' => 'general', 'label' => esc_html__('Restaurar opciones por defecto', 'pirumatic')));

	// Prism
	register_setting('pirumatic_options_prism', 'pirumatic_options_prism', 'pirumatic_validate_prism');

	add_settings_section('settings_prism', esc_html__('Ajustes de Prism.js', 'pirumatic'), 'pirumatic_section_prism', 'pirumatic_options_prism');

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

	add_settings_field('line_highlight', esc_html__('Resaltado de línea', 'pirumatic'), 'pirumatic_callback_checkbox', 'pirumatic_options_prism', 'settings_prism', array('id' => 'line_highlight', 'section' => 'prism', 'label' => esc_html__('Activar', 'pirumatic') . ' <a target="_blank" rel="noopener noreferrer" href="https://prismjs.com/plugins/line-highlight/">' . esc_html__('Line Highlight', 'pirumatic') . '</a>'));
	add_settings_field('line_numbers', esc_html__('Números de línea', 'pirumatic'), 'pirumatic_callback_checkbox', 'pirumatic_options_prism', 'settings_prism', array('id' => 'line_numbers', 'section' => 'prism', 'label' => esc_html__('Activar', 'pirumatic') . ' <a target="_blank" rel="noopener noreferrer" href="https://prismjs.com/plugins/line-numbers/">' . esc_html__('Line Numbers', 'pirumatic') . '</a>'));
	add_settings_field('show_language', esc_html__('Mostrar lenguaje', 'pirumatic'), 'pirumatic_callback_checkbox', 'pirumatic_options_prism', 'settings_prism', array('id' => 'show_language', 'section' => 'prism', 'label' => esc_html__('Activar', 'pirumatic') . ' <a target="_blank" rel="noopener noreferrer" href="https://prismjs.com/plugins/show-language/">' . esc_html__('Show Language', 'pirumatic') . '</a>'));
	add_settings_field('copy_clipboard', esc_html__('Copiar al portapapeles', 'pirumatic'), 'pirumatic_callback_checkbox', 'pirumatic_options_prism', 'settings_prism', array('id' => 'copy_clipboard', 'section' => 'prism', 'label' => esc_html__('Activar', 'pirumatic') . ' <a target="_blank" rel="noopener noreferrer" href="https://prismjs.com/plugins/copy-to-clipboard/">' . esc_html__('Copy to Clipboard', 'pirumatic') . '</a>'));
	add_settings_field('command_line', esc_html__('Línea de comandos', 'pirumatic'), 'pirumatic_callback_checkbox', 'pirumatic_options_prism', 'settings_prism', array('id' => 'command_line', 'section' => 'prism', 'label' => esc_html__('Activar', 'pirumatic') . ' <a target="_blank" rel="noopener noreferrer" href="https://prismjs.com/plugins/command-line/">' . esc_html__('Command Line', 'pirumatic') . '</a>'));
	add_settings_field('singular_only', esc_html__('Limitar a Entradas', 'pirumatic'), 'pirumatic_callback_checkbox', 'pirumatic_options_prism', 'settings_prism', array('id' => 'singular_only', 'section' => 'prism', 'label' => esc_html__('Limitar a Entradas y Páginas', 'pirumatic')));

	add_settings_section('settings_prism_code', esc_html__('Escape de código', 'pirumatic'), 'pirumatic_section_prism_code', 'pirumatic_options_prism');

	add_settings_field('filter_content', 'Post Content', 'pirumatic_callback_select', 'pirumatic_options_prism', 'settings_prism_code', array('id' => 'filter_content', 'section' => 'prism', 'label' => esc_html__('Escape code for post content in the Admin Area', 'pirumatic')));
	add_settings_field('filter_excerpts', 'Post Excerpts', 'pirumatic_callback_select', 'pirumatic_options_prism', 'settings_prism_code', array('id' => 'filter_excerpts', 'section' => 'prism', 'label' => esc_html__('Escape code for post excerpts in the Admin Area', 'pirumatic')));
	add_settings_field('filter_comments', 'Post Comments', 'pirumatic_callback_select', 'pirumatic_options_prism', 'settings_prism_code', array('id' => 'filter_comments', 'section' => 'prism', 'label' => esc_html__('Escape code for post comments in the Admin Area', 'pirumatic')));


	// Highlight
	register_setting('pirumatic_options_highlight', 'pirumatic_options_highlight', 'pirumatic_validate_highlight');

	add_settings_section('settings_highlight', esc_html__('Ajustes de Highlight.js', 'pirumatic'), 'pirumatic_section_highlight', 'pirumatic_options_highlight');

	add_settings_field('highlight_theme', esc_html__('Tema', 'pirumatic'), 'pirumatic_callback_select', 'pirumatic_options_highlight', 'settings_highlight', array('id' => 'highlight_theme', 'section' => 'highlight', 'label' => esc_html__('Tema de Highlight', 'pirumatic')));
	add_settings_field('init_javascript', esc_html__('Script de inicio', 'pirumatic'), 'pirumatic_callback_textarea', 'pirumatic_options_highlight', 'settings_highlight', array('id' => 'init_javascript', 'section' => 'highlight', 'label' => esc_html__('Script de inicio para Highlight.js (requerido)', 'pirumatic')));
	add_settings_field('noprefix_classes', esc_html__('Sin prefijos', 'pirumatic'), 'pirumatic_callback_checkbox', 'pirumatic_options_highlight', 'settings_highlight', array('id' => 'noprefix_classes', 'section' => 'highlight', 'label' => esc_html__('Soporte para nombres de clase sin prefijo', 'pirumatic')));
	add_settings_field('singular_only', esc_html__('Limitar a Entradas', 'pirumatic'), 'pirumatic_callback_checkbox', 'pirumatic_options_highlight', 'settings_highlight', array('id' => 'singular_only', 'section' => 'highlight', 'label' => esc_html__('Limitar a Entradas y Páginas', 'pirumatic')));

	add_settings_section('settings_highlight_code', esc_html__('Escape de código', 'pirumatic'), 'pirumatic_section_highlight_code', 'pirumatic_options_highlight');

	add_settings_field('filter_content', 'Content', 'pirumatic_callback_select', 'pirumatic_options_highlight', 'settings_highlight_code', array('id' => 'filter_content', 'section' => 'highlight', 'label' => esc_html__('Escape code for post content in the Admin Area', 'pirumatic')));
	add_settings_field('filter_excerpts', 'Excerpts', 'pirumatic_callback_select', 'pirumatic_options_highlight', 'settings_highlight_code', array('id' => 'filter_excerpts', 'section' => 'highlight', 'label' => esc_html__('Escape code for post excerpts in the Admin Area', 'pirumatic')));
	add_settings_field('filter_comments', 'Comments', 'pirumatic_callback_select', 'pirumatic_options_highlight', 'settings_highlight_code', array('id' => 'filter_comments', 'section' => 'highlight', 'label' => esc_html__('Escape code for post comments in the Admin Area', 'pirumatic')));


	// Plain
	register_setting('pirumatic_options_plain', 'pirumatic_options_plain', 'pirumatic_validate_plain');

	add_settings_section('settings_plain', esc_html__('Escape de código', 'pirumatic'), 'pirumatic_section_plain', 'pirumatic_options_plain');

	add_settings_field('filter_content', 'Content', 'pirumatic_callback_select', 'pirumatic_options_plain', 'settings_plain', array('id' => 'filter_content', 'section' => 'plain', 'label' => esc_html__('Escape code for post content in the Admin Area', 'pirumatic')));
	add_settings_field('filter_excerpts', 'Excerpts', 'pirumatic_callback_select', 'pirumatic_options_plain', 'settings_plain', array('id' => 'filter_excerpts', 'section' => 'plain', 'label' => esc_html__('Escape code for post excerpts in the Admin Area', 'pirumatic')));
	add_settings_field('filter_comments', 'Comments', 'pirumatic_callback_select', 'pirumatic_options_plain', 'settings_plain', array('id' => 'filter_comments', 'section' => 'plain', 'label' => esc_html__('Escape code for post comments in the Admin Area', 'pirumatic')));


	// Advanced
	register_setting('pirumatic_options_advanced', 'pirumatic_options_advanced', 'pirumatic_validate_advanced');

	add_settings_section('settings_advanced', esc_html__('Ajustes Avanzados', 'pirumatic'), 'pirumatic_section_advanced', 'pirumatic_options_advanced');

	add_settings_field('custom_style', esc_html__('CSS Personalizado', 'pirumatic'), 'pirumatic_callback_textarea', 'pirumatic_options_advanced', 'settings_advanced', array('id' => 'custom_style', 'section' => 'advanced', 'label' => esc_html__('CSS opcional para incluir en todas las páginas (no incluir etiquetas &lt;style&gt;)', 'pirumatic')));

}
