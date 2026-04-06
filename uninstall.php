<?php // Pirumatic - Uninstall Remove Options

if (!defined('ABSPATH') && !defined('WP_UNINSTALL_PLUGIN')) exit();

delete_option('pirumatic_options_general');
delete_option('pirumatic_options_prism');
delete_option('pirumatic_options_highlight');
delete_option('pirumatic_options_plain');
delete_option('pirumatic-dismiss-notice');