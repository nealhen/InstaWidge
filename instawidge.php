<?php
/*
Plugin Name: InstaWidge 
Plugin URI: http://www.nealheneghan.com/instawidge
Description: A wordpress plug-in that displays instagram images in widget.
Version: 1.0
Author: Neal Heneghan
Author URI: http://www.nealheneghan.com/
License: GPL2
*/

class wp_my_plugin extends WP_Widget {

	// constructor
	function wp_my_plugin() {
		parent::WP_Widget(false, $name = __('InstaWidge', 'wp_widget_plugin') );
	}

	// widget form creation
	// widget form creation
function form($instance) {

// Check values
if( $instance) {
     $title = esc_attr($instance['title']);
     $clientID = esc_attr($instance['clientID']);
     $imgid = esc_attr($instance['imgid']);
     $usr = esc_attr($instance['usr']);
     $pass = esc_attr($instance['pass']);
     $tag = esc_attr($instance['tag']);
     $select = esc_attr($instance['select']); // Added
} else {
     $title = '';
     $imgid = '';
     $clientID = '';
     $usr = '';
     $pass = '';
     $tag = '';
     $select = ''; // Added
}
?>

<p>
<label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Widget Title', 'wp_widget_plugin'); ?></label>
<input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>" />
</p>
<p>
<label for="<?php echo $this->get_field_id('clientID'); ?>"><?php _e('Client ID', 'wp_widget_plugin'); ?></label>
<input class="widefat" id="<?php echo $this->get_field_id('clientID'); ?>" name="<?php echo $this->get_field_name('clientID'); ?>" type="text" value="<?php echo $clientID; ?>" />
<p>A client ID is required to validate your widget with Instagram. To get your client ID go to 
   <a href='http://instagram.com/developer' target='_blank'>instagram.com/developer</a> and click on the blue "Register Your Application" button. 
   Click the green "Register a New Client" button. Complete the form and then click submit. Your client ID will then be displayed</p>
</p>
<script>
  function getval(sel) {
    if(sel.value == 'Single Image'){
        jQuery('.SingleImg').show();
        jQuery('.UsrMulti').hide();
        jQuery('.TagMulti').hide();
      }
      else if(sel.value == 'Users Images'){
        jQuery('.SingleImg').hide();
        jQuery('.UsrMulti').show();
        jQuery('.TagMulti').hide();
      }
      else if(sel.value == 'Hash Tag'){
        jQuery('.SingleImg').hide();
        jQuery('.UsrMulti').hide();
        jQuery('.TagMulti').show();
      }
  }
</script>

<p>
  
  <select name='<?php echo $this->get_field_name("select"); ?>' id="SelType <?php// echo $this->get_field_id('select'); ?>" class="widefat selMode" onchange="getval(this);" style='display:none;'>
  <?php 
    $options = array('Hash Tag');
    foreach ($options as $option) {
      echo '<option value="' . $option . '" id="' . $option . '"', $select == $option ? ' selected="selected"' : '', '>', $option, '</option>';
    }?>
  </select>
</p>


<p class='SingleImg' 
  <?php if($select != "Single Image"){ ?> 
    style='display: none;'
  <?php }?>
  >
  <label class='SingleImg' for="<?php echo $this->get_field_id('imgid'); ?>"><?php _e('Image ID:', 'wp_widget_plugin'); ?></label>
  <input class="widefat SingleImg" id="<?php echo $this->get_field_id('imgid'); ?>" name="<?php echo $this->get_field_name('imgid'); ?>" type="text" value="<?php echo $imgid; ?>" />
</p>

<p class='UsrMulti'
<?php if($select != "Users Images"){ ?> 
    style='display: none;'
  <?php }?>
>
<label class='UsrMulti' for="<?php echo $this->get_field_id('usr'); ?>"><?php _e('User name:', 'wp_widget_plugin'); ?></label>
<input class="widefat UsrMulti" id="<?php echo $this->get_field_id('usr'); ?>" name="<?php echo $this->get_field_name('usr'); ?>" type="text" value="<?php echo $usr; ?>" />
</p>

<p class='UsrMulti'
  <?php if($select != "Users Images"){ ?> 
    style='display: none;'
  <?php }?>
>
<label class='UsrMulti' for="<?php echo $this->get_field_id('pass'); ?>"><?php _e('Password:', 'wp_widget_plugin'); ?></label>
<input class="widefat UsrMulti" id="<?php echo $this->get_field_id('pass'); ?>" name="<?php echo $this->get_field_name('pass'); ?>" type="text" value="<?php echo $pass; ?>" />
</p>

<p class='TagMulti'
  <?php if($select != "Hash Tag"){ ?> 
    style='display: none;'
  <?php }?>
>
<label class='TagMulti' for="<?php echo $this->get_field_id('tag'); ?>"><?php _e('Hash tag:', 'wp_widget_plugin'); ?></label>
<input class="TagMulti widefat" id="<?php echo $this->get_field_id('tag'); ?>" name="<?php echo $this->get_field_name('tag'); ?>" type="text" value="<?php echo $tag; ?>" />
</p>


<?php
}

