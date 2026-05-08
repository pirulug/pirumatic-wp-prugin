<?php // Pirumatic - Display Settings

if (!defined('ABSPATH')) exit;

function pirumatic_menu_pages() {
	
	// add_options_page( $page_title, $menu_title, $capability, $menu_slug, $function )
	add_options_page('Pirumatic', 'Pirumatic', 'manage_options', 'pirumatic', 'pirumatic_display_settings');
	
}

function pirumatic_get_tabs() {
	
	$tabs = array(
		'tab1' => esc_html__('General',      'pirumatic'), 
		'tab2' => esc_html__('Prism.js',     'pirumatic'), 
		'tab3' => esc_html__('Highlight.js', 'pirumatic'), 
		'tab4' => esc_html__('Plain Flavor', 'pirumatic'), 
		'tab5' => esc_html__('Advanced',     'pirumatic'), 
	);
	
	return $tabs;
	
}

function pirumatic_display_settings() { 
	
	$tab_active = isset($_GET['tab']) ? $_GET['tab'] : 'tab1';
	
	$tab_href = admin_url('options-general.php?page=pirumatic');
	
	$tab_names = pirumatic_get_tabs();
	
	?>
	
	<div class="wrap wrap-<?php echo esc_attr($tab_active); ?>">
		<h1><span class="pirumatic-icon"><?php echo '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="32" height="32" style="vertical-align: middle; margin-right: 10px;"><path fill="currentColor" d="m23.134 8.64-5.973-3.62a.286.286 0 0 0-.412.125l-1.4 3.286 2.842 1.696a.53.53 0 0 1 0 .921l-5.335 3.14-2.267 5.274a.127.127 0 0 0 .052.203.12.12 0 0 0 .134-.035l3.914-2.365 1.545 2.219a.37.37 0 0 0 .309.167h3.708a.37.37 0 0 0 .327-.2.38.38 0 0 0-.018-.386l-2.513-3.852 5.088-3.077q.865-.524.865-1.172V9.813q0-.649-.866-1.172zM13.082 4.35.845 12.052q-.865.523-.845 1.171v1.173q.021.648.866 1.15l6.056 3.496a.286.286 0 0 0 .412-.146l1.36-3.286-2.884-1.633a.52.52 0 0 1-.275-.384.53.53 0 0 1 .254-.537l5.295-3.245 2.183-5.316a.13.13 0 0 0-.04-.142.12.12 0 0 0-.146-.005z"/></svg>'; ?></span><?php echo PIRUMATIC_NAME; ?> <span class="pirumatic-version"><?php echo PIRUMATIC_VERSION; ?></span></h1>
		<h2 class="nav-tab-wrapper">
			
			<?php 
				
				foreach ($tab_names as $key => $value) {
					
					$active = ($tab_active === $key) ? ' nav-tab-active' : '';
					
					echo '<a href="'. $tab_href .'&tab='. $key .'" class="nav-tab nav-'. $key . $active .'">'. $value .'</a>';
					
				}
				
			?>
			
		</h2>
		<form method="post" action="options.php">
			
			<?php
				
				if ($tab_active === 'tab1') {
					
					settings_fields('pirumatic_options_general');
					do_settings_sections('pirumatic_options_general');
				
				} elseif ($tab_active === 'tab2') {
					
					settings_fields('pirumatic_options_prism');
					do_settings_sections('pirumatic_options_prism');
					
				} elseif ($tab_active === 'tab3') {
					
					settings_fields('pirumatic_options_highlight');
					do_settings_sections('pirumatic_options_highlight');
					
				} elseif ($tab_active === 'tab4') {
					
					settings_fields('pirumatic_options_plain');
					do_settings_sections('pirumatic_options_plain');
					
				} elseif ($tab_active === 'tab5') {
					
					settings_fields('pirumatic_options_advanced');
					do_settings_sections('pirumatic_options_advanced');
					
				}
				
				submit_button();
				
			?>
			
		</form>
	</div>
	
<?php }

