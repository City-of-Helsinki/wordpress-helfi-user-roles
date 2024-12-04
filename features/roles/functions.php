<?php

declare(strict_types = 1);

namespace CityOfHelsinki\WordPress\UserRoles\Features\Roles;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

function create_custom_roles_factory(): Custom_Roles_Factory {
	return new Custom_Roles_Factory();
}

function default_role_factory(): Custom_Roles_Factory {
	static $factory = null;

	if ( ! $factory ) {
		$factory = create_custom_roles_factory();
	}

	return $factory;
}

function create_custom_roles_adapter( Custom_Roles_Factory $factory ): Custom_Roles_Adapter {
	return new Custom_Roles_Adapter( $factory );
}

function default_role_adapter(): Custom_Roles_Adapter {
	static $adapter = null;

	if ( ! $adapter ) {
		$adapter = create_custom_roles_adapter( default_role_factory() );
	}

	return $adapter;
}

function create_hook_adapter( Custom_Role_Interface $role ): Role_Hook_Adapter {
	return new Role_Hook_Adapter( $role );
}
