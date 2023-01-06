<?php
/**
 * Plugin Name:       Bricks Class Manager
 * Plugin URI:        https://www.wpget.au
 * Description:       Adds feature to sort Bricks Global Classes
 * Version:           0.0.4
 * Author:            Alan Blair
 * Author URI:        https://www.wpget.au
 * License:           GPL v2 or later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain:       wpg-bricks-class-manager
 * Domain Path:       /languages
 */


// don't call the file directly
if ( !defined( 'ABSPATH' ) ) exit;

$theme = wp_get_theme();
if ( 'Bricks' != $theme->name && 'Bricks' != $theme->parent_theme ) {
    return;
}

define('WPG_BSC_DEBUG', false);
define('WPG_BSC_PLUGIN_FILE', __FILE__);
define('WPG_BSC_PLUGIN_URL', plugin_dir_url(__FILE__));
define('WPG_BSC_SLUG', 'wwpg-bricks-class-manager');
define('WPG_BSC_SLUG_TEXT_DOMAIN', 'wpg-bricks-class-manager');
define('WPG_BSC_API_NAMESPACE', 'bsc/v1' );
define('WPG_BSC_CSS_UPLOAD_DIR', wp_get_upload_dir()['basedir'].'/bricks_classes/');
define('WPG_BSC_CSS_UPLOAD_URL', wp_get_upload_dir()['baseurl'].'/bricks_classes/');

define('WPG_BSC_BRICKS_GLOBAL_CLASSES_OPTION', 'bricks_global_classes' );

/* Options for imported and parsed CSS */
define('WPG_BSC_IMPORTED_CLASSES_OPTION', 'wpg_bricks_imported_classes' );


require_once __DIR__ . '/vendor/autoload.php';

add_action('init', function (){
    new \WPG_BSC\Application();
}, 999);
