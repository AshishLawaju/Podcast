=== Podcast Subscribe Buttons ===
Contributors: secondlinethemes
Donate link: https://secondlinethemes.com/
Tags: podcast, subscribe, podcasting, buttons, social, blocks, podcasts, follow
Requires at least: 3.8
Tested up to: 5.8
Requires PHP: 5.7
Stable tag: trunk
License: GPLv3 or later
License URI: https://www.gnu.org/licenses/gpl-3.0.html

Add beautiful podcast subscribe buttons anywhere.

== Description ==

This plugin helps to easily include 60+ custom and Podcast-specific Subscribe (follow) Buttons anywhere within your site with a simple shortcode. 
The Podcast Subscribe Buttons are intended for podcasters and therefore the list of companies/icons only include podcast-related companies. (Need a new icon? Let us know!)

With the Podcast Subscribe Buttons plugin, you could display links to subscribe to your podcast across various external podcast platforms, those links may include regular links to your pages on external podcast platforms, direct links to RSS feeds, or URI links to open directly in an external application. 

There are a few ways to add subscribe buttons with the plugin.
First, you can use the custom block in any page/post that uses the new ("Gutenberg") WordPress editor. 
Also, you can create new "Subscribe Button" sets via the menu that appears in your WordPress dashboard (under "Tools -> Podcast Subscribe Buttons"). Simply adjust the default display settings, add links, and display the button via a shortcode anywhere within your site. See example below:
`[podcast_subscribe id="1789"]`

Lastly, you can add the buttons directly via your theme or via a custom Elementor widget in case you use one of our [Podcast Themes](https://secondlinethemes.com/themes)

== About SecondLineThemes ==

SecondLineThemes is creating WordPress themes and plugins for podcasts. We are dedicated to help podcasters with their WordPress sites. To read more about us please check our website:
[https://secondlinethemes.com](https://secondlinethemes.com)


== Installation ==

1. Upload the plugin files to the `/wp-content/plugins/podcast-subscribe-buttons` directory, or install the plugin through the WordPress plugins screen directly.
2. Activate the plugin through the 'Plugins' screen in WordPress.
3. Add new subscribe buttons via the 'Tools -> Podcast Subscribe Buttons' section in your WordPress admin panel. (or directly via the Block Editor)
4. Add the shortcode anywhere within your site. (example: [podcast_subscribe id="1789"] )
5. (Optional) Add an attribute (type="inline" / "modal" / "list") to override the button type on different locations. (example: [podcast_subscribe id="1789" type="inline"] )


== Frequently Asked Questions ==

= Do you support any additional podcast platforms or icons? =
Sure. If you feel something is missing, please reach out and we will ensure to add in a future update.

== Screenshots ==

1. Display a Modal (Pop-Up Lightbox) with a list of subscribe icons.
2. Inline buttons that can fit on any page.
3. Show a list of buttons on your sidebar or within posts and pages.

== Changelog ==

= 1.4.1 =
* Fix: Saved shortcode button types were not applied properly.

= 1.4.0 =
* Big Update!
* Added a custom block to build / add podcast buttons in the block editor.
* Replaced some icons (whenever possible) from PNG files to SVG files for better image quality.

= 1.3.0 =
* Resolved conflicts with other plugins on the shortcode column.

= 1.2.9 =
* Added new icons - Gaana, PodcastIndex, Podfriend, Swoot, Vurbl.
* Replaced icons - Anchor.fm and Amazon Music were updated.
* Added alt tags for all icons for better accessibility.
* Updated CMB2 to latest version.
* Updated compatibility with WP 5.7.x

= 1.2.9 =
* Added new icons - Gaana, PodcastIndex, Podfriend, Swoot, Vurbl.
* Replaced icons - Anchor.fm and Amazon Music were updated.
* Added alt tags for all icons for better accessibility.
* Updated CMB2 to latest version.
* Updated compatibility with WP 5.7.x

= 1.2.8 =
* Updated compatibility with WP 5.6.x

= 1.2.7 =
* Added new icon - Amazon Music (Amazon Podcasts).
* Moved plugin settings link to 'Tools -> Podcast Subscribe Buttons'.
* Replaced assets.

= 1.2.6 =
* Fixed issue with MyTunerRadio icon (issue with last update).

= 1.2.5 =
* Added new icon - fyyd.de.
* Fixed issue with MyTunerRadio icon.

= 1.2.4 =
* Added new icons - Podfan, Patreon, Podbay, Radio.com, Himalaya.com and iVoox.

= 1.2.3 =
* Added compatibility tag for WordPress 5.4.
* Updated minimum PHP version to 5.6.

= 1.2.2 =
* Added We.fo, myTuner Radio, Podtail, The Podcast App, Owltail.
* Updated CMB2.

= 1.2.1 =
* Rolled back to CMB2 2.6 until issues with CMB2_Hookup class/file names resolved.

= 1.2.0 =
* Added Podkicker, RSSRadio and Podcast Republic icons.
* Updated CMB2 to latest version.

= 1.1.9 =
* Added Acast icon.

= 1.1.8 =
* Fixed Yandex Music icon.

= 1.1.7 =
* Added Vkontakte and Yandex.

= 1.1.6 =
* Added Pandora icon.
* Minor fix for responsiveness of the modal/pop-up on mobile devices.

= 1.1.5 =
* Added Listen Notes and Player.fm icons.
* Added support for the upcoming TwentyTwenty theme.
* Fixed layout issues with some themes.

= 1.1.4 =
* Added YouTube and Podcast Addict.
* Fixed issues of some links opening two new tabs.

= 1.1.3 =
* Fixed modal issue when the same button set was appearing more than once on the same page.

= 1.1.2 =
* Added back Radio Public!

= 1.1.1 =
* Added 8 new icons (Breaker, Podchaser, Laughable, Plex, Bullhorn, Podknife, Podcoin, RedCircle).
* Icons now sorted alphabetically for easier selection.
* Added a new layout option - Icons. (To show only icons. Can also override existing buttons via the shortcode type="icons")

= 1.1.0 =
* Added a new "Type" attribute (defaults to "null", can accept "inline" / "modal" / "list") to override the button type. (example: [podcast_subscribe id="1789" type="inline"] )
* Bumped compatibility to WordPress 5.2.

= 1.0.9 =
* Fixed list button styles.

= 1.0.8 =
* Updated compatibility with WordPress 5.1.
* Updated CMB2 to latest version.

= 1.0.7 =
* Added Anchor.fm and Radio Public icons.
* Added support for custom buttons with custom URLs.
* Updated CMB2 to latest version.

= 1.0.6 =
* You can now add multiple buttons and modals per page without conflicts.
* Spotify added as an exception protocol to support Spotify URIs.
* Removed Clammr from the icon list (it was shut down more than a year ago).

= 1.0.5 =
* Changed modal class to prevent theme conflicts.

= 1.0.4 =
* Fixed query conflict on pages/posts with comments. 
* Fixed CastBox icon.
* Added podcast.de icon.

= 1.0.3 =
* Compatibility with WordPress 5.0 and Gutenberg.

= 1.0.2 =
* Fixed unresponsive buttons.

= 1.0.1 =
* Added demo screenshots.
* Modified readme.txt file.
* Check if CMB2 is already installed.

= 1.0 =
* Initial Release.
