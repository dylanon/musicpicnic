<?php

// Single Blog Post Template

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
	next_post_link( '%link', 'next post (newer): <em>%title</em> &raquo;' );
	echo '</p>';
	echo '</div>'; // .mp-single-nav-links
}

genesis();