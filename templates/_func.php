<?php namespace ProcessWire;

/**
 * Return Navigation Links
 * 
 * @param array|string $options Options to modify default behavior:
 *  - `root_url` (link): Home Page URL.
 *  - `class` (string): link class.
 *
 */
function navLinks($options = array())
{
// $out is where we store the markup we are creating in this function
  $out = '';
// Reset variables  
  $class = '';
// Default Options
  $defaults = array(
    'root_url' => pages('/')->and(pages('/')->children),
    'class' => 'link-item'
  );
// Merge Options
  $options = _mergeOptions($defaults, $options);

  $class = $options['class'];

  foreach($options['root_url'] as $item) {
      $class = $item->id == page()->id ? 'current-item' : $options['class'];
      $out .= "<a class='$class' href='$item->url'>$item->title</a>\n";
  }
  return $out;
}

/**
 *
 * @param Page|PageArray|null $page
 *
 */
function breadCrumb($page = null)
{

  if ($page == null) return;

// $out is where we store the markup we are creating in this function
  $out = '';

// breadcrumbs are the current page's parents
  foreach ($page->parents() as $item) {
      $out .= "<span><a href='$item->url'>$item->title</a>" . ' / ' . "</span>";
  }

// optionally output the current page as the last item
  $out .= $page->id != 1  ? "<span>$page->title</span><br>" : '';
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
 * Return Site Logo
 * 
 * @param array|string $options Options to modify default behavior:
 *  - `home_url` (link): Home Page URL.
 *  - `logo_url` (link): Site logo URL.
 *  - `logo_alt` (string): Loago alt text.
 *
 */
function siteLogo($options = array())
{
// Default Options
  $defaults = array(
		'home_url' => setting('home')->url,
    'logo_url' => pages('options')->logo ? pages('options')->logo->url : '',
    'logo_alt' => pages('options')->site_name,
  );
// Merge Options
  $options = _mergeOptions($defaults, $options);
// Display logo
  return "<a href='$options[home_url]'><img src='$options[logo_url]' alt='$options[logo_alt]'></a>\n";
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
  <form id='search-f' class='search-f' action='$options[search_page]' method='get'>
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
 * Return Social Profiles 
 * 
 * @param string $items Url social profiles separate with comma like:
 * https://facebook.com/,
 * https://twitter.com/processwire,
 * https://youtube.com/,
 * https://instagram.com/,
 * https://github.com/processwire/processwire
 *
 */
function socialProfiles($items)
{
// If items is empty return null
if(!$items) return;
// $out is where we store the markup we are creating in this function
$out = '';
// Explode to array
$items = explode(',', $items);
// Remove NULL, FALSE and Empty Strings ("") ( https://www.php.net/manual/en/function.array-filter.php#Hcom111091 )
$items = array_filter($items, 'strlen');
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
    $out .= "\n<a class='social-item $profileName' title='$profileName' href='$getUrl' target='_blank'>"; 
    $out .= "<i data-feather='$profileName'></i></a>\n";
  }
  // Return all Social Profiles
  return $out;
}

/**
 * Return Privacy Policy Page 
 * 
 * @param Page $privacyPage get privacy poilcy page
 *
 */
function privacyPolicy($privacyPage)
{
  if(!$privacyPage) return;
  $more = setting('read-more');
  return "
  <p>
    <i data-feather='info'></i>
    {$privacyPage->meta_title}
    <a href='{$privacyPage->url}'>
        $more
    </a>
  </p>
  ";
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
  'class' => 'debug flex-centerdebug-bar'
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