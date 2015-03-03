# The J A Mortram

## Created by Mike Hartley and JA Mortram

A simple, elegant one column WordPress template with a fullscreen image slideshow. Designed for photo stories.

## Created for Small Town Inertia

Created for Small Town Inertia featuring the work of J A Mortram. A working example:

http://smalltowninertia.co.uk

### For more information, please visit:

http://bigflannel.com/2013/07/the-j-a-mortram-wordpress-theme/

Copyright (c) 2013 bigflannel, Mike Hartley, Jim Mortram

Licensed under the GNU General Public License
(See http://www.gnu.org/licenses/gpl-2.0.html)

# Features and Use

### WordPress Media Settings

Recommended settings:

Thumbnail 1200 x 300
[uncheck crop thumbnail]
Medium 2400 x 600
Large 4800 x 1200

### Posts

The inspiration for this theme is the work of J A Mortram. It is designed to encourage readers to go through a story and then read on about that subject or return to the main index of stories. The single post page does not have next and previous post navigation, instead it features tags as navigation at the end of the post. Single post or photo story subjects are best grouped in the theme using a post's tags.

### Post Format : Gallery

Use this format to activate fullscreen image display on a post (in those browsers that support it). All images in the post must be uploaded through the post, if you want to use an image in two posts with format gallery, you must upload the image twice. The 'Link URL' field for an added image must be empty.

### Menu Options

The theme can display three menus, one below the header ('Header') and two before the page footer ('Donate' and 'Footer'). In the footer, if it exists, 'Donate' is shown first, then 'Footer'. 'Footer' displays the default menu if none are set.

### Widget Options

The default widget in the footer is search, widgets you add will replace it and be stacked vertically.

### Footer Copyright

Set the text displayed after the footer copyright text (© 2013) using theme settings and 'Copyright Statement for Footer'.

# Changelog

### 1.16

February 18, 2015.

* Replaced jQuery Fullscreen with screenfull.js (see LICENSE.txt) to improve performance of fullscreen slideshow (was failing in Safari 8.0x).
* Added description meta tag (uses blog tagline) to home page (only).
* Maintained time in pages throughout site but deleted the <time> tag applied to them.

### 1.15

January 14, 2015.

* Added a Tagline widget that is displayed below the header image and above the header display text. Useful for adding a text based tagline below a custom header image.

### 1.14

October 11th, 2014.

* Amended all functions in functions.php to have same prefix (jam).
* Amended functions.php so all scripts added using wp_enqueue_script without using wp_register_script beforehand.
* Amended how Open Sans font is loaded from Google in functions.php (http://themeshaper.com/2014/08/13/how-to-add-google-fonts-to-wordpress-themes/).
* Amended the text-domain to be in the format the-j-a-mortram and not The J A Mortram.
* Added a header widget option between the header navigation and the start of page content.
* Removed datetime meta data from time tags.
* Updated screenshot with a creative commons licensed image.

### 1.13

October 9th, 2014.

* Added option for image as header. See 'Appearance/Header'.
* Added readme.md as .txt to WordPress upload.
* Updated theme home page.
* Updated screenshot.png to be 880px by 660px.
* Removed <?php screen_icon('themes'); ?> from functions.php as deprecated.
* Amended theme description to use fluid-layout and responsive-layout tags rather than flexible-layout.

### 1.12

September 11th, 2013.

* Removed readme.md from the WordPress upload.

### 1.11

September 9th, 2013.

* Amended version in styles.css.

### 1.10

September 9th, 2013.

* Amended readme.md.

### 1.09

September 9th, 2013.

* Share This Story styling removed from styles.css.
* Removed Social Media Share Buttons text from Features and Use Section of readme.
* Renamed Site menu as Footer and added a Header menu that displays below the blog title and description.
* Amended Post Format : Gallery description in readme.
* Removed comma between date and comments below title of a single post.
* Amended excerpt suffix '[...]' on home/archive pages to be a link to the post.

### 1.08

July 23rd, 2013.

* 'Share this story' removed from theme options.

### 1.07

July 22nd, 2013.

* Remaining Google Analytics options code removed from functions.php.
* Amended header.php to set page title meta tag using wp_title filter and a function in functions.php.
* Comment-reply script now enqueued in functions.php.
* PHP code and Javascript used in single.php to pass data to javascript moved and functionality added using action loop_start in functions.php
* Clear float styling added to the_content in page.php.
* Captioned images styled to not overflow their containers.
* Added style rules to table, th and td elements.
* Added style rules to nest unordered lists and nest and number ordered lists.
* Non-breaking text styled so does not overflow the container.
* Next and previous image navigation added to attachment page.
* home_url() replaced with esc_url(home_url('/')) throughout theme.
* CSS edited to conform with WordPress Theme Development CSS best practices.
* Amended code for sharing in single page so validates.
* Amended readme.md to better describe template use. Discusses post navigation by tag and setting post subjects as tags.

### 1.06

July 8, 2013.

* In functions.php, content width, add theme support and register nav menus wrapped in a function 'jam_theme_setup' and added to 'after_setup_theme' action.
* In functions.php, register sidebar wrapped in function 'jam_register_sidebar' and added to 'widgets_init' action.
* Javascript call on gallery posts now called from site.js, rather than html-footer.php.
* WordPress data passed to site.js using wp_localize_script in functions.php / starkers_script_enqueuer.
* Amended theme javascript to only load on pages it is needed (single.php in post format gallery).
* Google Analytics removed from theme options.

### 1.05

June 16, 2013.

* Added navigation by keystroke to fullscreen image slideshow.
* Added a fullscreen icon on rollover to images that go fullscreen.
* Amended all page titles to be post title | blog title, not blog title | post title.
* Added option to show Twitter, Facebook and Google+ share buttons at the end of a post.
* Internationalized all text in theme.

### 1.04

June 9, 2013.

* Fixed the way Google Font CSS enqueued.

### 1.03

May 21, 2013.

* Added a link to the post date if there is no post title. Added this to index.php, archive.php and search.php.
* Excerpt text is now set in functions.php as 'This post is password protected.'
* Google Font CSS now enqueued in functions.php.
* Categories now displayed on single post page.
* Amended screenshot.png

### 1.02

May 8, 2013.

* Amended readme.txt to be readme.md and updated the text.

### 1.01

April 16, 2013.

* 'Donate' menu only displays if set.
* README now includes information on menu options, theme settings.

### 1.0

* Initial release. April 2013.
