<?php
/*
Plugin Name: Social Media Metrics
Plugin URI: http://wordpress.org/extend/plugins/social-media-metrics/
Description: Displays scores from <a href="http://klout.com">Klout<a> and <a href="http://peerindex.net">PeerIndex<a/> in widget.
Author: Steven Stern
Version: 1.7
Author URI: http://mywordpress.sterndata.com/
*/

define ("SMM_VERSION","1.7");

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
               <?php   block_peerIndex($twitter_id,$instance); ?>
              <?php echo $after_widget; ?>
        <?php
    }

    /** @see WP_Widget::update */
    function update($new_instance, $old_instance) {
			$instance = $old_instance;
			$instance['title'] = strip_tags($new_instance['title']);
			$instance['twitter_id'] = strip_tags($new_instance['twitter_id']);
			$instance['my_name'] = strip_tags($new_instance['my_name']);
			$instance['pi_color'] = strip_tags($new_instance['pi_color']);
			$instance['pi_yes'] = ( isset( $new_instance['pi_yes'] ) ? 1 : 0 );
			$instance['klout_yes'] = ( isset( $new_instance['klout_yes'] ) ? 1 : 0 );
      return $instance;
    }

    /** @see WP_Widget::form */
    function form($instance) {
        $title = esc_attr($instance['title']);
        $twitter_id=esc_attr($instance['twitter_id']);
        $my_name=esc_attr($instance['my_name']);
        $pi_color=esc_attr($instance['pi_color']);

        // set default values for the checkboxes
        if (!isset($instance['pi_yes'])) $instance['pi_yes'] = true;
        if (!isset($instance['klout_yes'])) $instance['klout_yes'] = true;

        ?>
         <p>
          <label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:'); ?></label>
          <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>" />
        </p>
        <p>
          <label for="<?php echo $this->get_field_id('twitter_id'); ?>"><?php _e('Twitter ID:'); ?></label>
          <input class="widefat" id="<?php echo $this->get_field_id('twitter_id'); ?>" name="<?php echo $this->get_field_name('twitter_id'); ?>" type="text" value="<?php echo $twitter_id; ?>" />
          <br><i>Enter a Twitter ID without the "@"</i></p>
       	<p>
       		<label for="<?php echo $this->get_field_id( 'pi_yes' ); ?>">Display PeerIndex?</label>
       	  <input class="checkbox" type="checkbox" <?php checked( $instance['pi_yes'], true ); ?> id="<?php echo $this->get_field_id( 'pi_yes' ); ?>" name="<?php echo $this->get_field_name( 'pi_yes' ); ?>" /></p>
       	<p>
       		<label for="<?php echo $this->get_field_id( 'klout_yes' ); ?>">Display Klout?</label>
       	  <input class="checkbox" type="checkbox" <?php checked( $instance['klout_yes'], true ); ?> id="<?php echo $this->get_field_id( 'klout_yes' ); ?>" name="<?php echo $this->get_field_name( 'klout_yes' ); ?>" /></p>
        <p>
	        <label for="<?php echo $this->get_field_id('my_name'); ?>"><?php _e('Name Override:'); ?></label>
          <input class="widefat" id="<?php echo $this->get_field_id('my_name'); ?>" name="<?php echo $this->get_field_name('my_name'); ?>" type="text" value="<?php echo $my_name; ?>" />
          <br><i>Use this instead of my name as supplied by PeerIndex (optional)</i></p>
        <p>
           <label for="<?php echo $this->get_field_id('pi_color'); ?>"><?php _e('PeerIndex Number Color:'); ?></label>
          <input class="widefat" id="<?php echo $this->get_field_id('pi_color'); ?>" name="<?php echo $this->get_field_name('pi_color'); ?>" type="text" value="<?php echo $pi_color; ?>" />
          <br><i>Enter an HTML color code here to override the theme color when displaying the PeerIndex number.<br>
          Must be of the form #nnnnnn. (Optional)</i></p>
        <p>
        <b>Note:</b> Your scores will be more accurately reported in you have created a profile on <a href="http://klout.com">Klout<a> and <a href="http://peerindex.net">Peerindex</a>.
        </p>
        <?php
    }

} // class SocialMediaMetrics

