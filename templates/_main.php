<?php namespace ProcessWire;
/**
 * _main.php template file, called after a page’s template file
 *
 */

// reset Variables
$img = $img_alt = $style = '';
// get CSS Files
$cssFiles = setting('css-files');
// get JS Files
$jsFiles = setting('js-files');
// disable turbolinks if the user is logged in
if (user()->isLoggedin()) {
	unset($jsFiles[0]); // unset turbolinks
}
// Get First Image
if(page()->images && count(page()->images)) {
  $img = page()->images->first;
  $img_alt = $img->description ?: page()->title;
}
// setting(false, 'background-image'); // Disable background image
if ( setting('background-image') && $img ) { // set Background Image
  $style = " style='background-image: linear-gradient( rgba(255, 255, 255, 0.92), rgba(216, 216, 216, 0.88) ), url($img->url);'";
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
<?php
echo $jsFiles->each("<script src='{value}' defer></script>\n");
echo hreflang(page())
?>
</head>
<body id='html-body' class='<?= setting('body-classes')->implode(' ') ?>'<?= $style ?>>

<!-- HEADER -->
	<header id="header" class="container-medium header">

		<?= privacyPolicy(['class' => 'privacy-policy']) ?>

		<?php echo langMenu(page()) ?>

		<?= siteInfo(['class' => 'site-info flex-center flex-direction-column']) ?>

		<?= breadCrumb(['class' => 'breadcrumb']) ?>

		<?= navLinks(['class' => 'main-nav']) ?>

	</header>

<!-- HERO -->
	<div id="hero" class='container-medium m-t flex-center flex-wrap-mobile hero' data-pw-optional>

		<div id='left-hero' class="flex-center flex-direction-column flex-wrap-mobile left-hero">

			<?= page()->if("meta_title", "<h1>{meta_title}</h1>") ?>

			<?php if ($img): ?>
				<img src='<?= $img->url ?>' class='responsive' alt='<?= $img_alt ?>'>
			<?php endif ?>

		</div>

		<?= page()->if("meta_description", "<h2 class='right-hero'>{meta_description}</h2>") ?>

	</div>

<!-- CONTENT BODY -->
	<div id="content-body" class='container content-body'>

		<?= page()->body ?>

	</div>

	<?= editPage() ?>
	<?= debugInfo() ?>

<!-- FOOTER -->
	<footer id='footer' class='container-full footer'>

		<?= searchForm() ?>

		<?= socialProfiles(['class' => 'social-profiles flex-center']) ?>

		<p id='copyright' class='copyright flex-center'>
			<small class='uk-text-small uk-text-muted'>&copy; <?= date('Y') ?> &bull;</small>
			<a href='https://processwire.com' target='_blank' rel='noopener noreferrer'>Powered by ProcessWire CMS</a>
		</p>

	</footer>

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
