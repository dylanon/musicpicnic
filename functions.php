<?php

//* Start the engine
include_once( get_template_directory() . '/lib/init.php' );

//* Child theme (do not remove)
define( 'CHILD_THEME_NAME', 'Music Picnic Theme' );
define( 'CHILD_THEME_URL', 'https://dylanon.com' );
define( 'CHILD_THEME_VERSION', '0.0.1' );

//* Add HTML5 markup structure for Genesis Framework
add_theme_support( 'html5', array( 'search-form', 'comment-form', 'comment-list', 'gallery', 'caption' ) );

//* Add Viewport meta tag for mobile browsers (requires HTML5 theme support)
add_theme_support( 'genesis-responsive-viewport' );

//* Remove the site description
remove_action( 'genesis_site_description', 'genesis_seo_site_description' );

//* Enqueue fonts
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

//* Add Featured Image to header for Pages, Posts, and Attachments
function mp_page_header_featured_image() {
	if ( is_singular() and has_post_thumbnail() ) {
		the_post_thumbnail( 'full', array( 'class' => 'mp-page-header-image') );
	}
}
add_action( 'genesis_entry_header', 'mp_page_header_featured_image', 7);

//* Replace Footer credits
function mp_footer_text() {
	return '<span class="footer-site-title">Music Picnic</span><br><a href="mailto:info@musicpicnic.com">info@musicpicnic.com</a>';
}
add_filter( 'genesis_footer_creds_text', 'mp_footer_text' );

//* Add support for 3-column footer widgets
add_theme_support( 'genesis-footer-widgets', 3 );

//* This function returns false - for the 'edit link' filter in front-page.php
function mp_return_false() {
	return false;
}

//* Register Front Page Widget Areas
function mp_register_home_widget_areas() {

	$args = array(
		'id'            => 'mp_home_1',
		'class'         => 'mp-home-1',
		'name'          => __( 'Home Page Panel 1', 'text_domain' ),
		'description'   => __( 'Home page widget 1.', 'text_domain' ),
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
	);
	register_sidebar( $args );

	$args = array(
		'id'            => 'mp_home_2',
		'class'         => 'mp-home-2',
		'name'          => __( 'Home Page Panel 2', 'text_domain' ),
		'description'   => __( 'Home page widget 1.', 'text_domain' ),
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
	);
	register_sidebar( $args );

	$args = array(
		'id'            => 'mp_home_3',
		'class'         => 'mp-home-3',
		'name'          => __( 'Home Page Panel 3', 'text_domain' ),
		'description'   => __( 'Home page widget 3.', 'text_domain' ),
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
	);
	register_sidebar( $args );

	$args = array(
		'id'            => 'mp_home_4',
		'class'         => 'mp-home-4',
		'name'          => __( 'Home Page Panel 4', 'text_domain' ),
		'description'   => __( 'Home page widget 4.', 'text_domain' ),
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
	);
	register_sidebar( $args );

}
add_action( 'widgets_init', 'mp_register_home_widget_areas' );

/**
 * Adds Foo_Widget widget.
 */
class Foo_Widget extends WP_Widget {
 
    /**
     * Register widget with WordPress.
     */
    public function __construct() {
        parent::__construct(
            'foo_widget', // Base ID
            'Foo_Widget', // Name
            array( 'description' => __( 'A Foo Widget', 'text_domain' ), ) // Args
        );
    }
 
    /**
     * Front-end display of widget.
     *
     * @see WP_Widget::widget()
     *
     * @param array $args     Widget arguments.
     * @param array $instance Saved values from database.
     */
    public function widget( $args, $instance ) {
        extract( $args );
        $title = apply_filters( 'widget_title', $instance['title'] );
 
        echo $before_widget;
        if ( ! empty( $title ) ) {
            echo $before_title . $title . $after_title;
        }
        echo __( 'Hello, World!', 'text_domain' );
        echo $after_widget;
    }
 
    /**
     * Back-end widget form.
     *
     * @see WP_Widget::form()
     *
     * @param array $instance Previously saved values from database.
     */
    public function form( $instance ) {
        if ( isset( $instance[ 'title' ] ) ) {
            $title = $instance[ 'title' ];
        }
        else {
            $title = __( 'New title', 'text_domain' );
        }
        ?>
        <p>
        <label for="<?php echo $this->get_field_name( 'title' ); ?>"><?php _e( 'Title:' ); ?></label>
        <input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
        </p>
        <?php
    }
 
    /**
     * Sanitize widget form values as they are saved.
     *
     * @see WP_Widget::update()
     *
     * @param array $new_instance Values just sent to be saved.
     * @param array $old_instance Previously saved values from database.
     *
     * @return array Updated safe values to be saved.
     */
    public function update( $new_instance, $old_instance ) {
        $instance = array();
        $instance['title'] = ( !empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
 
        return $instance;
    }
 
} // class Foo_Widget

// Register Foo_Widget widget
add_action( 'widgets_init', function() { register_widget( 'Foo_Widget' ); } );