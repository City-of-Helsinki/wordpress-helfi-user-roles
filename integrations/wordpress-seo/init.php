<?php

declare(strict_types = 1);

namespace CityOfHelsinki\WordPress\UserRoles\Integrations\WordPressSeo;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

add_action( 'helsinki_user_roles_loaded', __NAMESPACE__ . '\\loaded' );
function loaded(): void {
	add_action( 'admin_bar_menu', __NAMESPACE__ . '\\hide_toolbar_item', 9999 );
}

function hide_toolbar_item( \WP_Admin_Bar $wp_admin_bar ): void {
	if ( ! current_user_can( 'manage_options' ) ) {
		$wp_admin_bar->remove_menu( 'wpseo-menu' );
	}
}
