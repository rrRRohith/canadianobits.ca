=== Pagination by BestWebSoft - Customizable WordPress Content Splitter and Navigation Plugin ===
Contributors: bestwebsoft
Donate link: https://bestwebsoft.com/donate/
Tags: pagination, pagination block, custom pagination block, multiple navigation, multiple pages, navigation, next page, post pagination, pagination buttons, pagination plugin, improve pages navigation, paginate plugin
Requires at least: 5.6
Tested up to: 6.0
Stable tag: 1.2.2
License: GPLv3 or later
License URI: http://www.gnu.org/licenses/gpl-3.0.html

Add customizable pagination to WordPress website. Split long content to multiple pages for better navigation.

== Description ==

Simple plugin which automatically adds custom pagination to your WordPress website blog, search results, archive, category, tags, and author pages. Choose pagination type, position, and customize its appearance.

Improve navigation through your website content today!

[View Demo](https://bestwebsoft.com/demo-pagination-plugin/?ref=readme)

http://www.youtube.com/watch?v=TwAd3DWLGr8

= Free Features =

* Automatically add pagination to:
	* Home
	* Blog
	* Archive
	* Search results
	* Paginated posts/pages
* Compatible with:
	* [Gallery](https://bestwebsoft.com/products/wordpress/plugins/gallery/?k=8a6c514916efe4264d0732b86b82487f)
	* [Portfolio](https://bestwebsoft.com/products/wordpress/plugins/portfolio/?k=982e34e0a05371dc2dcca2a5fc535c1a)
* Add pagination via function to:
	* Comments PHP template
	* PHP files
* Choose pagination position:
	* Above the main content
	* Below the main content
	* Above and below the main content
	* Via function
* Display and customize Next/Previous arrows
* Display "Page X of Y" information
* Set numeric pagination display type:
	* Full (1,2,3,4,5,6)
	* Short (1,2...5,6)
* Hide pagination for:
	* Default
		* Posts (for standard WP themes)
		* On paginated post or pages
		* Comments
	* Custom pages
* Set pagination block width
* Add rel="nofollow" attribute
* Set pagination align:
	* Left
	* Center
	* Right
* Set margins for left and right align
* Customize pagination styles:
	* Hover color 
	* Background color
	* Current page background color
	* Text color
	* Current page text color
	* Border color
	* Border width and radius
* Add custom code via plugin settings page
* Compatible with latest WordPress version
* Incredibly simple settings for fast setup without modifying code
* Detailed step-by-step documentation and videos

> **Pro Features**
>
> All features from Free version included plus:
>
> * Choose pagination type:
> 	* Numeric (default)
> 	* Load More button
> 	* Infinite scroll
>	* Next/Previous buttons
> * Display "Load More" button after page loading
> * Compatibility with Divi [NEW]
> * Get answer to your support question within one business day ([Support Policy](https://bestwebsoft.com/support-policy/))
>
> [Upgrade to Pro Now](https://bestwebsoft.com/products/wordpress/plugins/pagination/?k=beef8d83cadcb70a8565e009a280f80c)

If you have a feature suggestion or idea you'd like to see in the plugin, we'd love to hear about it! [Suggest a Feature](https://support.bestwebsoft.com/hc/en-us/requests/new)

= Documentation & Videos =

* [[Doc] User Guide](https://bestwebsoft.com/documentation/pagination/pagination-user-guide/)
* [[Doc] Installation](https://bestwebsoft.com/documentation/how-to-install-a-wordpress-product/how-to-install-a-wordpress-plugin/)
* [[Doc] Purchase](https://bestwebsoft.com/documentation/how-to-purchase-a-wordpress-plugin/how-to-purchase-wordpress-plugin-from-bestwebsoft/)
* [[Video] Installation Instruction](http://www.youtube.com/watch?v=Xh0LjOSgxzs)

= Help & Support =

Visit our Help Center if you have any questions, our friendly Support Team is happy to help - <https://support.bestwebsoft.com/>

= Translation =

* French (fr_FR) (thanks to [Jean-Louis Cordonnier](mailto:jlcord2@wanadoo.fr) www.labosdebabel.org)
* German (de_DE)
* Portuguese (pt_PT) (thanks to [Antonio Carreira](mailto:antoniocarreira@streetdog.pt) www.streetdog.pt)
* Hebrew (he_IL) (thanks to [Rubb](mailto:hanan@mstudio.co.il))
* Russian (ru_RU)
* Ukrainian (uk)

Some of these translations are not complete. We are constantly adding new features which should be translated. If you would like to create your own language pack or update the existing one, you can send [the text of PO and MO files](http://codex.wordpress.org/Translating_WordPress) to [BestWebSoft](https://support.bestwebsoft.com/hc/en-us/requests/new) and we'll add it to the plugin. You can download the latest version of the program for work with PO and MO [files Poedit](http://www.poedit.net/download.php).

= Recommended Plugins =

* [Updater](https://bestwebsoft.com/products/wordpress/plugins/updater/?k=f471af6c58ecd7f550f0601416e4331f) - Automatically check and update WordPress website core with all installed plugins and themes to the latest versions.
* [Gallery](https://bestwebsoft.com/products/wordpress/plugins/gallery/?k=8a6c514916efe4264d0732b86b82487f) - Add beautiful galleries, albums & images to your Wordpress website in few clicks.
* [Portfolio](https://bestwebsoft.com/products/wordpress/plugins/portfolio/?k=982e34e0a05371dc2dcca2a5fc535c1a) - Create and add personal portfolio to your WordPress website. Manage and showcase past projects to get more clients.

== Installation ==

1. Upload the `pagination` folder to the `/wp-content/plugins/` directory.
2. Activate the plugin using the 'Plugins' menu in your WordPress admin panel.
3. You can adjust the necessary settings using your WordPress admin panel in "Pagination".

[View a Step-by-step Instruction on Pagination Installation](https://bestwebsoft.com/documentation/how-to-install-a-wordpress-product/how-to-install-a-wordpress-plugin/)

http://www.youtube.com/watch?v=Xh0LjOSgxzs

== Frequently Asked Questions ==

= Where can I find the settings to adjust the plugin work after activation? =

In the 'Plugin' menu you can find a link to the settings page.

= Can I replace the standard pagination in my theme? =

Yes, in the Hide pagination block you can choose any pagination to be displayed as well as to hide your theme`s standard pagination.

= How can I remove the custom pagination? =

In order to hide it, type a block class or block id into the text field in the Hide pagination block and check the "Custom" checkbox.

= I filled up all necessary settings, save the changes, but the custom pagination block did not appeared on some (or all) necessary pages. How can I fix it? =

Most likely that your theme was created incorrectly and it does not provide the needed functionality to display custom pagination block. Please, contact your support service (<https://support.bestwebsoft.com>) and we will help you to solve this issue.

= I have custom post types where I output the information via custom query to the database. How can I add the pagination block to this custom post type? =

It is necessary to add function <?php if ( function_exists( 'pgntn_display_pagination' ) ) pgntn_display_pagination( 'custom', $second_query ); ?> to the necessary place. In this function, specify the name of your custom query to the database instead of $second_query.

= How to display Pagination (Next/Previous buttons, Infinite scroll, "Load More" button) for posts in the Divi theme? =

1. Go to the Pagination Settings page;
2. Find "Posts selector" and set it to "#content-area div".

= How to display Pagination (Next/Previous buttons, Infinite scroll, "Load More" button) for posts in the Avada theme? =

1. Go to the Pagination Settings page;
2. Find "Posts selector" and set it to ".fusion-posts-container".

= I have some problems with the plugin's work. What Information should I provide to receive proper support? =

Please make sure that the problem hasn't been discussed yet on our forum (<https://support.bestwebsoft.com>). If no, please provide the following data along with your problem's description:

1. The link to the page where the problem occurs
2. The name of the plugin and its version. If you are using a pro version - your order number.
3. The version of your WordPress installation
4. Copy and paste into the message your system status report. Please read more here: [Instruction on System Status](https://bestwebsoft.com/documentation/admin-panel-issues/system-status/)

== Screenshots ==

1. Custom pagination block in the front-end - shorthand output.
2. Custom pagination block in the front-end with all page numbers.
3. Plugin settings in WordPress admin panel.

== Changelog ==

= V1.2.2 - 26.04.2022 =
* Bugfix : Deactivation Feedback fix.

= V1.2.1 - 22.03.2022 =
* Update : BWS Panel section was updated.
* Update : All functionality was updated for WordPress 5.9.

= V1.2.0 - 02.07.2021 =
* Update : BWS Panel section was updated.
* Update : All functionality was updated for WordPress 5.7.2
* PRO : Compatibility with Divi theme added.

= V1.1.9 - 03.03.2021 =
* Update : BWS Panel section was updated.
* Update : All functionality was updated for WordPress 5.6.2
* Bugfix : Compatibility with Gallery by BestWebSoft updated.
* Bugfix : Compatibility with Portfolio by BestWebSoft updated.

= V1.1.8 - 20.04.2020 =
* Update : All functionality was updated for WordPress 5.4.
* Update : BWS menu has been updated.

= V1.1.7 - 04.09.2019 =
* Update: The deactivation feedback has been changed. Misleading buttons have been removed.

= V1.1.6 - 17.06.2019 =
* Bugfix : Compatibility with Gallery by BestWebSoft has been fixed.
* NEW : The German language file has been added.

= V1.1.5 - 15.05.2019 =
* Update : BWS menu has been updated.
* PRO : The bug  with the infinite scroll and "Load More" button on paginated posts/pages has been fixed.

= V1.1.4 - 19.03.2019 =
* Update : All functionality was updated for WordPress 5.1.1.
* PRO : The bug with the infinite scroll and "Load More" button has been fixed.

= V1.1.3 - 29.01.2019
* Update : All functionality for WordPress 5.0.3 was updated.
* Bugfix : Fixed small bugs. 
* PRO : Buttons for non numeric pagination was added. 

= V1.1.2 - 18.09.2018 =
* Update : All functionality for WordPress 4.9.8 was updated.
* Pro : The bug with the infinite scroll has been fixed.

= V1.1.1 - 03.05.2018 =
* NEW : Ability to choose pagination hover color has been added.
* Update : The plugin settings page has been updated.
* Update : Hebrew language file has been added.

= V1.1.0 - 28.02.2018 =
* NEW : Ability to add "nofollow" attribute has been added.
* Pro : Ability to display "Load More" button after page loading has been added.

= V1.0.9 - 20.11.2017 =
* Bugfix : Settings Page displaying has been fixed.
* Bugfix : Pagination displaying has been fixed.

= V1.0.8 - 18.07.2017 =
* Update : All functionality for WordPress 4.8 was updated.

= V1.0.7 - 14.04.2017 =
* NEW : The French language file is added.
* NEW : The Portuguese language file is added.
* Bugfix : Multiple Cross-Site Scripting (XSS) vulnerability was fixed.

= V1.0.6 - 11.10.2016 =
* NEW : Ability to display pagination block automatically on paginated posts/pages has been added.
* Pro : "Load More" button pagination type.
* Pro : Infinite scroll pagination type.

= V1.0.5 - 20.07.2016 =
* NEW : Ability to disable plugin styles.
* Update : Color Picker was updated.
* Update : BWS panel section was updated.

= V1.0.4 - 19.04.2016 =
* NEW : Ability to use for custom post types with custom queries to the dababase.
* NEW : Ability to add custom styles.
* Bugfix : The conflict in the RSS feed was fixed.

= V1.0.3 - 30.12.2015 =
* Bugfix : Displaying pagination block on the archive page and multipages was fixed.
* Bugfix : The bug with plugin menu duplicating was fixed.

= V1.0.2 - 30.10.2015 =
* Update : BWS plugins section is updated.
* Update : We updated all functionality for wordpress 4.3.1.

= V1.0.1 - 09.07.2015 =
* NEW : Ability to restore settings to defaults.

= V1.0.0 - 20.05.2015 =
* NEW : We added the ability to configure the custom pagination block.
* NEW : The Russian and Ukrainian language files were added.
* Update : We updated all functionality for wordpress 4.2.2.

== Upgrade Notice ==

= V1.2.2 =
* Bug fixed.

= V1.2.1 =
* Usability improved.

= V1.2.0 =
* The compatibility with new WordPress version updated.
* New features added.
* Bugs fixed.

= V1.1.9 =
* The compatibility with new WordPress version updated.
* The compatibility with new Gallery version updated.
* The compatibility with new Portfolio version updated.
* Bugs fixed.

= V1.1.8 =
* The compatibility with new WordPress version updated.

= V1.1.7 =
* Usability improved

= V1.1.6 =
* Bugs fixed.
* New language added.

= V1.1.5 =
* Functionality  improved.
* Bugs fixed.

= V1.1.4 =
* Bugs fixed.
* The compatibility with new WordPress version updated.

= V1.1.3 =
* The compatibility with new WordPress version updated.
* New features added.
* Bugs fixed.

= V1.1.2 =
* Bugs fixed.
* The compatibility with new WordPress version updated.

= V1.1.1 =
* New features added.
* Usability improved.
* New language added.

= V1.1.0 =
* New features added.

= V1.0.9 =
* Bugs fixed.

= V1.0.8 =
* The compatibility with new WordPress version updated.

= V1.0.7 =
* New languages added.
* Bugs fixed.

= V1.0.6 =
* New features added.

= V1.0.5 =
* Functionality expanded.
* Usability improved.

= V1.0.4 =
Ability to use for custom post types with custom queries to the dababase. Ability to add custom styles. The conflict in the RSS feed was fixed.

= V1.0.3 =
Displaying pagination block on the archive page and multipages was fixed. The bug with plugin menu duplicating was fixed.

= V1.0.2 =
BWS plugins section is updated. We updated all functionality for wordpress 4.3.1.

= V1.0.1 =
Ability to restore settings to defaults.

= V1.0.0 =
We added the ability to configure the custom pagination block. The Russian and Ukrainian language files were added. We updated all functionality for wordpress 4.2.2.
