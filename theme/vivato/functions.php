<?php
/**
 * Vivato functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package Vivato
 */

require get_template_directory() . '/functions-templates.php';
require get_template_directory() . '/functions-loaders.php';


if ( ! defined( '_S_VERSION' ) ) {
	// Replace the version number of the theme on each release.
	define( '_S_VERSION', '1.0.0' );
}

if ( ! function_exists( 'vivato_setup' ) ) :
	/**
	 * Sets up theme defaults and registers support for various WordPress features.
	 *
	 * Note that this function is hooked into the after_setup_theme hook, which
	 * runs before the init hook. The init hook is too late for some features, such
	 * as indicating support for post thumbnails.
	 */
	function vivato_setup() {
		/*
		 * Make theme available for translation.
		 * Translations can be filed in the /languages/ directory.
		 * If you're building a theme based on Vivato, use a find and replace
		 * to change 'vivato' to the name of your theme in all the template files.
		 */
		load_theme_textdomain( 'vivato', get_template_directory() . '/languages' );

		// Add default posts and comments RSS feed links to head.
		add_theme_support( 'automatic-feed-links' );

		/*
		 * Let WordPress manage the document title.
		 * By adding theme support, we declare that this theme does not use a
		 * hard-coded <title> tag in the document head, and expect WordPress to
		 * provide it for us.
		 */
		add_theme_support( 'title-tag' );

		/*
		 * Enable support for Post Thumbnails on posts and pages.
		 *
		 * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
		 */
		add_theme_support( 'post-thumbnails' );

		/*
		 * Switch default core markup for search form, comment form, and comments
		 * to output valid HTML5.
		 */
		add_theme_support(
			'html5',
			array(
				'search-form',
				'comment-form',
				'comment-list',
				'gallery',
				'caption',
				'style',
				'script',
			)
		);

		// Set up the WordPress core custom background feature.
		add_theme_support(
			'custom-background',
			apply_filters(
				'vivato_custom_background_args',
				array(
					'default-color' => 'ffffff',
					'default-image' => '',
				)
			)
		);

		// Add theme support for selective refresh for widgets.
		add_theme_support( 'customize-selective-refresh-widgets' );

		/**
		 * Add support for core custom logo.
		 *
		 * @link https://codex.wordpress.org/Theme_Logo
		 */
		add_theme_support(
			'custom-logo',
			array(
				'height'      => 250,
				'width'       => 250,
				'flex-width'  => true,
				'flex-height' => true,
			)
		);
	}
endif;
add_action( 'after_setup_theme', 'vivato_setup' );

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function vivato_content_width() {
	$GLOBALS['content_width'] = apply_filters( 'vivato_content_width', 640 );
}
add_action( 'after_setup_theme', 'vivato_content_width', 0 );


/**
 * Enqueue scripts and styles.
 */
 

function vivato_scripts() {
	
	//wp_enqueue_script( 'jquery-3', get_template_directory_uri() . '/js/jquery-3.2.0.min.js', array(), null, false);
	wp_enqueue_script( 'mobilemenu', get_template_directory_uri() . '/plugins/mmenu/jquery-simple-mobilemenu.js', array('jquery'), null, false);
	wp_enqueue_script( 'fancybox', get_template_directory_uri() . '/plugins/fancybox/jquery.fancybox.js', array('jquery'), null, false);
	wp_enqueue_script( 'swiper', get_template_directory_uri() . '/plugins/swiper/swiper.js', array('jquery'), null, false);
	
	wp_enqueue_script( 'momentjs', get_template_directory_uri() . '/plugins/daterangepicker/moment.min.js', array('jquery'), null, false);
	wp_enqueue_script( 'daterangepicker', get_template_directory_uri() . '/plugins/daterangepicker/daterangepicker.js', array('jquery'), null, false);
	
	wp_enqueue_script( 'main', get_template_directory_uri() . '/js/main.js', array('jquery'), null, false);

	
	wp_enqueue_style( 'swiper', get_template_directory_uri() . '/plugins/swiper/swiper.css', array(), null, false);
	wp_enqueue_style( 'fancybox', get_template_directory_uri() . '/plugins/fancybox/jquery.fancybox.css', array(), null, false);
	wp_enqueue_style( 'mobilemenu', get_template_directory_uri() . '/plugins/mmenu/styles/jquery-simple-mobilemenu-slide.css', array(), null, false);
	wp_enqueue_style( 'daterangepicker', get_template_directory_uri() . '/plugins/daterangepicker/daterangepicker.css', array(), null, false);
	
	
	wp_enqueue_style( 'style', get_template_directory_uri() . '/css/style.css', array(), null, false);
	

	wp_enqueue_style( 'vivato-style', get_stylesheet_uri(), array(), _S_VERSION );
	wp_style_add_data( 'vivato-style', 'rtl', 'replace' );
	
	wp_enqueue_script( 'vivato-navigation', get_template_directory_uri() . '/js/navigation.js', array(), _S_VERSION, true );
	
	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'vivato_scripts' );





// disable gutenberg for posts
add_filter('use_block_editor_for_post', '__return_false', 10);
// disable gutenberg for post types
add_filter('use_block_editor_for_post_type', '__return_false', 10);

