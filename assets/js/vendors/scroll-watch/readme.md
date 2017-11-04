# jQuery.scrollWatch

Watching for element when browser window scrolls. Useful for sticky headers.

## How to initiate?

jQuery is required for this script to work.
Initiate the script for the web page element with `$( '#masthead' ).scrollWatch();`.
You can also use some options:

```
$( '#masthead' ).scrollWatch( {
  offset      : 0,
  placeholder : true,
  fixWidth    : true,
} );
```

## How does it work?

When the element (`#masthead` from the example above) is scrolled to, the script applies a `scrolled-to-masthead` class on the HTML body. (The `masthead` part of the class is taken from the element's `data-scroll-watch-id` attribute, or `id` attribute, or the first class assigned to onto element.)

Once you scroll down past the element, a `scrolled-past-masthead` class is added onto HTML body.

If you set `offset` option (`0` by default, value is in pixels) for the script, additional `scrolled-to-masthead-offset` and `scrolled-past-masthead-offset` classes are added.

Additionally to these classes, there are basic scrolling classes applied on HTML body. When the page is not scrolled, there is `scrolled-not` class applied. When the page is scrolled, there is `scrolled` class applied together with the directional class of `scrolled-up` or `scrolled-down`.

If `placeholder` option is enabled (`true` by default) the targeted element (`#masthead` from the example above) is wrapped in `div.scroll-watch-placeholder.masthead-placeholder` placeholder (only if there is no wrapper with `.scroll-watch-placeholder` class assigned already) and height is set for this placeholder matching the element height.

If `fixWidth` option is enabled (`true` by default) and `placeholder` is also enabled, the element is set for the width of the placeholder. This helps to keep the width of the fix-positioned element the same as it was when un-fixed.

All of the forced inline styles can be overridden with CSS if needed or simply disabled via script options.

There is no responsive setup here as all of that can be targeted with CSS. This unfortunately means that script will continue working on all screen sizes. All of the above functionality is recalculated upon browser window resize or orientation change.

## HTML body classes reference

Again, here are all the HTML body classes the script applies when the window:

* `scrolled-not` - is not scrolled and on top.
* `scrolled` - is scrolled (even during page load).
* `scrolled-up` - is scrolled up.
* `scrolled-down` - is scrolled down.
* `scrolled-to-ELEMENT_ID` - is scrolled to the element.
* `scrolled-past-ELEMENT_ID` - is scrolled past the element.
* `scrolled-to-ELEMENT_ID-offset` and `scrolled-past-ELEMENT_ID-offset` - the same as above but targetting the element position with offset amount of pixels.

The `ELEMENT_ID` above is retrieved from (ordered by priority, 1 being highest):

1. Element `data-scroll-watch-id` attribute: `fixed-header` from `<header class="site-header sticky-header" id="masthead" data-scroll-watch-id="fixed-header">`
2. Element `id` attribute: `masthead` from `<header class="site-header sticky-header" id="masthead">`
3. First element class: `site-header` from `<header class="site-header sticky-header">`

## License

Licensed under MIT license.

---

&copy; 2017 [WebMan Design](https://www.webmandesign.eu)
