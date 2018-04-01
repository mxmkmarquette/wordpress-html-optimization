=== HTML Optimization ===
Contributors: o10n
Donate link: https://github.com/o10n-x/
Tags: html, minify, compress, search replace, optimization, strip, comments
Requires at least: 4.0
Requires PHP: 5.4
Tested up to: 4.9.4
Stable tag: 0.0.10
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Advanced HTML optimization toolkit. Minify, code optimization, search & replace, strip comments and more.

== Description ==

This plugin is a toolkit for advanced HTML optimization.

The plugin provides in a complete solution for HTML optimization including HTML minification, selective removal of comments and search & replace.

Additional features can be requested on the [Github forum](https://github.com/o10n-x/wordpress-html-optimization/issues).

**This plugin is a beta release.**

Documentation is available on [Github](https://github.com/o10n-x/wordpress-html-optimization/tree/master/docs).

== Installation ==

### WordPress plugin installation

1. Upload the `html-optimization/` directory to the `/wp-content/plugins/` directory.
2. Activate the plugin through the 'Plugins' menu in WordPress.
3. Navigate to the plugin settings page.
4. Configure HTML Optimization settings. Documentation is available on [Github](https://github.com/o10n-x/wordpress-html-optimization/tree/master/docs).

== Screenshots ==


== Changelog ==

= 0.0.10 =
* Added: plugin update protection (plugin index).

= 0.0.9 =
* Core update (see changelog.txt)

= 0.0.7 =
* Temporary fix for HtmlMin minifier: WordPress SVN [does not support PHP7+](https://make.wordpress.org/systems/2018/03/12/change-all-svn-php-linting-to-php7/), Symfony [css-selector](https://github.com/symfony/css-selector/) removed until it can be published.

= 0.0.6 =
* Added: support for multiple HTML minifiers.
* Added: [HtmlMin](https://github.com/voku/HtmlMin) minifier by voku
* Added: Custom minifier option (support for Node.js, server software etc.)

= 0.0.5 =
* Core update (see changelog.txt)

= 0.0.2 =
* Update readme

= 0.0.1 =

Beta release. Please provide feedback on [Github forum](https://github.com/o10n-x/wordpress-html-optimization/issues).

== Upgrade Notice ==

None.