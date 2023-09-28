<?php 

$hotel_id = '1858509';
if(isset($_GET['hotel_id'])) $hotel_id = $_GET['hotel_id'];

$request_data_raw = Array(
	'hotel_id' => $hotel_id,
	'locale' => 'he'
);

hotel_post_id = get_hotel_post_id($hotel_id);
$hotel_post = get_post($hotel_post_id);


$hotel_data = load_data_from_booking_api('v1/hotels/data', $request_data_raw );
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


$hotel_images = load_data_from_booking_api('v1/hotels/photos', $request_data_raw );

$hotel_review_scores = load_data_from_booking_api('v1/hotels/review-scores', $request_data_raw );

$request_data_raw_reviews = Array(
	'hotel_id' => $hotel_id,
	'locale' => 'he',
	'sort_type' => 'SORT_MOST_RELEVANT',
	'language_filter' => 'he'
);

$hotel_reviews = load_data_from_booking_api('v1/hotels/reviews', $request_data_raw_reviews);

?>


<section class="hotel">
	<div class="section-inner">
		<div class="parts">
			<div class="part part-info">
				<p class="title-main"><?=$hotel_data->name?></p>
				<div class="about text-hidden">
					<div class="text">
						<div class="content">
							<?=wpautop($hotel_description)?>
						</div>
					</div>
					<div class="read-more">קראו עוד</div>
				</div>

				<div class="buttons">
					<a href="<?=$hotel_data->url?>" target="_blank" class="button-yellow">
						<div class="inner">
							<img src="<?=$td?>/images/icons/hotel/bed.svg">
							<span>הזמינו חדר במלון</span>
						</div>
					</a>
					
					<?php 
						$curent_user = wp_get_current_user();
						if(isset($curent_user->data->ID)) {
							$curent_user_id = $curent_user->data->ID;
							$do_i_like_hotel = do_i_like_hotel($curent_user_id , $hotel_id);
							if($do_i_like_hotel) $button_text = "נמצא במועדפים";
							else $button_text = "הוספה למועדפים";
						};
					?>
					
					<a href="#" class="button-icon button-hotel <?php if($do_i_like_hotel) echo "liked"; else echo "not-liked"  ?>">
						<div class="inner">
							<div class="icon"></div>
							<span><?=$button_text?></span>
						</div>
					</a>
				</div>
			</div>
			<div class="part part-slider">
				<p class="title-main"><?=$hotel_data->name?></p>
				<div class="wrapper-rating-location">
					<div class="rating"> 
						<div class="box-stars">
							<?php 
								$stars = "";
								if(isset($hotel_data -> booking_home -> quality_class)) $stars = $hotel_data -> booking_home -> quality_class;
								elseif(isset($hotel_data -> class)) $stars = $hotel_data -> class;
								if($stars) : 
								$stars_num = (int)$stars;
							?>
							<div class="stars">
								<?php 
									for($i=0; $i<$stars_num; $i++):
								?>
									<img src="<?=$td?>/images/icons/box-hotel/star.svg">
								<?php endfor; ?>
							</div>
							<?php endif; ?>
							<?php if(isset($hotel_data -> review_nr)) : ?>
								<p class="feedback"><?=$hotel_data -> review_nr;?> חוות דעת</p>
							<?php endif; ?>
						</div>
						<?php if(isset($hotel_data -> review_score)) : ?>
							<div class="box-number">
								<p><?=$hotel_data -> review_score;?></p>
							</div>
						<?php endif; ?>
					</div>
					<p class="location">
						<?php if(isset($hotel_data -> city)) echo ", " . $hotel_data -> city; ?>
						<?php if(isset($hotel_data -> address)) echo ", " . $hotel_data -> address; ?>
					</p>

					<?php 
						$map_url = "https://www.google.com/maps/@".$hotel_data->location->latitude.",".$hotel_data->location->longitude.",19z";
					?>
					
					<a href="<?=$map_url?>" target="_blank" class="button-icon">
						<div class="inner">
							<img src="<?=$td?>/images/icons/attraction/map.svg">
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
							$image_url = str_replace("max1280x900", "max715", $image_url);
							$image_full_url = $item -> url_1440;
						?>
							<a class="swiper-slide" href="<?=$image_full_url?>" data-fancybox="gallery">
								<img src="<?=$image_url?>">
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
								<img src="<?=$image_url?>">
							</div>
						<?php endforeach; ?>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>

