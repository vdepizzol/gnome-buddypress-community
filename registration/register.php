<?php get_header() ?>

	<div id="content">
		<div class="padder">

		<?php do_action( 'bp_before_register_page' ) ?>

		<div class="page" id="register-page">
            
            <div class="page_title">
                <h1><?php _e( 'Create an Account', 'buddypress' ) ?></h1>
            </div>
            
            <p class="main_feature">
                GNOME Community was created to 
            </p>
            
            <hr class="top_shadow" />

			<form action="" name="signup_form" id="signup_form" class="standard-form sanewidth" method="post" enctype="multipart/form-data">

			<?php if ( 'request-details' == bp_get_current_signup_step() ) : ?>

				<?php do_action( 'template_notices' ) ?>
                

				<?php do_action( 'bp_before_account_details_fields' ) ?>

				<div class="register-section" id="basic-details-section">

					<?php /***** Basic Account Details ******/ ?>

					<h3><?php _e( 'Account Details', 'buddypress' ) ?></h3>

                    <div class="editfield">
                        <label for="signup_username"><?php _e( 'Username', 'buddypress' ) ?>*</label>
                        <?php do_action( 'bp_signup_username_errors' ) ?>
                        <div class="field">
                            <input type="text" name="signup_username" id="signup_username" value="<?php bp_signup_username_value() ?>" />
                        </div>
                    </div>

                    <div class="editfield">
                        <label for="signup_email"><?php _e( 'Email Address', 'buddypress' ) ?>*</label>
                        <?php do_action( 'bp_signup_email_errors' ) ?>
                        <div class="field">
                            <input type="text" name="signup_email" id="signup_email" value="<?php bp_signup_email_value() ?>" />
                        </div>
                    </div>
                    
                    <div class="editfield">
                        <label for="signup_password"><?php _e( 'Choose a Password', 'buddypress' ) ?>*</label>
                        <?php do_action( 'bp_signup_password_errors' ) ?>
                        <div class="field">
                            <input type="password" name="signup_password" id="signup_password" value="" />
                        </div>
                    </div>
                    
                    <div class="editfield">
                        <label for="signup_password_confirm"><?php _e( 'Confirm Password', 'buddypress' ) ?>*</label>
                        <?php do_action( 'bp_signup_password_confirm_errors' ) ?>
                        <div class="field">
                            <input type="password" name="signup_password_confirm" id="signup_password_confirm" value="" />
                        </div>
                    </div>

				</div><!-- #basic-details-section -->

				<?php do_action( 'bp_after_account_details_fields' ) ?>

				<?php /***** Extra Profile Details ******/ ?>

				<?php if ( bp_is_active( 'xprofile' ) ) : ?>

					<?php do_action( 'bp_before_signup_profile_fields' ) ?>

					<div class="register-section" id="profile-details-section">

						<h3><?php _e( 'Profile Details', 'buddypress' ) ?></h3>

						<?php /* Use the profile field loop to render input fields for the 'base' profile field group */ ?>
						<?php if ( function_exists( 'bp_has_profile' ) ) : if ( bp_has_profile( 'profile_group_id=1' ) ) : while ( bp_profile_groups() ) : bp_the_profile_group(); ?>

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

						<input type="hidden" name="signup_profile_field_ids" id="signup_profile_field_ids" value="<?php bp_the_profile_group_field_ids() ?>" />

						<?php endwhile; endif; endif; ?>

					</div><!-- #profile-details-section -->

					<?php do_action( 'bp_after_signup_profile_fields' ) ?>

				<?php endif; ?>
				
				<?php if ( bp_get_blog_signup_allowed() ) : ?>

					<?php do_action( 'bp_before_blog_details_fields' ) ?>

					<?php /***** Blog Creation Details ******/ ?>

					<div class="register-section" id="blog-details-section">

						<h4><?php _e( 'Blog Details', 'buddypress' ) ?></h4>

						<p><input type="checkbox" name="signup_with_blog" id="signup_with_blog" value="1"<?php if ( (int) bp_get_signup_with_blog_value() ) : ?> checked="checked"<?php endif; ?> /> <?php _e( 'Yes, I\'d like to create a new blog', 'buddypress' ) ?></p>

						<div id="blog-details"<?php if ( (int) bp_get_signup_with_blog_value() ) : ?>class="show"<?php endif; ?>>

							<label for="signup_blog_url"><?php _e( 'Blog URL', 'buddypress' ) ?> <?php _e( '(required)', 'buddypress' ) ?></label>
							<?php do_action( 'bp_signup_blog_url_errors' ) ?>

							<?php if ( is_subdomain_install() ) : ?>
								http:// <input type="text" name="signup_blog_url" id="signup_blog_url" value="<?php bp_signup_blog_url_value() ?>" /> .<?php echo str_replace( 'http://', '', site_url() ) ?>
							<?php else : ?>
								<?php echo site_url() ?>/ <input type="text" name="signup_blog_url" id="signup_blog_url" value="<?php bp_signup_blog_url_value() ?>" />
							<?php endif; ?>

							<label for="signup_blog_title"><?php _e( 'Blog Title', 'buddypress' ) ?> <?php _e( '(required)', 'buddypress' ) ?></label>
							<?php do_action( 'bp_signup_blog_title_errors' ) ?>
							<input type="text" name="signup_blog_title" id="signup_blog_title" value="<?php bp_signup_blog_title_value() ?>" />

							<span class="label"><?php _e( 'I would like my blog to appear in search engines, and in public listings around this site', 'buddypress' ) ?>:</span>
							<?php do_action( 'bp_signup_blog_privacy_errors' ) ?>

							<label><input type="radio" name="signup_blog_privacy" id="signup_blog_privacy_public" value="public"<?php if ( 'public' == bp_get_signup_blog_privacy_value() || !bp_get_signup_blog_privacy_value() ) : ?> checked="checked"<?php endif; ?> /> <?php _e( 'Yes' ) ?></label>
							<label><input type="radio" name="signup_blog_privacy" id="signup_blog_privacy_private" value="private"<?php if ( 'private' == bp_get_signup_blog_privacy_value() ) : ?> checked="checked"<?php endif; ?> /> <?php _e( 'No' ) ?></label>

						</div>

					</div><!-- #blog-details-section -->

					<?php do_action( 'bp_after_blog_details_fields' ) ?>

				<?php endif; ?>

				<?php do_action( 'bp_before_registration_submit_buttons' ) ?>

				<div class="submit">
					<input type="submit" name="signup_submit" id="signup_submit" value="<?php _e( 'Complete Sign Up', 'buddypress' ) ?> &rarr;" />
				</div>

				<?php do_action( 'bp_after_registration_submit_buttons' ) ?>

				<?php wp_nonce_field( 'bp_new_signup' ) ?>

			<?php endif; // request-details signup step ?>

			<?php if ( 'completed-confirmation' == bp_get_current_signup_step() ) : ?>

				<h2><?php _e( 'Sign Up Complete!', 'buddypress' ) ?></h2>

				<?php do_action( 'template_notices' ) ?>

				<?php if ( bp_registration_needs_activation() ) : ?>
					<p><?php _e( 'You have successfully created your account! To begin using this site you will need to activate your account via the email we have just sent to your address.', 'buddypress' ) ?></p>
				<?php else : ?>
					<p><?php _e( 'You have successfully created your account! Please log in using the username and password you have just created.', 'buddypress' ) ?></p>
				<?php endif; ?>

				<?php if ( bp_is_active( 'xprofile' ) && !(int)bp_get_option( 'bp-disable-avatar-uploads' ) ) : ?>

					<?php if ( 'upload-image' == bp_get_avatar_admin_step() ) : ?>

						<h4><?php _e( 'Your Current Avatar', 'buddypress' ) ?></h4>
						<p><?php _e( "We've fetched an avatar for your new account. If you'd like to change this, why not upload a new one?", 'buddypress' ) ?></p>

						<div id="signup-avatar">
							<?php bp_signup_avatar() ?>
						</div>

						<p>
							<input type="file" name="file" id="file" />
							<input type="submit" name="upload" id="upload" value="<?php _e( 'Upload Image', 'buddypress' ) ?>" />
							<input type="hidden" name="action" id="action" value="bp_avatar_upload" />
							<input type="hidden" name="signup_email" id="signup_email" value="<?php bp_signup_email_value() ?>" />
							<input type="hidden" name="signup_username" id="signup_username" value="<?php bp_signup_username_value() ?>" />
						</p>

						<?php wp_nonce_field( 'bp_avatar_upload' ) ?>

					<?php endif; ?>

					<?php if ( 'crop-image' == bp_get_avatar_admin_step() ) : ?>

						<h3><?php _e( 'Crop Your New Avatar', 'buddypress' ) ?></h3>

						<img src="<?php bp_avatar_to_crop() ?>" id="avatar-to-crop" class="avatar" alt="<?php _e( 'Avatar to crop', 'buddypress' ) ?>" />

						<div id="avatar-crop-pane">
							<img src="<?php bp_avatar_to_crop() ?>" id="avatar-crop-preview" class="avatar" alt="<?php _e( 'Avatar preview', 'buddypress' ) ?>" />
						</div>

						<input type="submit" name="avatar-crop-submit" id="avatar-crop-submit" value="<?php _e( 'Crop Image', 'buddypress' ) ?>" />

						<input type="hidden" name="signup_email" id="signup_email" value="<?php bp_signup_email_value() ?>" />
						<input type="hidden" name="signup_username" id="signup_username" value="<?php bp_signup_username_value() ?>" />
						<input type="hidden" name="signup_avatar_dir" id="signup_avatar_dir" value="<?php bp_signup_avatar_dir_value() ?>" />

						<input type="hidden" name="image_src" id="image_src" value="<?php bp_avatar_to_crop_src() ?>" />
						<input type="hidden" id="x" name="x" />
						<input type="hidden" id="y" name="y" />
						<input type="hidden" id="w" name="w" />
						<input type="hidden" id="h" name="h" />

						<?php wp_nonce_field( 'bp_avatar_cropstore' ) ?>

					<?php endif; ?>

				<?php endif; ?>

			<?php endif; // completed-confirmation signup step ?>

			<?php do_action( 'bp_custom_signup_steps' ) ?>

			</form>

		</div>

		<?php do_action( 'bp_after_register_page' ) ?>

		</div><!-- .padder -->
	</div><!-- #content -->

	<?php locate_template( array( 'sidebar.php' ), true ) ?>

	<?php do_action( 'bp_after_directory_activity_content' ) ?>

	<script type="text/javascript">
		jQuery(document).ready( function() {
			if ( jQuery('div#blog-details').length && !jQuery('div#blog-details').hasClass('show') )
				jQuery('div#blog-details').toggle();

			jQuery( 'input#signup_with_blog' ).click( function() {
				jQuery('div#blog-details').fadeOut().toggle();
			});
		});
	</script>

<?php get_footer() ?>
