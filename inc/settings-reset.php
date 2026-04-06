<?php // Pirumatic - Reset Settings

if (!defined('ABSPATH')) exit;

function pirumatic_admin_notice() {
	
	$screen_id = pirumatic_get_current_screen_id();
	
	if ($screen_id === 'settings_page_pirumatic') {
		
		if (isset($_GET['reset-options'])) {
			
			if ($_GET['reset-options'] === 'true') : ?>
				
				<div class="notice notice-success is-dismissible"><p><strong><?php esc_html_e('Default options restored.', 'pirumatic'); ?></strong></p></div>
				
			<?php else : ?>
				
				<div class="notice notice-info is-dismissible"><p><strong><?php esc_html_e('No changes made to options.', 'pirumatic'); ?></strong></p></div>
				
			<?php endif;
			
		}
		
		if (!pirumatic_check_date_expired() && !pirumatic_dismiss_notice_check()) {
			
			$tabs = array('tab1', 'tab2', 'tab3', 'tab4', 'tab5');
			
			$tab = (isset($_GET['tab']) && in_array($_GET['tab'], $tabs)) ? $_GET['tab'] : 'tab1';
			
			?>
			
			<div class="notice notice-success notice-margin notice-custom">
				<p>
					<strong><?php esc_html_e('Spring Sale!', 'pirumatic'); ?></strong> 
					<?php esc_html_e('Take 30% OFF any of our', 'pirumatic'); ?> 
					<a target="_blank" rel="noopener noreferrer" href="https://plugin-planet.com/"><?php esc_html_e('Pro WordPress plugins', 'pirumatic'); ?></a> 
					<?php esc_html_e('and', 'pirumatic'); ?> 
					<a target="_blank" rel="noopener noreferrer" href="https://books.perishablepress.com/"><?php esc_html_e('books', 'pirumatic'); ?></a>. 
					<?php esc_html_e('Apply code', 'pirumatic'); ?> <code>SPRING2025</code> <?php esc_html_e('at checkout. Sale ends 6/25/2025.', 'pirumatic'); ?> 
					<?php echo pirumatic_dismiss_notice_link($tab); ?>
				</p>
			</div>
			
			<?php
			
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
