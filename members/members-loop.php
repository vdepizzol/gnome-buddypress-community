<?php do_action( 'bp_before_members_loop' ) ?>

<?php if ( bp_has_members( 'per_page=15' ) ) : ?>

	<?php do_action( 'bp_before_directory_members_list' ) ?>

	<ul id="members-list" class="item-list">
	<?php while ( bp_members() ) : bp_the_member(); ?>

		<li>
            <a href="<?php bp_member_permalink() ?>">
                <span class="item-avatar">
                    <?php bp_member_avatar(array('alt' => '')) ?>
                </span>

                <span class="item">
                    <span class="item-title">
                        <?php bp_member_name() ?>
                    </span>

                    <span class="item-meta">
                        <?php bp_profile_field_data( array('field' => GNOME_FIELD_LOCATION, 'user_id' => bp_get_member_user_id() ) ); ?>
                    </span>

                    <?php do_action( 'bp_directory_members_item' ) ?>
                </span>

                <span class="action">

                    <?php do_action( 'bp_directory_members_actions' ); ?>

                </span>
            </a>
		</li>

	<?php endwhile; ?>
	</ul>

	<?php do_action( 'bp_after_directory_members_list' ) ?>
    
    <div class="clear"></div>
    
    <?php if (bp_get_members_pagination_links() != '') { ?>
    <hr class="bottom_shadow" />
    <?php } ?>

	<?php bp_member_hidden_fields() ?>

	<div id="pag-bottom" class="pagination">

		<div class="pagination-links" id="member-dir-pag-bottom">
			<?php bp_members_pagination_links() ?>
		</div>

	</div>

<?php else: ?>

    <div class="content" style="padding: 0 80px">
        
        <h2>Sorry, but no one was found.</h2>
        
        <p>Suggestions:</p>
        
        <ul>
            <li>Make sure all words are spelled correctly.</li>
            <li>Try different keywords.</li>
            <li>Try fewer keywords.</li>
        </ul>
        
        <p>If you feel lost, you may want to search for <?php echo htmlspecialchars(stripslashes(strip_tags($_GET['s'])));?> in all GNOME websites on <a href="http://google.com/search?q=<?php echo htmlspecialchars(stripslashes(strip_tags($_GET['s'])));?>%20site:gnome.org">Google</a>.</p>
    
    </div>

<?php endif; ?>

<?php do_action( 'bp_after_members_loop' ) ?>

