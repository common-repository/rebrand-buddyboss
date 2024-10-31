jQuery(document).ready(function() {
	
	jQuery('.buddyboss-wl-setting-tabs').on('click', '.buddyboss-wl-tab', function(e) {
		e.preventDefault();
		var id = jQuery(this).attr('href');
		jQuery(this).siblings().removeClass('active');
		jQuery(this).addClass('active');
		jQuery('.buddyboss-wl-setting-tabs-content .buddyboss-wl-setting-tab-content').removeClass('active');
		jQuery('.buddyboss-wl-setting-tabs-content').find(id).addClass('active');
	});

});
 
