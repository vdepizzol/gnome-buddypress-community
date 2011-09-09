<?php

$_SESSION['footer_art'] = '404';

get_header();

?>

	<div id="content">
		<div class="padder">

		<?php do_action( 'bp_before_404' ) ?>

		<div class="page 404" style="padding: 40px 80px;">
            
            <h1>Ooooops. Something is not here.</h1>
			
            <p class="main_feature">The page you tried to access was not found.</p>
            
            <hr />
            
            <div style="width: 380px; float: left; margin-right: 10px;">
                <p>For now, you may want to go to the <a href="<?php echo get_bloginfo('url') . '/'; ?>">home page</a> to start
                from beginning or try your luck in the search form above.</p>
            </div>
            
            <div style="width: 380px; float: left; margin-left: 10px;">
                <p>If you think there is a bug in some link around GNOME
                website, please, we ask you to <a href="https://bugzilla.gnome.org/enter_bug.cgi?product=website&component=www.gnome.org">report a bug</a>. Thank you.</p>
            </div>
            
            <div class="clear"></div>

			<?php do_action( 'bp_404' ) ?>

		</div>

		<?php do_action( 'bp_after_404' ) ?>

		</div><!-- .padder -->
	</div><!-- #content -->

	<?php locate_template( array( 'sidebar.php' ), true ) ?>

<?php $footer_art = '404'; get_footer(); ?>
