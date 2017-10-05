<?php

//* Start the engine
include_once( get_template_directory() . '/lib/init.php' );

//* Child theme (do not remove)
define( 'CHILD_THEME_NAME', 'Music Picnic Theme' );
define( 'CHILD_THEME_URL', 'https://dylanon.com' );
define( 'CHILD_THEME_VERSION', '0.0.1' );

//* Add HTML5 markup structure for Genesis Framework
add_theme_support( 'html5', array( 'search-form', 'comment-form', 'comment-list', 'gallery', 'caption' ) );

//* Remove the site description
remove_action( 'genesis_site_description', 'genesis_seo_site_description' );

// Enqueue fonts
function mp_enqueue_styles() {
	wp_enqueue_style( 'google-font-montserrat', 'https://fonts.googleapis.com/css?family=Montserrat:400,900' );
	wp_enqueue_style( 'google-font-open-sans', 'https://fonts.googleapis.com/css?family=Open+Sans:400,700' );
}
add_action( 'wp_enqueue_scripts', 'mp_enqueue_styles' );

//* Remove the header right widget area
unregister_sidebar( 'header-right' );

//* Reposition the primary navigation menu
remove_action( 'genesis_after_header', 'genesis_do_nav' );
add_action( 'genesis_header', 'genesis_do_nav', 12 );

// Add Featured Image to page header
function mp_page_header_featured_image() {
	// echo "Hello World";
	if ( has_post_thumbnail() ) {
		the_post_thumbnail( 'full', array( 'class' => 'mp-page-header-image') );
	}
}
add_action( 'genesis_entry_header', 'mp_page_header_featured_image', 7);

// Replace footer credits
function mp_footer_text() {
	return '<span class="footer-site-title">Music Picnic</span><br><a href="mailto:info@musicpicnic.com">info@musicpicnic.com</a>';
}
add_filter( 'genesis_footer_creds_text', 'mp_footer_text' );