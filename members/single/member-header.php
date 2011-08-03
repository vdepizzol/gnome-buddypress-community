<?php do_action( 'bp_before_member_header' ) ?>

<div id="item-header-content">

    <h2 class="fn">
        <a href="<?php bp_displayed_user_link() ?>">
            <?php bp_displayed_user_fullname() ?>
        </a>
        <em>(<?php bp_displayed_user_username() ?>)</em>
        <?php if ( bp_is_my_profile() ) : ?>
            <img src="<?php bloginfo('stylesheet_directory'); ?>/images/profile-this-is-you.png" alt="this is you!" />
        <?php endif; ?>
    </h2>
    <h3><?php bp_profile_field_data( 'field=' . GNOME_FIELD_LOCATION ); ?></h3>

    <?php do_action( 'bp_before_member_header_meta' ) ?>

    <div id="item-meta">
        <div id="about-me">
            <p><?php bp_profile_field_data( 'field=' . GNOME_FIELD_DESCRIPTION ); ?></p>
        </div>
        
        <?php
        /*
         * We don't want any buttons in the profile at the moment
         */
         
        /*
        <div id="item-buttons">

            <?php do_action( 'bp_member_header_actions' ); ?>

        </div><!-- #item-buttons -->
        */
        ?>

        <?php do_action( 'bp_profile_header_meta' ) ?>

    </div><!-- #item-meta -->

</div><!-- #item-header-content -->

<?php do_action( 'bp_after_member_header' ) ?>
