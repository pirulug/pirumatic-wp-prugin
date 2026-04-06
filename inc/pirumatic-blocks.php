<?php // Pirumatic - Gutenberg Blocks

function pirumatic_register_block_assets() {
	
	global $pirumatic_options_general;
	
	if (!function_exists('register_block_type')) return;
    
	$script_url = null;
	
	if (isset($pirumatic_options_general['library'])) {
		
		if ($pirumatic_options_general['library'] === 'prism') {
			
			$script_url = plugins_url('/js/blocks-prism.js',  dirname(__FILE__));
			
		} elseif ($pirumatic_options_general['library'] === 'highlight') {
			
			$script_url = plugins_url('/js/blocks-highlight.js',  dirname(__FILE__));
			
		} elseif ($pirumatic_options_general['library'] === 'plain') {
			
			$script_url = plugins_url('/js/blocks-plain.js',  dirname(__FILE__));
			
		}
		
	}
	
	if ($script_url) {
		
		$style_url  = plugins_url('/css/styles-blocks.css', dirname(__FILE__));
		
		$script_dep = ['wp-i18n', 'wp-element', 'wp-blocks', 'wp-components', 'wp-editor', 'wp-hooks'];
		$style_dep  = [];
		
		wp_register_script('pirumatic-blocks', $script_url, $script_dep);
		wp_register_style ('pirumatic-blocks', $style_url,  $style_dep);
		
		register_block_type('pirumatic/blocks', array('editor_script' => 'pirumatic-blocks', 'style' => 'pirumatic-blocks'));
		
	}
	
}