jQuery(function() {

    jQuery('#whats-new').click(function(e) {
    
        jQuery('#whats-new-options').slideDown();
    
    }).blur(function(e) {
    
        if(jQuery(this).val() == '') {
                
            jQuery('#whats-new-options').slideUp();
        
        }
    
    });

});
