=== Plugin Name ===
Contributors: steve@sterndata.com
Tags: Twitter, PeerIndex, Klout, Metrics, Statistics, Stats
Requires at least: 2.8
Tested up to: 3.1.1
Stable tag: 0.8

 Displays scores from Klout and PeerIndex in widget.

== Description ==

Displays scores from <a href="http://klout.com">Klout</a> and <a href="http://peerindex.net">PeerIndex</a> in widget.

Set up accounts on Klout and PeerIndex *before* activating the plugin.  

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

Because Klout info comes from an iframe and there's no API, you see what
Klout provides.

= Can other PeerIndex items be displayed? =

Yes!  Send me a note and I'll add it. Also, if you have suggestions on how to format the PI display,
please let me know.

== Screenshots ==
1.  This is the plugin with the title set to "Social Metrics".

== Changelog ==
= 0.8 =
Added a define to allow current version number to be displayed in a comment
Supply PeerIndex logo as part of plugin - removes dependency it not changing on PI site
Add option to override theme color for PeerIndex number

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
