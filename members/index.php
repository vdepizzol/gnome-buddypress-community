<?php get_header() ?>

	<div id="content">
		<div class="padder">

		<form action="" method="post" id="members-directory-form" class="dir-form">
            
            <?php if (!isset($_GET['s']) && (!isset($_GET['upage']) || $_GET['upage'] == '1')): ?>
		
                <div id="members-map" style="height: 400px; margin-bottom: 20px;">
                </div>
                            
                <script type="text/javascript" src="<?php bloginfo('stylesheet_directory'); ?>/map/leaflet.js"></script>
                <link rel="stylesheet" href="<?php bloginfo('stylesheet_directory'); ?>/map/leaflet.css" />
                
                <script type="text/javascript">
                    var map = new L.Map('members-map');

                    var cloudmadeUrl = 'http://{s}.tile.cloudmade.com/BC9A493B41014CAABB98F0471D759707/42030/256/{z}/{x}/{y}.png',
                        cloudmadeAttribution = 'Map data &copy; 2011 OpenStreetMap contributors, Imagery &copy; 2011 CloudMade',
                        cloudmade = new L.TileLayer(cloudmadeUrl, {maxZoom:8, attribution: cloudmadeAttribution});
                    
                    map.setView(new L.LatLng(15, 0), 2).addLayer(cloudmade);
                    
                    var pinIcon = L.Icon.extend({
                        iconUrl: '<?php bloginfo('stylesheet_directory'); ?>/map/images/pin.png',
                        shadowUrl: '<?php bloginfo('stylesheet_directory'); ?>/map/images/pin-shadow.png',
                        iconSize: new L.Point(12, 28),
                        shadowSize: new L.Point(20, 28),
                        iconAnchor: new L.Point(6, 24),
                        popupAnchor: new L.Point(0, -24)
                    });
                    var pin = new pinIcon();
                    
                    var members = jQuery.ajax({
                        url: '?members_json',
                        dataType: 'json',
                        success: function(data) {
                            var marker = {};
                            jQuery.each(data, function(index, value) {
                                marker[index] = new L.Marker(new L.LatLng(parseFloat(value.lat), parseFloat(value.lng)), {icon: pin});
                                marker[index].bindPopup("<a class=\"user_tooltip\" href=\"<?php echo site_url() ?>/members/" + value.user + "/\"><b>" + value.name + "</b><br />" + value.location + '</a>');
                                map.addLayer(marker[index]);
                            });
                        }
                    });

                </script>
                
                <hr class="top_shadow" />
                
                <h3 style="text-align: center;">GNOME is a diverse international community</h3>
                
                <p class="main_feature" style="text-align: center;">We are programmers, designers, translators and writers from all<br /> over the world with the same vision.</p>
            
            <?php else: ?>
            
            <div class="page_title">
            <?php if (isset($_GET['s'])): ?>
                <h1>Looking for <em><?php echo htmlspecialchars(strip_tags($_GET['s']));?></em>...</h1>
            <?php else: ?>
                <h1>Members directory</h1>
            <?php endif; ?>
            </div>
            
            <?php endif; ?>
            
			<?php do_action( 'bp_before_directory_members_content' ) ?>

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
