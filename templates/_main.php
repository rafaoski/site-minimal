<?php namespace ProcessWire;
/**
 * _main.php template file, called after a page’s template file
 *
 */

// Get First Image
$img = '';
if(page()->images && count(page()->images)) {
$img = page()->images->first;
$img_alt = $img->description ?: page()->title;
}
// Get CSS Files
$cssFiles = setting('css-files');
// Get JS Files
$jsFiles = setting('js-files');
// Disable Turbolinks if the user is logged in
if (user()->isLoggedin()) {
    unset($jsFiles[0]); // Unset Turbolinks Script
}
?>
<!DOCTYPE html>
<html lang="<?= setting('lang-code') ?>">
<head id='html-head'>
<meta http-equiv="content-type" content="text/html; charset=utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="icon" href="<?= setting('favicon') ?>"/>
<title><?= page('meta_title|title') ?></title>
<meta name="description" content="<?= page('meta_description') ?>"/>
<?= $cssFiles->each("<link rel='stylesheet' href='{value}'>\n") ?>
<style media="screen">
#main {
    background: no-repeat center center fixed;
    background-size: contain;
    color: black;
}
@media screen and (max-width: 1024px) {
    .header-image { display: none; }
}   
</style>
<?php
echo $jsFiles->each("<script src='{value}' defer></script>\n");
// echo hreflang(page())
?>
</head>
<body id='html-body' class='<?= setting('body-classes')->implode(' ') ?>'>

<!-- MAIN -->
<div id='main' class='main flex-center position-ref full-height'
style="background-image: linear-gradient( rgba(255, 255, 255, 0.92), rgba(216, 216, 216, 0.88) ),
url(<?php if($img) echo $img->url; ?>);">

<!-- CONTENT -->
  <div id='content' class='content'>

        <div id='top-panel' class='top-panel'>
            <div id="social-profiles" class='social-profiles'>
                <?= socialProfiles(pages('options')->textarea) ?>
            </div>

            <div id="privacy-policy" class='privacy-policy'>
                <?= privacyPolicy(pages('/privacy-policy/')) ?>
            </div>
            <?php // echo langMenu(page()) ?>
        </div>

        <div id='site-info' class="site-info flex-center m-b-md">
            <div id="logo" class='logo'>
                <?= siteLogo() ?>
            </div>

            <div id='site-name' class="site-name">
                <?= pages('options')->site_name ?>
            </div>
        </div>

        <div id='links' class="links flex-center">
            <?= navLinks() ?>
        </div>

        <div id='bredcrumb' class='breadcrumb'>
            <?= breadCrumb(page()) ?>
        </div>

        <div id="site-seo" class='site-seo' data-pw-optional>
            <?= page()->if("meta_title", "<h1>{meta_title}</h1>") ?>
            <?= page()->if("meta_description", "<h2>{meta_description}</h2>") ?>
        </div>

        <div id="header-image" class='header-image flex-center' data-pw-optional>
            <?php if($img) echo "<img width='300' src='{$img->url}' alt='{$img_alt}'>"; ?>
        </div>

        <div id="content-body" class='content-body'>
            <?= page()->body ?>
        </div>

        <?= editPage() ?>
        <?= debugInfo() ?>

       <!-- If you need a search form, just uncomment it
        <div id="search-form" class='search-form'>
        <?php // echo searchForm() ?>
        </div> -->

        <p id='copyright' class='copyright flex-center'>
            <small class='uk-text-small uk-text-muted'>&copy; <?= date('Y') ?> &bull;</small>
            <a href='https://processwire.com'>Powered by ProcessWire CMS</a>
        </p>

  </div><!-- /CONTENT -->

</div><!-- MAIN -->

<?php
// Google Fonts
echo googleFonts( ['fonts' => ['Nunito:200,600']] );
// echo gwCode( setting('gw-code') );
// echo gaCode( setting('ga-code') );
?>
<script>
window.addEventListener('<?php if (!user()->isLoggedin()) echo 'turbolinks:';?>load', function() {
  feather.replace();
})
</script>

</body>
</html>
