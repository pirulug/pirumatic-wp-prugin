<?php // Pirumatic - TimyMCE Quicktag Buttons

function pirumatic_buttons() {
	
	if (current_user_can('edit_posts')) {
		
		add_filter('mce_buttons',          'pirumatic_register_buttons');
		add_filter('mce_external_plugins', 'pirumatic_add_buttons');
		
	}
	
}

function pirumatic_register_buttons($buttons) {
	
	array_push($buttons, 'button_prism', 'button_highlight');
	
	return $buttons;
	
}

function pirumatic_add_buttons($plugin_array) {
	
	global $pirumatic_options_general;
	
	if (isset($pirumatic_options_general['library'])) {
		
		if ($pirumatic_options_general['library'] === 'prism') {
		
			$plugin_array['pirumatic_buttons'] = plugins_url('/js/buttons-prism.js', dirname(__FILE__));
			
		} elseif ($pirumatic_options_general['library'] === 'highlight') {
			
			$plugin_array['pirumatic_buttons'] = plugins_url('/js/buttons-highlight.js', dirname(__FILE__));
			
		} elseif ($pirumatic_options_general['library'] === 'plain') {
			
			$plugin_array['pirumatic_buttons'] = plugins_url('/js/buttons-plain.js', dirname(__FILE__));
			
		}
		
	}
	
	return $plugin_array;
	
}

function pirumatic_add_quicktags() {
	
	$screen_id = pirumatic_get_current_screen_id();
	
	if (($screen_id === 'post' || $screen_id === 'page') && wp_script_is('quicktags')) :
	
	// QTags.addButton( id, display, arg1, arg2, access_key, title, priority, instance );
	
	?>
	
	<script type="text/javascript">
		window.onload = function() {
			QTags.addButton('pirumatic_pre', 'pre', '<pre><code class="language-">', '</code></pre>', 'z', 'Preformatted Code');
		};
	</script>
	
<?php endif;

}
