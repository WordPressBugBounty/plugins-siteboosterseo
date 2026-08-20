<?php
/**
 * Plugin Name: Siteboosterseo
 * Plugin URI: https://dev-ia.com/siteboosterseo
 * Description: Simple SEO metadata inserter for all pages.
 * Version: 2.0.0
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
require_once plugin_dir_path( __FILE__ ) . 'includes/admin/feedback-request.php';
// namespace
use nameSiteboosterseo\classSiteboosterseo;
use nameSiteboosterseo\classSiteboosterseoFeedbackRequest;

// Install the plugin
function dcjSbseoConnectPlugin() {
    $pluginSbseo = new classSiteboosterseo();
    $pluginSbseo->run();
    classSiteboosterseoFeedbackRequest::run();
}
dcjSbseoConnectPlugin();

