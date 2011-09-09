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

if ( !function_exists( 'bp_dtheme_enqueue_styles' ) ) :
    function bp_dtheme_enqueue_styles() {
        wp_dequeue_style('bp-admin-bar');
        wp_enqueue_style( 'gnome-style', get_bloginfo('stylesheet_directory') . '/style.css', array(), $version );
    }
    add_action( 'wp_print_styles', 'bp_dtheme_enqueue_styles' );
endif;

function bp_dtheme_enqueue_gnome_scripts() {
    wp_enqueue_script( 'gnome-template', get_bloginfo('stylesheet_directory') . '/template.js', array( 'jquery' ), $version );
}
add_action( 'wp_enqueue_scripts', 'bp_dtheme_enqueue_gnome_scripts' );



/* Replace "Read more" string */
/* ========================================================================== */


add_filter('bp_activity_excerpt_append_text', function() {
    return 'read more »';
});



/* Provide custom image header for login page */
/* ========================================================================== */


add_action('login_head', function() {
    echo '
        <link rel="stylesheet" href="' . get_bloginfo('stylesheet_directory') . '/css/fonts.css" type="text/css" media="screen" />
        <style type="text/css">
        html {
            background: #fff url(' . get_bloginfo('stylesheet_directory') . '/images/html-bg.png) 0 10px repeat-x !important;
        }
        body,
        body form .input,
        .button-primary {
            font-family: Cantarell !important;
        }
        h1 a {
            background-image: url(' . get_bloginfo('stylesheet_directory') . '/images/community-logo.png) !important;
        }
    </style>';
});

add_action('login_headertitle', function() {
    echo 'GNOME Community';
});

add_action('login_headerurl', function() {
    echo get_bloginfo('url') . '/';
});


/* List of Members JSON */
/* ========================================================================== */

if (isset($_GET['members_json'])) {
    
    header("Cache-Control: max-age=21600, must-revalidate");
    
    global $bp;
    
    //delete_transient('gnome_all_users_position');

    if (false === ($users_on_map = get_transient('gnome_all_users_position'))) {
        
        $field_name = xprofile_get_field_id_from_name('Name');
        $field_location = xprofile_get_field_id_from_name(GNOME_FIELD_LOCATION);
        $field_geoposition = xprofile_get_field_id_from_name(GNOME_FIELD_GEOPOSITION);
        
        $users_raw_data = $wpdb->get_results( "SELECT `value`, `user_id`, `field_id` FROM " . $bp->profile->table_name_data . " " .
                                              "WHERE `field_id` IN ('" . $field_name . "', '" . $field_geoposition . "', '" . $field_location . "') ".
                                              "ORDER BY `user_id` ASC");
        
        $users_login_data = $wpdb->get_results( "SELECT `ID`, `user_nicename` FROM " . $wpdb->users );
                
        $users_on_map = array();
        
        foreach ($users_raw_data as $key => $user_data) {
            
            if ($user_data->field_id == $field_name) {
                $users_on_map[$user_data->user_id]['name'] = $user_data->value;
            }
            
            if ($user_data->field_id == $field_geoposition) {
                $latlng = explode('/', $user_data->value);
                $lat = number_format($latlng[0], 3, '.', '');
                $lng = number_format($latlng[1], 3, '.', '');
                
                $users_on_map[$user_data->user_id]['lat'] = $lat;
                $users_on_map[$user_data->user_id]['lng'] = $lng;
            }
            
            if ($user_data->field_id == $field_location) {
                $users_on_map[$user_data->user_id]['location'] = $user_data->value;
            }
            
        }
        
        foreach ($users_login_data as $key => $user_data) {
            $users_on_map[$user_data->ID]['user'] = $user_data->user_nicename;
        }
        
        set_transient('gnome_all_users_position', serialize($users_on_map), (3600 * 3)); // 3 hours
        
    } else {
        
        $users_on_map = unserialize($users_on_map);

    }
    
    echo json_encode($users_on_map);
    
    die;
    
}



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
