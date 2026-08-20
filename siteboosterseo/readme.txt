=== Siteboosterseo ===
Contributors: javicastilowp 
Tags: seo, metadata, booster, performance, site
Requires at least: 6.0
Tested up to: 7.1
Requires PHP: 8.2.4 
Stable tag: 2.0.0
License: GPLv2 or later
License URI: https://www.gnu.org/licenses/gpl-2.0.html

Edit sitewide meta title, description, and keywords with a clean preview. Works with any theme and domain/subdomain.

== Description ==

A lightweight, easy-to-use WordPress SEO plugin focused on speed and clean markup.
Edit titles, meta descriptions, and keywords with a simple UI and live snippet preview.
Works with most sitemap plugins so you can submit your site to Google Search Console in just a few steps.
Set site-wide defaults once to keep titles and descriptions consistent across all pages.
Control how your pages appear on Google and other search engines.

== Installation ==

1. Upload the `siteboosterseo` folder.
2. Activate it through the menu.
3. Go to the 'SBSEO' menu in the admin panel to configure your metadata.

== Frequently Asked Questions ==

= Does this support multisite? =
Yes, it works with multisite installations.

= What happens if I leave the title field empty? =
Your theme's default title will be used instead.

= Can this plugin be used with any WordPress theme? =
Yes, the plugin is designed to be compatible with all well-coded WordPress themes. It injects metadata into the head section without interfering with theme functionality.

= Will this plugin slow down my website? =
No, the plugin is lightweight and optimized for performance. It runs only in the admin when needed and adds minimal overhead to your site.

== Changelog ==
= 2.0.0 =
* Tested compatibility with WordPress 7.1
* Improved request URI sanitization and secure redirect handling to follow WordPress security best practices.
* Improved internal function naming to prevent potential conflicts(dcjSbseoConnectPlugin).
= 1.3.0 =
* Tested compatibility with WordPress 7.0.
* Added live preview effects for title and description fields in the settings panel.
* Added a non-intrusive review request notice for plugin users.
* Added delayed feedback display after the plugin has been configured.
* Added "Leave a review", "Maybe later", and "No, thanks" actions.
* Improved feedback notice behavior on the plugin settings page and WordPress Dashboard.
* Improved redirect handling after feedback actions.
* Added a visual fallback to hide the feedback notice after returning from the WordPress.org review page.
* Improved admin feedback notice styling and responsive layout.

= 1.2.0 =
* Replacing the filemtime by version in the enqueue_admin_styles function of the class-childmaker-ai.php file to enqueue the siteboosterseo.admin.css file for better performance.
*Delete the class-dcjmyplug.php cause it is not necesary anymore.

= 1.0.0 =
* Initial release.

== Screenshots ==

1. Minimalist setting page
2. Note the tip and max length of the char strings

== License ==

This is licensed under the GPLv2 or later.
