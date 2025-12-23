<?php
/**
 * Fired when the plugin is uninstalled.
 */

// 如果不是由 WordPress 呼叫，則離開
if ( ! defined( 'WP_UNINSTALL_PLUGIN' ) ) {
	exit;
}

// 清理資料庫中的選項 (變數名稱已改為 mud_last_run)
delete_option( 'mud_last_run' );