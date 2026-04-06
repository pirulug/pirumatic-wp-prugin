<?php
/*
		Plugin Name: Pirumatic
		Plugin URI: https://github.com/pirulug/piru-pirumatic
		Description: Potente y ligero plugin para el resaltado de sintaxis de código en WordPress, con soporte integrado para Prism.js, Highlight.js y Plain Flavor.
		Tags: code, snippets, syntax, highlight, language
		Author: Pirulug
		Contributors: -
		Author URI: https://github.com/pirulug/
		Donate link: https://github.com/pirulug/donate
		Requires at least: 4.7
		Tested up to: 6.8
		Stable tag: 0.0.1
		Version: 0.0.1
		Requires PHP: 5.6.20
		Text Domain: pirumatic
		Domain Path: /languages
		License: MIT
*/


if (!defined('ABSPATH'))
	die();

if (!class_exists('Pirumatic')) {

	final class Pirumatic {

		private static $instance;

		public static function instance() {

			if (!isset(self::$instance) && !(self::$instance instanceof Pirumatic)) {

				self::$instance = new Pirumatic;
				self::$instance->constants();
				self::$instance->includes();

				register_activation_hook(__FILE__, 'pirumatic_dismiss_notice_activate');

				add_action('admin_init', array(self::$instance, 'check_plugin'));
				add_action('admin_init', array(self::$instance, 'check_version'));
				add_filter('plugin_action_links', array(self::$instance, 'action_links'), 10, 2);
				add_filter('plugin_row_meta', array(self::$instance, 'plugin_links'), 10, 2);
				add_filter('admin_footer_text', array(self::$instance, 'footer_text'), 10, 1);

				add_action('wp_enqueue_scripts', 'pirumatic_block_styles');
				add_action('wp_enqueue_scripts', 'pirumatic_enqueue');
				add_action('admin_enqueue_scripts', 'pirumatic_enqueue');
				add_action('admin_enqueue_scripts', 'pirumatic_enqueue_settings');
				add_action('admin_enqueue_scripts', 'pirumatic_enqueue_buttons');
				add_action('admin_print_footer_scripts', 'pirumatic_add_quicktags');
				add_action('admin_notices', 'pirumatic_admin_notice');
				add_action('admin_menu', 'pirumatic_menu_pages');
				add_action('admin_init', 'pirumatic_register_settings');
				add_action('admin_init', 'pirumatic_reset_options');
				add_action('admin_init', 'pirumatic_buttons');
				add_action('admin_init', 'pirumatic_dismiss_notice_save');
				add_action('admin_init', 'pirumatic_dismiss_notice_version');

				add_action('init', 'pirumatic_register_block_assets');
				add_action('init', 'pirumatic_add_filters');
				add_action('init', array(self::$instance, 'load_textdomain'));

				add_shortcode('pirumatic_code', 'pirumatic_code_shortcode');

			}

			return self::$instance;

		}

		public function load_textdomain() {

			load_plugin_textdomain('pirumatic', false, PIRUMATIC_SLUG . '/languages/');

		}

		public static function options_general() {

			$options = array(

				'library'              => 'none',
				'disable_block_styles' => false,

			);

			return apply_filters('pirumatic_options_general', $options);

		}

		public static function options_prism() {

			$options = array(

				'prism_theme'     => 'default',
				'filter_content'  => 'none',
				'filter_excerpts' => 'none',
				'filter_comments' => 'none',
				'line_highlight'  => false,
				'line_numbers'    => false,
				'show_language'   => false,
				'copy_clipboard'  => false,
				'command_line'    => false,
				'singular_only'   => true,

			);

			return apply_filters('pirumatic_options_prism', $options);

		}

		public static function options_highlight() {

			$options = array(

				'highlight_theme' => 'default',
				'filter_content'  => 'none',
				'filter_excerpts' => 'none',
				'filter_comments' => 'none',
				'init_javascript' => 'hljs.highlightAll();',
				'singular_only'   => true,

			);

			return apply_filters('pirumatic_options_highlight', $options);

		}

		public static function options_plain() {

			$options = array(

				'filter_content'  => 'none',
				'filter_excerpts' => 'none',
				'filter_comments' => 'none',

			);

			return apply_filters('pirumatic_options_plain', $options);

		}

		public static function options_advanced() {

			$options = array(

				'custom_style' => '',

			);

			return apply_filters('pirumatic_options_advanced', $options);

		}

		private function constants() {

			if (!defined('PIRUMATIC_VERSION'))
				define('PIRUMATIC_VERSION', '0.0.1');
			if (!defined('PIRUMATIC_REQUIRE'))
				define('PIRUMATIC_REQUIRE', '4.7');
			if (!defined('PIRUMATIC_NAME'))
				define('PIRUMATIC_NAME', 'Pirumatic');
			if (!defined('PIRUMATIC_AUTHOR'))
				define('PIRUMATIC_AUTHOR', 'Pirulug');
			if (!defined('PIRUMATIC_HOME'))
				define('PIRUMATIC_HOME', 'https://github.com/pirulug/piru-pirumatic/');
			if (!defined('PIRUMATIC_URL'))
				define('PIRUMATIC_URL', plugin_dir_url(__FILE__));
			if (!defined('PIRUMATIC_DIR'))
				define('PIRUMATIC_DIR', plugin_dir_path(__FILE__));
			if (!defined('PIRUMATIC_FILE'))
				define('PIRUMATIC_FILE', plugin_basename(__FILE__));
			if (!defined('PIRUMATIC_SLUG'))
				define('PIRUMATIC_SLUG', basename(dirname(__FILE__)));

		}

		private function includes() {

			require_once PIRUMATIC_DIR . 'inc/pirumatic-blocks.php';
			require_once PIRUMATIC_DIR . 'inc/pirumatic-buttons.php';
			require_once PIRUMATIC_DIR . 'inc/pirumatic-core.php';
			require_once PIRUMATIC_DIR . 'inc/resources-enqueue.php';
			require_once PIRUMATIC_DIR . 'inc/settings-callbacks.php';
			require_once PIRUMATIC_DIR . 'inc/settings-display.php';
			require_once PIRUMATIC_DIR . 'inc/settings-register.php';
			require_once PIRUMATIC_DIR . 'inc/settings-reset.php';
			require_once PIRUMATIC_DIR . 'inc/settings-validate.php';

		}

		public function action_links($links, $file) {

			if ($file == PIRUMATIC_FILE && (current_user_can('manage_options'))) {

				$pirumatic_links = '<a href="' . admin_url('options-general.php?page=pirumatic') . '">' . esc_html__('Settings', 'pirumatic') . '</a>';
				array_unshift($links, $pirumatic_links);

			}

			return $links;

		}

		public function plugin_links($links, $file) {

			if ($file == PIRUMATIC_FILE) {

				$home_href  = 'https://perishablepress.com/pirumatic/';
				$home_title = esc_attr__('Plugin Homepage', 'pirumatic');
				$home_text  = esc_html__('Homepage', 'pirumatic');

				$links[] = '<a target="_blank" rel="noopener noreferrer" href="' . $home_href . '" title="' . $home_title . '">' . $home_text . '</a>';

				$rate_href  = 'https://wordpress.org/support/plugin/' . PIRUMATIC_SLUG . '/reviews/?rate=5#new-post';
				$rate_title = esc_attr__('Click here to rate and review this plugin on WordPress.org', 'pirumatic');
				$rate_text  = esc_html__('Rate this plugin', 'pirumatic') . '&nbsp;&raquo;';

				$links[] = '<a target="_blank" rel="noopener noreferrer" href="' . $rate_href . '" title="' . $rate_title . '">' . $rate_text . '</a>';

				$pro_href  = 'https://plugin-planet.com/pirumatic-pro/';
				$pro_title = esc_attr__('Get Pirumatic Pro!', 'pirumatic');
				$pro_text  = esc_html__('Go&nbsp;Pro', 'pirumatic');
				$pro_style = 'padding:1px 5px;color:#eee;background:#333;border-radius:1px;';

				// $links[]    = '<a target="_blank" rel="noopener noreferrer" href="'. $pro_href .'" title="'. $pro_title .'" style="'. $pro_style .'">'. $pro_text .'</a>';

			}

			return $links;

		}

		function footer_text($text) {

			return $text;

		}

		public function check_plugin() {

			if (class_exists('Pirumatic_Pro')) {

				if (is_plugin_active(PIRUMATIC_FILE)) {

					deactivate_plugins(PIRUMATIC_FILE);

					$msg = '<strong>' . esc_html__('Warning:', 'pirumatic') . '</strong> ';
					$msg .= esc_html__('Pro version of Pirumatic currently active. Free and Pro versions cannot be activated at the same time. ', 'pirumatic');
					$msg .= esc_html__('Please return to the', 'pirumatic') . ' <a href="' . admin_url() . '">' . esc_html__('WP Admin Area', 'pirumatic') . '</a> ';
					$msg .= esc_html__('and try again.', 'pirumatic');

					wp_die($msg);

				}

			}

		}

		public function check_version() {

			$wp_version = get_bloginfo('version');

			if (isset($_GET['activate']) && $_GET['activate'] == 'true') {

				if (version_compare($wp_version, PIRUMATIC_REQUIRE, '<')) {

					if (is_plugin_active(PIRUMATIC_FILE)) {

						deactivate_plugins(PIRUMATIC_FILE);

						$msg = '<strong>' . PIRUMATIC_NAME . '</strong> ' . esc_html__('requires WordPress ', 'pirumatic') . PIRUMATIC_REQUIRE;
						$msg .= esc_html__(' or higher, and has been deactivated! ', 'pirumatic');
						$msg .= esc_html__('Please return to the', 'pirumatic') . ' <a href="' . admin_url() . '">';
						$msg .= esc_html__('WP Admin Area', 'pirumatic') . '</a> ' . esc_html__('to upgrade WordPress and try again.', 'pirumatic');

						wp_die($msg);

					}

				}

			}

		}

		public function __clone() {

			_doing_it_wrong(__FUNCTION__, esc_html__('Cheatin&rsquo; huh?', 'pirumatic'), PIRUMATIC_VERSION);

		}

		public function __wakeup() {

			_doing_it_wrong(__FUNCTION__, esc_html__('Cheatin&rsquo; huh?', 'pirumatic'), PIRUMATIC_VERSION);

		}

	}

}

