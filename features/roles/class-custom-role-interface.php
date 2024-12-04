<?php

declare(strict_types = 1);

namespace CityOfHelsinki\WordPress\UserRoles\Features\Roles;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

interface Custom_Role_Interface
{
	public function version(): int;
	public function name(): string;
	public function title(): string;
	public function description(): string;

	public function allowed_post_types(): array;
	public function is_allowed_post_type( string $type ): bool;

	public function allowed_taxonomies(): array;
	public function is_allowed_taxonomy( string $type ): bool;

	public function capabilities(): array;
	public function can_create_posts( string $type ): bool;

	public function disallowed_admin_pages(): array;
}
