<?php

declare(strict_types = 1);

namespace CityOfHelsinki\WordPress\UserRoles\Features\Roles;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Custom_Roles_Adapter
{
	protected Custom_Roles_Factory $factory;

	public function __construct( Custom_Roles_Factory $factory )
	{
		$this->factory = $factory;
	}

	public function register_roles(): void
	{
		array_map( array( $this, 'register_role' ), $this->factory->roles() );
	}

	protected function register_role( Custom_Role_Interface $role ): bool
	{
		return $this->should_update_role( $role )
			? $this->update_role( $role )
			: $this->add_role( $role );
	}

	protected function add_role( Custom_Role_Interface $role ): bool
	{
		$wp_role = \add_role( $role->name(), $role->title(), $role->capabilities() );

		if ( $wp_role instanceof \WP_Role ) {
			$this->update_role_current_version( $role );

			return true;
		}

		return false;
	}

	protected function update_role( Custom_Role_Interface $role ): bool
	{
		$wp_role = get_role( $role->name() );

		if ( $wp_role instanceof \WP_Role ) {
			foreach ( $role->capabilities() as $capability => $granted ) {
				$granted ? $wp_role->add_cap( $capability ) : $wp_role->remove_cap( $capability );
			}

			$this->update_role_current_version( $role );

			return true;
		}

		return false;
	}

	protected function should_update_role( Custom_Role_Interface $role ): bool
	{
		$version = $this->role_current_version( $role );

		return $version ? $version < $role->version() : false;
	}

	protected function role_current_version( Custom_Role_Interface $role ): int
	{
		return (int) get_option( $this->role_version_option( $role ), 0 ) ?: 0;
	}

	protected function update_role_current_version( Custom_Role_Interface $role ): bool
	{
		return update_option( $this->role_version_option( $role ), $role->version() );
	}

	protected function role_version_option( Custom_Role_Interface $role ): string
	{
		return sprintf( '%s_version', $role->name() );
	}
}
