<?php

declare(strict_types = 1);

namespace CityOfHelsinki\WordPress\UserRoles\Features\Roles;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
  * Activate
  */
add_action( 'helsinki_user_roles_activate', __NAMESPACE__ . '\\activate' );
function activate(): void {
	$adapter = default_role_adapter();

	$adapter->register_roles();
}

/**
  * Loaded
  */
add_action( 'helsinki_user_roles_loaded', __NAMESPACE__ . '\\loaded' );
function loaded(): void {
	$factory = default_role_factory();

	foreach ( $factory->roles() as $role ) {
		$hooks = create_hook_adapter( $role );

		add_filter( 'register_post_type_args', array( $hooks, 'register_post_type_args' ), 10, 2 );

		add_filter( 'register_taxonomy_args', array( $hooks, 'register_taxonomy_args' ), 10, 3 );

		add_filter( 'pre_delete_post', array( $hooks, 'pre_delete_post' ), 10, 3 );

		add_filter( 'pre_trash_post', array( $hooks, 'pre_trash_post' ), 10, 3 );

		add_action( 'admin_menu', array( $hooks, 'admin_menu' ) );

		foreach( $role->disallowed_admin_pages() as $page ) {
			add_action( "load-{$page}", array( $hooks, 'redirect_disallowed_page' ) );
		}
	}
}
