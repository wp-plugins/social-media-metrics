<?php
/*
Plugin Name: Social Media Metrics
Plugin URI: http://wordpress.org/extend/plugins/social-media-metrics/
Description: Displays scores from <a href="http://klout.com">Klout<a> and <a href="http://peerindex.net">PeerIndex<a/> in widget.
Author: Steven Stern
Version: 0.5
Author URI: http://mywordpress.sterndata.com/
*/
/*  Copyright 2011 Steven D. Stern  (email : steve@sterndata.com)

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License, version 2, as 
    published by the Free Software Foundation.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/

/**
 * SocialMediaMetrics Class
 */
class SocialMediaMetrics extends WP_Widget {
    /** constructor */
    function SocialMediaMetrics() {
        parent::WP_Widget(false, $name = 'SocialMediaMetrics');	
    }

    /** @see WP_Widget::widget */
    function widget($args, $instance) {		
        extract( $args );
        $title = apply_filters('widget_title', $instance['title']);
        $twitter_id = apply_filters('twitter_id', $instance['twitter_id']);
        ?>
              <?php echo $before_widget; ?>
                  <?php if ( $title )
                        echo $before_title . $title . $after_title; ?>
               <?php   block_peerIndex($twitter_id); ?>
              <?php echo $after_widget; ?>
        <?php
    }

    /** @see WP_Widget::update */
    function update($new_instance, $old_instance) {				
	$instance = $old_instance;
	$instance['title'] = strip_tags($new_instance['title']);
	$instance['twitter_id'] = strip_tags($new_instance['twitter_id']);
        return $instance;
    }

    /** @see WP_Widget::form */
    function form($instance) {				
        $title = esc_attr($instance['title']);
        $twitter_id=esc_attr($instance['twitter_id']);
        ?>
         <p>
          <label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:'); ?></label> 
          <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>" />
        </p>
        <p>
          <label for="<?php echo $this->get_field_id('twitter_id'); ?>"><?php _e('Twitter ID:'); ?></label> 
          <input class="widefat" id="<?php echo $this->get_field_id('twitter_id'); ?>" name="<?php echo $this->get_field_name('twitter_id'); ?>" type="text" value="<?php echo $twitter_id; ?>" />
          <br><i>Enter a Twitter ID without the "@"</i><br><br>
        Your scores will be more accurately reported in you have created a profile on <a href="http://klout.com">Klout<a> and <a href="http://peerindex.net">Peerindex</a>.
        </p>
        <?php 
    }

} // class SocialMediaMetrics

// register SocialMediaMetrics widget
add_action('widgets_init', create_function('', 'return register_widget("SocialMediaMetrics");'));


// main work function
function block_peerIndex($twitter_id) {
    
  //  echo "<pre>Debug: Twitter ID is ",$twitter_id,"\n</pre>";
    // Klout score
    echo '<p align="center" style="margin-top: 10px;">';
    echo '<iframe allowtransparency="true" frameborder="0" height="59px" scrolling="no" src="http://widgets.klout.com/badge/'.$twitter_id.'?size=s" style="border:0;" width="120"></iframe></p>'."\n";
    
    // PeerIndex score
    $url = "http://api.peerindex.net/1/profile/show.json?id=".$twitter_id."&api_key=1f38f3ddfd21f6936e1449c703eebd62";

    $str = file_get_contents($url);
    $json = json_decode (  $str, true );
    if (isset($json['error'])) {
    	  echo "PeerIndex APA Error: " ,$json['error'];
    	  return false;
    	}

    if (strlen($json['peerindex'])!=0) {    
      echo "<p style=\"text-align:center;\">";
      echo "<a href='".$json['url']."'><img src='http://a0.twimg.com/profile_images/1162568983/peerindex_bigger-1_bigger.png'	border=0 width=73 height=73 align=center style=\"margin:5px;border:none;\"></a>\n";
      echo  "<br>",$json['name'],"'s (<a href='http://twitter.com/".$json['twitter'],"'>@",$json['slug'],"</a>) <a href='http://peerindex.net/".$json['slug']."'><b>PeerIndex</b></a> is ";
      echo "<b>",$json['peerindex'],"</b><br>\n";    
      echo "</p>\n";
      return true;
    }
}
