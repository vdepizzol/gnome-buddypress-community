<?php do_action( 'bp_before_profile_loop_content' ) ?>

<?php if ( function_exists('xprofile_get_profile') ) : ?>

	<?php if ( bp_has_profile() ) : ?>

		<?php while ( bp_profile_groups() ) : bp_the_profile_group(); ?>

			<?php if ( bp_profile_group_has_fields() ) : ?>

				<?php do_action( 'bp_before_profile_field_content' ) ?>

				<div class="bp-widget <?php bp_the_profile_group_slug() ?>">
					<?php if ( 1 != bp_get_the_profile_group_id() ) : ?>
						<h4><?php bp_the_profile_group_name() ?></h4>
					<?php endif; ?>

					<table class="profile-fields zebra">
						<?php while ( bp_profile_fields() ) : bp_the_profile_field(); ?>

							<?php if ( bp_field_has_data() && bp_get_the_profile_field_name() != GNOME_FIELD_GEOPOSITION) : ?>
								<tr<?php bp_field_css_class() ?>>

									<td class="label">
										<?php bp_the_profile_field_name() ?>
									</td>

									<td class="data">
										<?php bp_the_profile_field_value() ?>
										<?php
										
										if (bp_get_the_profile_field_name() == 'Current location') {
										
										    echo '</td></tr><tr><td colspan="2" class="map">';
										    
										    ?>
										    <div id="map_view"></div>
										    
	                                        <script type="text/javascript" src="<?php bloginfo('stylesheet_directory'); ?>/map/leaflet.js"></script>
	                                        <link rel="stylesheet" href="<?php bloginfo('stylesheet_directory'); ?>/map/leaflet.css" />
	                                        <script type="text/javascript">
		                                        var map = new L.Map('map_view');
		
		                                        var cloudmadeUrl = 'http://{s}.tile.cloudmade.com/BC9A493B41014CAABB98F0471D759707/997/256/{z}/{x}/{y}.png',
			                                        cloudmadeAttribution = 'Map data &copy; 2011 OpenStreetMap contributors, Imagery &copy; 2011 CloudMade',
			                                        cloudmade = new L.TileLayer(cloudmadeUrl, {maxZoom: 13, attribution: cloudmadeAttribution});
		                                        
										        <?php
										        
										        $latlng = bp_get_profile_field_data( 'field=' . GNOME_FIELD_GEOPOSITION );
										        
										        if (empty($latlng) || strpos($latlng, '/') === false) {
                    					            $latlng = '0/0';
                					            }
                					            
                					            $latlng = explode('/', $latlng);
										        
										        $lat = number_format($latlng[0], 3, '.', '');
                    					        $lng = number_format($latlng[1], 3, '.', '');
										        
										        ?>
		                                        map.setView(new L.LatLng(<?php echo $lat;?>, <?php echo $lng;?>), 11).addLayer(cloudmade);
		
		
		                                        var markerLocation = new L.LatLng(<?php echo $lat;?>, <?php echo $lng;?>),
			                                        marker = new L.Marker(markerLocation);
		
		                                        map.addLayer(marker);
		
	                                        </script>
										    
										    <?php
										
										}
										
										?>
									</td>

								</tr>
							<?php endif; ?>

							<?php do_action( 'bp_profile_field_item' ) ?>

						<?php endwhile; ?>
					</table>
				</div>

				<?php do_action( 'bp_after_profile_field_content' ) ?>

			<?php endif; ?>

		<?php endwhile; ?>

		<?php do_action( 'bp_profile_field_buttons' ) ?>

	<?php endif; ?>

<?php else : ?>

	<?php /* Just load the standard WP profile information, if BP extended profiles are not loaded. */ ?>
	<?php bp_core_get_wp_profile() ?>

<?php endif; ?>

<?php do_action( 'bp_after_profile_loop_content' ) ?>