function smartwp_remove_wp_block_library_css(){
    wp_dequeue_style( 'wp-block-library' );
    wp_dequeue_style( 'wp-block-library-theme' );
    wp_dequeue_style( 'wc-blocks-style' ); // Remove WooCommerce block CSS
} 
add_action( 'wp_enqueue_scripts', 'smartwp_remove_wp_block_library_css', 100 );


add_shortcode('menu', 'print_menu_shortcode');
function print_menu_shortcode($atts, $content = null) {
    extract(shortcode_atts(array( 'name' => null, ), $atts));
    return wp_nav_menu( array( 'menu' => $name, 'echo' => false ) );
}

add_filter('wpcf7_autop_or_not', '__return_false');

// Custom menus
function wpb_custom_new_menu() {
  register_nav_menus(
    array(
		'top-menu' => __( 'תפריט עליון ' ),
		'mobile-menu' => __( 'תפריט מובייל' ),
		'footer-menu' => __( 'תפריט footer' ),
    )
  );
}
add_action( 'init', 'wpb_custom_new_menu' );

//Settings page
if( function_exists('acf_add_options_page') ) {
	
	acf_add_options_page(array(
		'page_title' 	=> 'הגדרות כלליות',
		'menu_title'	=> 'הגדרות כלליות',
		'menu_slug' 	=> 'theme-general-settings',
		'capability'	=> 'edit_posts',
		'redirect'		=> false,
		'position' => 2,
	));
}


add_action( 'admin_head', 'hide_editor' );
function hide_editor() {
	$template_file = $template_file = basename( get_page_template() );
	if($template_file != "page.php" && $template_file != 'tmp-checklist.php' && $template_file != 'tmp-page-banners.php' && $template_file != 'tmp-user-profile.php' && $template_file != 'tmp-new-story.php' && $template_file != 'tmp-weather-archive.php')
	{
		remove_post_type_support('page', 'editor');
	}
}





add_filter( 'wpseo_breadcrumb_single_link', 'ss_breadcrumb_single_link', 10, 2 );

function ss_breadcrumb_single_link( $link_output, $link ) {
	
	if(!strpos($link_output,"breadcrumb_last")) {
	
		if(strpos($link['url'], "/category/")) {
			$id = get_option( 'page_for_posts' );
			$link['url'] = get_permalink($id);
			$link['text'] = get_post($id) -> post_title;
		}
		
	}

	if ( isset( $link['text'] ) && ( is_string( $link['text'] ) && $link['text'] !== '' ) ) {
		$link['text'] = trim( $link['text'] );
		if ( ! isset( $link['allow_html'] ) || $link['allow_html'] !== true ) {
			$link['text'] = esc_html( $link['text'] );
		}
		if ( ( strpos($link_output,"breadcrumb_last") == false && ( isset( $link['url'] ) && ( is_string( $link['url'] ) && $link['url'] !== '' ) ) )
		) {
			$link_output = '';
			$link_output .= '<' . 'span' . '>';
			$title_attr   = isset( $link['title'] ) ? ' title="' . esc_attr( $link['title'] ) . '"' : '';
			$link_output .= '<a href="' . esc_url( $link['url'] ) . '" ' . $title_attr . '>' . $link['text'] . '</a>';
		}
		else {
			$inner_elm = 'span';
			if ( strpos($link_output,"breadcrumb_last") && WPSEO_Options::get( 'breadcrumbs-boldlast' ) === true ) {
				$inner_elm = 'strong';
			}
			
			$link_output = '';
			$link_output .= '<' . $inner_elm . ' class="breadcrumb_last" aria-current="page">' . $link['text'] . '</' . $inner_elm . '>';
		}
	}
    return $link_output;
}




add_action('admin_head', 'my_custom_fonts');

function my_custom_fonts() {
  echo '<style>
    .select2-container--default .select2-results__option[aria-selected=true], .select2-container--default .select2-results__option[data-selected=true] {
		background-color: #ddd;
	}
	.wdspromos {
		display: none;
	}
	#edittag {
		max-width: 1600px;
	}
  </style>';
}


function make_short($string, $num_of_words) {
	$no_tags = wp_strip_all_tags($string);
	return wp_trim_words($no_tags, $num_of_words);
}


//add SVG to allowed file uploads
function add_file_types_to_uploads($file_types){

     $new_filetypes = array();
     $new_filetypes['svg'] = 'image/svg';
     $file_types = array_merge($file_types, $new_filetypes );

     return $file_types; 
} 
add_action('upload_mimes', 'add_file_types_to_uploads');

function get_cur_template() {
    global $template;
    return basename($template);
}


function hl_last_word($string) {
	$formatted = preg_replace('/\S+$/', '<span>$0</span>', $string);
	return $formatted;
}

add_image_size( 'thumb-post', 480, 240, true );
add_image_size( 'thumb-location', 500, 434, true );
add_image_size( 'thumb-attraction', 360, 290, true );
add_image_size( 'thumb-attraction-location', 250, 160, true );
add_image_size( 'thumb-attraction-slide', 850, 650, true );

add_image_size( 'slider-attraction', 715, 470, true );
add_image_size( 'slider-index-top', 1920, 900, true );

add_image_size( 'thumb-articles-index', 430, 200, true );
add_image_size( 'thumb-blogger-story', 495, 210, true );


