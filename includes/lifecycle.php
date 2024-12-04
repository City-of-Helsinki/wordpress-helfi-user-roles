<?php

declare(strict_types = 1);

namespace CityOfHelsinki\WordPress\UserRoles;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

function setup() : void {
	if ( ! did_action( 'helsinki_user_roles_setup' ) ) {
		do_action( 'helsinki_user_roles_setup' );
	}
}

function loaded() : void {
	setup();

	do_action( 'helsinki_user_roles_loaded' );
}

function init() : void {
	do_action( 'helsinki_user_roles_init' );
}

function activate() : void {
	setup();

	do_action( 'helsinki_user_roles_activate' );
}

function deactivate() : void {
	setup();

	do_action( 'helsinki_user_roles_deactivate' );
}

function uninstall() : void {
	setup();

	do_action( 'helsinki_user_roles_uninstall' );
}
