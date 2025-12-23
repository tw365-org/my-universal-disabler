=== My Universal Disabler ===
Contributors: tw365_org
Tags: disable plugins, debug, performance, troubleshooting
Requires at least: 6.9
Tested up to: 6.9
Stable tag: 1.0.0
Requires PHP: 7.4
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

A tool to strictly disable all active plugins except this one for emergency debugging.

== Description ==

**My Universal Disabler** is an emergency tool designed for developers and site administrators. 

When you are facing critical conflicts, white screens of death (if backend is accessible), or performance issues, you often need to disable all plugins to identify the culprit. This plugin allows you to "Reset" the active plugins list with one click, while keeping **My Universal Disabler** itself active so you don't lose your tool.

**Key Features:**

* **One-Click Disable:** Instantly deactivates all other plugins.
* **Self-Preservation:** Automatically excludes itself from the deactivation list.
* **Clean Uninstall:** Removes all temporary options when deleted.
* **Safe:** Restricted to administrators with `manage_options` capability.

**Usage:**
1. Go to Tools > Universal Disabler.
2. Click the "Disable All Plugins" button.
3. All plugins except this one will be deactivated.

== Installation ==

1. Upload the `my-universal-disabler` folder to the `/wp-content/plugins/` directory.
2. Activate the plugin through the 'Plugins' menu in WordPress.
3. Navigate to Tools > Universal Disabler to use the feature.

== Screenshots ==

1. The admin interface under Tools menu.

== Changelog ==

= 1.0.0 =
* Initial release.

== Upgrade Notice ==

= 1.0.0 =
* Initial release.