add_image_size( 'slider-main-mobile', 450, 668, true );
add_image_size( 'thumb-attraction-mobile', 280, 270, true );
add_image_size( 'thumb-post-mobile', 186, 150, true );
add_image_size( 'thumb-hotel-mobile', 120, 140, true );

add_image_size( 'banner-mobile', 500, 99999, false );


add_image_size( 'thumb-hotel-rec', 475, 290, true );
add_image_size( 'thumb-cube', 120, 120, true );
add_image_size( 'thumb-cube-bigger', 190, 190, true );


function load_data_from_weather_api($request_url, $request_data_raw) {
	$curl = curl_init();
	$request_data = http_build_query($request_data_raw);

	$url = "https://weatherbit-v1-mashape.p.rapidapi.com/" . $request_url . "?" . $request_data;

	curl_setopt_array($curl, [
		CURLOPT_URL => $url,
		CURLOPT_RETURNTRANSFER => true,
		CURLOPT_FOLLOWLOCATION => true,
		CURLOPT_ENCODING => "",
		CURLOPT_MAXREDIRS => 10,
		CURLOPT_TIMEOUT => 30,
		CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
		CURLOPT_CUSTOMREQUEST => "GET",
		CURLOPT_HTTPHEADER => [
			"X-RapidAPI-Host: weatherbit-v1-mashape.p.rapidapi.com",
			"X-RapidAPI-Key: 63a9f03888msha758c9bfcd7395bp176219jsn00145fd093c5"
		],
	]);

	$response = curl_exec($curl);
	$err = curl_error($curl);

	curl_close($curl);

	if ($err) {
		echo "cURL Error #:" . $err;
		return;
	} else {
		$response_object = json_decode($response);
		return $response_object;
	}
}



function load_data_from_booking_api($request_url, $request_data_raw) {
	$curl = curl_init();
	$request_data = http_build_query($request_data_raw);

	$url = "https://booking-com.p.rapidapi.com/" . $request_url . "?" . $request_data;

	curl_setopt_array($curl, [
		CURLOPT_URL => $url,
		CURLOPT_RETURNTRANSFER => true,
		CURLOPT_FOLLOWLOCATION => true,
		CURLOPT_ENCODING => "",
		CURLOPT_MAXREDIRS => 10,
		CURLOPT_TIMEOUT => 30,
		CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
		CURLOPT_CUSTOMREQUEST => "GET",
		CURLOPT_HTTPHEADER => [
			"X-RapidAPI-Host: booking-com.p.rapidapi.com",
			//"X-RapidAPI-Key: f0e013bd3amsh41df72eb5bdb980p165d74jsn2bffbdc1990b"
			'X-RapidAPI-Key: 63a9f03888msha758c9bfcd7395bp176219jsn00145fd093c5',
		],
	]);

	$response = curl_exec($curl);
	$err = curl_error($curl);

	curl_close($curl);

	if ($err) {
		echo "cURL Error #:" . $err;
		return;
	} else {
		$response_object = json_decode($response);
		return $response_object;
	}
}

function load_data_from_google_api($request_url, $request_data_raw) {
	$curl = curl_init();
	$request_data = http_build_query($request_data_raw);

	$url = $request_url . "?" . $request_data;

	curl_setopt_array($curl, [
		CURLOPT_URL => $url,
		CURLOPT_RETURNTRANSFER => true,
		CURLOPT_FOLLOWLOCATION => true,
		CURLOPT_ENCODING => "",
		CURLOPT_MAXREDIRS => 10,
		CURLOPT_TIMEOUT => 30,
		CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
		CURLOPT_CUSTOMREQUEST => "GET",
		/*
		CURLOPT_HTTPHEADER => [
			"X-RapidAPI-Host: booking-com.p.rapidapi.com",
			//"X-RapidAPI-Key: f0e013bd3amsh41df72eb5bdb980p165d74jsn2bffbdc1990b"
			'X-RapidAPI-Key: 63a9f03888msha758c9bfcd7395bp176219jsn00145fd093c5',
		],
		*/
	]);

	$response = curl_exec($curl);
	$err = curl_error($curl);

	curl_close($curl);

	if ($err) {
		echo "cURL Error #:" . $err;
		return;
	} else {
		$response_object = json_decode($response);
		return $response_object;
	}
}


function distance($lat1, $lon1, $lat2, $lon2, $unit) {
  if (($lat1 == $lat2) && ($lon1 == $lon2)) {
    return 0;
  }
  else {
    $theta = $lon1 - $lon2;
    $dist = sin(deg2rad($lat1)) * sin(deg2rad($lat2)) +  cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * cos(deg2rad($theta));
    $dist = acos($dist);
    $dist = rad2deg($dist);
    $miles = $dist * 60 * 1.1515;
    $unit = strtoupper($unit);

    if ($unit == "K") {
      return ($miles * 1.609344);
    } else if ($unit == "N") {
      return ($miles * 0.8684);
    } else {
      return $miles;
    }
  }
}



/*
add_action('after_setup_theme','add_roles');

function add_roles(){
    $roles_set = get_option('my_roles_are_set');
    if(!$roles_set){
        add_role('blogger', 'בלוגר', array(
            'read' => true,
            'edit_posts' => true,
            'delete_posts' => true,
            'upload_files' => true,

        ));
        update_option('my_roles_are_set', true);
    }
}
*/

add_action( 'login_form_middle', 'add_lost_password_link' );
function add_lost_password_link() {
    return '<a class="lost-password" href="/wp-login.php?action=lostpassword">שכחת סיסמה?</a>';
}

