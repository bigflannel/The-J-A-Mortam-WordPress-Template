/*
 Small Town Inertia Wordpress Template
 http://bigflannel.com/the-j-a-mortram/
 Copyright (c) 2013 bigflannel, Mike Hartley, Jim Mortram
 Licensed under the GNU General Public License
 (See http://www.gnu.org/licenses/gpl-2.0.html)
*/

var imagesOnPage;
var imageOrderOnPageByID = new Array();
var screenWidth;
var screenHeight;
var devicePixelRatio;
var imageSRCsbyIDs;
var addHTML;
var classList;
var classSplit;
var imageID;
var imageOrder;
var i;
var j;

var getImagesByID = function() {
	imagesOnPage = jQuery('#the-content img');
	for (i = 0; i < imagesOnPage.length; i++) {
		// calculate the imageID
		classList = imagesOnPage[i].className.split(/\s+/);
		for (j = 0; j < classList.length; j++) {
			if (classList[j].indexOf('wp-image-')==0) {
				classSplit = classList[j].split('-');
				imageOrderOnPageByID.push(classSplit[2]);
			}
		}
	}
}

var addFullscreenImages = function () {
	screenWidth = screen.width;
	screenHeight = screen.height;
	if (screenWidth > screenHeight) {
		maxScreenDimension = screenWidth;
	} else {
		maxScreenDimension = screenHeight;
	}
	devicePixelRatio = window.devicePixelRatio;
	if (devicePixelRatio == undefined) {
		devicePixelRatio = 1;
	}
	maxScreenDimension = maxScreenDimension * devicePixelRatio;
	if (maxScreenDimension > 900) {
		imageSRCsbyIDs = largeImageSRCsbyIDs;
	} else {
		imageSRCsbyIDs = mediumImageSRCsbyIDs;
	}
	jQuery('#image-for-fullscreen').css({
		'width': screenWidth,
		'height': screenHeight
	});
	addHTML = '<span class="helper"></span>';
	for (i = 0; i < imageOrderOnPageByID.length; i++) {
		addHTML = addHTML + '<img id="' + imageOrderOnPageByID[i] + '" src="' + imageSRCsbyIDs[imageOrderOnPageByID[i]] + '" />';
	}
	jQuery('#image-list').html(addHTML);
	// set a height so the css centering technique works
	jQuery('#image-list').css('height', screenHeight - jQuery('#image-for-fullscreen header').outerHeight(true) - jQuery('#image-for-fullscreen nav').outerHeight(true));
	for (i = 0; i < imageOrderOnPageByID.length; i++) {
		jQuery('#'+imageOrderOnPageByID[i]).css({
			'vertical-align': 'middle',
			'display': 'none',
			'max-width': screenWidth*.9,
			'max-height': screenHeight - jQuery('#image-for-fullscreen header').outerHeight(true) - jQuery('#image-for-fullscreen nav').outerHeight(true)
		});
	}
}

var addImageClickHandler = function () {
	jQuery('#the-content img').css('cursor','pointer');
	jQuery('#the-content img').click( function imageClicked(event) {
		classList = jQuery(event.target).attr('class').split(/\s+/);
		for (i = 0; i < classList.length; i++) {
			if (classList[i].indexOf('wp-image-')==0) {
				classSplit = classList[i].split('-');
				imageID = classSplit[2];
			}
		}
		for (i = 0; i < imageOrderOnPageByID.length; i++) {
			if (imageOrderOnPageByID[i] == imageID) {
				imageOrder = i;
			}
		}
		jQuery('#'+imageOrderOnPageByID[imageOrder]).css('display','inline');
		setFullscreenNav();
		jQuery('#image-for-fullscreen').css('display','block');
		jQuery(document).bind("fullscreenerror", function() {
		    removeImageClickHandler();
		});
		jQuery('#image-for-fullscreen').fullScreen(true);
	});
}

var removeImageClickHandler = function () {
	jQuery('#the-content img').off('click');
	jQuery('#the-content img').css('cursor','auto');
	jQuery('#image-for-fullscreen').css('display','none');
}

var setFullscreenNav = function () {
	if (imageOrderOnPageByID.length == 1) {
		jQuery('#image-for-fullscreen #post-nav').css('visibility','hidden');
	} else {
		if (imageOrder == 0) {
			jQuery('#image-prev').css('visibility','hidden');
		} else {
			jQuery('#image-prev').css('visibility','visible');
		}
		if (imageOrder == imageOrderOnPageByID.length-1) {
			jQuery('#image-next').css('visibility','hidden');
		} else {
			jQuery('#image-next').css('visibility','visible');
		}
	}
}

var addExitFullscreen = function () {
	// hide images when drop back from fullscreen
	jQuery(document).bind("fullscreenchange", function() {
	    if (jQuery(document).fullScreen() == false) {
	    	jQuery('#'+imageOrderOnPageByID[imageOrder]).css('display','none');
	    	jQuery('#image-for-fullscreen').css('display','none');
	    }
	});
}

var addFullscreenNavClickHandler = function () {
	jQuery('#post-nav').click( function navClicked(event) {
		if (event.target.id == 'image-prev') {
			prevClicked();
		} else if (event.target.id == 'image-next') {
			nextClicked();
		}
	});
}

var prevClicked = function () {
	if (imageOrder > 0) {
		jQuery('#'+imageOrderOnPageByID[imageOrder]).css('display','none');
		imageOrder = imageOrder - 1;
		jQuery('#'+imageOrderOnPageByID[imageOrder]).css('display','inline');
	}
	setFullscreenNav();	
}

var nextClicked = function () {
	if (imageOrder < imageOrderOnPageByID.length-1) {
		jQuery('#'+imageOrderOnPageByID[imageOrder]).css('display','none');
		imageOrder = imageOrder + 1;
		jQuery('#'+imageOrderOnPageByID[imageOrder]).css('display','inline');
	}
	setFullscreenNav();
}

function singleConstructor() {
	if (jQuery(document).fullScreen() != null) {
		// get an array of images in the content of the page by ID by order on page
		getImagesByID();
		// add fullscreen images to the page
		addFullscreenImages();
		// add a click handler to take images fullscreen
		addImageClickHandler();
		// add leaving fullscreen handler
		addExitFullscreen();
		// add the fullscreen nav click handler
		addFullscreenNavClickHandler();
	}
}

