jQuery(function() {
    
    /* Global Domain bar user area */
    
    jQuery('body').click(function(e) {
        
        global_domain_bar_user_settings('close');
        
    });
    
    function global_domain_bar_user_settings(action) {
        
        if (action == 'open') {
            
            jQuery('#global_domain_bar .user').addClass('active');
            
            jQuery('#global_domain_bar .user_settings').show().css({top: '-10px', opacity: 0}).animate({top: '0', opacity: 1}, 200);
            
        } else if (action == 'close') {
            
            jQuery('#global_domain_bar .user').removeClass('active');
            
            jQuery('#global_domain_bar .user_settings').animate({top: '10px', opacity: 0}, 200, function() {
                jQuery(this).hide();
            });
        }
        
    }
    
    jQuery('#global_domain_bar .user').click(function(e) {
        
        e.preventDefault();
        
        e.stopPropagation();
        
        if (!jQuery(this).hasClass('active')) {
            global_domain_bar_user_settings('open');
        } else {
            global_domain_bar_user_settings('close');
        }
        
    });

});
