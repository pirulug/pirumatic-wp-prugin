<?php // Pirumatic - Enqueue Resources

if (!defined('ABSPATH')) exit;

function pirumatic_enqueue() {
	
	global $pirumatic_options_general;
	
	$library = (isset($pirumatic_options_general['library'])) ? $pirumatic_options_general['library'] : 'none';
	
	if (is_admin()) {
		
		$screen_id = pirumatic_get_current_screen_id();
		
		if ($screen_id === 'post' || $screen_id === 'page') {
			
			if ($library === 'prism') {
				
				pirumatic_prism_enqueue();
				
			} elseif ($library === 'highlight') {
				
				pirumatic_highlight_enqueue();
				
			}
			
		}
		
	} else {
		
		if ($library === 'prism') {
			
			pirumatic_prism_enqueue();
			
		} elseif ($library === 'highlight') {
			
			pirumatic_highlight_enqueue();
			
		}
		
		pirumatic_custom_enqueue();
		
	}
	
}

function pirumatic_enqueue_settings() {
	
	$screen_id = pirumatic_get_current_screen_id();
	
	if ($screen_id === 'settings_page_pirumatic') {
		
		wp_enqueue_style('pirumatic-font-icons', PIRUMATIC_URL .'css/styles-font-icons.css', array(), PIRUMATIC_VERSION);
		
		wp_enqueue_style('pirumatic-settings', PIRUMATIC_URL .'css/styles-settings.css', array(), PIRUMATIC_VERSION);
		
		wp_enqueue_style('wp-jquery-ui-dialog');
		
		$js_deps = array('jquery', 'jquery-ui-core', 'jquery-ui-dialog');
		
		wp_enqueue_script('pirumatic-settings', PIRUMATIC_URL .'js/scripts-settings.js', $js_deps, PIRUMATIC_VERSION);
		
		$data = pirumatic_get_vars_admin();
		
		wp_localize_script('pirumatic-settings', 'pirumatic_settings', $data);
		
	}
	
}

function pirumatic_enqueue_buttons() {
	
	$screen_id = pirumatic_get_current_screen_id();
	
	if ($screen_id === 'post' || $screen_id === 'page') {
		
		wp_enqueue_style('pirumatic-buttons', PIRUMATIC_URL .'css/styles-buttons.css', array(), PIRUMATIC_VERSION);
		
	}
	
}

function pirumatic_get_vars_admin() {
	
	$data = array(
		
		'reset_title'   => __('Confirm Reset',            'pirumatic'),
		'reset_message' => __('Restore default options?', 'pirumatic'),
		'reset_true'    => __('Yes, make it so.',         'pirumatic'),
		'reset_false'   => __('No, abort mission.',       'pirumatic'),
		
	);
	
	return $data;
	
}

