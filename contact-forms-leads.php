<?php
/*
Plugin Name: CFLEAD
Plugin URI:http://pkbhatt.com
Description: Display  contact form 7 submissions as leads in wordpress admin panel. This will be usefull only for wordpress plugin contact form 7
Version: 2.1
Author: pkbhatt
License: GPLv2
Text Domain: contactform , CF7 to db , CF2DB , Lead Generation , 
*/

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
include_once( plugin_dir_path( __FILE__ ) . 'leads.php' );
function cfl_init() {
	if( !is_plugin_active( 'contact-form-7/wp-contact-form-7.php' ) ) {
 
		?>
		<div class="error notice">
    <p>Contact form 7 is not activated . Please activate the plugin to use CFLEAD</p>
</div>
		<?php
 
	}
}
add_action( 'admin_init', 'cfl_init' );

// The below code is usefull for saving the contact form data into wordpress database as custom post.
function cfl_add_lead($form){
        $newArray = array();
    foreach($_POST as $key => $value) {
    if (substr($key,0,6) !== '_wpcf7')
        $newArray[$key] = $value;
}
   
     $content =" ";
    foreach($newArray as $key => $value) {
        $fkey =sanitize_text_field( $key );
        $fvalue =sanitize_text_field( $value ) ;
  
      $content .= $fkey." :- ".$fvalue."\n";
 }
  
   
	    $new_post = array(
		'post_type'=>'cflead',
		'post_title'=>"$form->title Submission",
		'post_content'=>"$content"
	    );
	    wp_insert_post($new_post);

    }