// register SocialMediaMetrics widget
add_action('widgets_init', create_function('', 'return register_widget("SocialMediaMetrics");'));


// main work function
function block_peerIndex($twitter_id,$instance) {

    // just a bit of debugging code
    echo "<!-- Plugin Version: ".SMM_VERSION." -->";

    $plugin_dir = WP_PLUGIN_URL.'/'.str_replace(basename( __FILE__),"",plugin_basename(__FILE__));

    // process PeerIndex color.
    $pi_color = apply_filters('pi_color', $instance['pi_color']);
    if(!preg_match('/^#[a-f0-9]{6}$/i', $pi_color)) $pi_color="";

    // is there a name override?
    $my_name = trim(apply_filters('my_name', $instance['my_name']));

    if ($instance['klout_yes']) {
      // Klout score
      echo '<div style="margin-top: 10px;text-align:center;">';
      $url="http://api.klout.com/1/klout.json?key=yghgxyh283cx9tmqk3gnsd68&users=".$twitter_id;
      $str = @file_get_contents($url);
      $json = json_decode (  $str, true );
      if ($json['status'] == '200') {
        echo "<a href=\"http://twitter.com".$twitter_id."\">";
        if (strlen($my_name != "")) {
             echo $my_name;
             }
            else {
             echo $twitter_id;
             }
        echo "</a> has a <a href=\"http://klout.com/#/".$twitter_id."\">"."<b>Klout</b></a> score of";
        echo '<div style="margin:2px auto;;background-image:  url('.$plugin_dir.'klout.png); background-repeat: no-repeat;height: 67px; width: 75px;">';
        echo '<div style="color:#000;font-size:120%;position: relative; height: auto; width: auto; top: 20px; padding-left:8px;" >';
        echo "\n";
        echo "<b>",$json['users'][0]['kscore'],"</b>\n";
        echo "</div></div>\n";
        }
       else {
       	echo "Klout API Error ".$json['status'].":";
       	echo "<br>Visit my <a href='http://klout.com/#/".$twitter_id."'>Klout profile</a>";
      }
    }

    if ($instance['pi_yes']) {
      // PeerIndex score
      $url = "http://api.peerindex.net/1/profile/show.json?id=".$twitter_id."&api_key=1f38f3ddfd21f6936e1449c703eebd62";

      $str = @file_get_contents($url);
      if ($str) {
        $json = json_decode (  $str, true );
        if (isset($json['error'])) {
    	    echo "PeerIndex API Error: " ,$json['error'].".\n";
    	    echo "<br>Visit my <a href='http://peerindex.net/".$twitter_id."'>PeerIndex profile</a>";
    	    return false;
    	    }

        if (strlen($json['peerindex'])!=0) {
          echo "<div style=\"text-align:center;\">";
          echo  "<br>";
          if (strlen($my_name != "")) {
             echo $my_name;
             }
            else {
             echo $json['name'];
             }
          echo "'s (<a href='http://twitter.com/".$json['twitter'],"'>@",$json['slug'],"</a>) <a href='http://peerindex.net/".$json['slug']."'><b>PeerIndex</b></a> is";
          echo '<div style="margin:0px auto;;background-image:  url('.$plugin_dir.'pi.png); background-repeat: no-repeat;height: 73px; width: 73px;">';
          echo '<div style="';
          if ($pi_color != "") echo 'color:'.$pi_color.';';
          echo 'font-size:150%;position: relative; height: auto; width: auto; top: 20px;" >';
          echo "\n";
          echo "<b>",$json['peerindex'],"</b>\n";
          echo "</div></div>\n";
          echo "</div>\n";
         return true;
        }
    }
    else {
      // failed to contact PeerIndex -- do nothing
         echo "<!-- PeerIndex error: ".$str." -->\n";
         return false;
       }
    }
  }
