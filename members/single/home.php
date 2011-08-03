<?php get_header() ?>

	<div id="content">
		<div class="padder">
		
		    <div id="item-sidebar">
                <?php locate_template( array( 'members/single/member-sidebar.php' ), true ) ?>
		    </div>
		    
		    <div id="item-content">

			    <?php do_action( 'bp_before_member_home_content' ) ?>

			    <div id="item-header">
                    <?php locate_template( array( 'members/single/member-header.php' ), true ) ?>
			    </div><!-- #item-header -->
			
                <?php do_action( 'template_notices' ) ?>

			    <div id="item-body">
				    <?php do_action( 'bp_before_member_body' ) ?>

				    <?php if ( bp_is_user_activity() || !bp_current_component() ) : ?>
					    <?php locate_template( array( 'members/single/activity.php' ), true ) ?>

				    <?php elseif ( bp_is_user_blogs() ) : ?>
					    <?php locate_template( array( 'members/single/blogs.php' ), true ) ?>

				    <?php elseif ( bp_is_user_friends() ) : ?>
					    <?php locate_template( array( 'members/single/friends.php' ), true ) ?>

				    <?php elseif ( bp_is_user_groups() ) : ?>
					    <?php locate_template( array( 'members/single/groups.php' ), true ) ?>

				    <?php elseif ( bp_is_user_messages() ) : ?>
					    <?php locate_template( array( 'members/single/messages.php' ), true ) ?>

				    <?php elseif ( bp_is_user_profile() ) : ?>
					    <?php locate_template( array( 'members/single/profile.php' ), true ) ?>

				    <?php else : ?>
					    <?php
						    /* If nothing sticks, just load a member front template if one exists. */
						    locate_template( array( 'members/single/front.php' ), true );
					    ?>
				    <?php endif; ?>

				    <?php do_action( 'bp_after_member_body' ) ?>

			    </div><!-- #item-body -->

			    <?php do_action( 'bp_after_member_home_content' ) ?>
			    
		    </div><!-- #item-content -->

		</div><!-- .padder -->
	</div><!-- #content -->

	<?php locate_template( array( 'sidebar.php' ), true ) ?>

<?php get_footer() ?>