	// widget update
	// update widget
function update($new_instance, $old_instance) {
      
      $instance = $old_instance;
      // Fields
      $instance['title'] = strip_tags($new_instance['title']);
      $instance['clientID'] = strip_tags($new_instance['clientID']);
      $instance['imgid'] = strip_tags($new_instance['imgid']);
      $instance['usr'] = strip_tags($new_instance['usr']);
      $instance['pass'] = strip_tags($new_instance['pass']);
      $instance['tag'] = strip_tags($new_instance['tag']);
      $instance['select'] = strip_tags($new_instance['select']);

      //$instance['text'] = strip_tags($new_instance['text']);
      //$instance['textarea'] = strip_tags($new_instance['textarea']);
     return $instance;
   
}

	// widget display
	// display widget
function widget($args, $instance) {
   extract( $args );
   // these are the widget options
   $title = apply_filters('widget_title', $instance['title']);
   $clientID = $instance['clientID'];
   $imgid = $instance['imgid'];
   $usr = $instance['usr'];
   $pass = $instance['pass'];
   $tag = $instance['tag'];
   $select = $instance['select'];
   echo $before_widget;
   // Display the widget
   echo '<div class="widget-text wp_widget_plugin_box">';

   // Check if title is set
   if ( $title ) {
      echo $before_title . $title . $after_title;
   }

   if( $clientID ) {
    echo '<input type="hidden" id="IWcliID" value="'.$clientID.'"/>';
   }
   else{
    echo'<p>Please enter client ID</p>';
   }

   if( $select ) {
    echo '<input type="hidden" id="IWtype" value="'.$select.'"/>';
   }

   // Check if text is set
   if( $imgid ) {
      echo '<input type="hidden" id="IWImgID" value="'.$imgid.'" />';
   }
   // Check if textarea is set
   if( $usr ) {
     echo '<input type="hidden" id="IWUsrID" value="'.$usr.'"/>';
   }
   if( $pass ) {
     echo '<input type="hidden" id="IWPassword" value="'.$pass.'"/>';
   }
   if( $tag ) {
     echo '<input type="hidden" id="IWTag" value="'.$tag.'"/>';
   }

   if($tag && $clientID){
    function callInstagram($url){
      $ch = curl_init();
      curl_setopt_array($ch, array(
      CURLOPT_URL => $url,
      CURLOPT_RETURNTRANSFER => true,
      CURLOPT_SSL_VERIFYPEER => false,
      CURLOPT_SSL_VERIFYHOST => 2
    ));

    $result = curl_exec($ch);
    curl_close($ch);
    return $result;
    }

    //$tag = 'YOUR_TAG_HERE';
    //$client_id = "YOUR_CLIENT_ID";

    $url = 'https://api.instagram.com/v1/tags/'.$tag.'/media/recent?client_id='.$clientID;

    $inst_stream = callInstagram($url);
    $results = json_decode($inst_stream, true);
    wp_register_style( 'iwStyle', plugins_url('/css/iwStyle.css', __FILE__) );
    wp_enqueue_style('iwStyle');
    //wp_enqueue_style( 'iwStyle', plugins_url().'/InstaWidge/css/iwStyle.css', '', '1.0', 'css' );
    //wp_enqueue_script( 'jCarousel', plugins_url().'/InstaWidge/js/jquery.jcarousel.min.js', '', '1.0'); 
    wp_enqueue_script( 'InstaWidgeJS', plugins_url().'/InstaWidge/js/InstaWidge.min.js', '', '1.0'); 
    //Now parse through the $results array to display your results...
    echo '<div class="jcarousel-wrapper">';
      echo '<div class="jcarousel">';
        echo '<ul id="InstaWidgeSlider">'; 
        foreach($results['data'] as $item){
            $image_link = $item['images']['low_resolution']['url'];
            echo '<li><img src="'.$image_link.'" /></li>';
        }
        echo '</ul>';
      echo'</div>';
    echo "</div>";
  }

   echo '</div>';
   echo $after_widget;
}
}

// register widget
add_action('widgets_init', create_function('', 'return register_widget("wp_my_plugin");'));


