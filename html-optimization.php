<?php
namespace O10n;

/**
 * HTML Optimization
 *
 * Advanced HTML optimization toolkit. Minify, code optimization, search & replace, strip comments and more.
 *
 * @link              https://github.com/o10n-x/
 * @package           o10n
 *
 * @wordpress-plugin
 * Plugin Name:       HTML Optimization
 * Description:       Advanced HTML optimization toolkit. Minify, code optimization, search & replace, strip comments and more.
 * Version:           0.0.10
 * Author:            Optimization.Team
 * Author URI:        https://optimization.team/
 * Text Domain:       o10n
 * Domain Path:       /languages
 */

if (! defined('WPINC')) {
    die;
}

// abort loading during upgrades
if (defined('WP_INSTALLING') && WP_INSTALLING) {
    return;
}

// settings
$module_version = '0.0.10';
$minimum_core_version = '0.0.38';
$plugin_path = dirname(__FILE__);

// load the optimization module loader
if (!class_exists('\O10n\Module')) {
    require $plugin_path . '/core/controllers/module.php';
}

// load module
new Module(
    'html',
    'HTML Optimization',
    $module_version,
    $minimum_core_version,
    array(
        'core' => array(
            'tools',
            'http',
            'html'
        ),
        'admin' => array(
            'AdminHtml'
        )
    ),
    false,
    array(),
    __FILE__
);