function pirumatic_prism_enqueue() {
	
	global $pirumatic_options_prism, $pirumatic_options_advanced;
	
	if (isset($pirumatic_options_prism['singular_only']) && $pirumatic_options_prism['singular_only'] && !is_singular() && !is_admin()) return;
	
	$languages = pirumatic_active_languages('prism');
	
	$languages = array_filter($languages);
	
	if (!empty($languages)) {
		
		$theme = (isset($pirumatic_options_prism['prism_theme'])) ? $pirumatic_options_prism['prism_theme'] : 'default';
		
		wp_enqueue_style('pirumatic-prism', PIRUMATIC_URL .'lib/prism/css/theme-'. $theme .'.css', array(), PIRUMATIC_VERSION, 'all');
		
		wp_enqueue_script('pirumatic-prism', PIRUMATIC_URL .'lib/prism/js/prism-core.js', array(), PIRUMATIC_VERSION, true);
		
		if (
			(isset($pirumatic_options_prism['show_language'])  && $pirumatic_options_prism['show_language']) || 
			(isset($pirumatic_options_prism['copy_clipboard']) && $pirumatic_options_prism['copy_clipboard'])
		) {
			
			wp_enqueue_style('pirumatic-plugin-styles', PIRUMATIC_URL .'lib/prism/css/plugin-styles.css', array(), PIRUMATIC_VERSION, 'all');
			
			wp_enqueue_script('pirumatic-prism-toolbar', PIRUMATIC_URL .'lib/prism/js/plugin-toolbar.js', array('pirumatic-prism'), PIRUMATIC_VERSION, true);
			
		}
		
		if (isset($pirumatic_options_prism['line_highlight']) && $pirumatic_options_prism['line_highlight']) {
			
			wp_enqueue_script('pirumatic-prism-line-highlight', PIRUMATIC_URL .'lib/prism/js/plugin-line-highlight.js', array('pirumatic-prism'), PIRUMATIC_VERSION, true);
			
		}
		
		if (isset($pirumatic_options_prism['line_numbers']) && $pirumatic_options_prism['line_numbers']) {
			
			wp_enqueue_script('pirumatic-prism-line-numbers', PIRUMATIC_URL .'lib/prism/js/plugin-line-numbers.js', array('pirumatic-prism'), PIRUMATIC_VERSION, true);
			
		}
		
		if (isset($pirumatic_options_prism['show_language']) && $pirumatic_options_prism['show_language']) {
			
			wp_enqueue_script('pirumatic-prism-show-language', PIRUMATIC_URL .'lib/prism/js/plugin-show-language.js', array('pirumatic-prism'), PIRUMATIC_VERSION, true);
			
		}
		
		if (isset($pirumatic_options_prism['copy_clipboard']) && $pirumatic_options_prism['copy_clipboard']) {
			
			wp_enqueue_script('pirumatic-copy-clipboard', PIRUMATIC_URL .'lib/prism/js/plugin-copy-clipboard.js', array('pirumatic-prism'), PIRUMATIC_VERSION, true);
			
		}
		
		if (isset($pirumatic_options_prism['command_line']) && $pirumatic_options_prism['command_line']) {
			
			wp_enqueue_script('pirumatic-command-line', PIRUMATIC_URL .'lib/prism/js/plugin-command-line.js', array('pirumatic-prism'), PIRUMATIC_VERSION, true);
			
		}
		
		$prefix = array('lang-', 'language-');
		
		foreach ($languages as $language) {
			
			$language = str_replace($prefix, '', $language);
			
			$file = PIRUMATIC_DIR .'lib/prism/js/lang-'. $language .'.js';
			
			if (file_exists($file)) {
				
				wp_enqueue_script('pirumatic-prism-'. $language, PIRUMATIC_URL .'lib/prism/js/lang-'. $language .'.js', array('pirumatic-prism'),  PIRUMATIC_VERSION, true);
				
			}
			
		}
		
		if (is_admin()) {
			
			// todo: once gutenberg is further developed, find a better way to add editor support
			
			function pirumatic_prism_inline_js() {
				
				?>
				
				<script type="text/javascript">
					document.onreadystatechange = function () {
					    if (document.readyState == 'complete') {
					        Prism.highlightAll();
					    }
					}
				</script>
				
				<?php
				
			}
			add_action('admin_print_footer_scripts', 'pirumatic_prism_inline_js');
				
		}
		
	}
	
}

function pirumatic_highlight_enqueue() {
	
	global $pirumatic_options_highlight, $pirumatic_options_advanced;
	
	if (isset($pirumatic_options_highlight['singular_only']) && $pirumatic_options_highlight['singular_only'] && !is_singular() && !is_admin()) return;
	
	$always_load = (isset($pirumatic_options_highlight['noprefix_classes']) && $pirumatic_options_highlight['noprefix_classes']) ? true : false;
	
	$languages = pirumatic_active_languages('highlight');
	
	$languages = array_filter($languages);
	
	if (!empty($languages) || $always_load) {
		
		$theme = (isset($pirumatic_options_highlight['highlight_theme'])) ? $pirumatic_options_highlight['highlight_theme'] : 'default';
		
		wp_enqueue_style('pirumatic-highlight', PIRUMATIC_URL .'lib/highlight/css/'. $theme .'.css', array(), PIRUMATIC_VERSION, 'all');
		
		wp_enqueue_script('pirumatic-highlight', PIRUMATIC_URL .'lib/highlight/js/highlight-core.js', array(), PIRUMATIC_VERSION, true);
		
		$init = (isset($pirumatic_options_highlight['init_javascript'])) ? $pirumatic_options_highlight['init_javascript'] : '';
		
		if ($init) {
			
			wp_add_inline_script('pirumatic-highlight', $init, 'after');
			
		}
		
		if (is_admin()) {
			
			// todo: once gutenberg is further developed, find a better way to add editor support
			
			function pirumatic_highlight_inline_js() {
				
				?>
				
				<script type="text/javascript">
					document.onreadystatechange = function () {
					    if (document.readyState == 'complete') {
					        jQuery('pre > code').each(function() {
								hljs.highlightBlock(this);
							});
					    }
					}
				</script>
				
				<?php
				
			}
			add_action('admin_print_footer_scripts', 'pirumatic_highlight_inline_js');
				
		}
		
	}
	
}

