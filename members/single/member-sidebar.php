<div id="item-header-avatar">
    <a href="<?php bp_user_link() ?>">
        <?php bp_displayed_user_avatar( array('type' => 'full', 'width' => 256, 'height' => 256) ) ?>
    </a>
</div><!-- #item-header-avatar -->
                
<div id="item-nav">
    <div class="item-list-tabs no-ajax" id="object-nav">
	    <ul>
		    <?php bp_get_displayed_user_nav() ?>

		    <?php do_action( 'bp_member_options_nav' ) ?>
	    </ul>
    </div>
</div><!-- #item-nav -->
