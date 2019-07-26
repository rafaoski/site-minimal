<?php namespace ProcessWire;

/**
 * Given a group of pages render a tree of navigation
 *
 * @param Page|PageArray $items Page to start the navigation tree from or pages to render
 * @param int $maxDepth How many levels of navigation below current should it go?
 *
 */
function renderNavTree($items, $maxDepth = 3) {

	$currentPage = setting('current-page');

	// if we've been given just one item, convert it to an array of items
	if($items instanceof Page) $items = array($items);

	// if there aren't any items to output, exit now
	if(!count($items)) return;

	// $out is where we store the markup we are creating in this function
	// start our <ul> markup
	echo "<ul class='nav nav-tree' role='navigation'>";

	// cycle through all the items
	foreach($items as $item) {

		// markup for the list item...
		// if current item is the same as the page being viewed, add a "current" class and
		// visually hidden text for screen readers to it
		if($item->id == wire('page')->id) {
			echo "<li class='current' aria-current='true'><span class='visually-hidden'>$currentPage</span>";
		} else {
			echo "<li>";
		}

		// markup for the link
		echo "<a href='$item->url'>$item->title</a>";

		// if the item has children and we're allowed to output tree navigation (maxDepth)
		// then call this same function again for the item's children
		if($item->hasChildren() && $maxDepth) {
			renderNavTree($item->children, $maxDepth-1);
		}

		// close the list item
		echo "</li>";
	}

	// end our <ul> markup
	echo "</ul>";
}


/**
 * Return Privacy Policy Page
 *
 * @param array|string $options Options to modify default behavior:
 *	- `id` (string): Selector id.
 *  - `class` (string): Selector class.
 *  - `privacy_page` (link): URL to privacy page.
 *
 */
function privacyPolicy($options = array())
{
// Default Options
$defaults = array(
	'privacy_page' => pages()->get("template=privacy-policy"),
	'id' => 'privacy-policy',
	'class' => 'privacy-policy',
	'read_more' => setting('read-more'),
  );
// Merge Options
$options = _mergeOptions($defaults, $options);
  	return "
  	<p id='$options[id]' class='$options[class]'>

	<span class='privacy-text'>
		<i data-feather='info'></i>
		{$options['privacy_page']->meta_title}
	</span>

	<a href='{$options['privacy_page']->url}'>
		$options[read_more]
	</a>
  </p>
  ";
}

/**
 * Return Social Profiles
 *
 * @param array|string $options Options to modify default behavior:
 *  - `social_profiles` (link): URL to social profiles separate with comma like.
 *  - `id` (string): Selector id.
 *  - `class` (string): Selector class.
 * `https://facebook.com/,`
 * `https://twitter.com/processwire,`
 * `https://youtube.com/,`
 * `https://instagram.com/,`
 * `https://github.com/processwire/processwire`
 *
 */
function socialProfiles($options = array())
{

// $out is where we store the markup we are creating in this function
$out = '';

// Default Options
$defaults = array(
	'social_profiles' => pages('options')->textarea,
	'id' => 'social-profiles',
	'class' => 'social-profiles'
  );
// Merge Options
$options = _mergeOptions($defaults, $options);

// Explode to array
$items = explode(',', $options['social_profiles']);
// Remove NULL, FALSE and Empty Strings ("") ( https://www.php.net/manual/en/function.array-filter.php#Hcom111091 )
$items = array_filter($items, 'strlen');
$out .= "<p id='$options[id]' class='$options[class]'>";
  	// Start loop
  	foreach ($items as $item) {
  	// Get clean url
	$getUrl = sanitizer()->text($item, ['reduceSpace' => true]);
  	// Remove ( https:// ) from url like ( https://twitter.com )
	$profileName = substr($getUrl, 8);
  	// Get first position ( .com )
	$pos = strpos($profileName, '.com/');
  	// Show clean icon name like: ( 'twitter', 'facebook')
	$profileName = substr($profileName, 0, $pos);

  	// Or cut the profileName in this way
	// $pos = strpos($getUrl, '.com/');
	// $profileName = substr($getUrl, 8, $pos - 8);

  // Prepare link to social profiles
	$out .= "\n<a class='social-item $profileName' title='$profileName' href='$getUrl' target='_blank' rel='noopener noreferrer'>";
	$out .= "<i data-feather='$profileName'></i></a>\n";
  }

  	$out .= "</p>";

	// Return all Social Profiles
	return $out;
}

