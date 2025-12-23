<?php
/**
 * Plugin Name: My Universal Disabler
 * Plugin URI:
 * Description: A tool to disable all plugins except this one. Useful for debugging.
 * Version:     1.0.0
 * Author:      Your Name
 * Author URI:
 * Text Domain: my-universal-disabler
 * Domain Path: /languages
 * License:     GPL-2.0+
 */

// 若直接存取此檔案則終止執行
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// 定義外掛常數 (Prefix 改為 MUD)
define( 'MUD_VERSION', '1.0.0' );
define( 'MUD_PLUGIN_DIR', plugin_dir_path( __FILE__ ) );
define( 'MUD_PLUGIN_URL', plugin_dir_url( __FILE__ ) );
define( 'MUD_PLUGIN_BASENAME', plugin_basename( __FILE__ ) );

// 載入核心類別
require_once MUD_PLUGIN_DIR . 'includes/class-mud-admin.php';

// 初始化外掛
function mud_init() {
	// 實例化管理類別
	new MUD_Admin();
}
add_action( 'plugins_loaded', 'mud_init' );