if (class_exists('Pirumatic')) {

	$pirumatic_options_general = get_option('pirumatic_options_general', Pirumatic::options_general());
	$pirumatic_options_general = apply_filters('pirumatic_get_options_general', $pirumatic_options_general);

	$pirumatic_options_prism = get_option('pirumatic_options_prism', Pirumatic::options_prism());
	$pirumatic_options_prism = apply_filters('pirumatic_get_options_prism', $pirumatic_options_prism);

	$pirumatic_options_highlight = get_option('pirumatic_options_highlight', Pirumatic::options_highlight());
	$pirumatic_options_highlight = apply_filters('pirumatic_get_options_highlight', $pirumatic_options_highlight);

	$pirumatic_options_plain = get_option('pirumatic_options_plain', Pirumatic::options_plain());
	$pirumatic_options_plain = apply_filters('pirumatic_get_options_plain', $pirumatic_options_plain);

	$pirumatic_options_advanced = get_option('pirumatic_options_advanced', Pirumatic::options_advanced());
	$pirumatic_options_advanced = apply_filters('pirumatic_get_options_advanced', $pirumatic_options_advanced);

	if (!function_exists('pirumatic')) {

		function pirumatic() {

			do_action('pirumatic');

			return Pirumatic::instance();
		}

	}

	pirumatic();

}
