<?php

/**
 * BuddyPress - Activity Stream Comment
 *
 * This template is used by bp_activity_comments() functions to show
 * each activity.
 *
 * @package BuddyPress
 * @subpackage bp-default
 */

?>

<?php do_action( 'bp_before_activity_comment' ); ?>

<li id="acomment-<?php bp_activity_comment_id(); ?>">

    <div class="acomment-item">
        
        <div class="acomment-avatar">
            <a href="<?php bp_activity_comment_user_link(); ?>">
                <?php bp_activity_avatar( 'type=thumb&user_id=' . bp_get_activity_comment_user_id() ); ?>
            </a>
        </div>

        <div class="acomment-header">
            <?php
            /* translators: 1: user profile link, 2: user name */
            printf( __( '<a href="%1$s" class="username">%2$s</a>', 'buddypress' ), bp_get_activity_comment_user_link(), bp_members_get_user_nicename(bp_get_activity_comment_user_id()) );
            ?>
            
            <?php if ( bp_activity_user_can_delete() ) : ?>
                <a href="<?php bp_activity_comment_delete_link(); ?>" class="delete acomment-delete confirm bp-secondary-action" rel="nofollow" title="<?php _e( 'Delete', 'buddypress' ); ?>"><?php _e( 'Delete', 'buddypress' ); ?></a>
            <?php endif; ?>
            
        </div>

        <div class="acomment-content"><?php bp_activity_comment_content(); ?></div>

        <div class="acomment-options">
            
            <a href="<?php bp_activity_thread_permalink() ?>" class="activity-time-since"><span class="time-since"><?php bp_activity_comment_date_recorded() ?></span></a>

            <?php if ( is_user_logged_in() && bp_activity_can_comment_reply( bp_activity_current_comment() ) ) : ?>

                <a href="#acomment-<?php bp_activity_comment_id(); ?>" class="acomment-reply bp-primary-action" id="acomment-reply-<?php bp_activity_id() ?>-from-<?php bp_activity_comment_id() ?>" title="<?php _e( 'Reply', 'buddypress' ); ?>"><?php _e( 'Reply', 'buddypress' ); ?></a>

            <?php endif; ?>

        </div>
    
    </div>

	<?php bp_activity_recurse_comments( bp_activity_current_comment() ); ?>
</li>

<?php do_action( 'bp_after_activity_comment' ); ?>
