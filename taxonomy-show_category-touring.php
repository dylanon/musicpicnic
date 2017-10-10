<?php
/**
 * Template Name: Shows - Touring
 */

// First, standard genesis loop displays the page content.

// Add a custom loop that displays posts of type 'shows'
add_action( 'genesis_after_loop', 'mp_shows_archive_loop' );
function mp_shows_archive_loop() {

	// Set up loop modifications
		// Remove post header, date, author, edit link
		remove_action( 'genesis_entry_header', 'genesis_entry_header_markup_open', 5 );
		remove_action( 'genesis_entry_header', 'genesis_post_info', 12 );
		remove_action( 'genesis_entry_header', 'genesis_entry_header_markup_close', 15 );
		// Change post image priority
		remove_action( 'genesis_entry_content', 'genesis_do_post_image', 8 );
		add_action( 'genesis_entry_content', 'genesis_do_post_image', 7 );
		// Output opening markup to wrap post title and post content
		add_action( 'genesis_entry_content', 'mp_shows_archive_text_wrapper_open', 8);
		function mp_shows_archive_text_wrapper_open() {
			genesis_markup( array(
				'open'   => '<div %s>',
				'context' => 'shows-archive-text-wrapper',
			) );
		}
		// Move post title into content area after image, before content
		remove_action( 'genesis_entry_header', 'genesis_do_post_title' );
		add_action( 'genesis_entry_content', 'genesis_do_post_title', 9 );
		// Output closing markup to wrap post title and post content
		add_action( 'genesis_entry_content', 'mp_shows_archive_text_wrapper_close', 11);
		function mp_shows_archive_text_wrapper_close() {
			genesis_markup( array(
				'close'   => '</div>',
				'context' => 'shows-archive-text-wrapper',
			) );
		}

	// Output markup and run loop
		// Output opening markup
		genesis_markup( array(
			'open'   => '<section %s>',
			'context' => 'shows-archive',
		) );
		// Set custom query arguments
		$mpargs = array(
			'post_type' => 'shows',
			'tax_query' => array(
				 				array(
					 				'taxonomy' => 'show_category',
					 				'field' => 'slug',
					 				'terms' => 'touring',
					 			),
							),
			'orderby'   => 	array(					// Sort by menu order 0 - 10+, then by date starting from most recent
							'menu_order' => 'ASC', 
							'date' => 'DESC' 
							)
		);
		// Output all posts of type 'shows' and show category 'touring'
		genesis_custom_loop( $mpargs );
		// Output closing markup
		genesis_markup( array(
			'close'   => '</section>',
			'context' => 'shows-archive',
		) );

	// Reset Genesis loops just in case
	genesis_reset_loops();
}

genesis();