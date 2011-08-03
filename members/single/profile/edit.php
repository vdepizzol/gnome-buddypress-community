<?php do_action( 'bp_before_profile_edit_content' ) ?>

<?php if ( bp_has_profile( 'profile_group_id=' . bp_get_current_profile_group_id() ) ) : while ( bp_profile_groups() ) : bp_the_profile_group(); ?>

<form action="<?php bp_the_profile_group_edit_form_action() ?>" method="post" id="profile-edit-form" class="standard-form <?php bp_the_profile_group_slug() ?>">

	<?php do_action( 'bp_before_profile_field_content' ) ?>
	
	    <?php
	    
	    if ( !$groups = wp_cache_get( 'xprofile_groups_inc_empty', 'bp' ) ) {
		    $groups = BP_XProfile_Group::get( array( 'fetch_fields' => true ) );
		    wp_cache_set( 'xprofile_groups_inc_empty', $groups, 'bp' );
	    }
        
        if (count($groups) > 1): ?>

		<h4><?php printf( __( "Editing '%s' Profile Group", "buddypress" ), bp_get_the_profile_group_name() ); ?></h4>

		<ul class="button-nav">
			<?php bp_profile_group_tabs(); ?>
		</ul>

		<div class="clear"></div>
		
		<?php endif; ?>

		<?php while ( bp_profile_fields() ) : bp_the_profile_field(); ?>

			<div<?php bp_field_css_class( 'editfield' ) ?>>

				<?php if ( 'textbox' == bp_get_the_profile_field_type() ) : ?>

					<label for="<?php bp_the_profile_field_input_name() ?>">
					    <?php bp_the_profile_field_name() ?><?php if ( bp_get_the_profile_field_is_required() ) : ?>*<?php endif; ?>
	        			<span class="description"><?php bp_the_profile_field_description() ?></span>
				    </label>
					<div class="field">
					    <?php if( bp_get_the_profile_field_name() == GNOME_FIELD_GEOPOSITION):
					    
					    ?>
					    
                        <div id="map_view" style="height: 230px; cursor: crosshair;"></div>
					    
                        <script type="text/javascript" src="<?php bloginfo('stylesheet_directory'); ?>/map/leaflet.js"></script>
                        <link rel="stylesheet" href="<?php bloginfo('stylesheet_directory'); ?>/map/leaflet.css" />
                        <script type="text/javascript">
                            var map = new L.Map('map_view');

                            var cloudmadeUrl = 'http://{s}.tile.cloudmade.com/BC9A493B41014CAABB98F0471D759707/997/256/{z}/{x}/{y}.png',
                                cloudmadeAttribution = 'Map data &copy; 2011 OpenStreetMap contributors, Imagery &copy; 2011 CloudMade',
                                cloudmade = new L.TileLayer(cloudmadeUrl, {maxZoom: 13, attribution: cloudmadeAttribution});
                            
					        <?php
					        
					        $latlng = bp_get_the_profile_field_edit_value();
					        
					        if (empty($latlng) || strpos($latlng, '/') === false) {
					            $latlng = '0/0';
					            $ask_for_location = true;
					        } else {
    					        $ask_for_location = false;
					        }
					        
					        $latlng = explode('/', $latlng);
					        
					        $lat = number_format($latlng[0], 3, '.', '');
					        $lng = number_format($latlng[1], 3, '.', '');
					        
					        ?>
                            map.setView(new L.LatLng(<?php echo $lat;?>, <?php echo $lng;?>), 11).addLayer(cloudmade);


                            var markerLocation = new L.LatLng(<?php echo $lat;?>, <?php echo $lng;?>),
                                marker = new L.Marker(markerLocation);
                            
                            map.on('click', onMapClick);
                            
    	                    map.on('locationfound', function(e) {
        	                    onMapClick(e);
        	                    map.panTo(e.latlng);
    	                    });
				
		                    function onMapClick(e) {
			                    var new_LatLng = e.latlng.lat.toFixed(3) + '/' + e.latlng.lng.toFixed(3);
			                    jQuery('input[name="<?php bp_the_profile_field_input_name() ?>"]').val(new_LatLng);
                                marker.setLatLng(e.latlng);
		                    }
		                    
		                    <?php if ($ask_for_location): ?>
    		                    map.locate();
		                    <?php endif; ?>

                            map.addLayer(marker);

                        </script>
    				    <input type="hidden" name="<?php bp_the_profile_field_input_name() ?>" id="<?php bp_the_profile_field_input_name() ?>" value="<?php bp_the_profile_field_edit_value() ?>" />					    
					    <?php else: ?>
    				    
        				    <input type="text" name="<?php bp_the_profile_field_input_name() ?>" id="<?php bp_the_profile_field_input_name() ?>" value="<?php bp_the_profile_field_edit_value() ?>" />

        				    <?php if( bp_get_the_profile_field_name() == GNOME_FIELD_LOCATION): ?>
        				        <a id="locate" href="#" onclick="map.locate(); return false;">Detect location on the map</a>
        				    <?php endif; ?>
    				    
    				    <?php endif; ?>
				    </div>

				<?php endif; ?>

				<?php if ( 'textarea' == bp_get_the_profile_field_type() ) : ?>

					<label for="<?php bp_the_profile_field_input_name() ?>">
					    <?php bp_the_profile_field_name() ?><?php if ( bp_get_the_profile_field_is_required() ) : ?>*<?php endif; ?>
	        			<span class="description"><?php bp_the_profile_field_description() ?></span>
				    </label>
					<div class="field">
    					<textarea rows="5" cols="40" name="<?php bp_the_profile_field_input_name() ?>" id="<?php bp_the_profile_field_input_name() ?>"><?php bp_the_profile_field_edit_value() ?></textarea>
					</div>

				<?php endif; ?>

				<?php if ( 'selectbox' == bp_get_the_profile_field_type() ) : ?>

					<label for="<?php bp_the_profile_field_input_name() ?>">
					    <?php bp_the_profile_field_name() ?><?php if ( bp_get_the_profile_field_is_required() ) : ?>*<?php endif; ?>
	        			<span class="description"><?php bp_the_profile_field_description() ?></span>
				    </label>
					<div class="field">
					    <select name="<?php bp_the_profile_field_input_name() ?>" id="<?php bp_the_profile_field_input_name() ?>">
						    <?php bp_the_profile_field_options() ?>
					    </select>
				    </div>

				<?php endif; ?>

				<?php if ( 'multiselectbox' == bp_get_the_profile_field_type() ) : ?>

					<label for="<?php bp_the_profile_field_input_name() ?>">
					    <?php bp_the_profile_field_name() ?><?php if ( bp_get_the_profile_field_is_required() ) : ?>*<?php endif; ?>
	        			<span class="description"><?php bp_the_profile_field_description() ?></span>
				    </label>
					<div class="field">
					    <select name="<?php bp_the_profile_field_input_name() ?>" id="<?php bp_the_profile_field_input_name() ?>" multiple="multiple">
						    <?php bp_the_profile_field_options() ?>
					    </select>
					    
					    <?php if ( !bp_get_the_profile_field_is_required() ) : ?>
						    <a class="clear-value" href="javascript:clear( '<?php bp_the_profile_field_input_name() ?>' );"><?php _e( 'Clear', 'buddypress' ) ?></a>
					    <?php endif; ?>
                    </div>

				<?php endif; ?>

				<?php if ( 'radio' == bp_get_the_profile_field_type() ) : ?>
                    
					<label>
					    <?php bp_the_profile_field_name() ?><?php if ( bp_get_the_profile_field_is_required() ) : ?>*<?php endif; ?>
	        			<span class="description"><?php bp_the_profile_field_description() ?></span>
				    </label>
					<div class="field radio">

						<?php bp_the_profile_field_options() ?>

						<?php if ( !bp_get_the_profile_field_is_required() ) : ?>
							<a class="clear-value" href="javascript:clear( '<?php bp_the_profile_field_input_name() ?>' );"><?php _e( 'Clear', 'buddypress' ) ?></a>
						<?php endif; ?>
					</div>

				<?php endif; ?>

				<?php if ( 'checkbox' == bp_get_the_profile_field_type() ) : ?>
                    
					<label>
					    <?php bp_the_profile_field_name() ?><?php if ( bp_get_the_profile_field_is_required() ) : ?>*<?php endif; ?>
	        			<span class="description"><?php bp_the_profile_field_description() ?></span>
				    </label>
					<div class="field checkbox">
						<?php bp_the_profile_field_options() ?>
					</div>

				<?php endif; ?>

				<?php if ( 'datebox' == bp_get_the_profile_field_type() ) : ?>
				
					<label for="<?php bp_the_profile_field_input_name() ?>_day">
					    <?php bp_the_profile_field_name() ?><?php if ( bp_get_the_profile_field_is_required() ) : ?>*<?php endif; ?>
	        			<span class="description"><?php bp_the_profile_field_description() ?></span>
				    </label>

					<div class="field datebox">

						<select name="<?php bp_the_profile_field_input_name() ?>_day" id="<?php bp_the_profile_field_input_name() ?>_day">
							<?php bp_the_profile_field_options( 'type=day' ) ?>
						</select>

						<select name="<?php bp_the_profile_field_input_name() ?>_month" id="<?php bp_the_profile_field_input_name() ?>_month">
							<?php bp_the_profile_field_options( 'type=month' ) ?>
						</select>

						<select name="<?php bp_the_profile_field_input_name() ?>_year" id="<?php bp_the_profile_field_input_name() ?>_year">
							<?php bp_the_profile_field_options( 'type=year' ) ?>
						</select>
					</div>					

				<?php endif; ?>

				<?php do_action( 'bp_custom_profile_edit_fields' ) ?>

			</div>

		<?php endwhile; ?>

	<?php do_action( 'bp_after_profile_field_content' ) ?>

	<div class="submit">
		<input type="submit" name="profile-group-edit-submit" id="profile-group-edit-submit" value="<?php _e( 'Save Changes', 'buddypress' ) ?> " />
	</div>

	<input type="hidden" name="field_ids" id="field_ids" value="<?php bp_the_profile_group_field_ids() ?>" />
	<?php wp_nonce_field( 'bp_xprofile_edit' ) ?>

</form>

<?php endwhile; endif; ?>

<?php do_action( 'bp_after_profile_edit_content' ) ?>
