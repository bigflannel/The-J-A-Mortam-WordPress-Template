/*
 Small Town Inertia Wordpress Template
 http://bigflannel.com/the-j-a-mortram/
 Copyright (c) 2013 bigflannel, Mike Hartley, Jim Mortram
 Licensed under the GNU General Public License
 (See http://www.gnu.org/licenses/gpl-2.0.html)
*/

var jam = {};

jam.imagesOnPage;
jam.imageOrderOnPageByID = new Array();
jam.screenWidth;
jam.screenHeight;
jam.devicePixelRatio;
jam.imageSRCsbyIDs;
jam.addHTML;
jam.classList;
jam.classSplit;
jam.imageID;
jam.imageOrder;
var i;
var j;

jam.getImagesByID = function() {
	jam.imagesOnPage = jQuery('#the-content img');
	for (i = 0; i < jam.imagesOnPage.length; i++) {
		// calculate the jam.imageID
		jam.classList = jam.imagesOnPage[i].className.split(/\s+/);
		for (j = 0; j < jam.classList.length; j++) {
			if (jam.classList[j].indexOf('wp-image-')==0) {
				jam.classSplit = jam.classList[j].split('-');
				jam.imageOrderOnPageByID.push(jam.classSplit[2]);
			}
		}
	}
}

jam.addFullscreenImages = function () {
	jam.screenWidth = screen.width;
	jam.screenHeight = screen.height;
	var maxScreenDimension;
	if (jam.screenWidth > jam.screenHeight) {
		maxScreenDimension = jam.screenWidth;
	} else {
		maxScreenDimension = jam.screenHeight;
	}
	jam.devicePixelRatio = window.jam.devicePixelRatio;
	if (jam.devicePixelRatio == undefined) {
		jam.devicePixelRatio = 1;
	}
	maxScreenDimension = maxScreenDimension * jam.devicePixelRatio;
	if (maxScreenDimension > 900) {
		jam.imageSRCsbyIDs = largeImageSRCsbyIDs;
	} else {
		jam.imageSRCsbyIDs = mediumImageSRCsbyIDs;
	}
	jQuery('#image-for-fullscreen').css({
		'width': jam.screenWidth,
		'height': jam.screenHeight
	});
	jam.addHTML = '<span class="helper"></span>';
	for (i = 0; i < jam.imageOrderOnPageByID.length; i++) {
		jam.addHTML = jam.addHTML + '<img id="' + jam.imageOrderOnPageByID[i] + '" src="' + jam.imageSRCsbyIDs[jam.imageOrderOnPageByID[i]] + '" />';
	}
	jQuery('#image-list').html(jam.addHTML);
	// set a height so the css centering technique works
	jQuery('#image-list').css('height', jam.screenHeight - jQuery('#image-for-fullscreen header').outerHeight(true) - jQuery('#image-for-fullscreen nav').outerHeight(true));
	for (i = 0; i < jam.imageOrderOnPageByID.length; i++) {
		jQuery('#'+jam.imageOrderOnPageByID[i]).css({
			'vertical-align': 'middle',
			'display': 'none',
			'max-width': jam.screenWidth*.9,
			'max-height': jam.screenHeight - jQuery('#image-for-fullscreen header').outerHeight(true) - jQuery('#image-for-fullscreen nav').outerHeight(true)
		});
	}
}

jam.addImageClickHandler = function () {
	jQuery('#the-content img').css('cursor','pointer');
	jQuery('#the-content img').click( function imageClicked(event) {
		jam.classList = jQuery(event.target).attr('class').split(/\s+/);
		for (i = 0; i < jam.classList.length; i++) {
			if (jam.classList[i].indexOf('wp-image-')==0) {
				jam.classSplit = jam.classList[i].split('-');
				jam.imageID = jam.classSplit[2];
			}
		}
		for (i = 0; i < jam.imageOrderOnPageByID.length; i++) {
			if (jam.imageOrderOnPageByID[i] == jam.imageID) {
				jam.imageOrder = i;
			}
		}
		jQuery('#'+jam.imageOrderOnPageByID[jam.imageOrder]).css('display','inline');
		jam.setFullscreenNav();
		jQuery('#image-for-fullscreen').css('display','block');
		jQuery('#image-for-fullscreen')[0].addEventListener(screenfull.raw.fullscreenerror, function() {
			jam.removeImageClickHandler();
		});
		screenfull.request(jQuery('#image-for-fullscreen')[0]);
	});
}

