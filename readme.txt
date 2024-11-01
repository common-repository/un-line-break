=== Un-Line-Break ===
Contributors: cdillon27
Tags: shortcode, content, wpautop, auto-paragraph, line breaks
Requires at least: 3.5
Tested up to: 5.0
Stable tag: 0.2.2
License: GPLv3 or later
License URI: http://www.gnu.org/licenses/gpl-3.0.html

Remove unwanted line breaks from shortcode content.

== Description ==

> This plugin is up for adoption.

Un-Line-Break is a lightweight plugin with a very specific purpose: Improved shortcode readability.

Normally, in the post editor, placing shortcodes on separate lines (like HTML formatting) results in extra line breaks in the rendered output, thanks to the WordPress auto-paragraph function (wpautop).

This plugin removes those extra line breaks from the rendered output so, in the post editor, you can place shortcodes on separate lines, thus making it easier to read and edit them.

It will not remove any double-spacing or `<p>` or `<br>` tags that you have added.

== Installation ==

Option A:

1. Go to `Plugins > Add New`.
1. Search for "un-line-break".
1. Click "Install Now".

Option B:

1. Download the zip file.
1. Unzip it on your hard drive.
1. Upload the `un-line-break` folder to the `/wp-content/plugins/` directory.

Option C:

1. Download the zip file.
1. Upload the zip file via `Plugins > Add New > Upload`.

After activating the plugin, go to **Settings > Un-Line-Break** to select which shortcodes the plugin should process.

== Frequently Asked Questions ==

= Does this affect all shortcodes? =

No. You must select which shortcodes to process. Typically, this only applies to shortcodes with content like columns, tabs, accordions, and so on.

= Leave No Trace? =

Some plugins and themes don't fully uninstall themselves, leaving artifacts like settings, database tables, and subdirectories.

This plugin will completely remove itself upon deletion. Deactivating the plugin will leave the settings intact, though. You can switch off "Leave No Trace" so the settings remain after deletion, if you want.

== Changelog ==

= 0.2.2 =
* Remove translation file.

= 0.2.1 =
* Update admin links.

= 0.2 =
* Improve grouping on admin screen.

= 0.1 =
* First release.
