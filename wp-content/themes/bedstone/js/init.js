jQuery(document).ready(function($){
    console.log('jQuery version: ' + jQuery.fn.jquery); // version
    console.log('jQuery version (aliased): ' + $.fn.jquery); // version, alias confirmation

    var win = $(window),
        body = $(document.body);

    // body events and manipulation
    body
	    .on('click', 'a[rel~="external"]', function(e){
	        // rel="external" opens in new window
	        e.preventDefault();
	        window.open(this.href);
	        return false;
	    })
	    .on('click', '.toggle-nav', function(e){
            //add or remove nav-open class to body for off-canvas nav
            e.preventDefault();
	        body.toggleClass('nav-open');
	    });

});