<section class="facilities">
	<div class="section-inner">
		<p class="section-title">מתקנים <span>פופולריים</span></p>

		<ul class="list">
			<?php 
				require get_template_directory() . '/static-data.php';
				$hotel_facilities_array = explode(",", $hotel_data->hotel_facilities);
				
				
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
		<p class="section-title">חוות <span>דעת</span></p>
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
					if($i>4) break;
					if(isset($item->author->avatar)) $avatar_url = $item->author->avatar;
					else $avatar_url = $td . "/images/inner/avatar.jpg";
					 
				?>
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

			</div>
		</div>
		
		<div class="wrapper-more">
			<a href="#" class="button-icon">
				<div class="inner">
					<img src="<?=$td?>/images/icons/attraction/pencil.svg">
					<span>לכל חוות דעת</span>
				</div>
			</a>
		</div>
		
	</div>
</section>
<?php endif; ?>

<?php 
	$request_data_raw_places = Array(
		'location' => $hotel_data->location->latitude.",".$hotel_data->location->longitude,
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
		<p class="section-title">בסביבת <span>המלון</span></p>
		<div class="col cols-2 ">
			<div class="col-title">
				<div class="icon">
					<img src="<?=$td?>/images/icons/attraction/building.svg">
				</div>
				<span>אטרקציות פופולריות</span>
			</div>
			<div class="items">
				<?php 
					$i=0;
					foreach($places_best->results as $item):
					$dist = round(distance($hotel_data->location->latitude, $hotel_data->location->longitude, $item->geometry->location->lat, $item->geometry->location->lng, "K"), 2);
					$i++;
					if($i>20) break;
				?>
					<div class="item">
						<div class="title has-icon">
							<div class="icon" style="background-color:<?=$item->icon_background_color?>80">
                                <img src="<?=$item->icon?>">
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
							<img src="<?=$td?>/images/icons/attraction/food.svg">
						</div>
						<span>מסעדות ובתי קפה</span>
					</div>
					<div class="items">
						<?php 
							$i=0;
							foreach($places_restaurants->results as $item):
							$dist = round(distance($hotel_data->location->latitude, $hotel_data->location->longitude, $item->geometry->location->lat, $item->geometry->location->lng, "K"), 2);
							$i++;
							if($i>10) break;
						?>
							<div class="item">
								<div class="title has-icon">
									<div class="icon" style="background-color:<?=$item->icon_background_color?>80">
										<img src="<?=$item->icon?>">
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
							<img src="<?=$td?>/images/icons/attraction/sea.svg">
						</div>
						<span>חופים וטבע</span>
					</div>
					<div class="items">
						<?php 
							$i=0;
							foreach($places_natural->results as $item):
							$dist = round(distance($hotel_data->location->latitude, $hotel_data->location->longitude, $item->geometry->location->lat, $item->geometry->location->lng, "K"), 2);
							$i++;
							if($i>10) break;
						?>
							<div class="item">
								<div class="title has-icon">
									<div class="icon" style="background-color:<?=$item->icon_background_color?>80">
										<img src="<?=$item->icon?>">
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

<script>
	$(document).ready(function ($) {
		$(".button-hotel").on("click", function(){
			
			$.ajax({
				type: "POST",
				url: ajax_object.ajaxurl,
				data: {
					action: 'like_hotel_button_pressed',
					user_id: '<?=$curent_user_id ?>',
					hotel_id: '<?=$hotel_id?>',
				},
				beforeSend: function(){
					$(".button-hotel").addClass("loading");
				},
				success: function(answer){
					var answerObj = JSON.parse(answer);
					$(".button-hotel").removeClass("loading");
					$(".button-hotel span").text(answerObj.buttonText);
					
					$(".button-hotel").removeClass("not-liked");
					$(".button-hotel").removeClass("liked");
					if(answerObj.result == "1") $(".button-hotel").addClass("not-liked");
					if(answerObj.result == "2") $(".button-hotel").addClass("liked");
				},
				complete: function(answer){
					
				},
				eror: function() {console.log("error during ajax request");},
			});
		});
	});
</script>
<script>
	$(document).ready(function ($) {
		$(".button-follow").on("click", function(){
			
			$.ajax({
				type: "POST",
				url: ajax_object.ajaxurl,
				data: {
					action: 'follow_button_pressed',
					my_id: '<?=$curent_user_id ?>',
					follow_user_id: '<?=$author_id?>',
				},
				beforeSend: function(){
					$(".button-follow").addClass("loading");
				},
				success: function(answer){
					var answerObj = JSON.parse(answer);
					$(".button-follow").removeClass("loading");
					$(".button-follow span").text(answerObj.buttonText);
				},
				complete: function(answer){
					
				},
				eror: function() {console.log("error during ajax request");},
			});
		});
	});
</script>
<script>
	$(document).ready(function ($) {
		var galleryThumbs = new Swiper('.slider-hotel-thumbs', {
			slidesPerView: 3,
			spaceBetween: 13,
			loop: true,
			breakpoints: {
				0: {
					//spaceBetween: 13,
				},
				1360: {
					//spaceBetween: 13,
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

		
	});
</script>