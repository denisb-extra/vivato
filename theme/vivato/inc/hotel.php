<?php 

$hotel_id = '1858509';
if(isset($_GET['hotel_id'])) $hotel_id = $_GET['hotel_id'];

if(is_singular('hotel')) $hotel_id = get_post_meta($post->ID, 'booking-id', true);

$request_data_raw = Array(
	'hotel_id' => $hotel_id,
	'locale' => 'he'
);

if(isset($_GET['load-data'])) {
	echo update_hotel_post($hotel_id);
}

$hotel_post_id = get_hotel_post_id($hotel_id);
$hotel_post = get_post($hotel_post_id);


$hotel_images = load_data_from_booking_api('v1/hotels/photos', $request_data_raw );

$hotel_review_scores = load_data_from_booking_api('v1/hotels/review-scores', $request_data_raw );

$request_data_raw_reviews = Array(
	'hotel_id' => $hotel_id,
	'locale' => 'he',
	'sort_type' => 'SORT_MOST_RELEVANT',
	'language_filter' => 'he'
);

$hotel_reviews = load_data_from_booking_api('v1/hotels/reviews', $request_data_raw_reviews);

$location_terms = get_the_terms($post->ID, "location");
if($location_terms) $location_term = $location_terms[0];

?>





<section class="hotel">
	<div class="section-inner">
		<div class="parts">
			<div class="part part-info">
				<h1 class="title-main"><?=$hotel_post->post_title?></h1>
				<?php if( current_user_can( 'manage_options' )) : ?>
				<div class="admin-panel content">
					<p><a href="<?=get_permalink($hotel_post_id);?>?load-data=1">עדכן נתונים מ booking.com</a></p>
				</div>
				<?php endif; ?>
				<div class="about text-hidden">
					<div class="text">
						<div class="content">
							<?=wpautop($hotel_post->post_content)?>
						</div>
					</div>
					<div class="read-more">קראו עוד</div>
				</div>

				<div class="buttons">
					<a href="<?=get_post_meta($hotel_post_id, 'url', true)?>?aid=8017496" target="_blank" class="button-yellow">
						<div class="inner">
							<img src="<?=$td?>/images/icons/hotel/bed.svg" alt="booking.com">
							<span>הזמנת חדר דרך Booking.com</span>
						</div>
					</a>
					<?php if(is_user_logged_in()) : ?>
					<div  class="button-icon cont-like">
						<div class="inner">
							<?= do_shortcode("[wp_ulike id='$hotel_post_id']"); ?>
							<span>להוסיף לטיול שלי</span>
						</div>
					</div>
					<?php else : ?>
						<a href="<?=get_permalink(462)?>" class="button-icon">
							<div class="inner">
								<img src="<?=$td?>/images/icons/heart-empty.svg" alt="הוספה לטיול שלי">
								<span>להוסיף לטיול שלי</span>
							</div>
						</a>
					<?php endif; ?>
				</div>
			</div>
			<div class="part part-slider">
				<p class="title-main"><?=$hotel_post->post_title?></p>
				<div class="wrapper-rating-location">
					<div class="rating"> 
						<div class="box-stars">
							<?php 
								$stars = get_post_meta($hotel_post_id, 'stars', true);
								if($stars) : 
								$stars_num = (int)$stars;
							?>
							<div class="stars">
								<?php 
									for($i=0; $i<$stars_num; $i++):
								?>
									<img src="<?=$td?>/images/icons/box-hotel/star.svg" alt="כוכב">
								<?php endfor; ?>
							</div>
							<?php endif; ?>
							<p class="feedback" scroll-to="section.reviews"><?=get_post_meta($hotel_post_id, 'feedback-num', true);?> חוות דעת</p>
							
						</div>
						<?php if(get_post_meta($hotel_post_id, 'rating', true)) : ?>
							<div class="box-number">
								<p><?=get_post_meta($hotel_post_id, 'rating', true);?></p>
							</div>
						<?php endif; ?>
					</div>
					<p class="location">
						<?=get_post_meta($hotel_post_id, 'location-exect', true);?>
					</p>

					<?php 
						$map_url = "https://www.google.com/maps/@".get_post_meta($hotel_post_id, 'cords_latitude', true).",".get_post_meta($hotel_post_id, 'cords_longitude', true).",19z";
					?>
					
					<a href="<?=$map_url?>" target="_blank" class="button-icon">
						<div class="inner">
							<img src="<?=$td?>/images/icons/attraction/map.svg" alt="צפייה במפה">
							<span>צפייה במפה</span>
						</div>
					</a>
				</div>

				<div class="swiper-container slider-hotel-main">
					<div class="swiper-wrapper">
						<?php 
							$i=0;
							foreach($hotel_images as $item):
							$i++;
							if($i > 10) break;
							
							$image_url = $item -> url_max;
							$size = "max715";
							if(wp_is_mobile()) $size = "max450";
							$image_url = str_replace("max1280x900", $size, $image_url);
							$image_full_url = $item -> url_1440;
						?>
							<a class="swiper-slide" href="<?=$image_full_url?>" data-fancybox="gallery">
								<img src="<?=$image_url?>" alt="<?=$hotel_post->post_title?>" title="<?=$hotel_post->post_title?>">
							</a>
						<?php endforeach; ?>
					</div>
				</div>

				<div class="swiper-container slider-hotel-thumbs">
					<div class="swiper-wrapper">
						<?php 
							$i=0;
							foreach($hotel_images as $item):
							$i++;
							if($i > 10) break;
							
							$image_url = $item -> url_max;
							$image_url = str_replace("max1280x900", "max202x150", $image_url);
						?>
							<div class="swiper-slide">
								<img src="<?=$image_url?>" alt="<?=$hotel_post->post_title?>" title="<?=$hotel_post->post_title?>">
							</div>
						<?php endforeach; ?>
					</div>
					<div class="nav">
						<div class="arrow arrow-left">
							<img src="<?=$td?>/images/icons/angle-right-w.svg" alt="חץ ימני">
						</div>
						<div class="arrow arrow-right">
							<img src="<?=$td?>/images/icons/angle-left-w.svg" alt="חץ שמאלי">
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>