if(!function_exists('login_page'))
{
  function login_page()
  {
      $args = array(
        'echo'           => true,
        'remember'       => true,
        'redirect'       => ( is_ssl() ? 'https://' : 'http://' ) . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'],
        'form_id'        => 'loginform',
        'id_username'    => 'user_login',
        'id_password'    => 'user_pass',
        'id_remember'    => 'rememberme',
        'id_submit'      => 'wp-submit',
        'label_username' => __( 'שם משתמש או כתובת אימייל' ),
        'label_password' => __( 'סיסמה' ),
        'label_remember' => __( 'זכור אותי' ),
        'label_log_in'   => __( 'התחברות' ),
        'value_username' => '',
        'value_remember' => false
    );
    wp_login_form($args);
    add_lost_password_link();
  }
  add_shortcode('login-form', 'login_page');
}



function get_content_of_attraction_category_in_location($attraction_category_id, $location_id) {
	$items = get_field('attractions-categories-content', get_term($location_id));
	if(!$items) return "";
	$content = array();
	foreach($items as $item) {
		if($item['category'] == $attraction_category_id) $content = $item;
	}
	
	return $content;
}

function get_seo_of_attraction_category_in_location($attraction_category_id, $location_id) {
	$items = get_field('attractions-categories-content', get_term($location_id));
	if(!$items) return "";
	$content = "";
	foreach($items as $item) {
		if($item['category'] == $attraction_category_id) $content = $item['seo'];
	}
	
	return $content;
}


function get_content_of_posts_category_in_location($attraction_category_id, $location_id) {
	$items = get_field('posts-categories-content', get_term($location_id));
	if(!$items) return "";
	$content = array();
	foreach($items as $item) {
		if($item['category'] == $attraction_category_id) $content = $item;
	}
	
	return $content;
}

function get_seo_of_posts_category_in_location($attraction_category_id, $location_id) {
	$items = get_field('posts-categories-content', get_term($location_id));
	if(!$items) return "";
	$content = "";
	foreach($items as $item) {
		if($item['category'] == $attraction_category_id) $content = $item['seo'];
	}
	
	return $content;
}


if (!function_exists('write_log')) {

    function write_log($log) {
        if (true === WP_DEBUG) {
            if (is_array($log) || is_object($log)) {
                error_log(print_r($log, true));
            } else {
                error_log($log);
            }
        }
    }
}

function am_i_following_author($curent_user_id , $author_id) {
	global $wpdb;
	
	$rows = $wpdb->get_results("SELECT * FROM `thf_followers` WHERE `thf_followers`.`user_id` = " . $curent_user_id  . " AND `thf_followers`.`follow_user_id` = " . $author_id);
	if($rows) {
		return true;
	}
	else {
		return false;
	}
}

function do_i_like_hotel($curent_user_id , $hotel_id) {
	global $wpdb;
	
	$rows = $wpdb->get_results("SELECT * FROM `thf_hotels_likes` WHERE `thf_hotels_likes`.`user_id` = " . $curent_user_id  . " AND `thf_hotels_likes`.`hotel_id` = " . $hotel_id);
	if($rows) {
		return true;
	}
	else {
		return false;
	}
}

function get_followers_number_of_author($author_id) {
	$blogger_post_id = get_blogger_post_id($author_id);
	return (int)wp_ulike_get_post_likes($blogger_post_id);
}

function get_posts_views_likes_number_of_author($author_id) {
	$args = Array(
		'post_type' => 'blogger-story',
		'numberposts' => -1,
		'author' =>  $author_id,
		'fields' => 'ids',
	);
	
	$items = get_posts($args);
	
	$views = 0;
	$likes = 0;
	foreach($items as $item) {
		$views = $views + pvc_get_post_views($item);
		$likes = $likes + (int)wp_ulike_get_post_likes($item);	
	}
	
	$result = Array(
		"posts" => sizeof($items),
		"views" => $views,
		"likes" => $likes
	);
	
	return $result;
}


function get_tips_views_likes_number_of_author($author_id) {
	$args = Array(
		'post_type' => 'tip',
		'numberposts' => -1,
		'author' =>  $author_id,
		'fields' => 'ids',
	);
	
	$items = get_posts($args);
	
	$views = 0;
	$likes = 0;
	foreach($items as $item) {
		$views = $views + pvc_get_post_views($item);
		$likes = $likes + (int)wp_ulike_get_post_likes($item);	
	}
	
	$result = Array(
		"posts" => sizeof($items),
		"views" => $views,
		"likes" => $likes
	);
	
	return $result;
}


function get_blogger_post_id($user_id, $create=true) {
	$args = array(
		'meta_key' => 'user-id',
		'meta_value' => $user_id,
		'post_type' => 'blogger',
		'post_status' => 'any',
		'posts_per_page' => -1,
		'fields' => 'ids'
	);
	$posts = get_posts($args);
	
	if(sizeof($posts)) return $posts[0];
	else {
		if(!$create) return 0;
		$author_display_name = get_the_author_meta('display_name', $user_id);
		$new_post = array(
			'post_title' => $author_display_name,
			'post_status' => 'publish',
			'post_type' => 'blogger',
		);
		$post_id = wp_insert_post($new_post);
		update_post_meta($post_id, 'user-id', $user_id );
		return($post_id);
	}
}



