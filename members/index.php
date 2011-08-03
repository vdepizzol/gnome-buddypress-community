<?php

global $bp;

delete_transient('gnome_all_users_position');

if (false === ($users_on_map = get_transient('gnome_all_users_position'))) {

    $users_on_map = $wpdb->get_results( "SELECT `value`, `user_id` FROM " . $bp->profile->table_name_data . " " .
                                        "WHERE `field_id` = (SELECT `id` FROM ". $bp->profile->table_name_fields ." ".
                                                            "WHERE `name` = '" . mysql_real_escape_string(GNOME_FIELD_GEOPOSITION) . "')");
                                                            
    set_transient('gnome_all_users_position', serialize($users_on_map), (3600 * 60 * 1));
    
} else {
    
    $users_on_map = unserialize($users_on_map);

}


?>
<?php get_header() ?>

	<div id="content">
		<div class="padder">

		<form action="" method="post" id="members-directory-form" class="dir-form">
		
			<div id="members-map" style="height: 400px; margin-bottom: 20px;">
		    </div>

			<h3><?php _e( 'Members Directory', 'buddypress' ) ?></h3>

			<?php do_action( 'bp_before_directory_members_content' ) ?>
		    
		    <script type="text/javascript" src="<?php bloginfo('stylesheet_directory'); ?>/map/leaflet.js"></script>
            <link rel="stylesheet" href="<?php bloginfo('stylesheet_directory'); ?>/map/leaflet.css" />
            
            <script type="text/javascript">
                var map = new L.Map('members-map');

                var cloudmadeUrl = 'http://{s}.tile.cloudmade.com/BC9A493B41014CAABB98F0471D759707/42030/256/{z}/{x}/{y}.png',
                    cloudmadeAttribution = 'Map data &copy; 2011 OpenStreetMap contributors, Imagery &copy; 2011 CloudMade',
                    cloudmade = new L.TileLayer(cloudmadeUrl, {maxZoom:4, attribution: cloudmadeAttribution});
                
                map.setView(new L.LatLng(15, 0), 2).addLayer(cloudmade);
                
                <?php
                
                foreach ($users_on_map as $id => $user) {
                
                    $latlng = explode('/', $user->value);
			        $lat = number_format($latlng[0], 1, '.', '');
			        $lng = number_format($latlng[1], 1, '.', '');
			        
                    ?>var marker<?php echo $id;?> = new L.Marker(new L.LatLng(<?php echo $lat;?>,<?php echo $lng;?>));map.addLayer(marker<?php echo $id;?>);<?php
                }
                
                ?>

                map.addLayer(marker);

            </script>

			<div id="members-dir-list" class="members dir-list">
				<?php locate_template( array( 'members/members-loop.php' ), true ) ?>
			</div><!-- #members-dir-list -->

			<?php do_action( 'bp_directory_members_content' ) ?>

			<?php wp_nonce_field( 'directory_members', '_wpnonce-member-filter' ) ?>

			<?php do_action( 'bp_after_directory_members_content' ) ?>

		</form><!-- #members-directory-form -->

		</div><!-- .padder -->
	</div><!-- #content -->

	<?php locate_template( array( 'sidebar.php' ), true ) ?>

<?php get_footer() ?>
