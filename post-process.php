<?php
/*
 * After making changes to cassis.js, run this file to transform the JS into
 * native PHP code. This process involves removing all PHP and HTML comments,
 * so that no comment hacks or output buffering is required in order to use
 * Cassis in PHP.
 */

// Load the source code
$source = file_get_contents('cassis.js');

// Remove the top comment that talks about using ob_start
$source = preg_replace('/\/\* <!--.+\n\/\* <!-- /Usm', '', $source);

// Remove HTML comments
// Without this step, you would need to wrap every function call in ob_start/ob_get_clean.
// This effectively removes all the (JS) comments, so only actual PHP source code is left.
$source = preg_replace('/<!--(.|\s)*?-->/', '', $source);

// Remove close/open PHP tags
$source = preg_replace('/\?>\s+<\?php/', '', $source);

// Remove trailing HTML comment tag (and PHP tag since we can do that safely)
$source = preg_replace('/\?> -->$/', '', $source);

file_put_contents('cassis.php', $source);
