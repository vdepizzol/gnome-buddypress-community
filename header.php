<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml" <?php language_attributes(); ?>>

	<head profile="http://gmpg.org/xfn/11">

		<meta http-equiv="Content-Type" content="<?php bloginfo('html_type'); ?>; charset=<?php bloginfo('charset'); ?>" />

		<title><?php bp_page_title() ?></title>

		<?php do_action( 'bp_head' ) ?>

		<meta name="generator" content="WordPress <?php bloginfo('version'); ?>" /> <!-- leave this for stats -->

		<link rel="stylesheet" href="<?php bloginfo('stylesheet_url'); ?>" type="text/css" media="screen" />

		<?php if ( function_exists( 'bp_sitewide_activity_feed_link' ) ) : ?>
			<link rel="alternate" type="application/rss+xml" title="<?php bloginfo('name'); ?> | <?php _e('Site Wide Activity RSS Feed', 'buddypress' ) ?>" href="<?php bp_sitewide_activity_feed_link() ?>" />
		<?php endif; ?>

		<?php if ( function_exists( 'bp_member_activity_feed_link' ) && bp_is_member() ) : ?>
			<link rel="alternate" type="application/rss+xml" title="<?php bloginfo('name'); ?> | <?php bp_displayed_user_fullname() ?> | <?php _e( 'Activity RSS Feed', 'buddypress' ) ?>" href="<?php bp_member_activity_feed_link() ?>" />
		<?php endif; ?>

		<?php if ( function_exists( 'bp_group_activity_feed_link' ) && bp_is_group() ) : ?>
			<link rel="alternate" type="application/rss+xml" title="<?php bloginfo('name'); ?> | <?php bp_current_group_name() ?> | <?php _e( 'Group Activity RSS Feed', 'buddypress' ) ?>" href="<?php bp_group_activity_feed_link() ?>" />
		<?php endif; ?>

		<link rel="alternate" type="application/rss+xml" title="<?php bloginfo('name'); ?> <?php _e( 'Blog Posts RSS Feed', 'buddypress' ) ?>" href="<?php bloginfo('rss2_url'); ?>" />
		<link rel="alternate" type="application/atom+xml" title="<?php bloginfo('name'); ?> <?php _e( 'Blog Posts Atom Feed', 'buddypress' ) ?>" href="<?php bloginfo('atom_url'); ?>" />

		<link rel="pingback" href="<?php bloginfo('pingback_url'); ?>" />

		<?php wp_head(); ?>
		
		<script type="text/javascript" src="<?php bloginfo('stylesheet_directory'); ?>/template.js"></script>

	</head>

	<body <?php body_class() ?> id="bp-default">

		<?php do_action( 'bp_before_header' ) ?>
		
        <!-- global gnome.org domain bar -->
        <div id="global_domain_bar">
            <div class="maxwidth">
                <div class="tab">
                    <a class="root" href="http://www.gnome.org/">GNOME.org</a>
                    <?php if ( is_user_logged_in() ) : ?>
                    <a class="user" href="<?php echo bp_loggedin_user_domain() ?>"><?php echo bp_core_get_username( bp_loggedin_user_id() ); ?></a>
                    <?php else: ?>
                    <a href="<?php echo get_bloginfo('url') . '/wp-login.php'; ?>">Login</a>
                    <?php endif; ?>
                </div>
                <div class="user_settings">
                    <ul>
                        <li><a href="<?php echo bp_loggedin_user_domain() ?>">Your profile</a></li>
                        <li><a href="<?php echo bp_loggedin_user_domain() ?>settings/">Settings</a></li>
                        <li><a href="<?php echo wp_logout_url( bp_get_root_domain() ) ?>">Log out</a></li>
                    </ul>
                </div>
            </div>
        </div>
        
        <div class="maxwidth">

		    <div id="gnome_header">

			    <h1 id="logo">
			        <a href="<?php echo site_url() ?>" title="<?php _e( 'Home', 'buddypress' ) ?>">
			        <?php
		            
		            /*
		             * Replace the word "GNOME" with the famous foot
		             */
		            
        			$gnome_logo = get_blog_option( BP_ROOT_BLOG, 'blogname' );
        			$gnome_logo = str_replace('GNOME', '<img src="'.get_bloginfo('stylesheet_directory').'/images/foot.png" alt="GNOME" />', $gnome_logo);
        			
        			echo $gnome_logo;
            			
			        ?>
			        </a>
		        </h1>

			    <ul id="globalnav">
				    <li<?php if ( bp_is_front_page() ) : ?> class="selected"<?php endif; ?>>
					    <a href="<?php echo site_url() ?>" title="<?php _e( 'Home', 'buddypress' ) ?>"><?php _e( 'Home', 'buddypress' ) ?></a>
				    </li>

				    <?php if ( 'activity' != bp_dtheme_page_on_front() && bp_is_active( 'activity' ) ) : ?>
					    <li<?php if ( bp_is_page( BP_ACTIVITY_SLUG ) ) : ?> class="selected"<?php endif; ?>>
						    <a href="<?php echo site_url() ?>/<?php echo BP_ACTIVITY_SLUG ?>/" title="<?php _e( 'Activity', 'buddypress' ) ?>"><?php _e( 'Activity', 'buddypress' ) ?></a>
					    </li>
				    <?php endif; ?>

				    <li<?php if ( bp_is_page( BP_MEMBERS_SLUG ) || bp_is_member() ) : ?> class="selected"<?php endif; ?>>
					    <a href="<?php echo site_url() ?>/<?php echo BP_MEMBERS_SLUG ?>/" title="<?php _e( 'Members', 'buddypress' ) ?>"><?php _e( 'Members', 'buddypress' ) ?></a>
				    </li>

				    <?php if ( bp_is_active( 'groups' ) ) : ?>
					    <li<?php if ( bp_is_page( BP_GROUPS_SLUG ) || bp_is_group() ) : ?> class="selected"<?php endif; ?>>
						    <a href="<?php echo site_url() ?>/<?php echo BP_GROUPS_SLUG ?>/" title="<?php _e( 'Groups', 'buddypress' ) ?>"><?php _e( 'Groups', 'buddypress' ) ?></a>
					    </li>

					    <?php if ( bp_is_active( 'forums' ) && ( function_exists( 'bp_forums_is_installed_correctly' ) && !(int) bp_get_option( 'bp-disable-forum-directory' ) ) && bp_forums_is_installed_correctly() ) : ?>
						    <li<?php if ( bp_is_page( BP_FORUMS_SLUG ) ) : ?> class="selected"<?php endif; ?>>
							    <a href="<?php echo site_url() ?>/<?php echo BP_FORUMS_SLUG ?>/" title="<?php _e( 'Forums', 'buddypress' ) ?>"><?php _e( 'Forums', 'buddypress' ) ?></a>
						    </li>
					    <?php endif; ?>
				    <?php endif; ?>

				    <?php if ( bp_is_active( 'blogs' ) && bp_core_is_multisite() ) : ?>
					    <li<?php if ( bp_is_page( BP_BLOGS_SLUG ) ) : ?> class="selected"<?php endif; ?>>
						    <a href="<?php echo site_url() ?>/<?php echo BP_BLOGS_SLUG ?>/" title="<?php _e( 'Blogs', 'buddypress' ) ?>"><?php _e( 'Blogs', 'buddypress' ) ?></a>
					    </li>
				    <?php endif; ?>

				    <?php do_action( 'bp_nav_items' ); ?>
			    </ul><!-- #nav -->

			    <div class="right" id="search-bar">

				    <?php if ( bp_search_form_enabled() ) : ?>

					    <form action="<?php echo bp_search_form_action() ?>" method="post" id="search-form">
						    <?php
						    
						    /*
						     * Choose which search type is active
						     */
						    
						    if (bp_is_page(BP_GROUPS_SLUG) || bp_is_group()) {
						        $search_which = 'groups';
						        $search_placeholder = 'Search for groups...';
						    } elseif (bp_is_page(BP_FORUMS_SLUG)) {
						        $search_which = 'forums';
						        $search_placeholder = 'Search in forum...';
						    } else {
						        $search_which = 'members';
						        $search_placeholder = 'Search for members...';
						    }
						    
						    if (array_key_exists('s', $_GET) && !empty($_GET['s'])) {
    						    $search_default_value = htmlspecialchars(stripslashes($_GET['s']));
						    } else {
						        $search_default_value = '';
						    }
						    
						    ?>
						    <input type="text" id="search_input" name="search-terms" value="<?php echo $search_default_value; ?>" placeholder="<?php echo $search_placeholder; ?>" />
						    <input type="hidden" name="search-which" value="<?php echo $search_which;?>" />

						    <?php wp_nonce_field( 'bp_search_form' ) ?>
					    </form><!-- #search-form -->

				    <?php endif; ?>

				    <?php do_action( 'bp_search_login_bar' ) ?>

			    </div><!-- #search-bar -->

			    <?php do_action( 'bp_header' ) ?>

		    </div><!-- #header -->
		    
    		<?php do_action( 'bp_after_header' ) ?>
		    
	    </div>
	    
	    <div class="clear"></div>

		<?php do_action( 'bp_before_container' ) ?>
		
		<div class="maxwidth">

    		<div id="container">