/**
 * Return Site Info => Logo / Site Name / Page Title
 *
 * @param array|string $options Options to modify default behavior:
 *  - `home_url` (link): Home Page URL.
 *  - `logo_url` (link): Site logo URL.
 *  - `logo_alt` (string): Loago alt text.
 * 	- `id` (string): Selector id.
 *  - `class` (string): Selector class.
 *
 */
function siteInfo($options = array())
{
// $out is where we store the markup we are creating in this function
	$out = '';

// Default Options
  $defaults = array(
	'home_url' => setting('home')->url,
	'logo_url' => pages('options')->logo ? pages('options')->logo->url : '',
	'logo_alt' => pages('options')->site_name,
	'id' => 'site-info',
	'class' => 'site-info'
  );
// Merge Options
  	$options = _mergeOptions($defaults, $options);
// Display logo
	$out .= "<p id='$options[id]' class='$options[class]'><a href='$options[home_url]'>";
	$out .= "<img src='$options[logo_url]' alt='$options[logo_alt]'></a>";
	if (page()->template == 'home') {
		$out .=	 "<span class='site-name name'>" . pages('options')->site_name . '</span></p>';
	} else {
		$out .=	 "<span class='site-name page-title'>/ " . page()->title . ' /</span></p>';
	}

// Return logo / Site Name
	return $out;
}

/**
 * Return Navigation Links
 *
 * @param array|string $options Options to modify default behavior:
 *  - `root_url` (link): Home Page URL.
 * 	- `id` (string): Selector id.
 *  - `class` (string): Selector class.
 *
 */
function navLinks($options = array())
{

// $out is where we store the markup we are creating in this function
$out = '';

// Default Options
$defaults = array(
	'root_url' => pages('/')->and(pages('/')->children),
	'id' => 'links',
	'class' => 'links'
);
// Merge Options
$options = _mergeOptions($defaults, $options);

	$out .= "<nav id='$options[id]' class='$options[class]'>";

		foreach($options['root_url'] as $item) {
			$class = $item->id == page()->id ? 'current-item' : 'no-current';
			$out .= "<a class='$class' href='$item->url'>$item->title</a>\n";
		}

	$out .= "</nav>";

  return $out;
}

/**
 * Return Breadcrumbs
 *
 * @param array|string $options Options to modify default behavior:
 *  - `page` (Page|PageArray): Home Page URL.
 * 	- `id` (string): Selector id.
 *  - `class` (string): Selector class.
 *
 */
function breadCrumb($options = array())
{
	if(page()->template == 'home' || page()->parent->template == 'home') return;

// $out is where we store the markup we are creating in this function
$out = '';

// Default Options
$defaults = array(
	'page' => page(),
	'id' => 'breadcrumb',
	'class' => 'breadcrumb'
);
// Merge Options
$options = _mergeOptions($defaults, $options);

$out .= "<ul id='$options[id]' class='$options[class]'>";

// breadcrumbs are the current page's parents
foreach ($options['page']->parents as $item) {
	$out .= "<li><a href='$item->url'>$item->title</a></li>";
}

// optionally output the current page as the last item
	$out .= $options['page']->parents->id != 1  ? "<li>{$options['page']->title}</li><br>" : '';

	$out .= "</ul>";

// return breadcrumb
	return $out;
}

/**
 * Return the hreflang parameter
 *
 * @param Page $page
 *
 */
