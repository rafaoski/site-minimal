<?php namespace ProcessWire;
/**
 * This _init.php file is called automatically by ProcessWire before every page render
 *
 */

/** @var ProcessWire $wire */

setting([
// GET Home Page
    'home' => pages()->get('/'),
// Custom body class
    'body-classes' => WireArray([
        'template-' . page()->template->name,
        'page-' . page()->id,
    ]),
// Options Page
    'logo' => pages('options')->logo ? pages('options')->logo->url : '',
    'favicon' => pages('options')->favicon ? pages('options')->favicon->url : '',
    'gw-code' => 'GOOGLE WEBMASTER CODE',
    'ga-code' => 'GOOGLE ANALYTICS CODE',
// Get Styles
    'css-files' => WireArray([
        urls('templates') . 'assets/css/main.css',
        // urls('templates') . 'assets/css/mix.css',
    ]),
// Get Scripts
    'js-files' => WireArray([
        urls('templates') . 'assets/js/turbolinks.js',
        'https://unpkg.com/feather-icons',
        // urls('templates') . 'assets/js/app.js',
    ]),
// Basic Transate
    'lang-code' => __('en'),
    'edit' => __('Edit'),
    'next' => __('Next'),
    'previous' => __('Previous'),
    'search-placeholder' => __('Search'),
    'search-label' => __('Search Word'),
    'found-pages' => __("Found %d page(s)."),
    'no-found' =>  __('Sorry, no results were found.'),
    'read-more' => __('Read More'),
    'e-mail' => __('E-Mail'),
    'phone' => __('Phone'),
    'adress' => __('Adress')
]);

include_once('./_func.php');

// ADD USER => https://processwire.com/api/variables/user/
    // $u = $users->add('user-demo');
    // $u->pass = "demo99";
    // $u->addRole("guest");
    // $u->save();

// RESET PASSWORD => https://processwire.com/talk/topic/1736-forgot-backend-password-how-do-you-reset/
    // $u = $users->get('admin'); // or whatever your username is
    // $u->of(false);
    // $u->pass = 'your-new-password';
    // $u->save();

/*
( ProcessWire API variables ) https://processwire.com/docs/start/variables/
( Page ) https://processwire.com/docs/start/variables/page/
( Pages ) https://processwire.com/docs/start/variables/pages/
( Images ) https://processwire.com/docs/fields/images/
( New functions API ) https://processwire.com/blog/posts/processwire-3.0.39-core-updates/#new-functions-api
( More on the Functions API ) https://processwire.com/blog/posts/processwire-3.0.40-core-updates/
( Markup regions ) https://processwire.com/docs/front-end/output/markup-regions/
( Get or set a runtime site setting ) https://processwire.com/api/ref/functions/setting/
( New $page->if() method ) https://processwire.com/blog/posts/pw-3.0.126/
( Optimize field use ) https://processwire.com/blog/posts/making-efficient-use-of-fields-in-processwire/
( Modules ( plugins ) and hooks ) https://processwire.com/docs/modules/
( Yes, it’s that simple! ;) ) https://processwire.com/blog/posts/building-custom-admin-pages-with-process-modules/
*/
