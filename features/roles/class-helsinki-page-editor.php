<?php

declare(strict_types = 1);

namespace CityOfHelsinki\WordPress\UserRoles\Features\Roles;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Helsinki_Page_Editor implements Custom_Role_Interface
{
	protected array $post_types = array(
		'page',
		'attachment',
	);

	protected array $taxonomies = array(
		'category',
		'post_tag',
	);

	public function version(): int
	{
		return 1;
	}

	public function name(): string
	{
		return 'helsinki_page_editor';
	}

	public function title(): string
	{
		return _x( 'Helsinki Page Editor', 'Role name', 'helsinki-user-roles' );
	}

	public function description(): string
	{
		return _x( 'The user can manage their own media files and update pages assigned to them. They cannot create or delete pages.', 'Role description', 'helsinki-user-roles' );
	}

	public function allowed_post_types(): array
	{
		return $this->post_types;
	}

	public function is_allowed_post_type( string $type ): bool
	{
		return in_array( $type, $this->allowed_post_types() );
	}

	public function allowed_taxonomies(): array
	{
		return $this->taxonomies;
	}

	public function is_allowed_taxonomy( string $type ): bool
	{
		return in_array( $type, $this->allowed_taxonomies() );
	}

	public function capabilities(): array
	{
		return array(
			'delete_posts' => true,
			'edit_posts' => true,
			'edit_pages' => true,
			'edit_published_pages' => true,
			'publish_pages' => true,
			'read' => true,
			'upload_files' => true,
		);
	}

	public function can_create_posts( string $type ): bool
	{
		return $type === 'page' ? false : $this->is_allowed_post_type( $type );
	}

	public function disallowed_admin_pages(): array
	{
		return array(
			'edit-comments.php',
			'tools.php',
		);
	}
}
