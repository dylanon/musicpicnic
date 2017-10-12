<?php
/**
 * Front Page Template
 */

// Remove the page title
remove_action( 'genesis_entry_header', 'genesis_do_post_title' );

// Remove the edit post link
add_filter( 'genesis_edit_post_link', 'mp_return_false' ); // See functions.php

// Wrap content area to apply full width background with less than full width content
add_action ( 'genesis_before_entry_content', 'mp_wrap_frontpage_content_open' );
function mp_wrap_frontpage_content_open() {
	echo '<div class="mp-frontpage-content-bg">';
	echo '<div class="mp-frontpage-content">';
	echo '<div class="mp-frontpage-tagline"><p>' . get_post_meta( get_the_ID(), 'frontpage_tagline', true ) . '</p></div>';
}

add_action ( 'genesis_after_entry_content', 'mp_wrap_frontpage_content_close' );
function mp_wrap_frontpage_content_close() {
	echo '</div>';
	echo '</div>';
}

// Display widgets
add_action( 'genesis_after_loop', 'mp_display_home_widgets' );
function mp_display_home_widgets() {
	if ( is_active_sidebar( 'mp_home_1' ) ) {
		dynamic_sidebar( 'mp_home_1' );
	}

	if ( is_active_sidebar( 'mp_home_2' ) ) {
		dynamic_sidebar( 'mp_home_2' );
	}

	if ( is_active_sidebar( 'mp_home_3' ) ) {
		dynamic_sidebar( 'mp_home_3' );
	}

	if ( is_active_sidebar( 'mp_home_4' ) ) {
		dynamic_sidebar( 'mp_home_4' );
	}
}

genesis();