=== SEO Facebook Comment ===

Contributors: bemcapaz

Donate link: --//--

Tags: comments, facebook, facebook comments, seo, facebook seo, post, plugin, page, google, facebook open graph, open graph, seo facebook comments, facebook plugin, wordpress facebook plugins

Requires at least: 2.9

Tested up to: 3.3.2

Stable tag: 1.4.5.1

This plugin will insert a Facebook Comment Form, Open Graph Tags and ALSO insert all Facebook Comments into your Wordpress Database for better SEO.


== Description ==


<strong>What This Plugin Does?</strong>

SEO Facebook Comments embeds a Facebook Comment Form on your blog and also looks at each of your blog posts searching for Facebook Comments already posted. All new found comments will be added to Wordpress Database.

Remember: <strong>You don't need to use any other Facebook Comment plugin</strong> with this one, SEO Facebook Comments will do all that is needed for you.

<strong> Why this is so Good </strong>

Among many advantages, you will have all your Wordpress Comments widgets and plugins still working since all the comments will also be at your database.

Also, even if Facebook goes down or slow it won' affect the loading of your site content.

<strong>And what is the SEO benefit?</strong>

Normally the Facebook comment system is embed into your page through an iframe. Because of that Google can't read those comments or associate then with your page.

This plugin changes all that by adding and loading all the comments on your page through your Wordpress Database like the rest of your site.

<strong>It will not hurt my server performance?</strong>

What makes this plugin shine is that it is very low server resources intensive. It will search for Facebook Comments specific to blog posts
only when those posts are loaded. This will save your server from any stress situation or overload.

<strong>One last thing... Incredible Easy to Install</strong>

All you need to do is enable the plugin, set its configuration with facebook (app id, secret and admin id) and it will already start adding all the facebook comments
to your Wordpress while the users visit your blog posts pages :)

== Screenshots ==

1. How it looks on the Theme to the user
2. The Plugin Installation View for the Admin
3. Plugin Admin Configuration View

== Installation ==


1. Upload `seo-facebook-comments` folder to the `/wp-content/plugins/` directory
2. Activate the plugin through the 'Plugins' menu in WordPress
3. Configure the Options of the plugin (App Id, App Secret and Admin E-mail are mandatory)
4. Profit :)


== Frequently Asked Questions ==