function pirumatic_custom_enqueue() {
	
	global $pirumatic_options_advanced;
	
	$custom_style = isset($pirumatic_options_advanced['custom_style']) ? $pirumatic_options_advanced['custom_style'] : '';
	
	if ($custom_style) {
		
		wp_register_style('pirumatic-custom', false);
		wp_enqueue_style('pirumatic-custom');
		wp_add_inline_style('pirumatic-custom', $custom_style);
		
	}
	
}

function pirumatic_active_languages($library) {
	
	global $posts, $post;
	
	$languages = array();
	
	if (is_admin()) {
		
		$content = $post->post_content;
		
		$languages = pirumatic_active_languages_loop($library, '', $content, array(), null);
		
	} else {
		
		if (is_singular()) {
			
			$excerpt = $post->post_excerpt;
			
			$content = $post->post_content;
			
			$comments = ($post->comment_count) ? get_comments(array('post_id' => $post->ID, 'status' => 'approve')) : array();
			
			$fields = function_exists('get_fields') ? get_fields($post->ID) : null; // ACF
			
			$languages = pirumatic_active_languages_loop($library, $excerpt, $content, $comments, $fields);
			
		} else {
			
			foreach ($posts as $post) {
				
				$excerpt = $post->post_excerpt;
				
				$content = $post->post_content;
				
				$comments = array();
				
				$langs_array[] = pirumatic_active_languages_loop($library, $excerpt, $content, $comments, null);
				
			}
			
			if (!empty($langs_array) && is_array($langs_array)) {
				
				foreach($langs_array as $key => $value) {
					
					foreach ($value as $k => $v) {
						
						$languages[] = $v;
						
					}
					
				}
				
			}
			
		}
		
	}
	
	return $languages;
	
}

function pirumatic_active_languages_loop($library, $excerpt, $content, $comments, $fields) {
	
	$languages = array();
	
	$classes = ($library === 'prism') ? pirumatic_prism_classes() : pirumatic_highlight_classes();
	
	foreach ($classes as $class) {
		
		foreach($class as $cls) {
			
			//
			
			if ($library === 'prism') {
				
				if ($excerpt && preg_match("/(\s|\")(" . $cls . ")(\s|\")/", $excerpt)) {
					
					$languages[] = $cls;
					
				}
				
			} else {
				
				if ($excerpt && strpos($excerpt, $cls) !== false) {
					
					$languages[] = $cls;
					
				}
				
			}
			
			//
			
			if ($library === 'prism') {
				
				if ($content && preg_match("/(\s|\")(" . $cls . ")(\s|\")/", $content)) {
					
					$languages[] = $cls;
					
				}
				
			} else {
				
				if ($content && strpos($content, $cls) !== false) {
					
					$languages[] = $cls;
					
				}
				
			}
			
			//
			
			foreach ($comments as $comment) {
				
				if ($library === 'prism') {
					
					if ($comment->comment_content && preg_match("/(\s|\")(" . $cls . ")(\s|\")/", $comment->comment_content)) {
						
						$languages[] = $cls;
						
					}
					
				} else {
					
					if ($comment->comment_content && strpos($comment->comment_content, $cls) !== false) {
						
						$languages[] = $cls;
						
					}
					
				}
				
			}
			
			//
			
			if ($fields) {
				
				foreach ($fields as $key => $value) {
					
					if ($library === 'prism') {
						
						if ($value && is_string($value) && preg_match("/(\s|\")(" . $cls . ")(\s|\")/", $value)) {
							
							$languages[] = $cls;
							
						}
						
					} else {
						
						if ($value && is_string($value) && strpos($value, $cls) !== false) {
							
							$languages[] = $cls;
							
						}
						
					}
					
				}
				
			}
			
		}
		
	}
	
	$languages = array_unique($languages);
	
	return $languages;
	
}