jam.removeImageClickHandler = function () {
	jQuery('#the-content img').off('click');
	jQuery('#the-content img').css('cursor','auto');
	jQuery('#image-for-fullscreen').css('display','none');
}

jam.setFullscreenNav = function () {
	if (jam.imageOrderOnPageByID.length == 1) {
		jQuery('#image-for-fullscreen #post-nav').css('visibility','hidden');
	} else {
		if (jam.imageOrder == 0) {
			jQuery('#image-prev').css('visibility','hidden');
		} else {
			jQuery('#image-prev').css('visibility','visible');
		}
		if (jam.imageOrder == jam.imageOrderOnPageByID.length-1) {
			jQuery('#image-next').css('visibility','hidden');
		} else {
			jQuery('#image-next').css('visibility','visible');
		}
	}
}

jam.addExitFullscreen = function () {
	jQuery('#image-for-fullscreen')[0].addEventListener(screenfull.raw.fullscreenchange, function() {
		if (screenfull.isFullscreen) {
			jQuery(document).keyup(jam.fullscreenKeyPress);
		}
		if (!screenfull.isFullscreen) {
			jQuery(document).unbind("keyup", jam.fullscreenKeyPress);
			jQuery('#'+jam.imageOrderOnPageByID[jam.imageOrder]).css('display','none');
			jQuery('#image-for-fullscreen').css('display','none');
		}
	});
}

jam.fullscreenKeyPress = function (e) {
	if (e.keyCode == 39 || e.keyCode == 190) {
		jam.nextClicked();
	}
	if (e.keyCode == 37 || e.keyCode == 188) {
		jam.prevClicked();
	}
}

jam.addFullscreenNavClickHandler = function () {
	jQuery('#post-nav').click( function navClicked(event) {
		if (event.target.id == 'image-prev') {
			jam.prevClicked();
		} else if (event.target.id == 'image-next') {
			jam.nextClicked();
		}
	});
}

jam.prevClicked = function () {
	if (jam.imageOrder > 0) {
		jQuery('#'+jam.imageOrderOnPageByID[jam.imageOrder]).css('display','none');
		jam.imageOrder = jam.imageOrder - 1;
		jQuery('#'+jam.imageOrderOnPageByID[jam.imageOrder]).css('display','inline');
	}
	jam.setFullscreenNav();	
}

jam.nextClicked = function () {
	if (jam.imageOrder < jam.imageOrderOnPageByID.length-1) {
		jQuery('#'+jam.imageOrderOnPageByID[jam.imageOrder]).css('display','none');
		jam.imageOrder = jam.imageOrder + 1;
		jQuery('#'+jam.imageOrderOnPageByID[jam.imageOrder]).css('display','inline');
	}
	jam.setFullscreenNav();
}

jam.addFullscreenIcon = function () {
	jQuery('#the-content img').hover(
		function() {
			var positionLeft = ((700 - jQuery(this).width())/2)+5;
			// data passed to site.js in functions.php / starkers_script_enqueuer
			jQuery(this).after('<img class="fullscreen-rollover" src="' + jam_data.stylesheet_directory_uri + '/img/fullscreen.png">');
			jQuery('.fullscreen-rollover').css('left',positionLeft);
		},
		function() {
			jQuery('.fullscreen-rollover').remove();
		}
	);
}

jam.singleConstructor = function() {
	if (screenfull.enabled) {
		// get an array of images in the content of the page by ID by order on page
		jam.getImagesByID();
		// add fullscreen images to the page
		jam.addFullscreenImages();
		// add a click handler to take images fullscreen
		jam.addImageClickHandler();
		// add leaving fullscreen handler
		jam.addExitFullscreen();
		// add image rollover
		jam.addFullscreenIcon();
		// add the fullscreen nav click handler
		jam.addFullscreenNavClickHandler();
	}
}

jQuery(document).ready(function() {
	if (jQuery('body').hasClass('single-format-gallery')) {
		jam.singleConstructor();
	}
});
