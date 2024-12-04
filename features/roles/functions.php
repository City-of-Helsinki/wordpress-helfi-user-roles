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

function roles_help_tab(): void {
	$screen = get_current_screen();

	$screen->add_help_tab( array(
        'id' => 'helsinki_user_roles_help',
        'title' => __( 'Helsinki User Roles', 'helsinki-user-roles' ),
        'content' => create_roles_help_tab_content(),
		'priority' => 100,
    ) );
}

function create_roles_help_tab_content(): string {
	$content = array( '<ul>' );

	foreach ( default_role_factory()->roles() as $role ) {
		$content[] = sprintf(
			'<li><strong>%s</strong>: %s</li>',
			esc_html( $role->title() ),
			esc_html( $role->description() )
		);
	}

	$content[] = '</ul>';

	return implode( '', $content );
}
