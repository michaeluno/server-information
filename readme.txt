=== Server Information ===
Contributors:       Michael Uno, miunosoft
Donate link:        http://en.michaeluno.jp/donate
Tags:               system, system information, admin tool, tool, server, server information, email, report, bug report, report form, form, email form
Requires at least:  3.3
Tested up to:       4.2.4
Stable tag:         1.1.3
License:            GPLv2 or later
License URI:        http://www.gnu.org/licenses/gpl-2.0.html

Allows you to send server information via email.

== Description ==

Troubleshooting with your plugin or theme developer? Send your server information to them with a few clicks.

<h4>Features</h4>
- **Server Information** - displays WordPress, PHP, MySQL information and more.
- **Email** - lets you send those information as an email.

== Installation ==

= Install =
1. Go to `Dashboard` -> `Plugins` -> `Add New` and press the `Upload Plugin` button then upload the zip file. If you need to do it manually, upload **`server-information.php`** and other files compressed in the zip folder to the **`/wp-content/plugins/server-information`** directory. 
2. Activate the plugin through the `Plugins` menu in WordPress.

= How to Use = 
1. Go to `Dashboard` -> `Tools` -> `Server Information`.
2. Type necessary information such as your name and email addresses.
3. Submit the report. 

== Other Notes ==

== Frequently Asked Questions ==

= The email does not seem to be sent. Is it broken? =
Emails may not work on some servers with certain configurations. Please report an issue on the forum.

== Screenshots ==

1. ***Report Page***

== Changelog ==

= 1.1.4 - 2015/08/10 =
- Fixed the PHP Error check box did not toggle the PHP error text area input.
- Changed it to mask sensitive information.
- Updated the [Admin Page Framework](http://en.michaeluno.jp/admin-page-framework/) library.

= 1.1.3 - 2015/03/02 =
- Fixed an issue that PHP warnings occurred on some servers with access restriction on PHP error logs.
- Updated the Admin Page Framework library.

= 1.1.2 - 2015/01/16 =
- Fixed an action name that is triggered when all the plugin components are loaded.

= 1.1.1 - 2014/01/06 =
- Added PHP and MySQL logs.
- Fixed an issue with PHP v5.5 or above that information fields became empty.
- Updated the [Admin Page Framework](http://en.michaeluno.jp/admin-page-framework/) library.

= 1.1.0 - 204/12/27 =
- Added options to select information types to send.
- Added more information for MySQL and the client.
- Fixed a bug that sending emails failed on servers with some error settings.
- Updated the [Admin Page Framework](http://en.michaeluno.jp/admin-page-framework/) library.

= 1.0.0 - 2014/12/25 =
- Hosted on WordPress.org.

= 0.0.1 - 2014/12/25 =
- Released initially.