function city_id_to_term($city_id, $term_id) {
	$ids = get_term_meta($term_id, "booking-data_city-ids", true);
	if($ids) $ids_array = explode(",", $ids);
	else $ids_array = Array();
	if(!in_array($city_id, $ids_array)) $ids_array[] = $city_id;
	$ids = implode(",", $ids_array);
	
	update_term_meta($term_id, "booking-data_city-ids", $ids);
}

function get_hotel_post_id($hotel_id, $create = true, $location_term_id = null) {
	$args = array(
		'meta_key' => 'booking-id',
		'meta_value' => $hotel_id,
		'post_type' => 'hotel',
		'post_status' => 'any',
		'posts_per_page' => -1,
		'fields' => 'ids'
	);
	$posts = get_posts($args);
	
	if(sizeof($posts)) return $posts[0];
	else {
		if(!$create) return 0;
		$request_data_raw = Array(
			'hotel_id' => $hotel_id,
			'locale' => 'he'
		);
		$hotel_data = load_data_from_booking_api('v1/hotels/data', $request_data_raw );
		
		
		$image_url = $hotel_data -> main_photo_url;
		$image_url = str_replace("square60", "square1000", $image_url);
		$name = $hotel_data->name;
		$location = $hotel_data->city;
		$stars_num = "";
		if(isset($hotel_data -> booking_home -> quality_class)) $stars_num = $hotel_data -> booking_home -> quality_class;
		elseif(isset($hotel_data -> class)) $stars_num = $hotel_data -> class;
		$review_nr = $hotel_data -> review_nr;
		$review_score = "";
		if(isset($hotel_data -> review_score)) $review_score = $hotel_data -> review_score;
		$hotel_description = "";
		if(isset($hotel_data->description_translations)) {
			foreach($hotel_data->description_translations as $item) {
				if($item->languagecode == "he") {
					$hotel_description = $item->description;
					break;
				}
			}
		}
		
		if(!$hotel_description) {
			$hotel_description_data = load_data_from_booking_api('v2/hotels/description', $request_data_raw );
			if(isset($hotel_description_data->description)) $hotel_description = $hotel_description_data->description;
		}
		
		
		$location_ex = "";
		if(isset($hotel_data -> city)) $location_ex .= $hotel_data -> city;
		if(isset($hotel_data -> address)) {
			if($location_ex) $location_ex .= ", ";
			$location_ex .= $hotel_data -> address;
		}
		
		$l_lat = $hotel_data->location->latitude;
		$l_long = $hotel_data->location->longitude;
		$url = $hotel_data->url;
		$city_id = $hotel_data->city_id;
		$city = $hotel_data->city;
		
		$new_post = array(
			'post_title' => $name,
			'post_content' => $hotel_description,
			'post_status' => 'publish',
			'post_type' => 'hotel',
		);
		$post_id = wp_insert_post($new_post);
		$hotel_facilities = $hotel_data->hotel_facilities;
		
		
		$location_terms_ids = Array();
		
		$terms = get_terms( array(
			'taxonomy'   => 'location',
			'hide_empty' => false,
			'fields' => 'ids'
		));

		foreach($terms as $term_id) {
			$ids = get_term_meta($term_id, "booking-data_city-ids", true);

			$ids_array = explode(",", $ids);
			
			if(in_array($city_id, $ids_array)) {
				$location_terms_ids[] = $term_id;
			}
		}
		
		if($location_terms_ids) wp_set_post_terms($post_id, $location_terms_ids, 'location');
		if($location_term_id) wp_set_post_terms($post_id, $location_term_id, 'location');
		
		
		set_post_image_from_url($post_id, $image_url);
		update_post_meta($post_id, 'booking-id', $hotel_id );
		update_post_meta($post_id, 'location', $location );
		update_post_meta($post_id, 'stars', $stars_num );
		update_post_meta($post_id, 'feedback-num', $review_nr );
		update_post_meta($post_id, 'location', $location );
		update_post_meta($post_id, 'location-exect', $location_ex );
		update_post_meta($post_id, 'rating', $review_score );
		update_post_meta($post_id, 'cords_latitude', $l_lat );
		update_post_meta($post_id, 'cords_longitude', $l_long );
		update_post_meta($post_id, 'url', $url );
		update_post_meta($post_id, 'city', $city );
		update_post_meta($post_id, 'city_id', $city_id );
		update_post_meta($post_id, 'hotel-facilities', $hotel_facilities );
		return($post_id);
	}
}


