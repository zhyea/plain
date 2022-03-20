<?php 

if ( ! function_exists( 'puma_setup' ) ) :
/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support for post thumbnails.
 *
 * @since Puma 2.0.0
 */
function puma_setup() {
	add_custom_background();
	register_nav_menu( 'puma', __( 'Primary Menu', 'puma' ) );
	
	add_theme_support( 'post-thumbnails' );
	add_theme_support( 'html5', array(
		'search-form', 'comment-form', 'comment-list', 'gallery', 'caption'
	) );
	add_theme_support( 'title-tag' );
	add_filter( 'pre_option_link_manager_enabled', '__return_true' );
	load_theme_textdomain( 'puma', get_template_directory() . '/languages' );
	add_theme_support( 'post-formats', array('status',) );
}
add_action( 'after_setup_theme', 'puma_setup' );
endif;


/**
 * Handles JavaScript detection.
 * Adds a `js` class to the root `<html>` element when JavaScript is detected.
 * @since Puma 2.1.0
 */
function puma_javascript_detection() {
	echo "<script>(function(html){html.className = html.className.replace(/\bno-js\b/,'js')})(document.documentElement);</script>\n";
}
add_action( 'wp_head', 'puma_javascript_detection', 0 );


/**
 * Enqueues scripts and styles.
 *
 * @since Puma 2.0.0
 */
function puma_load_static_files(){
	$dir = get_template_directory_uri() . '/static/';
	wp_enqueue_style('puma', $dir . 'css/bundle.css' , array(), PUMA_VERSION , 'screen');
	wp_enqueue_script( 'puma', $dir . 'js/bundle.js' , array( 'jquery' ), PUMA_VERSION, true );
	wp_localize_script( 'puma', 'PUMA', array(
		'ajax_url'   => admin_url('admin-ajax.php'),
	) );
}
add_action( 'wp_enqueue_scripts', 'puma_load_static_files' );

/**
 * Set up the WordPress core custom header feature.
 *
 * @uses twentyseventeen_header_style()
 */
function puma_custom_header_setup() {
	add_theme_support( 'custom-header', apply_filters( 'puma_custom_header_args', array(
		'default-image'      => get_parent_theme_file_uri( '/static/img/banner2.jpg' ),
		'width'              => 1200,
		'height'             => 560,
		'flex-height'        => true,
		'video'              => true,
	) ) );

	register_default_headers( array(
		'default-image' => array(
			'url'           => '%s/static/img/banner2.jpg',
			'thumbnail_url' => '%s/static/img/banner2.jpg',
			'description'   => __( 'Default Header Image', 'puma' ),
		),
	) );
}
add_action( 'after_setup_theme', 'puma_custom_header_setup' );



function puma_post_nav_background() {
	if ( ! is_single() ) {
		return;
	}

	$previous = ( is_attachment() ) ? get_post( get_post()->post_parent ) : get_adjacent_post( false, '', true );
	$next = get_adjacent_post( false, '', false );
	$css = '';

	if ( is_attachment() && 'attachment' == $previous->post_type ) {
		return;
	}

  if ( $previous &&  has_post_thumbnail( $previous->ID ) ) {
    $prevthumb = wp_get_attachment_image_src( get_post_thumbnail_id( $previous->ID ), 'post-thumbnail' );
    $css .= '
      .post-navigation .nav-previous { background-image: url(' . esc_url( $prevthumb[0] ) . ');}
      .post-navigation .nav-previous .post-title { color: #fff; }
      .post-navigation .nav-previous .meta-nav { color: rgba(255,255,255,.9)}
      .post-navigation .nav-previous:before{
      content: "";
      position: absolute;
      top: 0;
      bottom: 0;
      left: 0;
      right: 0;
      background-color: rgba(0,0,0,0.4);
    }
    ';
  }

  if ( $next && has_post_thumbnail( $next->ID ) ) {
    $nextthumb = wp_get_attachment_image_src( get_post_thumbnail_id( $next->ID ), 'post-thumbnail' );
    $css .= '
      .post-navigation .nav-next { background-image: url(' . esc_url( $nextthumb[0] ) . ');}
      .post-navigation .nav-next .post-title { color: #fff; }
      .post-navigation .nav-next .meta-nav { color: rgba(255,255,255,.9)}
      .post-navigation .nav-next:before{
      content: "";
      position: absolute;
      top: 0;
      bottom: 0;
      left: 0;
      right: 0;
      background-color: rgba(0,0,0,0.4);
    }
    ';
  }
  //echo $css;
  wp_add_inline_style( 'puma', $css );
}
add_action( 'wp_enqueue_scripts', 'puma_post_nav_background' );

/**
 * Replace the url of gravatar.
 *
 * @since Puma 2.0.0
 */

function puma_get_ssl_avatar($avatar) {
    $avatar = str_replace(array("www.gravatar.com", "0.gravatar.com", "1.gravatar.com", "2.gravatar.com"), "cn.gravatar.com", $avatar);
    return $avatar;
}
add_filter('get_avatar', 'puma_get_ssl_avatar');


/**
 * Add and remove the contact methods.
 *
 * @since Puma 2.0.0
 */
function puma_contactmethods( $contactmethods ) {
    $contactmethods['twitter'] = 'Twitter';
    $contactmethods['sina-weibo'] = 'Weibo';
    $contactmethods['location'] = '位置';
    $contactmethods['instagram'] = 'Instagram';
    unset($contactmethods['aim']);
    unset($contactmethods['yim']);
    unset($contactmethods['jabber']);
    return $contactmethods;
}
add_filter('user_contactmethods','puma_contactmethods',10,1);

/**
 * Recover comment fields since WordPress 4.4
 *
 * @since Puma 2.0.4
 */
function recover_comment_fields($comment_fields){
    $comment = array_shift($comment_fields);
    $comment_fields =  array_merge($comment_fields ,array('comment' => $comment));
    return $comment_fields;
}
add_filter('comment_form_fields','recover_comment_fields');
