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
	wp_enqueue_style( 'google-font-open-sans', 'https://fonts.googleapis.com/css?family=Open+Sans:300,400,600i,700' );
    wp_enqueue_script( 'mpnav', get_stylesheet_directory_uri() . '/assets/mpnav.js', array(), '1.0.0', true );
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
		'description'   => __( 'Home page widget area 1.', 'text_domain' ),
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
	);
	register_sidebar( $args );

	$args = array(
		'id'            => 'mp_home_2',
		'class'         => 'mp-home-2',
		'name'          => __( 'Home Page Panel 2', 'text_domain' ),
		'description'   => __( 'Home page widget area 2.', 'text_domain' ),
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
	);
	register_sidebar( $args );

	$args = array(
		'id'            => 'mp_home_3',
		'class'         => 'mp-home-3',
		'name'          => __( 'Home Page Panel 3', 'text_domain' ),
		'description'   => __( 'Home page widget area 3.', 'text_domain' ),
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
	);
	register_sidebar( $args );

	$args = array(
		'id'            => 'mp_home_4',
		'class'         => 'mp-home-4',
		'name'          => __( 'Home Page Panel 4', 'text_domain' ),
		'description'   => __( 'Home page widget area 4.', 'text_domain' ),
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
	);
	register_sidebar( $args );

}
add_action( 'widgets_init', 'mp_register_home_widget_areas' );

/**
 * Adds Music Picnic Show widget.
 */
class MP_Show_Widget extends WP_Widget {
 
