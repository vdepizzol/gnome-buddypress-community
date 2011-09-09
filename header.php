<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml" <?php language_attributes(); ?>>
	<head profile="http://gmpg.org/xfn/11">
		<meta http-equiv="Content-Type" content="<?php bloginfo( 'html_type' ) ?>; charset=<?php bloginfo( 'charset' ) ?>" />
		<title><?php wp_title( '|', true, 'right' ); bloginfo( 'name' ); ?></title>

		<?php do_action( 'bp_head' ) ?>

		<link rel="pingback" href="<?php bloginfo( 'pingback_url' ) ?>" />

		<?php
			if ( is_singular() && bp_is_blog_page() && get_option( 'thread_comments' ) )
				wp_enqueue_script( 'comment-reply' );

			wp_head();
		?>
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
                
                <div id="globalnav" role="navigation">
                    <?php wp_nav_menu( array( 'container' => false, 'menu_id' => 'globalnav', 'theme_location' => 'primary', 'fallback_cb' => 'bp_dtheme_main_nav' ) ); ?>
                </div>
                
                <?php do_action( 'bp_header' ) ?>

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
                
            </div><!-- #header -->
            
        </div>
        
        <div class="clear"></div>

		<?php do_action( 'bp_after_header' ) ?>
		<?php do_action( 'bp_before_container' ) ?>
        
        <div class="maxwidth">

            <div id="container">
