# Modern Changelog

## 2.0.1

* **Fix**: Quote post format metabox title

### Files changed:

	changelog.md
	style.css
	includes/plugins/advanced-custom-fields/class-advanced-custom-fields.php
	languages/modern.pot


## 2.0.0

* **Add**: A lot of theme customization options
* **Add**: Installing theme demo with one click
* **Add**: Theme "Welcome" admin page (under Appearance admin menu)
* **Add**: Making the theme accessibility ready
* **Add**: Compatibility with any page builder plugin
* **Add**: Compatibility with Jetpack Testimonials content type
* **Add**: Compatibility with Jetpack Content Options
* **Add**: Ability to display sidebar on any page/post
* **Add**: More post editor "Formats" dropdown styles
* **Add**: Easy post/page options setup with Advanced Custom Fields plugin compatibility
* **Add**: Right To Left languages support
* **Add**: More custom header images out of the box
* **Add**: Compatibility with WPML and Polylang multilingual plugins
* **Add**: Support for page excerpt
* **Add**: Simple theme starter content
* **Update**: Improved compatibility with WordPress 4.9
* **Update**: Library 2.6.0
* **Update**: CSS Starter 4.0.1
* **Update**: Code organization and improvements
* **Update**: Removing microformats (Schema.org) markup in favor of dedicated plugins
* **Update**: Improving and optimizing JavaScript codes
* **Update**: Dropping Internet Explorer 9 and 10 compatibility
* **Update**: Improving CSS styles
* **Update**: Improving theme performance
* **Update**: Improved sticky header
* **Update**: Improved responsive styles
* **Update**: Using SVG for social icons
* **Update**: Ability to display social icons in a Navigational Menu widget anywhere on the website
* **Update**: Making custom typography more flexible by supporting 3rd party plugins
* **Update**: Theme demo content and website
* **Update**: Localization
* **Update**: Documentation
* **Fix**: Front page slideshow controls issues
* **Fix**: Featured image size on single post and page
* **Fix**: All reported issues

### Files changed:

	*.* (Yes, all files have been changed in this update.)


## 1.4.6

* **Fix**: Gallery post slideshow navigation issue

### Files changed:

	js/scripts-global.js


## 1.4.5

* **Add**: WordPress 4.3 support
* **Add**: Touch enabled navigation, accessible with Tab key
* **Update**: Updated scripts: TGM Plugin Activation 2.5.2, Slick 1.5.8
* **Update**: Improved featured image size setup for pages
* **Update**: Licensed under GPLv3
* **Update**: Admin interface
* **Update**: Documentation (user manual)
* **Fix**: Google Fonts URL function subset issue
* **Fix**: Fixed issue with masonry footer layout when using Jetpack's infinite scroll
* **Fix**: Slider issue

### Files changed:

	license.txt
	readme.md
	style.css
	css/admin.css
	css/customizer.css
	css/slick.css
	inc/setup-theme-options.php
	inc/setup.php
	inc/customizer/customizer.php
	inc/lib/admin.php
	inc/lib/core.php
	inc/tgmpa/class-tgm-plugin-activation.php
	js/scripts-global.js
	js/scripts-navigation.js


## 1.4.4

* **Fix**: Search field text color on error 404 and nothing found page
* **Fix**: `wmhook_entry_image_link` is not applied correctly on page content

### Files changed:

	style.css
	content-page.php


## 1.4.3

* **Update**: Using new prefixed image sizes

### Files changed:

	content-custom-header.php
	content-featured-post.php


## 1.4.2

* **Update**: TGM Plugin Activation 2.4.2
* **Update**: Removing `example.html` Genericons file
* **Update**: Prefixed custom theme image sizes
* **Update**: Enqueuing `comment-reply.js` the right way
* **Update**: Saving image size setup into theme mod, not individual options
* **Update**: Removing obsolete constants

### Files changed:

	functions.php
	genericons/example.html
	inc/setup.php
	inc/setup-theme-options.php
	inc/lib/admin.php
	inc/lib/core.php
	inc/tgmpa/class-tgm-plugin-activation.php


## 1.4.1

* **Update**: TGM Plugin Activation 2.4.1
* **Update**: Starter CSS

### Files changed:

	css/starter.css
	inc/tgmpa/class-tgm-plugin-activation.php


## 1.4

* **Add**: Sticky mobile navigation button
* **Update**: Removed obsolete `loop-singular.php` file
* **Update**: Tightening security
* **Update**: Improved code

### Files changed:

	style.css
	inc/setup-theme-options.php
	inc/setup.php
	inc/lib/core.php
	inc/tgmpa/class-tgm-plugin-activation.php
	js/scripts-global.js


## 1.3

* **Add**: Additional post classes
* **Update**: Image size setup message
* **Update**: Typography setup simplified
* **Update**: Library and custimizer
* **Update**: Localization
* **Update**: Scripts
* **Fix**: Page with sidebar template layout when comments enabled (disabled comments for this page template)
* **Fix**: Responsive sidebar width
* **Fix**: Customizer script dependency