    /**
     * Register widget with WordPress.
     */
    public function __construct() {
        parent::__construct(
            'mp_show_widget', // Base ID
            'Music Picnic Show', // Name
            array( 'description' => __( 'Displays the featured image, title, tagline, and up to two configureable buttons for a show. For use in Home Page Panels only (maximum 1 show per panel). Do not place other widgets in the same panel.', 'text_domain' ), ) // Args
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
        $show_post_id = apply_filters( 'widget_show_post_id', $instance['show_post_id'] );
        $tagline = apply_filters( 'widget_show_tagline', $instance['tagline'] );
        $left_button_text = apply_filters( 'widget_left_button_text', $instance['left_button_text'] );
        $left_button_url = apply_filters( 'widget_left_button_url', $instance['left_button_url'] );
        $right_button_text = apply_filters( 'widget_right_button_text', $instance['right_button_text'] );
        $right_button_url = apply_filters( 'widget_right_button_url', $instance['right_button_url'] );

        echo $before_widget;

        // Display Widget Title (disabled)
        // if ( ! empty( $title ) ) {
        //     echo $before_title . $title . $after_title;
        // }

        // Output widget content
        if ( ! empty( $show_post_id ) ) {

	        // Output featured image if show has one
	        if ( has_post_thumbnail( $show_post_id ) ) {
				echo get_the_post_thumbnail( $show_post_id, 'large', array( 'class' => 'mp-show-widget-image' ) );
	        }

	        echo '<div class="mp-show-widget-title-block">';

	        echo '<p class="mp-show-widget-tagline">';
	        echo $tagline;
	        echo '</p>';

	        echo '<p class="mp-show-widget-post-title">';
	        echo get_the_title( $show_post_id );
	        echo '</p>';

	        echo '</div>';

	        echo '<div class="mp-show-widget-buttons">';

	        if ( ! empty( $left_button_text ) ) {
	        	echo '<a href="' . $left_button_url . '" class="mp-show-widget-button mp-button-left">' . $left_button_text . '</a>';
	        }

	        if ( ! empty( $right_button_text ) ) {
	        	echo '<a href="' . $right_button_url . '" class="mp-show-widget-button mp-button-right">' . $right_button_text . '</a>';
	        }

	        echo '</div>';

		} else {

			// Output instructions on how to find Show Post ID
			echo '<div style="color: #000000;">';
			echo '<h2>How to Use this Widget</h2>';
			echo '<p>To use this widget, specify a Show Post ID.</p>';
			echo '<p>To find the Show Post ID, click <a href="' . site_url() . '/wp-admin/edit.php?post_type=shows' . '">here</a> and hover your cursor over a Show name.</p>';
			echo '<p>Your browser will preview the URL for you (likely in the bottom corner). The number after <pre>post=</pre> in the URL is the Show Post ID.</p>';
			echo '</div>';

		}

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
    	// Get or set Title (disabled)
        // if ( isset( $instance[ 'title' ] ) ) {
        //     $title = $instance[ 'title' ];
        // }
        // else {
        //     $title = __( 'New title', 'text_domain' );
        // }

        // Get or set Show Post ID
        if ( isset( $instance[ 'show_post_id' ] ) ) {
            $show_post_id = $instance[ 'show_post_id' ];
        }
        else {
            $show_post_id = NULL;
        }

    	// Get or set Text above the show title (tagline)
        if ( isset( $instance[ 'tagline' ] ) ) {
            $tagline = $instance[ 'tagline' ];
        }
        else {
            $tagline = __( 'now touring', 'text_domain' );
        }

    	// Get or set Left Button text
        if ( isset( $instance[ 'left_button_text' ] ) ) {
            $left_button_text = $instance[ 'left_button_text' ];
        }
        else {
            $left_button_text = __( 'learn more', 'text_domain' );
        }

  		// Get or set Left Button URL
        if ( isset( $instance[ 'left_button_url' ] ) ) {
            $left_button_url = $instance[ 'left_button_url' ];
        }
        else {
        	$mp_site_url = site_url();
            $left_button_url = __( $mp_site_url, 'text_domain' );
        }

    	// Get or set Right Button text
        if ( isset( $instance[ 'right_button_text' ] ) ) {
            $right_button_text = $instance[ 'right_button_text' ];
        }
        else {
            $right_button_text = __( 'learn more', 'text_domain' );
        }

  		// Get or set Right Button URL
        if ( isset( $instance[ 'right_button_url' ] ) ) {
            $right_button_url = $instance[ 'right_button_url' ];
        }
        else {
        	$mp_site_url = site_url();
            $right_button_url = __( $mp_site_url, 'text_domain' );
        }


        ?>

        <!-- Show admin form for widget title (disabled) -->
<!--    <p>
        <label for="<?php // echo $this->get_field_name( 'title' ); ?>"><?php // _e( 'Widget Title:' ); ?></label>
        <input class="widefat" id="<?php // echo $this->get_field_id( 'title' ); ?>" name="<?php // echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php // echo esc_attr( $title ); ?>" />
        </p> -->

        <p>
        <label for="<?php echo $this->get_field_name( 'show_post_id' ); ?>"><?php _e( 'Show Post ID:' ); ?></label>
        <input class="widefat" id="<?php echo $this->get_field_id( 'show_post_id' ); ?>" name="<?php echo $this->get_field_name( 'show_post_id' ); ?>" type="number" value="<?php echo $show_post_id; ?>" />
        </p>

        <p>
        <label for="<?php echo $this->get_field_name( 'tagline' ); ?>"><?php _e( 'Tagline (appears above show name):' ); ?></label>
        <input class="widefat" id="<?php echo $this->get_field_id( 'tagline' ); ?>" name="<?php echo $this->get_field_name( 'tagline' ); ?>" type="text" value="<?php echo esc_attr( $tagline ); ?>" />
        </p>

        <p>
        <label for="<?php echo $this->get_field_name( 'left_button_text' ); ?>"><?php _e( 'Button 1 Text:' ); ?></label>
        <input class="widefat" id="<?php echo $this->get_field_id( 'left_button_text' ); ?>" name="<?php echo $this->get_field_name( 'left_button_text' ); ?>" type="text" value="<?php echo esc_attr( $left_button_text ); ?>" />
        </p>

        <p>
        <label for="<?php echo $this->get_field_name( 'left_button_url' ); ?>"><?php _e( 'Button 1 Link URL (start with http://):' ); ?></label>
        <input class="widefat" id="<?php echo $this->get_field_id( 'left_button_url' ); ?>" name="<?php echo $this->get_field_name( 'left_button_url' ); ?>" type="url" value="<?php echo esc_url( $left_button_url ); ?>" />
        </p>

        <p>
        <label for="<?php echo $this->get_field_name( 'right_button_text' ); ?>"><?php _e( 'Button 2 Text:' ); ?></label>
        <input class="widefat" id="<?php echo $this->get_field_id( 'right_button_text' ); ?>" name="<?php echo $this->get_field_name( 'right_button_text' ); ?>" type="text" value="<?php echo esc_attr( $right_button_text ); ?>" />
        </p>

        <p>
        <label for="<?php echo $this->get_field_name( 'right_button_url' ); ?>"><?php _e( 'Button 2 Link URL (start with http://):' ); ?></label>
        <input class="widefat" id="<?php echo $this->get_field_id( 'right_button_url' ); ?>" name="<?php echo $this->get_field_name( 'right_button_url' ); ?>" type="url" value="<?php echo esc_url( $right_button_url ); ?>" />
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
        // $instance['title'] = ( !empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';	// Update widget title (disabled)
        $instance['show_post_id'] = ( !empty( $new_instance['show_post_id'] ) ) ? $new_instance['show_post_id'] : NULL;
        $instance['tagline'] = ( !empty( $new_instance['tagline'] ) ) ? strip_tags( $new_instance['tagline'] ) : '';
 		$instance['left_button_text'] = ( !empty( $new_instance['left_button_text'] ) ) ? strip_tags( $new_instance['left_button_text'] ) : '';
 		$instance['left_button_url'] = ( !empty( $new_instance['left_button_url'] ) ) ? strip_tags( $new_instance['left_button_url'] ) : '';
 		$instance['right_button_text'] = ( !empty( $new_instance['right_button_text'] ) ) ? strip_tags( $new_instance['right_button_text'] ) : '';
 		$instance['right_button_url'] = ( !empty( $new_instance['right_button_url'] ) ) ? strip_tags( $new_instance['right_button_url'] ) : '';
 
        return $instance;
    }
 
} // class MP_Show_Widget

// Register MP_Show_Widget widget
add_action( 'widgets_init', function() { register_widget( 'MP_Show_Widget' ); } );

/**
 * Adds Music Picnic Latest News widget.
 */
class MP_Latest_News_Widget extends WP_Widget {
 
