<?php namespace ProcessWire;

/**
 *
 * @param PageArray $root
 *
 */
function navLinks($root = null)
{
  if(!$root) {
    $root = pages('/')->and(pages('/')->children);
  }
  foreach($root as $child) {
    $class = $child->id == wire('page')->id ? 'current-item' : 'link-item';
    echo "<a class='$class' href='$child->url'>$child->title</a>\n";
  }
}

/**
 *
 * @param Page|PageArray|null $page
 *
 */
function breadCrumb($page = null)
{
    if ($page == null) {
        return '';
    }
    $out = '';
    // breadcrumbs are the current page's parents
    foreach ($page->parents() as $item) {
        $out .= "<span><a href='$item->url'>$item->title</a>" . ' / ' . "</span>";
    }
    // optionally output the current page as the last item
    $out .= $page->id != 1  ? "<span>$page->title</span><br>" : '';
    return $out;
}

/**
 *
 * @param string $class
 *
 */
function siteLogo($alt = 'site-logo')
{
  if (!setting('logo')) return;
  $home = setting('home')->url;
  $logo = setting('logo');
  // Display logo
  return "<a href='$home'><img src='$logo' alt='$alt'></a>\n";
}

/**
 *
 * @return string
 *
 */
function searchForm()
{
$search_page = pages()->get('template=search')->url;
$placeholder = setting('search-placeholder');
$search_label = setting('search-label');
// Form
return "
  <form id='search-f' class='search-f' action='$search_page' method='get'>
    <label for='q'>$search_label</label>
    <input type='search' name='q' class='s-input' id='q' placeholder='$placeholder &hellip;' required>
  </form>";
}

/**
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
 *
 * Google Webmaster Tools Verification Code
 *
 * @param string|null $code
 *
 */
function gwCode($code = null)
{
    if ($code) {
        return "<meta name='google-site-verification' content='$code' />\n";
    }
}

/**
 *
 * https://developers.google.com/analytics/devguides/collection/analyticsjs/
 *
 * @param string|null $code Google Analytics Tracking Code
 *
 */
function gaCode($code = null)
{
if($code) {
return "<script defer src='https://www.googletagmanager.com/gtag/js?id=UA-{$code}'></script>
<script>
    window.dataLayer = window.dataLayer || [];
    function gtag(){dataLayer.push(arguments);}
    gtag('js', new Date());
    gtag('config', 'UA-{$code}');
</script>\n\n";
    }
}

/**
 *
 * @param string $str Separate with comma
 *
 */
function socialProfiles($str)
{
if(!$str) return;
$str = explode(',', $str);
$defaults = [
  'facebook',
  'twitter',
  'youtube',
  'instagram',
  'github'
];
$out = '';
// $style = "style='width: 40px; height: 40px; stroke-width: 1; color: #6d6d6d;'";
  foreach ($defaults as $item)
  {
    foreach ($str as $profile)
    {
        if( strpos( $profile, $item ) !== false ) {
          $out .= "<a class='social-item' title='$item' href='$profile' target='_blank'><i data-feather='$item'></i></a>";
        }
      }
  }
  return $out;
}

/**
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
 *
 * @param string $fonts
 *
 */
function googleFonts($fonts) {
if($fonts) {
return "<script>
/* ADD GOOGLE FONTS WITH WEBFONTLOADER
  https://github.com/typekit/webfontloader
*/
WebFontConfig = {
        google: {
        families: ['$fonts']
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
}

/**
 *
 * @param string $id
 * @param string $class
 *
 */
function editPage($id = 'edit-btn', $class = 'edit-btn flex-center')
{
if(!page()->editable()) return;
$edit = page()->editURL;
$edit_text = setting('edit');
// Display region debugging info
return "<div id='$id' class='$class'><a href='$edit'>$edit_text</a></div>";
}

/**
 *
 * @param string $id
 * @param string $class
 *
 */
function debugInfo($id = 'debug', $class = 'debug flex-center')
{
// display region debugging info
  if(config()->debug && user()->isSuperuser()) {
    return "<div id='$id' class='$class'><!--PW-REGION-DEBUG--></div>";
  }
}
