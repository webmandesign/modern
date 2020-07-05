# Modern Changelog

## 2.4.3

* **Update**: Updating CSS Vars Ponyfill JS
* **Update**: Improved accessibility styles
* **Fix**: Homepage slideshow not working
* **Fix**: Search form submit button alignment
* **Fix**: Intro image not fullwidth
* **Fix**: Safari browser linear gradient issue
* **Fix**: Mobile navigation double tap issue
* **Fix**: Color contrast on focused skip links

### Files changed:

	changelog.md
	readme.txt
	style.css
	assets/js/scripts-navigation-accessibility.js
	assets/scss/_css-vars.scss
	assets/scss/custom-styles.scss
	assets/scss/main.scss
	includes/custom-header/class-intro.php
	includes/customize/class-customize-styles.php
	includes/customize/class-customize.php
	includes/frontend/class-assets.php
	includes/plugins/ns-featured-posts/class-ns-featured-posts.php
	library/changelog.md
	library/includes/classes/class-css-variables.php
	library/js/vendors/css-vars-ponyfill/css-vars-ponyfill.js
	library/js/vendors/css-vars-ponyfill/css-vars-ponyfill.min.js


## 2.4.2

* **Update**: Adding `nofollow` rel attribute to footer links
* **Update**: Removing demo content XML and setting manual import for One Click Demo Import plugin to comply with WordPress.org theme requirements
* **Update**: Localization
* **Fix**: Not wrapping post excerpt in additional DIV when its empty
* **Fix**: Removing "Continue reading" link from blog page excerpt

### Files changed:

	changelog.md
	index.php
	style.css
	includes/frontend/class-post-summary.php
	includes/plugins/one-click-demo-import/class-one-click-demo-import.php
	includes/welcome/class-welcome.php
	library/changelog.md
	template-parts/footer/site-info.php


## 2.4.1

* **Add**: Adding WhatsApp and Google social icon
* **Update**: Implementing WordPress 5.2 code updates
* **Fix**: Preventing PHP error after theme activation

### Files changed:

	changelog.md
	header.php
	readme.txt
	style.css
	assets/images/svg/social-icons.svg
	includes/frontend/class-header.php
	includes/frontend/class-menu.php
	includes/welcome/welcome.php
	template-parts/admin/notice-welcome.php
	template-parts/admin/welcome-demo.php
	template-parts/admin/welcome-footer.php
	template-parts/admin/welcome-header.php
	template-parts/admin/welcome-promo.php
	template-parts/admin/welcome-quickstart.php
	template-parts/admin/welcome-wordpress.php


## 2.4.0

* **Update**: Navigation accessibility and touch screen functionality
* **Update**: Improving intro image accessibility
* **Update**: Custom typography info in theme options
* **Update**: Improving accessibility skip links
* **Update**: Excerpts display
* **Update**: Info about demo required plugins
* **Update**: Demo content
* **Update**: Welcome page and notice
* **Update**: Improving CSS variables functionality for browsers with no support
* **Update**: Donation links
* **Update**: Improving code
* **Update**: Localization
* **Fix**: CSS variables background image code escaping
* **Fix**: Gallery post format slideshow not working with Gutenberg editor

### Files changed:

	changelog.md
	footer.php
	header.php
	readme.txt
	style.css
	assets/js/scripts-navigation-accessibility.js
	assets/scss/custom-styles-editor.scss
	includes/custom-header/class-intro.php
	includes/customize/class-customize.php
	includes/frontend/class-header.php
	includes/frontend/class-menu.php
	includes/frontend/class-post-media.php
	includes/frontend/class-post-summary.php
	includes/plugins/one-click-demo-import/class-one-click-demo-import.php
	includes/plugins/one-click-demo-import/demo-content-modern.xml
	includes/post-formats/class-post-formats.php
	includes/welcome/class-welcome.php
	languages/modern.pot
	library/includes/classes/class-core.php
	library/includes/classes/class-css-variables.php
	template-parts/admin/notice-welcome.php
	template-parts/admin/welcome-footer.php
	template-parts/admin/welcome-header.php
	template-parts/admin/welcome-promo.php
	template-parts/component/link-more.php
	template-parts/content/content.php
	template-parts/header/links-skip.php
	template-parts/meta/entry-meta-element-comments.php
	template-parts/meta/entry-meta-element-date.php


## 2.3.1

* **Update**: Removing obsolete files (related to v2.0.0 upgrade notices)
* **Update**: Localization

