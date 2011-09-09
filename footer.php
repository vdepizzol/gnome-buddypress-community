		    </div>
		</div> <!-- #container -->

		<?php do_action( 'bp_after_container' ) ?>
		<?php do_action( 'bp_before_footer' ) ?>
		
        <?php
        
        if(isset($_SESSION['footer_art'])) {
            $footer_art = $_SESSION['footer_art'];
        } else {
            $footer_art = 'default';
        }
        
        ?>
        <?php if($footer_art == 'default' || $footer_art == 'none'): ?>
        <div id="footer_art" class="<?php echo $footer_art;?>">
        <?php else: ?>
        <div id="footer_art" style="background-image: url(<?php bloginfo('stylesheet_directory') ?>/images/footer_arts/<?php echo $footer_art;?>.png);">
        <?php endif; ?>
            &nbsp;
        </div>
        
        <div id="footer_grass">
        </div>

		<div id="footer">
	    	<p><?php printf( __( '%s is proudly powered by <a href="http://wordpress.org">WordPress</a> and <a href="http://buddypress.org">BuddyPress</a>', 'buddypress' ), get_bloginfo( 'name' ) ); ?></p>

			<?php do_action( 'bp_footer' ) ?>
		</div><!-- #footer -->

		<?php do_action( 'bp_after_footer' ) ?>

		<?php wp_footer(); ?>

	</body>

</html>
