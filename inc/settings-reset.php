<?php // Pirumatic - Reset Settings

if (!defined('ABSPATH')) exit;

function pirumatic_admin_notice() {
	
	$screen_id = pirumatic_get_current_screen_id();
	
	if ($screen_id === 'settings_page_pirumatic') {
		
		if (isset($_GET['reset-options'])) {
			
			if ($_GET['reset-options'] === 'true') : ?>
				
				<div class="notice notice-success is-dismissible"><p><strong><?php esc_html_e('Opciones por defecto restauradas.', 'pirumatic'); ?></strong></p></div>
				
			<?php else : ?>
				
				<div class="notice notice-info is-dismissible"><p><strong><?php esc_html_e('No se han realizado cambios en las opciones.', 'pirumatic'); ?></strong></p></div>
				
			<?php endif;
			
		}
		
	}
	
}

//

function pirumatic_dismiss_notice_activate() {
	
	delete_option('pirumatic-dismiss-notice');
	
}

function pirumatic_dismiss_notice_version() {
	
	$version_current = PIRUMATIC_VERSION;
	
	$version_previous = get_option('pirumatic-dismiss-notice');
	
	$version_previous = ($version_previous) ? $version_previous : $version_current;
	
	if (version_compare($version_current, $version_previous, '>')) {
		
		delete_option('pirumatic-dismiss-notice');
		
	}
	
}

function pirumatic_dismiss_notice_check() {
	
	$check = get_option('pirumatic-dismiss-notice');
	
	return ($check) ? true : false;
	
}

function pirumatic_dismiss_notice_save() {
	
	if (isset($_GET['dismiss-notice-verify']) && wp_verify_nonce($_GET['dismiss-notice-verify'], 'pirumatic_dismiss_notice')) {
		
		if (!current_user_can('manage_options')) exit;
		
		$result = update_option('pirumatic-dismiss-notice', PIRUMATIC_VERSION, false);
		
		$result = $result ? 'true' : 'false';
		
		$tabs = array('tab1', 'tab2', 'tab3', 'tab4', 'tab5');
		
		$tab = (isset($_GET['tab']) && in_array($_GET['tab'], $tabs)) ? $_GET['tab'] : 'tab1';
		
		$location = admin_url('options-general.php?page=pirumatic&tab='. $tab .'&dismiss-notice='. $result);
		
		wp_redirect($location);
		
		exit;
		
	}
	
}

function pirumatic_dismiss_notice_link($tab) {
	
	$nonce = wp_create_nonce('pirumatic_dismiss_notice');
	
	$href  = add_query_arg(array('dismiss-notice-verify' => $nonce), admin_url('options-general.php?page=pirumatic&tab='. $tab));
	
	$label = esc_html__('Dismiss', 'pirumatic');
	
	return '<a class="pirumatic-dismiss-notice" href="'. esc_url($href) .'">'. esc_html($label) .'</a>';
	
}

function pirumatic_check_date_expired() {
	
	$expires = apply_filters('pirumatic_check_date_expired', '2025-06-25');
	
	return (new DateTime() > new DateTime($expires)) ? true : false;
	
}

//

function pirumatic_reset_options() {
	
	if (isset($_GET['reset-options-verify']) && wp_verify_nonce($_GET['reset-options-verify'], 'pirumatic_reset_options')) {
		
		if (!current_user_can('manage_options')) exit;
		
		$update_general   = update_option('pirumatic_options_general',   Pirumatic::options_general());
		$update_prism     = update_option('pirumatic_options_prism',     Pirumatic::options_prism());
		$update_highlight = update_option('pirumatic_options_highlight', Pirumatic::options_highlight());
		$update_plain     = update_option('pirumatic_options_plain',     Pirumatic::options_plain());
		
		$result = 'false';
		
		if (
			$update_general   || 
			$update_prism     || 
			$update_highlight || 
			$update_plain 
			
		) $result = 'true';
		
		$location = admin_url('options-general.php?page=pirumatic&reset-options='. $result);
		
		wp_redirect($location);
		
		exit;
		
	}
	
}