    /**
     * Register widget with WordPress.
     */
    public function __construct() {
        parent::__construct(
            'mp_news_widget', // Base ID
            'Music Picnic Latest News', // Name
            array( 'description' => __( 'Displays the most recent blog post with its featured image as a background. For use in Home Page Panels only.', 'text_domain' ), ) // Args
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

        // The Query
        $the_query = new WP_Query( array( 'posts_per_page' => 1 ) );

        echo $before_widget;

	    // The Loop
		if ( $the_query->have_posts() ) {
			while ( $the_query->have_posts() ) {
				$the_query->the_post();

		        // Output featured image if post has one
		        if ( has_post_thumbnail() ) {
					echo get_the_post_thumbnail( $post, 'large', array( 'class' => 'mp-news-widget-image' ) );
		        }

		        echo '<div class="mp-news-widget-content">';
				echo '<p class="mp-news-widget-post-title"><a href="' . get_permalink() . '">' . get_the_title() . '</a></p>';
				echo '<p class="mp-news-widget-date">' . get_the_date() . '</p>';
				echo '<div class="mp-news-widget-post-text">';
				the_excerpt();
				echo '</div>'; // .mp-news-widget-post-text
				echo '</div>'; // .mp-news-widget-content
				echo '<a class="mp-news-widget-post-permalink" href="' . get_permalink() . '">read more</a>';
			}
			/* Restore original Post Data */
			wp_reset_postdata();
		} else {
			// no posts found
			echo "<p>No posts found</p>";
		}

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
 
        return $instance;
    }
 
} // class MP_Latest_News_Widget

// Register MP_Latest_News_Widget widget
add_action( 'widgets_init', function() { register_widget( 'MP_Latest_News_Widget' ); } );

/* Pick random primary color on page load */
function mp_random_color() {
    $colors = array( "#ffed51", "#dd1b19", "#87bd45", "#a3d2ee" ); // The colour options
    $pick = array_rand( $colors, 1 ); // Pick a random key (e.g. 2)
    // Take a break from PHP ?>
    <style>
        .site-header,
        .site-footer,
        .footer-widgets {
            background-color: <?php echo $colors[$pick]; ?>;
        }
        .home .mp-frontpage-content a {
            color: <?php echo $colors[$pick]; ?>;
        }
    </style>
    <?php // We were on a break (from PHP )
}
// Hook in to <head> section
add_action( 'wp_head', 'mp_random_color' );