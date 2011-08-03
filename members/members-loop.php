<?php /* Querystring is set via AJAX in _inc/ajax.php - bp_dtheme_object_filter() */ ?>

<?php do_action( 'bp_before_members_loop' ) ?>

<?php if ( bp_has_members( bp_ajax_querystring( 'members' ) ) ) : ?>

	<?php do_action( 'bp_before_directory_members_list' ) ?>

	<ul id="members-list" class="item-list">
	<?php while ( bp_members() ) : bp_the_member(); ?>

		<li>
			<div class="item-avatar">
				<a href="<?php bp_member_permalink() ?>"><?php bp_member_avatar() ?></a>
			</div>

			<div class="item">
				<div class="item-title">
					<a href="<?php bp_member_permalink() ?>"><?php bp_member_name() ?></a>
				</div>

				<div class="item-meta">
				    <?php bp_profile_field_data( array('field' => GNOME_FIELD_LOCATION, 'user_id' => bp_get_member_user_id() ) ); ?>
				</div>

				<?php do_action( 'bp_directory_members_item' ) ?>
			</div>

			<div class="action">

				<?php do_action( 'bp_directory_members_actions' ); ?>

			</div>

			<div class="clear"></div>
		</li>

	<?php endwhile; ?>
	</ul>

	<?php do_action( 'bp_after_directory_members_list' ) ?>

	<?php bp_member_hidden_fields() ?>

	<div id="pag-bottom" class="pagination">

		<div class="pag-count" id="member-dir-count-bottom">
			<?php bp_members_pagination_count() ?>
		</div>

		<div class="pagination-links" id="member-dir-pag-bottom">
			<?php bp_members_pagination_links() ?>
		</div>

	</div>

<?php else: ?>

	<div id="message" class="info">
		<p><?php _e( "Sorry, no members were found.", 'buddypress' ) ?></p>
	</div>

<?php endif; ?>

<?php do_action( 'bp_after_members_loop' ) ?>

