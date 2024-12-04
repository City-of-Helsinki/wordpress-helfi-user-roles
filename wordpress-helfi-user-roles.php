<?php
/**
	* Plugin Name: Helsinki User Roles
	* Description: Custom user roles for Helsinki WordPress sites.
	* Requires at least: 6.0.0
	* Requires PHP: 7.4
	* Version: 1.0.0
	* Author: ArtCloud
	* Author URI: https://www.artcloud.fi
	* License: GPL v2 or later
	* License URI: https://www.gnu.org/licenses/gpl-2.0.html
	* Text Domain: helsinki-user-roles
	* Domain Path: /languages
	*/

declare(strict_types = 1);

namespace CityOfHelsinki\WordPress\UserRoles;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
  * Setup
  */
require_once plugin_dir_path( __FILE__ ) . 'constants.php';
define_constants( __FILE__ );

require_once plugin_dir_path( __FILE__ ) . 'functions.php';
load_includes();

spl_autoload_register( __NAMESPACE__ . '\\class_loader' );

add_action( 'helsinki_user_roles_setup', __NAMESPACE__ . '\\setup_filters', 0 );
add_action( 'helsinki_user_roles_setup', __NAMESPACE__ . '\\load_features', 1 );
add_action( 'helsinki_user_roles_setup', __NAMESPACE__ . '\\load_integrations', 1 );

add_action( 'plugins_loaded', __NAMESPACE__ . '\\loaded' );

/**
  * Init
  */
add_action( 'init', __NAMESPACE__ . '\\textdomain' );
add_action( 'init', __NAMESPACE__ . '\\init', 100 );

/**
  * Activation
  */
register_activation_hook( __FILE__, __NAMESPACE__ . '\\activate' );

/**
  * Deactivation
  */
register_deactivation_hook( __FILE__, __NAMESPACE__ . '\\deactivate' );

/**
  * Uninstall
  */
// register_uninstall_hook( __FILE__, __NAMESPACE__ . '\\uninstall' );