<section class="facilities">
	<div class="section-inner">
		<h2 class="section-title">מתקנים <span>פופולריים</span></h2>

		<ul class="list">
			<?php 
				require get_template_directory() . '/static-data.php';
				$hotel_facilities_array = explode(",", get_post_meta($hotel_post_id, 'hotel-facilities', true));
				
				
				foreach($hotel_facilities_array as $f_id):
					if(isset($facilities_array->room_facility->$f_id)) $f_item = $facilities_array->room_facility->$f_id;
					//elseif(isset($facilities_array->facility_type->$f_id)) $f_item = $facilities_array->facility_type->$f_id;
					//elseif(isset($facilities_array->hotel_facility->$f_id)) $f_item = $facilities_array->hotel_facility->$f_id;
					else $f_item = null;
					if(isset($f_item)):
					
					if(isset($f_item->text)) $text = $f_item->text;
					else $text = $f_item;
					if(isset($f_item->icon)) $icon = $td . "/images/icons/hotel/facilities/" . $f_item->icon;
					else $icon = $icon = $td . "/images/icons/hotel/facilities/other.svg";
			?>
			<li class="item">
				<div class="icon">
					<img src="<?=$icon?>" alt="<?=$text?>" title="<?=$text?>">
				</div>
				<span><?=$text?></span>
			</li>
			<?php endif; ?>
			<?php endforeach; ?>
		</ul>
	</div>
</section>

<?php if($hotel_reviews -> result) : ?>
<section class="reviews">
	<div class="section-inner">
		<h2 class="section-title">חוות <span>דעת</span></h2>
		<?php 
			$items = $hotel_review_scores -> score_breakdown;
			foreach($items as $item) {
				if($item -> customer_type == "total") {
					$cats = $item -> question;
					break;
				}
			}
			if(isset($cats)):
		?>
		
		<div class="reviews-categories">
			<ul class="cat-list">
				<?php 
					foreach($cats as $cat):
					$percent = ((float)$cat->score / 10) * 100;
				?>
					<li class="item">
						<div class="text">
							<span class="title"><?=$cat->localized_question;?></span>
							<span class="num"><?=$cat->score;?></span>
						</div>
						<div class="line">
							<div class="thumb" style="width: <?=$percent?>%;"></div>
						</div>
					</li>
				<?php endforeach; ?>
			</ul>
		</div>
		<?php endif; ?>

		
		<div class="reviews">
			<div class="items">
				<?php 
					$i=0;
					$items = $hotel_reviews -> result;
					
		
					foreach($items as $item):
					$i++;
					if(isset($item->author->avatar)) $avatar_url = $item->author->avatar;
					else $avatar_url = $td . "/images/inner/avatar.jpg";
				?>
				
				<?php 
					if($i == 5) : 
					$hd = true;
				?>
				<div class="hidden" style="display:none">
				<?php endif; ?>
				<div class="item">
					<div class="part-photo">
						<div class="photo">
							<img src="<?=$avatar_url?>">
						</div>
						<p class="name"><?=$item->author->name?></p>
					</div>
					<div class="part-content">
						<p class="title"><?=$item->title?></p>
						<p class="subtitle"><strong>יתרונות:</strong></p>
						<div class="content">
							<?=wpautop($item->pros ?: "אין")?>
						</div>
						<p class="subtitle"><strong>חסרונות:</strong></p>
						<div class="content">
							<?=wpautop($item->cons ?: "אין")?>
						</div>
						
						<?php 
							if($item->reviewer_photos) : 
						?>
						<div class="gallery">
							<?php 
								foreach($item->reviewer_photos as $photo):
								$image_url = $photo -> max1280x900;
								$image_url = str_replace("max1280x900", "max75", $image_url);
								$image_full_url = $photo -> max1280x900;
							?>
								<a class="photo" href="<?=$image_full_url?>" data-fancybox>
									<img src="<?=$image_url?>">
								</a>
							<?php endforeach; ?>
							
						</div>
						<?php endif; ?>
					</div>
				</div>
				<?php endforeach; ?>
				<?php if(isset($hd) ) : ?>
				</div>
				<?php endif; ?>
			</div>
		</div>
		
		<?php if(isset($hd) ) : ?>
		<div class="wrapper-more">
			<a class="button-icon">
				<div class="inner">
					<img src="<?=$td?>/images/icons/attraction/pencil.svg" alt="לכל חוות הדעת">
					<span>לכל חוות דעת</span>
				</div>
			</a>
		</div>
		<?php endif; ?>
	</div>