function update_hotel_post($hotel_id) {
	$args = array(
		'meta_key' => 'booking-id',
		'meta_value' => $hotel_id,
		'post_type' => 'hotel',
		'post_status' => 'any',
		'posts_per_page' => -1,
		'fields' => 'ids'
	);
	
	$posts = get_posts($args);
	if(!sizeof($posts)) return;
	$post_id = $posts[0];
	

	$request_data_raw = Array(
		'hotel_id' => $hotel_id,
		'locale' => 'he'
	);
	$hotel_data = load_data_from_booking_api('v1/hotels/data', $request_data_raw );
	
	
	$image_url = $hotel_data -> main_photo_url;
	$image_url = str_replace("square60", "square1000", $image_url);
	$name = $hotel_data->name;
	$location = $hotel_data->city;
	$stars_num = "";
	if(isset($hotel_data -> booking_home -> quality_class)) $stars_num = $hotel_data -> booking_home -> quality_class;
	elseif(isset($hotel_data -> class)) $stars_num = $hotel_data -> class;
	$review_nr = $hotel_data -> review_nr;
	$review_score = "";
	if(isset($hotel_data -> review_score)) $review_score = $hotel_data -> review_score;
	$hotel_description = "";
	if(isset($hotel_data->description_translations)) {
		foreach($hotel_data->description_translations as $item) {
			if($item->languagecode == "he") {
				$hotel_description = $item->description;
				break;
			}
		}
	}

	if(!$hotel_description) {
		$hotel_description_data = load_data_from_booking_api('v2/hotels/description', $request_data_raw );
		if(isset($hotel_description_data->description)) $hotel_description = $hotel_description_data->description;
	}
	
	$update_post = array(
		'ID' => $post_id,
		'post_title' => $name,
		'post_content' => $hotel_description,
		'post_status' => 'publish',
		'post_type' => 'hotel',
	);
	wp_update_post($update_post);
	
	
	$location_ex = "";
	if(isset($hotel_data -> city)) $location_ex .= $hotel_data -> city;
	if(isset($hotel_data -> address)) {
		if($location_ex) $location_ex .= ", ";
		$location_ex .= $hotel_data -> address;
	}
	
	$l_lat = $hotel_data->location->latitude;
	$l_long = $hotel_data->location->longitude;
	$url = $hotel_data->url;
	$city_id = $hotel_data->city_id;
	$city = $hotel_data->city;
	
	$hotel_facilities = $hotel_data->hotel_facilities;
	
	$location_terms_ids = Array();
	
	$terms = get_terms( array(
		'taxonomy'   => 'location',
		'hide_empty' => false,
		'fields' => 'ids'
	));

	foreach($terms as $term_id) {
		$ids = get_term_meta($term_id, "booking-data_city-ids", true);

		$ids_array = explode(",", $ids);
		
		if(in_array($city_id, $ids_array)) {
			$location_terms_ids[] = $term_id;
		}
	}
	
	if($location_terms_ids) wp_set_post_terms($post_id, $location_terms_ids, 'location');
	
	
	set_post_image_from_url($post_id, $image_url);
	update_post_meta($post_id, 'booking-id', $hotel_id );
	update_post_meta($post_id, 'location', $location );
	update_post_meta($post_id, 'stars', $stars_num );
	update_post_meta($post_id, 'feedback-num', $review_nr );
	update_post_meta($post_id, 'location', $location );
	update_post_meta($post_id, 'location-exect', $location_ex );
	update_post_meta($post_id, 'rating', $review_score );
	update_post_meta($post_id, 'cords_latitude', $l_lat );
	update_post_meta($post_id, 'cords_longitude', $l_long );
	update_post_meta($post_id, 'url', $url );
	update_post_meta($post_id, 'city', $city );
	update_post_meta($post_id, 'city_id', $city_id );
	update_post_meta($post_id, 'hotel-facilities', $hotel_facilities );
	
	return("Data updated from booking.com");
	
}

function set_post_image_from_url($post_id, $image_url) {
	// Add Featured Image to Post
	$image_url        = $image_url; // Define the image URL here
	$image_name       = 'hotel-image.png';
	$upload_dir       = wp_upload_dir(); // Set upload folder
	$image_data       = file_get_contents($image_url); // Get image data
	$unique_file_name = wp_unique_filename( $upload_dir['path'], $image_name ); // Generate unique name
	$filename         = basename( $unique_file_name ); // Create image file name

	// Check folder permission and define file location
	if( wp_mkdir_p( $upload_dir['path'] ) ) {
		$file = $upload_dir['path'] . '/' . $filename;
	} else {
		$file = $upload_dir['basedir'] . '/' . $filename;
	}

	// Create the image  file on the server
	file_put_contents( $file, $image_data );

	// Check image file type
	$wp_filetype = wp_check_filetype( $filename, null );

	// Set attachment data
	$attachment = array(
		'post_mime_type' => $wp_filetype['type'],
		'post_title'     => sanitize_file_name( $filename ),
		'post_content'   => '',
		'post_status'    => 'inherit'
	);

	// Create the attachment
	$attach_id = wp_insert_attachment( $attachment, $file, $post_id );

	// Include image.php
	require_once(ABSPATH . 'wp-admin/includes/image.php');

	// Define attachment metadata
	$attach_data = wp_generate_attachment_metadata( $attach_id, $file );

	// Assign metadata to attachment
	wp_update_attachment_metadata( $attach_id, $attach_data );

	// And finally assign featured image to post
	set_post_thumbnail( $post_id, $attach_id );
}



