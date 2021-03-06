=== Plugin Name ===
Contributors: steve@sterndata.com
Tags: Twitter, PeerIndex, Klout, Metrics, Statistics, Stats
Requires at least: 2.8
Tested up to: 3.3.1
Stable tag: 1.9.1

Displays scores from Klout and PeerIndex in a widget. 

Do not download. Effective April 1, 2013 both Klout and Peerindex have changed their APIs.  As a result, this plugin will not work.  The plugin is left here in case anyone wants the code to build something that works with the new APIs.

== Description ==
Do not download. Effective April 1, 2013 both Klout and Peerindex have changed their APIs.  As a result, this plugin will not work.  The plugin is left here in case anyone wants the code to build something that works with the new APIs.
---
Displays scores from <a href="http://klout.com">Klout</a> and <a href="http://peerindex.net">PeerIndex</a> in widget.

Set up accounts on Klout and PeerIndex *before* activating the plugin.

Follow me on Twitter <a href="http://twitter.com/sds52">@sds52</a>.

== Installation ==

1. Upload the files (social-media-metrics.php, README.TXT) to the `/wp-content/plugins/social-media-metrics` directory
2. Activate the plugin through the 'Plugins' menu in WordPress
3. From APPEARANCE -> WIDGETS, drag the widget to an appropriate location. Enter your twitter ID
   without the "@", and optionally a title for the widget to display.

== Frequently Asked Questions ==

= I set up a PeerIndex profile, but nothing is showing =

Sometimes, it takes a while for PeerIndex to calulate the first score.

If your score on the PeerIndex website is "N/A", the plugin will not display any information for PeerIndex.

= Can the Klout information displayed be changed? =

Yes, in a later version. This is the first version using the new Klout API.

= Can other PeerIndex items be displayed? =

Yes!  Send me a note and I'll add it. Also, if you have suggestions on how to format the PI display,
please let me know.

== Screenshots ==
1.  This is the plugin with the widget title set to "Social Metrics".

== Changelog ==
= 1.9.1 =
Do not download. Effective April 1, 2013 both Klout and Peerindex have changed their APIs.  As a result, this plugin will not work.  The plugin is left here in case anyone wants the code to build something that works with the new APIs.


= 1.9 =
* Added caching for Peerindex, too.  Cache set to 12 hours
* updated screenshot

= 1.8 =
* cache klout scores so I don't go over the 10,000 per day limit on the api key. Cache set to 12 hours.

= 1.7 =
* change link to Klout to look like Peerindex link
* add error checking for Klout and fail gracefully

= 1.5 =
* Using the new Klout API to fetch the Klout score

= 1.4 =
* add option to display or not display Klout and PeerIndex scores.
* default both to be displayed

= 1.3 =
* minor spelling error in error message (APA instead of API)
* If over the limit on PI calls, display a link to the PI profile

= 1.2 =
Fail even more gracefully if PeerIndex is unavailable.

= 1.1 =
Override the full name supplied by PeerIndex if you'd rather use that. For example, my feed uses "Steven Stern", but I'd like it to use "Steve" here, to be consistent with my name on my blog.

= 1.0 =
If PeerIndex API is not available, fail gracefully

= 0.9 =
Corrected README for .08 to match what the code does.

= 0.8 =
* Added a define to allow current version number to be displayed in a comment
* Supply PeerIndex logo as part of plugin
* Add option to override theme color for PeerIndex number.  Defaults to blank. If blank or an invalid code is supplied, the theme's color applies

= 0.7 =
Unlinked PeerIndex score number.  The color got all messed up because the styles for links
got in the way.

= 0.6 =
Put PeerIndex score on top of PeerIndex logo

= 0.5 =
Removed unnecessary comments from code - no other changes

= 0.4 =
Added @ indicate a twitter ID in the PeerIndex link

= 0.3 =
* first released version
