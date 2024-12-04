<?php

declare(strict_types = 1);

namespace CityOfHelsinki\WordPress\UserRoles;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

function textdomain(): void {
	load_plugin_textdomain(
		'helsinki-user-roles',
		false,
		apply_filters( 'helsinki_user_roles_plugin_dirname', '' ) . '/languages'
	);
}
