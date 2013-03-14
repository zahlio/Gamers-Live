=== Facebook Comments for WordPress ===
Contributors: thinkswan, we8u, .shaun, AlmogBaku, sboddez
Donate link: https://www.paypal.com/cgi-bin/webscr?cmd=_donations&business=fbc%40we8u%2ecom&lc=US&item_name=Facebook%20Comments%20for%20WordPress&item_number=shaund&currency_code=USD&bn=PP%2dDonationsBF%3abtn_donateCC_LG%2egif%3aNonHosted
Tags: facebook comments, comments, facebook, social graph, posts, pages, discussion, community
Requires at least: 3.0.4
Tested up to: 3.1.1
Stable tag: 3.1.3

Allows your visitors to comment on posts using their Facebook profile. Supports custom styles, notifications, combined comment counts, recent comments widget, etc.

== Description ==

Official site (check for the latest): http://j.mp/fbc_official  || Twitter: http://twitter.com/we8u

This plugin integrates the Facebook commenting system (new, old or both) right into your website. 
If a reader is logged into Facebook while viewing any comment-enabled page or post, 
they'll be able to leave a comment using their Facebook profile. 

**Features:**

* Styles can all be customized to fit your site's theme (v1 only)
* Number of comments displayed can be adjusted
* Option to post comments directly to a user's Facebook profile page (v1 only)
* Comments can be included on pages only, posts only or both
* Comments can be shown in chronological order or with the most recent comments first (v1 only)
* Facebook comments can be attached to WordPress comments or inserted manually anywhere in your theme
* WordPress comments can be hidden on pages/posts where Facebook comments are enabled
* Comment counts on pages/posts reflect both the Facebook and WordPress comments (v1 only)
* Email notifications can be sent whenever a comment is posted
* facebook notifications can also be sent whenever a comment is posted

== Installation ==

1. Unzip `facebook-comments-for-wordpress.3.1.3.zip` to your `/wp-content/plugins/` directory
2. Activate the plugin through the `Plugins` menu in WordPress (depending on the number of posts on your site, activation may take a moment because the plugin is caching all of your comment counts)
3. Setup the plugin options by using the `Facebook Comments` page (located under the `Settings` menu)

* Note that a `Facebook application ID` is required. For details on how to get one, including a screenshot walkthrough,
  check out http://we8u.com/facebook-comments/#install
* In order to keep your comments through upgrades, you **must** set a unique `XID`. This `XID` will be maintained when you
  upgrade the plugin

== Frequently Asked Questions ==

If you need help, please refer to the official FAQ at http://we8u.com/facebook-comments/#faq.

== Changelog ==

= 3.1.3 =
* Feature: Dark style now available for dark sites with the v2 comment system ("v2 only" option).
* Bugfix: Fixed a bug that was causing comment caching to be slow.

