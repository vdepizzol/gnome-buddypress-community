<?php

/*
 * Please, don't forget to create a bp-custom.php file under wp-content/plugins
 * with the following code to make thumbnails work right in the theme:
 *
 * <<<
    
    <?php
    
    if (!defined('BP_AVATAR_THUMB_WIDTH'))
        define('BP_AVATAR_THUMB_WIDTH', 48);
    if (!defined('BP_AVATAR_THUMB_HEIGHT'))
        define('BP_AVATAR_THUMB_HEIGHT', 48);
    if (!defined('BP_AVATAR_FULL_WIDTH'))
        define('BP_AVATAR_FULL_WIDTH', 256);
    if (!defined('BP_AVATAR_FULL_HEIGHT'))
        define('BP_AVATAR_FULL_HEIGHT', 256);
 
   >>> EOF
   
 *
 *
 */


/* Default input field names */
/* ========================================================================== */

define('GNOME_FIELD_LOCATION', 'Current location');
define('GNOME_FIELD_GEOPOSITION', 'Lat/Lng');
define('GNOME_FIELD_DESCRIPTION', 'About me');


/* Disable BuddyPress admin bar */
/* ========================================================================== */


define('BP_DISABLE_ADMIN_BAR', true);



/* Disable custom header properties from BuddyPress default parent theme */
/* ========================================================================== */


define('BP_DTHEME_DISABLE_CUSTOM_HEADER', true);


/*
 * Remove automatic html from stream of activities so our template can do
 * whatever we want to
 */
/* ========================================================================== */


function remove_activity_meta($content) {
    return "";
}
add_filter('bp_activity_time_since', 'remove_activity_meta');
add_filter('bp_activity_permalink', 'remove_activity_meta');
add_filter('bp_activity_delete_link', 'remove_activity_meta');


/* Remove auto-links from the descriptions of each profile field */
/* ========================================================================== */

remove_filter( 'bp_get_the_profile_field_value', 'xprofile_filter_link_profile_data', 50 );



/* Changes default profile image with a GNOME default avatar */
/* ========================================================================== */
function myavatar_add_default_avatar($url, $size) {

    if ($size > 64) {
        return get_stylesheet_directory_uri() .'/images/default-avatar.png';
    }
    
    return get_stylesheet_directory_uri() .'/images/default-avatar-thumb.png';
    
}
add_filter('bp_core_mysteryman_src', 'myavatar_add_default_avatar', 1, 2);



/* GNOME Custom Settings Page */
/* ========================================================================== */



global $bp;

$settings_link = $bp->loggedin_user->domain . $bp->settings->slug . '/';

bp_core_new_subnav_item(
    array(
       'name' => __( 'Auto Updates', 'buddypress' ),
       'slug' => 'updates',
       'parent_url' => $settings_link,
       'parent_slug' => $bp->settings->slug,
       'screen_function' => 'gnome_autoupdate_settings',
       'position' => 15,
       'user_has_access' => bp_is_my_profile()
   )
);


function gnome_autoupdate_settings() {

    add_action( 'bp_template_title', function() { echo 'hey!'; });
	add_action( 'bp_template_content', function() { 
    	echo 'asd';
	 });

    bp_core_load_template( apply_filters( 'bp_core_template_plugin', 'members/single/plugins' ) );
}
