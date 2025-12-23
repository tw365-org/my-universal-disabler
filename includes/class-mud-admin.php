<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class MUD_Admin {

	public function __construct() {
		add_action( 'admin_menu', array( $this, 'add_admin_menu' ) );
		add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_assets' ) );
		add_action( 'admin_init', array( $this, 'process_disable_action' ) );
	}

	/**
	 * 新增選單至「工具」底下
	 */
	public function add_admin_menu() {
		add_management_page(
			esc_html__( 'Universal Disabler', 'my-universal-disabler' ), // Page Title
			esc_html__( 'Universal Disabler', 'my-universal-disabler' ), // Menu Title
			'manage_options',                                            // Capability
			'my-universal-disabler',                                     // Slug
			array( $this, 'render_page' )                                // Callback
		);
	}

	/**
	 * 載入外部資源 (CSS)
	 */
	public function enqueue_assets( $hook ) {
		if ( 'tools_page_my-universal-disabler' !== $hook ) {
			return;
		}

		wp_enqueue_style(
			'mud-admin-style',
			MUD_PLUGIN_URL . 'assets/css/admin-style.css',
			array(),
			MUD_VERSION
		);
	}

	/**
	 * 處理停用外掛的邏輯
	 */
	public function process_disable_action() {
		// 檢查是否有點擊按鈕
		if ( ! isset( $_POST['mud_disable_all'] ) ) {
			return;
		}

		// 檢查 Nonce (安全性修正：加入 sanitize_key)
		if ( ! isset( $_POST['mud_nonce'] ) || ! wp_verify_nonce( sanitize_key( $_POST['mud_nonce'] ), 'mud_disable_action' ) ) {
			wp_die( esc_html__( 'Security check failed.', 'my-universal-disabler' ) );
		}

		// 檢查權限
		if ( ! current_user_can( 'manage_options' ) ) {
			wp_die( esc_html__( 'You do not have permission to perform this action.', 'my-universal-disabler' ) );
		}

		// 1. 取得所有已啟用的外掛
		$active_plugins = get_option( 'active_plugins' );
		$plugins_to_deactivate = array();

		// 2. 篩選排除自己
		foreach ( $active_plugins as $plugin ) {
			if ( $plugin !== MUD_PLUGIN_BASENAME ) {
				$plugins_to_deactivate[] = $plugin;
			}
		}

		// 3. 執行停用
		if ( ! empty( $plugins_to_deactivate ) ) {
			deactivate_plugins( $plugins_to_deactivate );
			
			// 記錄操作時間 (用於 uninstall.php 清理演示)
			update_option( 'mud_last_run', current_time( 'mysql' ) );

			add_settings_error(
				'mud_messages',
				'mud_success',
				esc_html__( 'All other plugins have been successfully disabled.', 'my-universal-disabler' ),
				'updated'
			);
		} else {
			add_settings_error(
				'mud_messages',
				'mud_notice',
				esc_html__( 'No other active plugins found.', 'my-universal-disabler' ),
				'info'
			);
		}
	}

	/**
	 * 顯示後台頁面
	 */
	public function render_page() {
		?>
		<div class="wrap">
			<h1><?php esc_html_e( 'Universal Disabler', 'my-universal-disabler' ); ?></h1>
			
			<?php settings_errors( 'mud_messages' ); ?>

			<div class="card mud-card">
				<h2><?php esc_html_e( 'Emergency Mode', 'my-universal-disabler' ); ?></h2>
				<p>
					<?php esc_html_e( 'Clicking the button below will disable ALL plugins active on this site, EXCEPT for this one.', 'my-universal-disabler' ); ?>
				</p>
				<p class="description">
					<?php esc_html_e( 'Use this feature when you need to debug conflicts or improve performance strictly.', 'my-universal-disabler' ); ?>
				</p>

				<form method="post" action="">
					<?php wp_nonce_field( 'mud_disable_action', 'mud_nonce' ); ?>
					<p class="submit">
						<input type="submit" name="mud_disable_all" id="submit" class="button button-primary button-hero mud-danger-btn" value="<?php esc_attr_e( 'Disable All Plugins', 'my-universal-disabler' ); ?>">
					</p>
				</form>
			</div>
		</div>
		<?php
	}
}