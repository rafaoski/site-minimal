<?php namespace ProcessWire;

/**
 * ProcessWire Bootstrap API Ready
 * ===============================
 * This ready.php file is called during ProcessWire bootstrap initialization process.
 * This occurs after the current page has been determined and the API is fully ready
 * to use, but before the current page has started rendering. This file receives a
 * copy of all ProcessWire API variables. This file is an idea place for adding your
 * own hook methods.
 *
 */

/** @var ProcessWire $wire */

/** Hook Admin Custom CSS */
// $wire->addHookAfter('Page::render', function($event) {
// 	if(page()->template != 'admin') return; // Check if is Admin Panel
// 	$value  = $event->return; // Return Content
// 	$templates = urls()->templates; // Get Template folder URL	
// 	$style = "<link rel='stylesheet' href='{$templates}assets/css/admin.css'>"; // Add Style inside bottom head	
// 	$event->return = str_replace("</head>", "\n\t$style</head>", $value); // Return All Changes	
// });