function hreflang(Page $page)
{
  if(!$page->getLanguages()) return;
  if (!modules()->isInstalled("LanguageSupportPageNames")) return;

  // $out is where we store the markup we are creating in this function
  $out = '';

  // handle output of 'hreflang' link tags for multi-language
  foreach(languages() as $language) {
	// if this page is not viewable in the language, skip it
	if(!$page->viewable($language)) continue;
	// get the http URL for this page in the given language
	$url = $page->localHttpUrl($language);
	// hreflang code for language uses language name from homepage
	$hreflang = setting('home')->getLanguageValue($language, 'name');
	if($hreflang == 'home') $hreflang = setting('lang-code');
	// output the <link> tag: note that this assumes your language names are the same as required by hreflang.
	$out .= "<link rel='alternate' hreflang='$hreflang' href='$url' />\n";
  }
  return $out;
}

/**
 * Return Language Menu
 *
 * @param Page $page
 * @param string $id
 *
 */
function langMenu(Page $page, $id = 'lang-menu')
{
if(!$page->getLanguages()) return;
if (!modules()->isInstalled("LanguageSupportPageNames")) return;
// $out is where we store the markup we are creating in this function
$out = "\n\t<div id='$id'>\n";

foreach(languages() as $language) {
  if(!$page->viewable($language)) continue; // is page viewable in this language?
	$class = $language->id == user()->language->id ? 'current-item' : 'no-current';
	$url = $page->localUrl($language);
	$hreflang = setting('home')->getLanguageValue($language, 'name');
	if($hreflang == 'home') $hreflang = setting('lang-code');
	$out .= "\t\t<a class='lang-item $class' hreflang='$hreflang' href='$url'>$language->title</a>\n";
}
$out .= "\t</div>\n\n";
return $out;
}

/**
 * Return search form
 *
 * @param array|string $options Options to modify default behavior:
 *  - `search_page` (link): search page URL.
 *  - `input_placeholder` (string): input placeholder text.
 *  - `search_label` (string): label text.
 *
 */
function searchForm($options = array())
{

// Default Options
$defaults = array(
  'search_page' => pages()->get('template=search')->url,
  'input_placeholder' => setting('search-placeholder'),
  'search_label' => setting('search-label')
);
// Merge Options
$options = _mergeOptions($defaults, $options);

// return search form
return "
  <form id='search-f' class='p-20 search-f' action='$options[search_page]' method='get'>
	<label for='q'>$options[search_label]</label>
	<input type='search' name='q' class='s-input' id='q' placeholder='$options[input_placeholder] &hellip;' required>
  </form>";
}

/**
 *  Return Basic Pagination
 *  https://processwire.com/docs/front-end/markup-pager-nav/
 *
 * @param PageArray $results
 *
 */
function pagination(PageArray $results)
{
  return $results->renderPager(array(
	'nextItemLabel' => setting('next'),
	'previousItemLabel' => setting('previous'),
	'listMarkup' => "<ul class='MarkupPagerNav'>{out}</ul>",
	'itemMarkup' => "<li class='{class}'>{out}</li>",
	'linkMarkup' => "<a href='{url}'><span>{out}</span></a>"
));
}

/**
 * Return Google Webmaster Tools Verification Code
 *
 * @param string $code
 *
 */
function gwCode($code)
{
// If code is empty return null
if(!$code) return;
// Return Google Verification Code
return "<meta name='google-site-verification' content='$code' />\n";
}

/**
 * Return Google Analytics Tracking Code
 * https://developers.google.com/analytics/devguides/collection/analyticsjs/
 *
 * @param string $code {your-google-analytics-code}
 *
 */
function gaCode($code)
{
// If code is empty return null
if(!$code) return;
// Return Google Analytics Tracking Code
return "<script defer src='https://www.googletagmanager.com/gtag/js?id=UA-{$code}'></script>
<script>
	window.dataLayer = window.dataLayer || [];
	function gtag(){dataLayer.push(arguments);}
	gtag('js', new Date());
	gtag('config', 'UA-{$code}');
</script>\n\n";
}

