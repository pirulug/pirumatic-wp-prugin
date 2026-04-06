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
		<h1><span class="fa fa-pad fa-code"></span> <?php echo PIRUMATIC_NAME; ?> <span class="pirumatic-version"><?php echo PIRUMATIC_VERSION; ?></span></h1>
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