### Files changed:

	content-audio.php
	content-custom-header.php
	content-featured-post.php
	content-gallery.php
	content-image.php
	content-link.php
	content-page.php
	content-status.php
	content-video.php
	content.php
	functions.php
	image.php
	css/starter.css
	inc/setup.php
	inc/customizer/customizer.php
	inc/lib/core.php
	languages/sk_SK.mo
	languages/sk_SK.po
	languages/xx_XX.pot
	page-template/_sidebar.php


## 1.2.3

* **Fix**: Error on older versions of PHP

### Files changed:

	inc/setup.php


## 1.2.2

* **Update**: Allowed to set custom image sizes via WordPress admin
* **Update**: Localization
* **Update**: Editor styles
* **Fix**: Displaying `title` tag in HTML head
* **Fix**: Comments display condition

### Files changed:

	comments.php
	css/editor-styles.css
	inc/setup.php
	languages/sk_SK.mo
	languages/sk_SK.po
	languages/xx_XX.pot


## 1.2.1

* **Fix**: Incorrect filter hook name

### Files changed:

	inc/setup.php


## 1.2

* **Add**: Posts Views Count plugin support
* **Add**: NS Featured Posts plugin support for populating banner slideshow
* **Update**: Updated core framework
* **Update**: Updated copyright year
* **Update**: Optimized code
* **Update**: Updated scripts
* **Update**: Reorganized Customizer options
* **Update**: Using starter.css stylesheet
* **Update**: Optimized editor-style.css
* **Update**: Localization texts
* **Update**: Removed obsolete files and functions
* **Update**: User manual update
* **Fix**: Fixed and updated hooks
* **Fix**: Styles fixes
* **Fix**: Responsive styles

### Files changed:

	archive.php
	content-audio.php
	content-featured-post.php
	content-gallery.php
	content-image.php
	content-link.php
	content-page.php
	content-quote.php
	content-status.php
	content-video.php
	content.php
	functions.php
	header.php
	image.php
	sidebar-footer.php
	sidebar.php
	css/customizer.css
	css/editor-style.css
	css/starter.css
	inc/setup-theme-options.php
	inc/setup.php
	inc/custom-header/custom-header.php
	inc/customizer/customizer.php
	inc/jetpack/jetpack.php
	inc/lib/admin.php
	inc/lib/core.php
	inc/lib/hooks.php
	inc/lib/visual-editor.php
	inc/tgmpa/class-tgm-plugin-activation.php
	inc/tgmpa/plugins.php
	js/scripts.js
	js/skip-link-focus-fix.js


## 1.1.5

* **Add**: Original (not minified) JS scripts

### Files changed:

	js/dev/imagesloaded.pkgd.js
	js/dev/slick.js


## 1.1

* **Add**: WordPress 4.1 compatibility
* **Add**: Page edit link on front end
* **Add**: New icons to social links
* **Add**: Breadcrumbs support
* **Add**: Option to override header image
* **Update**: Stylesheet structure (colors grouped together)
* **Update**: Styles
* **Update**: Status post logic
* **Update**: Custom singular JS output
* **Update**: Mobile pagination styling
* **Update**: Tagcloud styles
* **Update**: Copyright info in readme file
* **Update**: Localization
* **Update**: Functions names
* **Update**: Theme options
* **Update**: Code organization
* **Update**: Scripts
* **Update**: `demo.xml` file
* **Update**: Removed unnecessary hooks
* **Fix**: Jetpack related posts styling
* **Fix**: Nested ordered lists styling
* **Fix**: Styling issues
* **Fix**: Filter hook names

### Files changed:

	archive.php
	comments.php
	content-audio.php
	content-custom-header.php
	content-featured-post.php
	content-gallery.php
	content-image.php
	content-link.php
	content-page.php
	content-status.php
	content-video.php
	content.php
	demo-content.xml
	functions.php
	header.php
	image.php
	loop-banner.php
	readme.md
	readme.txt
	searchform.php
	sidebar-footer.php
	style.css
	css/_custom.css
	css/colors.css
	css/editor-styles.css
	css/slick.css
	inc/post-formats.php
	inc/setup.php
	inc/setup-theme-options.php
	inc/customizer/customizer.php
	inc/customizer/controls/class-WM_Customizer_Hidden.php
	inc/customizer/controls/class-WM_Customizer_HTML.php
	inc/customizer/controls/class-WM_Customizer_Image.php
	inc/customizer/controls/class-WM_Customizer_Multiselect.php
	inc/customizer/controls/class-WM_Customizer_Select.php
	inc/customizer/controls/class-WM_Customizer_Textarea.php
	inc/jetpack/jetpack.php
	inc/lib/admin.php
	inc/lib/core.php
	inc/tgmpa/plugins.php
	page-template/_sidebar.php
	languages/readme.md
	languages/sk_SK.mo
	languages/sk_SK.po
	languages/wm_domain.pot


## 1.0

* Initial release.
