<?php
add_action('wp_ajax_follow_button_pressed', 'wp_ajax_follow_button_pressed_callback');
add_action('wp_ajax_nopriv_follow_button_pressed', 'wp_ajax_follow_button_pressed_callback');

function wp_ajax_follow_button_pressed_callback() {
	$my_id = $_POST['my_id'];
	$follow_user_id = $_POST['follow_user_id'];
	
	global $wpdb;
	
	$rows = $wpdb->get_results("SELECT * FROM `thf_followers` WHERE `thf_followers`.`user_id` = " . $my_id  . " AND `thf_followers`.`follow_user_id` = " . $follow_user_id);
	if($rows) {
		foreach($rows as $row) {
			$wpdb->delete( "thf_followers", array( 'id' => $row->id ) );
		}
		// Follow Removed
		$answer = '{"buttonText":"עקבו אחריי", "result":1}'; 
	}
	else {
		$wpdb->insert("thf_followers", array(
		   "user_id" => $my_id ,
		   "follow_user_id" =>$follow_user_id,
		));
		
		// Follow Added
		$answer = '{"buttonText":"עוקב", "result":2}'; 
	}

	echo $answer;
	die();
}


add_action('wp_ajax_like_hotel_button_pressed', 'wp_ajax_like_hotel_button_pressed_callback');
add_action('wp_ajax_nopriv_like_hotel_button_pressed', 'wp_ajax_like_hotel_button_pressed_callback');

function wp_ajax_like_hotel_button_pressed_callback() {
	$user_id = $_POST['user_id'];
	$hotel_id = $_POST['hotel_id'];
	
	global $wpdb;
	
	$rows = $wpdb->get_results("SELECT * FROM `thf_hotels_likes` WHERE `thf_hotels_likes`.`user_id` = " . $user_id  . " AND `thf_hotels_likes`.`hotel_id` = " . $hotel_id);
	if($rows) {
		foreach($rows as $row) {
			$wpdb->delete( "thf_hotels_likes", array( 'id' => $row->id ) );
		}
		// Follow Removed
		$answer = '{"buttonText":"הוספה למועדפים", "result":1}'; 
	}
	else {
		$wpdb->insert("thf_hotels_likes", array(
		   "user_id" => $user_id ,
		   "hotel_id" =>$hotel_id,
		));
		
		// Follow Added
		$answer = '{"buttonText":"נמצא במועדפים", "result":2}'; 
	}

	echo $answer;
	die();
}


add_action('wp_ajax_load_hotels', 'wp_ajax_load_hotels_callback');
add_action('wp_ajax_nopriv_load_hotels', 'wp_ajax_load_hotels_callback');

function wp_ajax_load_hotels_callback() {
	$parameters = Array();
	$now = new DateTime();
	$parameters['today_date'] = $now->format('Y-m-d');
	
	if(isset($_POST['checkin_date'])) $parameters['checkin_date'] = $_POST['checkin_date'];
	else $parameters['checkin_date'] = $now->add(new DateInterval('P1W'))->format('Y-m-d');
	
	if(isset($_POST['checkout_date'])) $parameters['checkout_date'] = $_POST['checkout_date'];
	else $parameters['checkout_date'] = $now->add(new DateInterval('P1W'))->format('Y-m-d');
	
	if(isset($_POST['dest_type'])) $parameters['dest_type'] = $_POST['dest_type'];
	else $parameters['dest_type'] = get_field('booking-data', get_field('locations')[0])['city-region'];
	
	if(isset($_POST['dest_id'])) $parameters['dest_id'] = $_POST['dest_id'];
	else $parameters['dest_id'] = get_field('booking-data', get_field('locations')[0])['id'];
	
	if(isset($_POST['adults_number'])) $parameters['adults_number'] = $_POST['adults_number'];
	else $parameters['adults_number'] = "2";
	
	if(isset($_POST['children_number'])) $parameters['children_number'] = $_POST['children_number'];
	else $parameters['children_number'] = "0";
	
	if(isset($_POST['room_number'])) $parameters['room_number'] = $_POST['room_number'];
	else $parameters['room_number'] = "1";
	
	if(isset($_POST['filters'])) $parameters['filters'] = $_POST['filters'];
	else $parameters['filters'] = "";
	
	if(isset($_POST['sort'])) $parameters['sort'] = $_POST['sort'];
	else $parameters['sort'] = "popularity";
	
	
	if(isset($_POST['page_number'])) $parameters['page_number'] = $_POST['page_number'];
	else $parameters['page_number'] = "0";
	
	if(isset($_POST['term_id'])) $parameters['term_id'] = $_POST['term_id'];
	else $parameters['term_id'] = "0";
	
	
	$request_data_raw = Array(
		'checkin_date' => $parameters['checkin_date'],
		'checkout_date' => $parameters['checkout_date'],
		'dest_type' => $parameters['dest_type'],
		'dest_id' => $parameters['dest_id'],
		'adults_number' => $parameters['adults_number'],
		'room_number' => $parameters['room_number'],
		'filter_by_currency' => 'AED',
		'locale' => 'he',
		'page_number' => $parameters['page_number'],
		'include_adjacency' => 'true',
		'units' => 'metric',
		'order_by' => $parameters['sort'],
	);


	if($parameters['filters']) $request_data_raw['categories_filter_ids'] = $parameters['filters'];
	if($parameters['children_number']) $request_data_raw['children_number'] = $parameters['children_number'];

	$loaded_data = load_data_from_booking_api('v1/hotels/search', $request_data_raw );

	$hotels = $loaded_data -> result;
	
	$currency = Array(
		"cur" => "₪",
		"rate" => round((float)get_field('coins', 4127)[1]['rate'])
	);
	foreach($hotels as $item){
		//city_id_to_term($item->hotel_id, $cur_location_term->term_id);
		template_hotel_search_box($item, $parameters['term_id'], $currency);
	}

	die();
}