= How do I setup a Facebook App =
Everything regarding this question can be found here
[How to Create a Facebook App](http://www.plulz.com/how-to-create-a-facebook-app "How to Create a Facebook App")

= How do I find my Facebook User ID =
Everything regarding this question can be found here
[How to Create a Facebook App](http://www.plulz.com/how-to-get-my-facebook-user-id "How to get my Facebook User ID")

= How do I find my Language Code to Configure the APP =

Here is a list with many available languages in Facebook
[Facebook Language Codes](http://www.plulz.com/facebook-language-codes)

= What the message " Warning: http://somelink is unreachable. " Means?
It mean's that Facebook can't find the page you're trying to use the SEO Facebook Comment. The reasons that could possibly lead to this are:
* You haven't correctly configured the APP ID or APP SECRET
* Facebook can't find the Host/Link of your page (using a LOCAL SERVER for example)
* You didn't correctly configured all the necessary options in the http://facebook.com/developers page

= It's normal that my comments appears only after some refreshes? =

Yes, in order to avoid excessive memory and server usage this plugins only updates the pages comments after someone loads that specific page.

So if someone update the page with a comment NOW and someone else opens that page the comment will not appear to that user yet. It will, however, appear normally on the Facebook comments box).

Loading a page will only make the Plugin sees that there is a new comment and that it should be added to the database, so in the next reload (2nd one) the comment will already appears at the page, if auto-approved or goes to the line of approval from the Admin.

= How SEO Facebook Comments keep track of the already added comments? =

The plugin uses a table that it creates (normally wp_comments_fbseo, depending on the prefix you used) to keep track of all the added comments and also the facebook users that added that comment.

= So what happens when I Remove this plugin and Reinstall it? =

On uninstall this plugin won't remove that table from database in order to avoid duplicating all the comments on a future re-install.

However you can access your database and manually remove the wp_comments_fbseo table, but keep in mind that it can cause you a lot of problems if you Reinstall this plugin later since it will duplicate all the Facebook Comments already added to your Wordpress Database.

== Changelog ==

= 1.4.5.1 =

* <strong>TWEAK</strong> The Sharing link defaults to false now

= 1.4.5 =

* <strong>FIXED</strong> Comments are saved/retrieved through the page permalink, and not by it's id
* <strong>TWEAK</strong> Updated Javascript SDK

= 1.4.4 =

* <strong>FIXED</strong> Added a validation in order to show facebook comments only on published posts @ thanks Marcin Pietrzak
* <strong>FIXED</strong> a curl call, pointing to the correct link now
* <strong>FIXED</strong> Absolute link with ID to Open Graph tags, avoiding facebook losing track of it if the permalink changes @ thanks again to Marcin Pietrzak
* <strong>FIXED</strong> Now the Admin open graph tag will output only if there is a valid admin ID (thus avoiding OG errors)

= 1.4.3 =

* <strong> FIXED </strong> many compatibility issues beetween the plugin and some php servers
* <strong> FIXED </strong> more compatibility issues beetween the plugin and some Wordpress installations
* <strong> FIXED </strong> color scheme bug, dark color scheme wasn't working
* <strong> TWEAK </strong> Added extra PHP Classes validations to avoid further compatibility issues


= 1.4.2.2 =

* <strong> FIXED </strong> A new validation to avoid compatibility issues with wordpress versions before 2.9
* <strong> FIXED </strong> Some issues with Windows Servers.

= 1.4.2.1 =

* <strong> FIXED </strong> Removed a invalid hook that was causing a PHP Warning

= 1.4.2 =

* <strong> TWEAK </strong> The Open Graphs are now added in a smarter way and with more information
* <strong> TWEAK </strong> Added a help link to configure the Facebook App Language
* <strong> FIXED </strong> Problems with the layout color selection
* <strong> FIXED </strong> Minor issues with the checkboxes in admin pages
* <strong> FIXED </strong> Minor issues with the Facebook Class
* <strong> FIXED </strong> A bug that could happen in PHP running on Windows environment

= 1.4.1 =

* <strong> FIXED </strong> Language is now correctly set for the facebook app again
* <strong> FIXED </strong> Some problems that were occurring related to checkbox fields
* <strong> FIXED </strong> Open Graphs are now correctly added only when the user chooses to
* <strong> FIXED </strong> No option are lost now when the plugin is deactivated/reactivated

= 1.4 =

* <strong>Tested</strong>  Tested and Working on Wordpress 3.3
* <strong>Tweak</strong> More information about the comments from Facebook are now stored in the database
* <strong>Tweak</strong> Many code improvements
* <strong>Tweak</strong> Better positioned in the Admin WP Menu to allow easier access to the configuration page
* <strong>FIXED</strong> Some changes on Facebook classes to further avoid conflicts with other Wordpress Plugins
* <strong>FIXED</strong> Now the Facebook App configurations won't be lost after the plugin is upgraded

= 1.3.2 =

* <strong>FIXED</strong> Warnings that were being throw to users who are using Windows Servers to Host Wordpress
* <strong>FIXED</strong> Facebook implementation class name changed and removed some unused methods
* <strong>ADDED</strong> Extra validation to avoid conflicts with other plugins using Facebook PHP SDK
* <strong>Tweak</strong> Minor css changes

= 1.3.1 =

* <strong>FIXED</strong> The comments are now being hidden again
* <strong>FIXED</strong> Fixed a issue regarding the loading of the Facebook Comment with IE versions bellow 9
* <strong>FIXED</strong> Open Graph tags are now optionally embed in the page,  they were conflicting with some other plugins
 that would also create Facebook Open Graph Tags.

= 1.3 =

* <strong>Updated</strong> All the files of Facebook PHP SDK
* <strong>FIXED</strong> The plugin correctly detects the wordpress installation prefixes before creating its database
* <strong>Tweak</strong> Major Admin pages re-design in the layout
* <strong>Tweak</strong> Added some extra validation to avoid errors and bugs

= 1.2 =

* <strong>Fixed</strong> Now the <html> tags are correctly sanitized before being inserted in the database
* <strong>Tweak</strong> Removed two self-made code in favor of the function wp_insert_comment (does more, better and with less code)
* <strong>Tweak</strong> New method to verify if the comment already exists in the SEO Facebook Comment table

= 1.1 =

* <strong>FIXED</strong> Validate to prevent a Fatal Error if there's another plugin also using the Facebook Class (from Facebook PHP SDK), instead of appending it again it will only instantiate it.
* <strong>FIXED</strong> The option to Hide Wordpress Comments are now working.
* <strong>FIXED</strong> Now the options from the plugin are removed from wp_options table when the plugin is uninstalled.
* <strong>Tweak</strong> Changed some texts to better guide the user in the Admin Configuration Page.
* <strong>Tweak</strong> Better commenting and tweaks on code to improve readability for developers.

= 1.0 =

* Initial Release


== Upgrade Notice ==

= 1.4.5.1 =

* Tweak. Upgrade Highly Advisable

= 1.4.5 =

* Fixes and Tweaks. Upgrade Highly Advisable

= 1.4.4 =

* Fixes and Tweaks. Upgrade Highly Advisable

= 1.4.3 =

* Fixed many integration issues. Upgrade Highly Advisable.

= 1.4.2.2 =

* Fixed issues with old wordpress versions and windows servers. Upgrade Highly Adisable.

= 1.4.2.1 =

* Fixed a invalid hook that was causing php warnings. Upgrade Highly Advisable.

= 1.4.2 =

* Fixed many issues from version 1.4.1. Upgrade Highly Advisable.

= 1.4.1 =

* Fixed many issues from version 1.4. Upgrade Highly Advisable.

= 1.4 =

* Code improvement for better compatibility and usability. Upgrade advisable.

= 1.3.2 =

* Fixed issues that was causing the plugin to crash on Windows Servers and could conflict with other plugins. Upgrade is Highly Advisable.

= 1.3.1 =

* Fixed severall issues regarding integration with other plugins and IE versions. Upgrade is Highly Advisable.

= 1.3 =

* Huge admin interface redesign provide far better support and easier integration. Upgrade is Highly Advisable.

= 1.2 =

* Fixed a major bug that allow HTML code to be inserted in the database/page. Upgrade is Highly Advisable.

= 1.1 =

* Fixes two major bugs, an Upgrade is highly advisable. One of the bugs was triggered by requiring the Facebook PHP Class without checking if it already existed.

= 1.0 =

* No upgrades so far


-- 
Fabio Zaffani