function pirumatic_prism_classes() {
	
	$classes = array(
		
		array(
			'language-apacheconf', 
			'language-applescript', 
			'language-arduino', 
			'language-asmatmel', 
			'language-awk', 
			'language-bash', 
			'language-batch', 
			'language-c', 
			'language-clike', 
			'language-coffeescript', 
			'language-cpp', 
			'language-csharp', 
			'language-css', 
			'language-d', 
			'language-dart', 
			'language-diff', 
			'language-elixir', 
			'language-gcode', 
			'language-git', 
			'language-go', 
			'language-graphql', 
			'language-groovy', 
			'language-hcl', 
			'language-http', 
			'language-ini', 
			'language-java', 
			'language-javascript', 
			'language-json', 
			'language-jsx', 
			'language-julia', 
			'language-kotlin', 
			'language-latex', 
			'language-liquid', 
			'language-lua', 
			'language-makefile', 
			'language-markdown', 
			'language-markup', 
			'language-matlab', 
			'language-nginx', 
			'language-objectivec', 
			'language-pascal', 
			'language-perl', 
			'language-php', 
			'language-powerquery', 
			'language-powershell', 
			'language-python', 
			'language-r', 
			'language-ruby', 
			'language-rust', 
			'language-sas', 
			'language-sass', 
			'language-scala',
			'language-scss', 
			'language-shell-session', 
			'language-solidity', 
			'language-sparql', 
			'language-splunk-spl', 
			'language-sql', 
			'language-swift', 
			'language-tsx', 
			'language-turtle', 
			'language-twig',
			'language-typescript', 
			'language-verilog', 
			'language-vhdl', 
			'language-vim', 
			'language-visual-basic', 
			'language-yaml', 
			
			// aliases
			
			'language-html', 
			'language-mathml', 
			'language-rss', 
			'language-ssml', 
			'language-svg', 
			'language-xml', 
			
			// none
			
			'language-none'
		),
		
		array(
			'lang-apacheconf', 
			'lang-applescript', 
			'lang-arduino', 
			'lang-asmatmel', 
			'lang-awk', 
			'lang-bash', 
			'lang-batch', 
			'lang-c', 
			'lang-clike', 
			'lang-coffeescript', 
			'lang-cpp', 
			'lang-csharp', 
			'lang-css', 
			'lang-d', 
			'lang-dart', 
			'lang-diff', 
			'lang-elixir', 
			'lang-gcode', 
			'lang-git', 
			'lang-go', 
			'lang-graphql', 
			'lang-groovy', 
			'lang-hcl', 
			'lang-http', 
			'lang-ini', 
			'lang-java', 
			'lang-javascript', 
			'lang-json', 
			'lang-jsx', 
			'lang-julia', 
			'lang-kotlin', 
			'lang-latex', 
			'lang-liquid', 
			'lang-lua', 
			'lang-makefile', 
			'lang-markdown', 
			'lang-markup', 
			'lang-matlab', 
			'lang-nginx', 
			'lang-objectivec', 
			'lang-pascal', 
			'lang-perl', 
			'lang-php', 
			'lang-powerquery', 
			'lang-powershell', 
			'lang-python', 
			'lang-r', 
			'lang-ruby', 
			'lang-rust', 
			'lang-sas', 
			'lang-sass', 
			'lang-scala',
			'lang-scss', 
			'lang-shell-session', 
			'lang-solidity', 
			'lang-sparql', 
			'lang-splunk-spl', 
			'lang-sql', 
			'lang-swift', 
			'lang-tsx', 
			'lang-turtle', 
			'lang-twig',
			'lang-typescript', 
			'lang-verilog', 
			'lang-vhdl', 
			'lang-vim', 
			'lang-visual-basic', 
			'lang-yaml', 
			
			// aliases
			
			'lang-html', 
			'lang-mathml', 
			'lang-rss', 
			'lang-ssml', 
			'lang-svg', 
			'lang-xml', 
			
			// none
			
			'lang-none'
			
		)
		
	);
	
	return $classes;
	
}

function pirumatic_highlight_classes() {
	
	$classes = array(
			
		array(
			'language-'
		),
		
		array(
			'lang-', 
		)
		
	);
	
	return $classes;
	
}

function pirumatic_get_current_screen_id() {
	
	if (!function_exists('get_current_screen')) require_once ABSPATH .'/wp-admin/includes/screen.php';
	
	$screen = get_current_screen();
	
	if ($screen && property_exists($screen, 'id')) return $screen->id;
	
	return false;
	
}