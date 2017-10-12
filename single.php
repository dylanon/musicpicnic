<?php

// // First, standard genesis loop displays the page content.

// // Add a custom loop that displays posts of type 'shows'
// add_action( 'genesis_after_loop', 'mp_shows_archive_loop' );
// function mp_shows_archive_loop() {

// 	// Set up loop modifications
// 		// Remove post header, date, author, edit link
// 		remove_action( 'genesis_entry_header', 'genesis_entry_header_markup_open', 5 );
// 		remove_action( 'genesis_entry_header', 'genesis_post_info', 12 );
// 		remove_action( 'genesis_entry_header', 'genesis_entry_header_markup_close', 15 );
// 		// Change post image priority
// 		remove_action( 'genesis_entry_content', 'genesis_do_post_image', 8 );
// 		add_action( 'genesis_entry_content', 'genesis_do_post_image', 7 );
// 		// Output opening markup to wrap post title and post content
// 		add_action( 'genesis_entry_content', 'mp_shows_archive_text_wrapper_open', 8);
// 		function mp_shows_archive_text_wrapper_open() {
// 			genesis_markup( array(
// 				'open'   => '<div %s>',
// 				'context' => 'shows-archive-text-wrapper',
// 			) );
// 		}
// 		// Move post title into content area after image, before content
// 		remove_action( 'genesis_entry_header', 'genesis_do_post_title' );
// 		add_action( 'genesis_entry_content', 'genesis_do_post_title', 9 );
// 		// remove_action( 'genesis_entry_content', 'genesis_do_post_content' );
// 		// Output closing markup to wrap post title and post content
// 		add_action( 'genesis_entry_content', 'mp_shows_archive_text_wrapper_close', 11);
// 		function mp_shows_archive_text_wrapper_close() {
// 			genesis_markup( array(
// 				'close'   => '</div>',
// 				'context' => 'shows-archive-text-wrapper',
// 			) );
// 		}

// 	// Output markup and run loop
// 		// Output opening markup
// 		genesis_markup( array(
// 			'open'   => '<section %s>',
// 			'context' => 'shows-archive',
// 		) );
// 		// Output 'More Shows' section title
// 		echo '<hr><br><h1 class="more-shows">More Shows</h1>';
// 		// Store value of global variable for post
// 		global $post;
// 		$mp_post_id = $post->ID;
// 		// Set custom query arguments
// 		$mpargs = array(
// 			'post_type' => 'shows',
// 			'posts_per_page' => 2, // Display two random shows, but not the current show
// 			'orderby'   => 	'rand',
// 			'post__not_in' => array( $mp_post_id ),
// 		);
// 		// Output all posts of type 'shows'
// 		genesis_custom_loop( $mpargs );
// 		// Output closing markup
// 		genesis_markup( array(
// 			'close'   => '</section>',
// 			'context' => 'shows-archive',
// 		) );

// 	// Reset Genesis loops just in case
// 	genesis_reset_loops();
// }

// // Remove date from the show post
// remove_action( 'genesis_entry_header', 'genesis_post_info', 12 );

// Remove author from post header info
add_filter( 'genesis_post_info', 'mp_filter_single_post_info' );
function mp_filter_single_post_info() {
	return '[post_date] [post_edit]';
}

// Remove categories and tags from post footer meta
add_filter( 'genesis_post_meta', 'mp_filter_single_post_meta' );
function mp_filter_single_post_meta() {
	return '';
}

add_action( 'genesis_entry_footer', 'mp_single_post_nav_links', 12 );
function mp_single_post_nav_links() {
	echo '<div class="mp-single-nav-links">';
	echo '<p class="mp-prev-post mp-single-nav-link">';
	previous_post_link( '&laquo; %link', 'previous post (older): <em>%title</em>' );
	echo '</p>';
	echo '<p class="mp-next-post mp-single-nav-link">';
	next_post_link( '&raquo; %link', 'next post (newer): <em>%title</em>' );
	echo '</p>';
	echo '</div>'; // .mp-single-nav-links
}

genesis();