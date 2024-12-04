<?php

declare(strict_types = 1);

namespace CityOfHelsinki\WordPress\UserRoles\Features\Roles;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Custom_Roles_Factory
{
	protected array $roles;

	public function __construct()
	{
		$this->roles = array(
			$this->page_editor(),
		);
	}

	public function roles(): array
	{
		return $this->roles;
	}

	public function page_editor(): Custom_Role_Interface
	{
		return $this->create_role( __FUNCTION__ );
	}

	protected function create_role( string $name ): Custom_Role_Interface
	{
		if ( $this->in_roles( $name ) ) {
			return $this->from_roles( $name );
		}

		$role = $this->format_role_name( $name );

		return $this->to_roles( $name, new $role() );
	}

	protected function format_role_name( string $name ): string
	{
		return sprintf(
			__NAMESPACE__ . '\\Helsinki_%s',
			implode( '_', array_map( 'ucfirst', explode( '_', $name ) ) )
		);
	}

	protected function in_roles( string $key ): bool
	{
		return ! empty( $this->roles[$key] );
	}

	protected function from_roles( string $key ): Custom_Role_Interface
	{
		return $this->roles[$key];
	}

	protected function to_roles( string $key, Custom_Role_Interface $role ): Custom_Role_Interface
	{
		$this->roles[$key] = $role;

		return $role;
	}
}
