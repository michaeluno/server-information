=== Server Information ===
Contributors:       Michael Uno, miunosoft
Donate link:        http://en.michaeluno.jp/donate
Tags:               system, system information, admin tool, tool, server, server information, email, report, bug report, report form, form, email form
Requires at least:  3.3
Tested up to:       4.1.0
Stable tag:         1.0.0
License:            GPLv2 or later
License URI:        http://www.gnu.org/licenses/gpl-2.0.html

Adds an email report form in the admin area to send server information.

== Description ==

<h4>Features</h4>
- **Server Information** - it displays WordPress, PHP, and MySQL information.
- **Email** - it lets the user send those information as an email.

<h4>Notes</h4>
- Sending emails may not function on some servers. In that case, please report in the support forum.

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

= 1.1.0 =
- Added options to select information types to send.
- Added more information for MySQL.
- Updated the Admin Page Framework library.

= 1.0.0 - 2014/12/25 =
- Hosted on WordPress.org.

= 0.0.1 - 2014/12/25 =
- Released initially.