add_action( 'init',  function() {
    add_rewrite_rule( 'מדריכים/(.*)/(.*)?$', 'index.php?article_location=$matches[1]&article_category=$matches[2]', 'top' );
	add_rewrite_rule( 'מדריכים/(.*)?$', 'index.php?article_location=$matches[1]', 'top' );
	
	add_rewrite_rule( 'אטרקציות/(.*)/(.*)?$', 'index.php?attraction_location=$matches[1]&attraction_category=$matches[2]', 'top' );
	add_rewrite_rule( 'אטרקציות/(.*)?$', 'index.php?attraction_location=$matches[1]', 'top' );
	
	add_rewrite_rule( 'בתי-מלון/(.*)?$', 'index.php?hotel_location=$matches[1]', 'top' );
	
	add_rewrite_rule( 'טיפים/(.*)?$', 'index.php?tip_location=$matches[1]', 'top' );
	
	add_rewrite_rule( 'מזג-אוויר/(.*)?$', 'index.php?weather_location=$matches[1]', 'top' );
	
	add_rewrite_rule( 'actions/(.*)?$', 'index.php?action=$matches[1]', 'top' );
	
	add_rewrite_rule( 'בלוגר/(.*)?$', 'index.php?blogger_slug=$matches[1]', 'top' );
	
	add_rewrite_rule( 'משתמש/(.*)?$', 'index.php?user_slug=$matches[1]', 'top' );
});

add_filter( 'query_vars', function( $query_vars ) {
    $query_vars[] = 'article_location';
	$query_vars[] = 'article_category';
	$query_vars[] = 'hotel_location';
	$query_vars[] = 'attraction_location';
	$query_vars[] = 'tip_location';
	$query_vars[] = 'weather_location';
	$query_vars[] = 'blogger_slug';
	$query_vars[] = 'user_slug';
	$query_vars[] = 'action';
    return $query_vars;
} );

add_action( 'template_include', function( $template ) {
    if(get_query_var( 'article_location')) {
        return get_template_directory() . '/special-templates/post-location-category.php';
    }
	
	if(get_query_var( 'hotel_location')) {
        return get_template_directory() . '/special-templates/hotel-location.php';
    }
	
	if(get_query_var( 'attraction_location')) {
        return get_template_directory() . '/special-templates/attraction-location-category.php';
    }
	
	if(get_query_var( 'tip_location')) {
        return get_template_directory() . '/special-templates/tip-location.php';
    }
	
	if(get_query_var( 'weather_location')) {
        return get_template_directory() . '/special-templates/weather-location.php';
    }
	
	if(get_query_var( 'blogger_slug')) {
        return get_template_directory() . '/special-templates/blogger-page.php';
    }
	
	if(get_query_var( 'user_slug')) {
        return get_template_directory() . '/special-templates/user-page.php';
    }
	
	if(get_query_var( 'action')) {
        return get_template_directory() . '/special-templates/actions.php';
    }
	
	return $template;
    
} );


function get_temp_color($num) {
	$result = "#4cd964";
	if($num < 0) $result = "#007aff";
	elseif($num >= 0 && $num < 15) $result = "#5ac8fa";
	elseif($num >= 15 && $num < 20) $result = "#4cd964";
	elseif($num >= 20 && $num < 25) $result = "#ffcc00";
	elseif($num >= 25 && $num < 30) $result = "#ff9500";
	elseif($num >= 30) $result = "#ff3b30";
	return $result;
}


function prefix_filter_description( $description ) {
	global $meta_description;
	if($meta_description) $description = $meta_description;
	return $description;
}
add_filter( 'wpseo_metadesc', 'prefix_filter_description' );


function prefix_filter_og_description($desc) {
	global $meta_description;
	if($meta_description) $desc = $meta_description;
	return $desc;
}
add_filter( 'wpseo_opengraph_desc', 'prefix_filter_og_description' );

function prefix_filter_title( $title ) {
	global $meta_title;
	if($meta_title) $title = $meta_title;
	return $title;
}
add_filter( 'wpseo_title', 'prefix_filter_title' );
add_filter( 'wpseo_opengraph_title', 'prefix_filter_title' );


add_filter( 'wpseo_opengraph_url', 'prefix_filter_canonical', 10, 2 );
add_filter( 'wpseo_canonical', 'prefix_filter_canonical', 10, 2 );
function prefix_filter_canonical($url, $presentation) {
	global $meta_canonical;
	if($meta_canonical) $url = $meta_canonical;
	return $url;
}



add_filter( 'wpseo_breadcrumb_links', 'wpseo_breadcrumb_set' );

function wpseo_breadcrumb_set( $links ) {
	global $my_bradcrumbs;
	if($my_bradcrumbs) return $my_bradcrumbs;
    return $links;
}




/**
 *  Create a new custom yoast seo sitemap
 */
 
add_filter( 'wpseo_sitemap_index', 'ex_add_sitemap_custom_items' );
add_action( 'init', 'init_wpseo_do_sitemap_actions' );


// Add custom index
function ex_add_sitemap_custom_items(){
	global $wpseo_sitemaps;
	$date = $wpseo_sitemaps->get_last_modified('hotel');

	$smp ='';

    	$smp .= '<sitemap>' . "\n";
	$smp .= '<loc>' . site_url() .'/location-hotels-sitemap.xml</loc>' . "\n";
	$smp .= '<lastmod>' . htmlspecialchars( $date ) . '</lastmod>' . "\n";
	$smp .= '</sitemap>' . "\n";


	return $smp;
}


function init_wpseo_do_sitemap_actions(){
	add_action( "wpseo_do_sitemap_location-hotels", 'ex_generate_origin_combo_sitemap');
}




