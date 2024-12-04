<?php

declare(strict_types = 1);

namespace CityOfHelsinki\WordPress\UserRoles\Features\Roles;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Role_Hook_Adapter
{
	protected Custom_Role_Interface $role;

	public function __construct( Custom_Role_Interface $role )
	{
		$this->role = $role;
	}

	public function register_post_type_args( array $args, string $post_type ): array
	{
		if ( $this->user_has_role() ) {
			$args['show_ui'] = $this->show_post_type_ui( $args, $post_type, $this->role );

			if ( ! in_array( $post_type, array( 'attachment', 'revision' ) ) ) {
				$args['capabilities']['create_posts'] = $this->role->can_create_posts( $post_type );
			}
		}

		return $args;
	}

	public function register_taxonomy_args( array $args, string $taxonomy, array $object_types ): array
	{
		$allow_terms = \wp_is_json_request()
			&& $this->user_has_role()
			&& $this->role->is_allowed_taxonomy( $taxonomy );

		if ( $allow_terms ) {
			$args['capabilities']['edit_terms'] = 'edit_posts';
			$args['capabilities']['assign_terms'] = 'edit_posts';
		}

		return $args;
	}

	public function pre_delete_post( $delete, \WP_Post $post, bool $force_delete )
	{
		return $this->user_has_role()
			? $this->role->is_allowed_post_type( $post->post_type )
			: $delete;
	}

	public function pre_trash_post( $trash, \WP_Post $post, string $previous_status )
	{
		return $this->user_has_role()
			? $this->role->is_allowed_post_type( $post->post_type )
			: $trash;
	}

	public function admin_menu(): void
	{
		if ( $this->user_has_role() ) {
			foreach( $this->role->disallowed_admin_pages() as $page ) {
				\remove_menu_page( $page );
			}
		}
	}

	public function redirect_disallowed_page(): void
	{
		if ( $this->user_has_role() ) {
			$this->redirect_to_admin();
		}
	}

	protected function redirect_to_admin( string $path = '/' ): void {
		\wp_redirect( \admin_url( $path ) );
		die;
	}

	protected function user_has_role( \WP_User $user = null ): bool {
		if ( ! $user ) {
			$user = \wp_get_current_user();
		}

		return in_array( $this->role->name(), (array) $user->roles );
	}

	protected function show_post_type_ui( array $args, string $post_type, Custom_Role_Interface $role ): bool {
		if ( isset( $args['show_ui'] ) ) {
			return $args['show_ui'] && $role->is_allowed_post_type( $post_type );
		} else {
			return $role->is_allowed_post_type( $post_type );
		}
	}
}