</section>
<?php endif; ?>

<?php 
	$request_data_raw_places = Array(
		'location' => get_post_meta($hotel_post_id, 'cords_latitude', true).",".get_post_meta($hotel_post_id, 'cords_longitude', true),
		'radius' => '1500',
		'language' => 'iw',
		'key' => 'AIzaSyCcyMVvrsnmLV67cXkdpGGiJ0OuBDoarqQ'
	);
	
	$request_data_raw_places['type'] = 'bar|beauty_salon|cafe|casino|church|clothing_store|gym|jewelry_store|zoo|university|synagogue|store|stadium|spa|shopping_mall|museum|movie_theater';
	$places_best = load_data_from_google_api("https://maps.googleapis.com/maps/api/place/nearbysearch/json", $request_data_raw_places);

	$request_data_raw_places['type'] = 'restaurant';
	$places_restaurants = load_data_from_google_api("https://maps.googleapis.com/maps/api/place/nearbysearch/json", $request_data_raw_places);

	$request_data_raw_places['type'] = 'natural_feature';
	$places_natural = load_data_from_google_api("https://maps.googleapis.com/maps/api/place/nearbysearch/json", $request_data_raw_places);

?>

<section class="places">
	<div class="section-inner">
		<h2 class="section-title">בסביבת <span>המלון</span></h2>
		<div class="col cols-2 ">
			<div class="col-title">
				<div class="icon">
					<img src="<?=$td?>/images/icons/attraction/building.svg" alt="אטרקציות פופולריות">
				</div>
				<span>אטרקציות פופולריות</span>
			</div>
			<div class="items">
				<?php 
					$i=0;
					foreach($places_best->results as $item):
					$dist = round(distance(get_post_meta($hotel_post_id, 'cords_latitude', true), get_post_meta($hotel_post_id, 'cords_longitude', true), $item->geometry->location->lat, $item->geometry->location->lng, "K"), 2);
					$i++;
					if($i>20) break;
				?>
					<div class="item">
						<div class="title has-icon">
							<div class="icon" style="background-color:<?=$item->icon_background_color?>80">
                                <img src="<?=$item->icon?>" alt="<?=$item->name?>" title="<?=$item->name?>">
                            </div>
							<span><?=$item->name?></span>
						</div>
						<span class="distance"><?=$dist?> ק"מ</span>
					</div>
				<?php endforeach; ?>
			</div>
		</div>
		
		<div class="parts">
			<div class="part">
				<div class="col">
					<div class="col-title">
						<div class="icon">
							<img src="<?=$td?>/images/icons/attraction/food.svg" alt="מסעדות ובתי קפה">
						</div>
						<span>מסעדות ובתי קפה</span>
					</div>
					<div class="items">
						<?php 
							$i=0;
							foreach($places_restaurants->results as $item):
							$dist = round(distance(get_post_meta($hotel_post_id, 'cords_latitude', true), get_post_meta($hotel_post_id, 'cords_longitude', true), $item->geometry->location->lat, $item->geometry->location->lng, "K"), 2);
							$i++;
							if($i>10) break;
						?>
							<div class="item">
								<div class="title has-icon">
									<div class="icon" style="background-color:<?=$item->icon_background_color?>80">
										<img src="<?=$item->icon?>" alt="<?=$item->name?>" title="<?=$item->name?>">
									</div>
									<span><?=$item->name?></span>
								</div>
								<span class="distance"><?=$dist?> ק"מ</span>
							</div>
						<?php endforeach; ?>
					</div>
				</div>
			</div>
			<div class="part">
				<div class="col">
					<div class="col-title">
						<div class="icon">
							<img src="<?=$td?>/images/icons/attraction/sea.svg" alt="חופים וטבע">
						</div>
						<span>חופים וטבע</span>
					</div>
					<div class="items">
						<?php 
							$i=0;
							foreach($places_natural->results as $item):
							$dist = round(distance(get_post_meta($hotel_post_id, 'cords_latitude', true), get_post_meta($hotel_post_id, 'cords_longitude', true), $item->geometry->location->lat, $item->geometry->location->lng, "K"), 2);
							$i++;
							if($i>10) break;
						?>
							<div class="item">
								<div class="title has-icon">
									<div class="icon" style="background-color:<?=$item->icon_background_color?>80">
										<img src="<?=$item->icon?>" alt="<?=$item->name?>" title="<?=$item->name?>">
									</div>
									<span><?=$item->name?></span>
								</div>
								<span class="distance"><?=$dist?> ק"מ</span>
							</div>
						<?php endforeach; ?>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>