= 3.1 =
`Dev Time: 33hrs`
* Important: I highly recommend using "v2 only", as it is, by far, the most feature-filled. If you have old comments, you can use "Display both v1 and v2 comments"
* Issue: If you see `Warning: http://example.com/example_post is unreachable.`, [make sure your app settings are correct](http://on.fb.me/myappsettings) (enter `http`&shy;`://example.com/` for "Site URL" and `example.com` for "Site Domain", note the lack of http or a trailing slash, this is important)
* Feature: Like button integrated into plugin. Enable on settings page. You can fully customize it there as well.
* Feature: Like button can also be added to the top or bottom of each post on the site's main page (same "like" count as the one in comments)
* Feature: Comment count for 'v2 only' comments now displayed. Customizable on plugin's settings page.
* Settings: Reorganized settings page to make clear what applies to which version of facebook comment system
* Bugfix: Users should no longer see "Fatal error: Cannot use object of type WP_Error as array in wp-content/plugins/facebook-comments-for-wordpress/facebook-comments-admin.php on line 71"
* Bugfix: "Comments Closed" should no longer display inappropriately
* Bugfix: The 'delete' link on the dashboard recent comments widget is functional again
* Bugfix: A request to facebook that times out no longer incorrectly asserts that the application ID is incorrect
* Bugfix: No longer dies if facebook is unreachable (i.e., no more "Uncaught CurlException: 6: [...] name lookup timed out thrown on line 622")
* Bugfix: ...and no more "Uncaught CurlException: 1: [...] thrown on line 519"
* Bugfix: Activation should no longer be slow on sites with many comments
* Bugfix: Other small edge case bug fixes

= 3.0.2.2 =
`Dev Time: 18hrs`
* To see what facebook has changed/removed in v2, please read this: http://bit.ly/fbc3_changes. Briefly, gone is custom css, dark site, like button. If you want these, select "v1 only" (the default) on the settings page.
* IMPORTANT: WRITE DOWN YOUR XID BEFORE INSTALL THIS. This should be completely unnecessary, but it's just a wise precaution to take.
* Added a notice in the plugin settings which displays your XID from 2.1.2 or before.
* Now displays "Comments Disabled" if comments are disabled for a page/post
* Bugfix: Fixed a conflict with a global variable which was causing the plugin to not load on certain sites.
* Bugfix: The visual editor should work again.
* Bugfix: Those who were unable to activate the plugin should now be able to (see next option).
* Option: Ability to disable comment caching (disabled by default).
* Option: Ability to show only v2 comments. See details on option page.

= 3.0.2 =
* Updated to handle the way WP3.1 updates plugins. see: [this link](http://bit.ly/wp3_1noupdate)

= 3.0.1 =
* Bugfix: Fixed a mistake where settings (including old app ID, secret and xid) weren't being copied from previous installations.
* Feature: Added setting to hide Dashboard Recent Comments admin widget.
* See a demo of facebook's new comment system here: http://bit.ly/fknVz8

= 3.0.0 =
`Dev Time: 41hrs`
* Upgraded to use the latest method of getting facebook comments, which means, THREADED COMMENTS! Yay!
* Option: Ability to display recent facebook comments as a widget
* Option: Ability to moderate facebook comments from dashboard
* Both of which can be styled via the stylesheet located in wp-content/plugins/facebook-comments-for-wordpress/css/facebook-comments-widgets.css
* Bugfix: Changed jQuery call to fix some conflicts users were having with other jQuery-using plugins (such as the fb like plugin)
* Removed dependency on cURL. Now uses wp_remote_get. (note: facebook.php still uses cURL)
* For a complete overview of changes, see http://we8u.com/fbc3

= 2.1.2 =
* Option: Ability to uncheck the **Post comment to my Facebook profile** box by default
* Bugfix: Pre-activation checks have been converted to warnings (if you receive a `Parse error` when activating, please ensure you're running PHP v5.0.0 or higher on your server)

= 2.1.1 =
* Bugfix: Replaced all `file_get_contents()` instances with cURL calls (since some web servers don't allow file fetching by URL for security reasons)
* Bugfix: Combined comment counts now work when comments are included manually (as long as the option is checked)
* The plugin now checks your PHP version (must be v5.0.0 or greater) and ensures you have the cURL extension installed before activating

= 2.1 =
* Bugfix: Removed the option to set widths as a percentage because the JavaScript was breaking the plugin for almost everyone (no more multiple inclusions)
* Bugfix: Switched from PHP's default mail() function to WordPress' built-in wp_mail() function for sending email notifications
* Bugfix: Removed JavaScript logging to ensure the plugin works in Firefox and IE again (these browsers do not have `console.log` defined unless Firebug is installed)
* Your current XID will now be emailed to you when you deactivate the plugin (this allows you to retrieve your site's comments should you ever activate the plugin again)

= 2.0 =
* Option: Send email notifications to the site admin whenever a Facebook comment is posted
* Option: Ability to load the JavaScript SDK the old way (for those of you who experienced issues with v1.6)
* Option: Ability to set the comment box width to `100%`
* Bugfix: Whitespace is now trimmed from the application ID, the application secret, all CSS styles and the XID to prevent loading issues
* Bugfix: Links on the plugin settings page have been updated to point to the correct information on the website now
* Bugfix: Cleaned up various parts of the code (no more PHP notices)
* Comment counts are now cached (no more slow load times on the main page). Depending on the number of posts you have on your site, it may take a few moments to activate the plugin because it retrieves the Facebook comment count for every post during activation for caching
* Added both PHP and JavaScript error logging to make troubleshooting easier
* Both a Facebook application ID **and** an application secret are required for the plugin to work now

= 1.6 =
* Comment inclusion code is now far more lightweight
* Facebook and WordPress comments are now counted together

= 1.5.2 =
* Bugfix: WordPress commenting form should now be properly hidden for most themes
* Bugfix: `type` attribute is now set in the script inclusion (so older browsers will render it properly)

= 1.5.1 =
* Bugfix: Fixes the bug where hiding the WordPress comments caused errors in `foreach()` loops on certain themes
* Moved all stylesheets to `css/` folder and all images to `images/` folder for better organization

= 1.5 =
* Option: WordPress comments can be hidden on pages/posts where Facebook comments are enabled
* Option: Like button can be hidden
* Option: `Facebook Social Plugins` text and icon is hidden
* Option: Custom stylesheet for darker websites can be included (as a result, ability to reference your own custom stylesheet was removed)
* Bugfix: Comments now render properly in Internet Explorer (due to `FBML` reference)
* Added `title` and `url` attributes to the `<fb:comments>` tag so the Like button links to the correct page when clicked
* Facebook comments can now be linked to by appending `#facebook-comments` to the end of a post/page's URL
* Support for 100+ languages is now available (including Arabic, Hebrew, Spanish and all other requested languages)

= 1.4.1 =
* Bugfix: WordPress comments are no longer hidden when the Pages only or Posts only options are selected

= 1.4 =
* Option: Include comments on pages only, posts only or both
* Tested and works properly with WordPress 3.0

= 1.3 =
* Bugfix: Settings/XID are no longer lost when upgrading
* Bugfix: Anonymous posting now works properly
* Option: Allow user to hide the `Facebook comments:` title
* Added `Settings` link to plugin's action links on the `Plugins` page
* Redesigned settings page
* Refactored code to prepare for next release

= 1.2 =
* Bugfix: Facebook comments will be hidden on posts on which WordPress comments are disabled
* Bugfix: Facebook comments are retained through upgrades (you **must** set a XID to keep your comments)
* Feature: add Facebook comments anywhere in your theme by manually inserting `<?php if (function_exists('facebook_comments')) facebook_comments(); ?>` where you'd like them to show up
* Option: Change `Facebook comments:` title to anything you want
* Option: Allow user to reverse the order of the Facebook comments so they're in chronological order (like WordPress comments)
* Option: Allow removal of the grey box behind the composer
* Option: Allow use of external stylesheet to alter the appearance of the Facebook comments section
* Option: Receive Facebook notifications whenever someone posts a comment
* Option: Uncheck `Post comment to my Facebook profile` box by default
* Assorted code maintenance

= 1.1 =
* Fixed bug: Plugin's settings are no longer reset/removed when activating/deactivating other plugins
* New option: Ability to hide the Facebook comments box without having to deactivate the plugin (in case you want to keep
  your settings)
* Minor style changes

= 1.0 =
* Initial release

== Upgrade Notice ==

= 3.1.3 =
Option to change style for dark sites for v2 users. Fixed issue causing plugin to be slow/crash for some people.

= 3.1 =
`{33hrs}` See http://j.mp/fbc-3_1. Lots of stuff. You're gonna want this update. Integrated like button, v2 comment count, bugfixes. Upgrade. No, really, do it.

= 3.0.2.2 =
* Upgrade, then pray...
* If you're using any 3.0.x version, this update resolves most issues with those versions.
* Multisite users, this may or may not work for you. If you have it installed on a WP MS site, drop me a line at fbc-multisite@we8u.com, if it's working, or even if it isn't.
* If you have used 2.1.2 or earlier on your site, then the XID from that version will display as a notice on the settings page (wp-admin/options-general.php?page=facebook-comments). This is just a precaution, everything should load automatically
* See changelog for more.

= 3.0.2 =
This update does the same thing as deactivating then reactivating 3.0.1. The reason for this update is that WP3.1 changed the way plugins update. see: http://bit.ly/wp3_1noupdate

= 3.0.1 =
This update will bring back your xid and fix any other problems you may have had with settings when upgrading to 3.0.0. Sorry for the trouble.

= 3.0.0 =
This update adds a few bug fixes and enhancements, as well as the option to use facebook's new comment system, which enables threading and many other features. Also included in this update are recent comment widgets and the ability to moderate comments on the Dashboard. Note, facebook's new v2 comments are somewhat buggy, see: http://we8u.com/fbc3

= 2.1.2 =
This update adds an option to uncheck the Post comment to my Facebook profile box by default, as well as changing the pre-activation checks to notices to fix the activation issues some people were having. (If you receive a Parse error when activating, please ensure you're running PHP v5.0.0 or higher on your server.)

= 2.1.1 =
This update replaces all file_get_contents() instances with cURL calls. This should bring the plugin back to a healthy state for everyone who doesn't have file fetching by URL enabled on their web server (which was a surprising number of people). Combined comment counts now work when the comments are included manually as well.

= 2.1 =
This update fixes a bug that caused the plugin to break in Firefox, as well as a bug that caused the comments to be included multiple times on some themes. It also removes the width as a percentage feature because it crippled the plugin for nearly everyone.

= 2.0 =
This update introduces both comment count caching (no more slow load times on the main page) and email notifications whenever a Facebook comment is posted. It also includes an option to load the JavaScript SDK the old way (for those of you who experienced issues with v1.6) and an option to set the comment box width to 100%.

= 1.6 =
This update introduces the highly-anticipated combined comment counts feature.

= 1.5.2 =
This update fixes a bug where the WordPress commenting form couldn't be hidden.

= 1.5.1 =
This update fixes a bug where hiding the WordPress comments caused errors with `foreach()` loops.

= 1.5 =
This update provides options to hide the Like button and to hide the WordPress comments section on pages/posts
where Facebook comments are enabled. The comments also render properly in Internet Explorer now.

= 1.4.1 =
This update provides a simple bugfix where WordPress comments were being hidden if the Pages only or Posts only
option was selected.

= 1.4 =
This update ensures compatibility with WordPress 3.0, and also provides an option to include the comments on pages
only, posts only or both.

= 1.3 =
This update adds the option to remove the `Facebook comments:` title, fixes a bug where settings are lost, allows
anonymous posting and provides a brand new configuration page.

= 1.2 =
This update fixes a bug where the Facebook comments are not consistent across upgrades. Also provides new options.

= 1.1 =
This update fixes a critical bug where the plugin's settings are reset or removed every time any other plugin is
activated/deactivated. Also provides new options.

== Known Issues ==

For a short list of known issues, please refer to the official website at http://we8u.com/facebook-comments/#issues.

== Upcoming Features ==

For a list of upcoming features, please refer to the official website at http://we8u.com/facebook-comments/#upcoming.

== Screenshots ==

1. The Facebook commenting box, complete with comments.
2. Anonymous posting for users without a Facebook account.
3. Using a custom stylesheet.
4. The plugin settings page.
5. Recent Comments widget
6. Recent Comments widget settings
7. Dashboard recent comments