function ex_generate_origin_combo_sitemap(){
	global $wpdb;
	global $wp_query;
	global $wpseo_sitemaps;
	
	$output = "";
	$terms = get_terms( array(
		'taxonomy'   => 'location',
		'hide_empty' => false,
	));
	
	foreach($terms as $term) {
		$args = Array(
			'post_type' => 'hotel',
			'numberposts' => 1,
			'orderby'           => 'date',
			'order'             => 'DESC',
			'tax_query' => array(
				array(
					'taxonomy' => 'location',
					'field' => 'term_id', 
					'terms' => $term -> term_id
				)
			)
		);
		
		$hotels = get_posts($args);
		if($hotels) {
			$h_date = get_the_modified_date('Y-m-d\TH:i:sP', $hotels[0]->ID);
		}
		else {
			$h_date = $wpseo_sitemaps->get_last_modified('hotel');
		}
			
		
		
		$output .= '<url>
						<loc>'.site_url() . "/בתי-מלון/" . $term -> slug . '/</loc>
						<lastmod>'.$h_date.'</lastmod>
					</url>';
	}



	$sitemap = '<urlset xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" ';
	$sitemap .= 'xsi:schemaLocation="http://www.sitemaps.org/schemas/sitemap/0.9 http://www.sitemaps.org/schemas/sitemap/0.9/sitemap.xsd" ';
	$sitemap .= 'xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">' . "\n";
	$sitemap .= $output . '</urlset>';

	//echo $sitemap;
	$wpseo_sitemaps->set_sitemap($sitemap);

}


add_action( 'init', 'ex_register_my_new_sitemap', 99 );

function ex_register_my_new_sitemap() {
	global $wpseo_sitemaps;
	$wpseo_sitemaps->register_sitemap( 'CUSTOM_KEY', 'ex_generate_origin_combo_sitemap' );
}

add_action( 'init', 'init_do_sitemap_actions' );

function init_do_sitemap_actions(){
	add_action( 'wp_seo_do_sitemap_our-CUSTOM_KEY', 'ex_generate_origin_combo_sitemap' );
}


// remove admin bar from non admin users
add_action('after_setup_theme', 'endo_remove_admin_bar');
function endo_remove_admin_bar() {
	if (!current_user_can('manage_options') && !is_admin()) {
		show_admin_bar(false);
	}
}


add_action('wp_logout','auto_redirect_after_logout');

function auto_redirect_after_logout(){
	wp_safe_redirect( home_url() );
	exit;
}

function before_login_form() {
?>
<?php get_header(); ?>
<section class="login">
	<div class="section-inner">
		<p class="section-title centered">התחברות <span>למערכת</span></p>
		<br>
		<div class="content white centered">
			<?php 
				$user = wp_get_current_user();
				if(isset($user->data->ID)):
			?>
			<p>אתה כבר מחובר למערכת</p>
			<div class="buttons-panel">
				<a class="button" href="<?=wp_logout_url(get_home_url());?>">התנתק</a>
			</div>
			<?php endif; ?>
<?php
}
add_action( 'login_head', 'before_login_form', 10 );


function after_login_form() {
	$td = plugin_dir_url( __FILE__ );
?>
			<div class="buttons-panel">
				<a class="button" href="<?=get_permalink(464);?>">הרשמה לאתר</a>
				<a class="button" href="<?=get_permalink(401);?>">הרשם כבלוגר</a>
			</div>
		</div>
	</div>
</section>
<?php get_footer(); ?>
<?php
}
add_action( 'login_footer', 'after_login_form', 10 );




function add_row_to_google_sheet($post_data) {
	require __DIR__ . '/google_sheets/vendor/autoload.php';
	$client = new \Google_Client();

	$client->setApplicationName('Google Sheets and PHP');

	$client->setScopes([\Google_Service_Sheets::SPREADSHEETS]);

	$client->setAccessType('offline');

	$client->setAuthConfig(__DIR__ . '/google_sheets/credentials.json');

	$service = new Google_Service_Sheets($client);

	$spreadsheetId = "1NroPBAvwpRjjOjM_Emc-c5rLPzQCUXwa8TYwRDlQIms"; //It is present in your URL
	

	$newRow = $post_data;
	$rows = [$newRow]; // you can append several rows at once
	$valueRange = new \Google_Service_Sheets_ValueRange();
	$valueRange->setValues($rows);
	$range = 'Sheet1'; // the service will detect the last row of this sheet
	$options = ['valueInputOption' => 'USER_ENTERED'];
	$service->spreadsheets_values->append($spreadsheetId, $range, $valueRange, $options);
}

//add_image_size( 'thumb-post', 374, 422, true );

add_action('wpcf7_before_send_mail', 'send_data_to_crm', 10, 3);
function send_data_to_crm($contact_form, &$abort, $object){
	$title = $contact_form->title;
	$form_id = $contact_form->id;
    $submission = WPCF7_Submission::get_instance();

    if ( $submission ) {
        $pd = $submission->get_posted_data();
		write_log($pd);
		$date = current_datetime()->format('Y-m-d H:i:s');
		$post_data = array($pd['your-name'] ?: "-", $pd['your-email'] ?: "-", $pd['your-tel'] ?: "-", $pd['your-message'] ?: "-", $pd['newsletter'] ?: "-", $pd['form-name'] ?: "-", $date);
		$images = $pd['upload-file'];
		foreach($images as $image) {
			$post_data[] = '=IMAGE("'.$image.'")';
		}
		add_row_to_google_sheet($post_data);
		
    }
}