### Files changed:

	changelog.md
	readme.txt
	style.css
	languages/*.*
	removing template-parts/admin/notice-upgrade-2.0.0.php
	removing template-parts/admin/notice-upgrade-child-theme-2.0.0.php


## 2.3.0

* **Update**: Support URL
* **Update**: Improving code
* **Update**: Improving security
* **Update**: Improving accessibility
* **Update**: Adding WPCS comments to code
* **Update**: Improving customizer functionality
* **Update**: Using CSS variables instead of generating customized styles
* **Update**: Removing obsolete functionality
* **Update**: Updating readme file
* **Update**: Setting `use strict` in JavaScript
* **Update**: Removing all `locate_template()` function references
* **Update**: Localization
* **Update**: Documentation
* **Update**: Removing old theme v2.0.0 upgrade notices and code (to update from pre v2.0.0 to v2.3.0, user need to install v2.0.0 first)
* **Fix**: Styling issues

### Files changed:

	changelog.md
	readme.txt
	style.css
	assets/js/customize-preview.js
	assets/js/scripts-global.js
	assets/js/scripts-navigation-accessibility.js
	assets/js/scripts-navigation-mobile.js
	assets/js/skip-link-focus-fix.js
	assets/scss/_css-vars.scss
	assets/scss/_setup.scss
	assets/scss/custom-styles-editor.scss
	assets/scss/custom-styles.scss
	assets/scss/main.scss
	includes/customize/class-customize-styles.php
	includes/customize/class-customize.php
	includes/frontend/class-assets.php
	includes/frontend/class-loop.php
	includes/frontend/class-menu.php
	includes/frontend/class-post-media.php
	includes/frontend/class-post.php
	includes/post-formats/class-post-formats.php
	includes/setup/class-setup.php
	languages/*.*
	library/changelog.md
	library/init.php
	library/includes/classes/class-admin.php
	library/includes/classes/class-core.php
	library/includes/classes/class-css-variables.php
	library/includes/classes/class-customize-control-html.php
	library/includes/classes/class-customize-control-multiselect.php
	library/includes/classes/class-customize-control-radio-matrix.php
	library/includes/classes/class-customize-control-select.php
	library/includes/classes/class-customize.php
	library/includes/classes/class-sanitize.php
	library/js/customize-control-multicheckbox.js
	library/js/customize-control-radio-matrix.js
	library/js/customize-controls.js
	template-parts/admin/welcome-header.php
	template-parts/admin/welcome-quickstart.php


## 2.2.3

* **Add**: More social icons
* **Update**: WordPress 5.0 ready
* **Update**: Loading Genericons Neue as separate stylesheet
* **Update**: Advanced Custom Fields plugin compatibility
* **Fix**: Making social icons menu multilingual ready
* **Fix**: Blog homepage intro text accepting empty value

### Files changed:

	changelog.md
	functions.php
	style.css
	assets/fonts/genericons-neue/*.*
	assets/images/svg/social-icons.svg
	assets/js/scripts-slick.js
	assets/scss/main.scss
	includes/frontend/class-assets.php
	includes/frontend/class-menu.php
	includes/frontend/class-svg.php
	includes/plugins/advanced-custom-fields/advanced-custom-fields.php
	includes/plugins/advanced-custom-fields/class-advanced-custom-fields.php
	includes/tgmpa/class-tgmpa-plugins.php
	library/includes/classes/class-visual-editor.php
	template-parts/intro/intro-content.php
	template-parts/menu/menu-social.php


## 2.2.2

* **Fix**: Theme options sanitization

### Files changed:

	changelog.md
	style.css
	includes/customize/class-customize.php


## 2.2.1

* **Fix**: Blog page excerpt display

### Files changed:

	changelog.md
	index.php
	style.css


## 2.2.0

* **Add**: Masonry posts layout option
* **Update**: Library 2.7.0
* **Update**: CSS Starter 4.0.2
* **Update**: Removing archive title options in favor of plugin
* **Update**: Improving NS Featured Posts plugin compatibility
* **Update**: Improving post meta display
* **Update**: Improving stylesheets loading
* **Update**: Localization
* **Fix**: All Envato Theme Check plugin test requirements
* **Fix**: Jetpack Author Bio display
* **Fix**: Intro image width on mobile devices
* **Fix**: "Back to top" button accessibility

### Files changed:

	changelog.md
	style.css
	assets/js/scripts-global.js
	assets/js/scripts-masonry.js
	assets/js/scripts-slick.js
	assets/scss/editor-style.scss
	assets/scss/main.scss
	assets/scss/starter/*.*
	includes/customize/class-customize-styles.php
	includes/customize/class-customize.php
	includes/frontend/class-assets.php
	includes/frontend/class-header.php
	includes/frontend/class-loop.php
	includes/frontend/class-menu.php
	includes/frontend/class-post.php
	includes/plugins/jetpack/class-jetpack-content-options.php
	includes/plugins/jetpack/class-jetpack-custom-post-types.php
	includes/plugins/jetpack/class-jetpack-setup.php
	includes/plugins/ns-featured-posts/class-ns-featured-posts.php
	includes/welcome/welcome.php
	languages/modern.pot
	library/*.*
	template-parts/footer/site-info.php
	template-parts/intro/intro-content.php
	template-parts/loop/loop-front-blog.php
	template-parts/loop/loop-front-portfolio.php
	template-parts/loop/loop-front-testimonials.php
	template-parts/menu/menu-primary.php


## 2.1.0

* **Add**: Adding intro background color option description
* **Update**: WordPress 4.9.6 compatibility (GDPR)
* **Update**: Improving nested comments indentation
* **Update**: Localization
* **Fix**: Intro background color display in customizer

### Files changed:

	changelog.md
	style.css
	assets/scss/main.scss
	includes/customize/class-customize.php
	includes/frontend/class-header.php
	languages/modern.pot
	template-parts/footer/site-info.php


## 2.0.3

* **Update**: Improving blog page summary display
* **Fix**: Intro section color styles
* **Fix**: Minor RTL styles issue with skip links

### Files changed:

	changelog.md
	index.php
	style.css
	assets/scss/custom-styles.scss
	assets/scss/main.scss


## 2.0.2

* **Add**: RSS and Xing social icons
* **Update**: Demo content files
* **Update**: Improving One Click Demo Import plugin compatibility, preventing PHP errors
* **Fix**: Reintroducing post formats support for Jetpack Portfolio projects
* **Fix**: Gaps between social links on mobile devices
* **Fix**: Intro image display on blog front page

### Files changed:

	changelog.md
	style.css
	assets/images/svg/symbol-rss.svg
	assets/images/svg/symbol-xing.svg
	assets/scss/main.scss
	includes/custom-header/class-intro.php
	includes/custom-header/class-menu.php
	includes/plugins/jetpack/class-jetpack-custom-post-types.php
	includes/plugins/one-click-demo-import/class-one-click-demo-import.php
	includes/plugins/one-click-demo-import/demo-content-modern.xml


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