<div class="bar-bottom-hotel">
	<div class="show-hide">
		<div class="button hide">
			<div class="inner">
				<img src="<?=$td?>/images/icons/close.svg" alt="הסתר">
				<span>הסתר</span>
			</div>
		</div>


		<div class="button show">
			<div class="inner">
				<img src="<?=$td?>/images/icons/ru.svg" alt="הצג">
				<span>הצג</span>
			</div>
		</div>
	</div>
	<div class="items">
		<div class="item">
			<p><strong>יעד:</strong> <span id="panel-dest">כריתים</span></p>
		</div>
		<div class="item">
			<p><strong>תאריך:</strong> <span id="panel-date">24 יוני 2023 - 30 יוני 2023</span></p>
		</div>
		<div class="item">
			<p><strong>מספר נוסעים:</strong> <span id="panel-guests">2 מבוגרים, 2 ילדים</span></p>
		</div>
	</div>

	<a target="_blank" href="<?=get_post_meta($hotel_post_id, 'url', true)?>?aid=8017496" class="button-yellow">
	<?php if(wp_is_mobile()) : ?>
		<div class="inner">
			<span>הזמינו מלון</span>
		</div>
	<?php else : ?>
		<div class="inner">
			<img src="<?=$td?>/images/icons/hotel/bed.svg" alt="הזמינו חדר במלון">
			<span>הזמנת חדר דרך Booking.com</span>
		</div>
	<?php endif; ?>
	</a>

</div>
	

<script>
	$(document).ready(function ($) {

		var galleryThumbs = new Swiper('.slider-hotel-thumbs', {
			slidesPerView: 3,
			spaceBetween: 13,
			loop: true,
			allowTouchMove: false, 
			navigation: {
				nextEl: '.arrow-right',
				prevEl: '.arrow-left',
			},
			breakpoints: {
				0: {
					allowTouchMove: true,
				},
				950: {
					allowTouchMove: false,
				},
			}
		});
		
		var galleryMain= new Swiper('.slider-hotel-main', {
			slidesPerView: 1,
			spaceBetween: 50,
			loop: true,
			thumbs: {
				swiper: galleryThumbs
			},
			breakpoints: {
				0: {
					//spaceBetween: 35,
				},
				1360: {
					//spaceBetween: 55,
				},
			}
		});
	
	
		$(".wrapper-more .button-icon").on("click", function(){
			$(".reviews .hidden").slideToggle();
		});
		
	});
</script>


<script>
	var searchHotelObj = JSON.parse(window.localStorage.getItem("searchHotelObj"));
	if(searchHotelObj) {
		
		<?php if(isset($location_term)) : ?>
		searchHotelObj.travel_location = "<?=$location_term->name?>";
		<?php endif; ?>
		$("#panel-dest").text(searchHotelObj.travel_location);
		$("#panel-date").text(searchHotelObj.checkin_date + " - " + searchHotelObj.checkout_date);
		var travalers = searchHotelObj.group_adults + " מבוגרים";
		if(searchHotelObj.group_children) travalers += ", " + searchHotelObj.group_children + " ילדים";
		$("#panel-guests").text(travalers);
	}
	else {
		$(".bar-bottom-hotel").hide();
	}
	if(searchHotelObj) {
		var url = "";
		for (var key in searchHotelObj) {
			if(key == "checkin_date" || key == "checkout_date" || key == "travel_location") continue;
			url += "&" + key + "=" + searchHotelObj[key];
		}
		var curUrl = $(".button-yellow").attr("href");
		curUrl += url;
		$(".button-yellow").attr("href", curUrl);
	}
</script>