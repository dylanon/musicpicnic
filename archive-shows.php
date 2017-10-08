<?php
/**
 * Template Name: Shows Archive
 */

// First, standard genesis loop displays the page content.

// Add a custom loop that displays posts of type 'shows'
add_action( 'genesis_after_loop', 'mp_shows_archive_loop' );
function mp_shows_archive_loop() {
	genesis_markup( array(
		'open'   => '<section %s>',
		'context' => 'shows-listing',
	) );
	genesis_custom_loop( array( 'post_type'=>'shows' ) );
	genesis_markup( array(
		'close'   => '</section>',
		'context' => 'shows-listing',
	) );
}

genesis();