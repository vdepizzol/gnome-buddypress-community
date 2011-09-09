<?php /* This template is used by activity-loop.php and AJAX functions to show each activity */ ?>

<?php do_action( 'bp_before_activity_entry' ) ?>

<li class="<?php bp_activity_css_class() ?>" id="activity-<?php bp_activity_id() ?>">

    <!--<div class="activity-item">-->
        
        <div class="activity-avatar">
            <a href="<?php bp_activity_user_link() ?>">
                <?php bp_activity_avatar( 'type=thumb&width=48&height=48' ) ?>
            </a>
        </div>

        <div class="activity-content">

            <div class="activity-header">

                <?php /* bp_activity_action(); */ ?>
                
                <a class="username" href="<?php bp_activity_user_link() ?>"><?php echo bp_members_get_user_nicename( bp_get_activity_user_id() ) ?></a>
                
                <?php
                
                if (bp_get_activity_type() != 'activity_update' && bp_get_activity_type() != 'activity_comment') {
                    bp_activity_type();
                }
                    
                ?>
                
                <?php if ( 'activity_comment' == bp_get_activity_type() ) : ?>
                    <span class="activity-inreplyto">
                        (<?php _e( 'in reply to', 'buddypress' ) ?> <a href="<?php bp_activity_thread_permalink() ?>"><?php _e( 'some existing activity', 'buddypress' ) ?></a>)
                    </span>
                <?php endif; ?>
                
                <?php
                
                global $activities_template, $bp;
                
                /* Add the delete link if the user has permission on this item */
                if ( ( is_user_logged_in() && $activities_template->activity->user_id == $bp->loggedin_user->id ) || $bp->is_item_admin || $bp->loggedin_user->is_super_admin ) {
                    bp_activity_delete_link();
                }
                    
                ?>
            </div>

            <?php if ( bp_activity_has_content() ) : ?>
                <div class="activity-inner">
                    <?php bp_activity_content_body() ?>
                </div>
            <?php endif; ?>

            <?php do_action( 'bp_activity_entry_content' ) ?>

            <div class="activity-meta">
            
                <?php
                
                /*
                 * Time since
                 */
                echo '<a class="time-since" href="' . bp_activity_get_permalink( $activities_template->activity->id, $activities_template->activity ) . '">' . bp_core_time_since( $activities_template->activity->date_recorded ) . '</a>';
                
                ?>

                <?php if ( is_user_logged_in() ) : ?>
                    <?php if ( !bp_get_activity_is_favorite() ) : ?>
                        <a href="<?php bp_activity_favorite_link() ?>" class="fav" title="<?php _e( 'Mark as Favorite', 'buddypress' ) ?>"><img src="<?php bloginfo('stylesheet_directory'); ?>/images/favorite-icon.png" alt="<?php _e( 'Favorite', 'buddypress' ) ?>" /></a>
                    <?php else : ?>
                        <a href="<?php bp_activity_unfavorite_link() ?>" class="unfav" title="<?php _e( 'Remove Favorite', 'buddypress' ) ?>"><img src="<?php bloginfo('stylesheet_directory'); ?>/images/favorited-icon.png" alt="<?php _e( 'Remove Favorite', 'buddypress' ) ?>" /></a>
                    <?php endif; ?>
                <?php endif;?>
                
                <?php if ( is_user_logged_in() && bp_activity_can_comment() ) : ?>
                    <a href="<?php bp_activity_comment_link() ?>" class="acomment-reply" id="acomment-comment-<?php bp_activity_id() ?>"><img src="<?php bloginfo('stylesheet_directory'); ?>/images/reply-icon.png" title="<?php _e( 'Reply', 'buddypress' ) ?>" alt="<?php _e( 'Reply', 'buddypress' ) ?>" /></a>
                <?php endif; ?>

                <?php do_action( 'bp_activity_entry_meta' ) ?>
            </div>
        </div>
        
    <!--</div>-->

	<?php do_action( 'bp_before_activity_entry_comments' ) ?>

	<?php if ( bp_activity_can_comment() ) : ?>
		<div class="activity-comments">
			<?php bp_activity_comments() ?>

			<?php if ( is_user_logged_in() ) : ?>
			<form action="<?php bp_activity_comment_form_action() ?>" method="post" id="ac-form-<?php bp_activity_id() ?>" class="ac-form"<?php bp_activity_comment_form_nojs_display() ?>>
				<div class="ac-reply-avatar"><?php bp_loggedin_user_avatar( 'width=' . BP_AVATAR_THUMB_WIDTH . '&height=' . BP_AVATAR_THUMB_HEIGHT ) ?></div>
				<div class="ac-reply-content">
					<div class="ac-textarea">
						<textarea id="ac-input-<?php bp_activity_id() ?>" class="ac-input" name="ac_input_<?php bp_activity_id() ?>"></textarea>
					</div>
					<input type="submit" name="ac_form_submit" value="<?php _e( 'Post', 'buddypress' ) ?> &rarr;" /><?php _e( 'Some HTML is ok. Press ESC to cancel.', 'buddypress' ) ?>
					<input type="hidden" name="comment_form_id" value="<?php bp_activity_id() ?>" />
				</div>
				<?php wp_nonce_field( 'new_activity_comment', '_wpnonce_new_activity_comment' ) ?>
			</form>
			<?php endif; ?>
		</div>
	<?php endif; ?>

	<?php do_action( 'bp_after_activity_entry_comments' ) ?>
</li>

<?php do_action( 'bp_after_activity_entry' ) ?>