/**
 * Return Google Fonts
 *
 * @param array|string $options Options to modify default behavior:
 *  - `fonts` (array): Font families from google fonts ( https://fonts.google.com/ ).
 *
 */
function googleFonts($options = array()) {

// Default Options
$defaults = array(
  'fonts' => ['Nunito:200,600','Hanalei','Butcherman'],
);
// Merge Options
$options = _mergeOptions($defaults, $options);

$fonts = "'" . implode("','" , $options['fonts']) . "'";

return "<script>
/* ADD GOOGLE FONTS WITH WEBFONTLOADER
  https://github.com/typekit/webfontloader
*/
WebFontConfig = {
		google: {
		families: [$fonts]
	}
};
(function(d) {
	var wf = d.createElement('script'), s = d.scripts[0];
	wf.src = 'https://ajax.googleapis.com/ajax/libs/webfont/1.6.26/webfont.js';
	wf.async = true;
	s.parentNode.insertBefore(wf, s);
})(document);
</script>\n\n";
}

/**
 * Return Link to Edit Page
 *
 * @param array|string $options Options to modify default behavior:
 *  - `id` (string): Selector id.
 *  - `div_class` (string): Selector div class.
 *  - `link_class` (string): Selector link class.
 *  - `edit_text` (string): The name of the buttont.
 *  - `edit_url` (link): Url to edit the page
 *
 */
function editPage($options = array())
{
// if not Page Editable return null
if(!page()->editable()) return;

// Default Options
$defaults = array(
  'id' => 'edit-btn',
  'div_class' => 'edit-btn flex-center',
  'link_class' => 'link-button',
  'edit_text' => setting('edit'),
  'edit_url' => page()->editURL,
);
// Merge Options
$options = _mergeOptions($defaults, $options);

// Display region debugging info
return "<div id='$options[id]' class='$options[div_class]'>
<a class='$options[link_class]' href='$options[edit_url]'>$options[edit_text]</a></div>";
}

/**
 * Return region debugging info
 *
 * @param array|string $options Options to modify default behavior:
 *  - `id` (string): Selector id.
 *  - `class` (string): Selector class.
 *
 */
function debugInfo($options = array())
{
// Default Options
$defaults = array(
	'id' => 'debug',
	'class' => 'container flex-center debug-bar'
);
// Merge Options
$options = _mergeOptions($defaults, $options);
// display region debugging info
  if(config()->debug && user()->isSuperuser()) {
	return "<div id='$options[id]' class='$options[class]'><!--PW-REGION-DEBUG--></div>";
  }
}

/*****************************************************************************************
 * Internal support functions
 *
 */

/**
 * Prepare and merge an $options argument
 *
 * - This converts PW selector strings data attribute strings to associative arrays.
 * - This converts non-associative attributes to associative boolean attributes.
 * - This merges $defaults with $options.
 *
 * @param array $defaults
 * @param array|string $options
 * @return array
 * @internal
 *
 */
function _mergeOptions(array $defaults, $options) {

	// allow for ProcessWire selector style strings
	// allow for Uikit data attribute strings
	if(is_string($options)) {
		$options = str_replace(';', ',', $options);
		$o = explode(',', $options);
		$options = array();
		foreach($o as $value) {
			if(strpos($value, '=')) {
				// key=value
				list($key, $value) = explode('=', $value, 2);
			} else if(strpos($value, ':')) {
				// key: value
				list($key, $value) = explode(':', $value, 2);
			} else {
				// boolean
				$key = $value;
				$value = true;
			}
			$key = trim($key);
			if(is_string($value)) {
				$value = trim($value);
				// convert boolean strings to real booleans
				$v = strtolower($value);
				if($v === 'false') $value = false;
				if($v === 'true') $value = true;
			}
			$options[$key] = $value;
		}
	}

	if(!is_array($options)) {
		$options = array();
	}

	foreach($options as $key => $value) {
		if(is_int($key) && is_string($value)) {
			// non-associative options convert to boolean attribute
			$defaults[$value] = true;
		}
	}

	return array_merge($defaults, $options);
}