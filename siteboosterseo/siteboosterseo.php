<?php
/**
 * Plugin Name: Siteboosterseo
 * Plugin URI: https://dev-ia.com/siteboosterseo
 * Description: Simple SEO metadata inserter for all pages.
 * Version: 1.2.0
 * Author: Javier A. D. Castillo
 * Author URI: https://dev-ia.com
 * License: GPL2
 * Text Domain: siteboosterseo
 * Domain Path: /languages
 */
if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}
// Get main class of the plugin
require_once plugin_dir_path( __FILE__ ) . 'includes/class-siteboosterseo.php';
// namespace
use nameSiteboosterseo\classSiteboosterseo;
// Install the plugin
function run_siteboosterseo() {
    $pluginSbseo = new classSiteboosterseo();
    $pluginSbseo->run();
}
run_siteboosterseo();

