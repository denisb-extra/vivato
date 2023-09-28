<?php 
	$parameters = Array();
	$now = new DateTime();
	$parameters['today_date'] = $now->format('Y-m-d');
	
	
	if(!isset($location_term)) {
		if(isset($_GET['dest_id'])) {
			$items = get_field('locations', 8);
			foreach($items as $term) {
				$item = get_field('booking-data', $term);
				if($_GET['dest_id'] == $item['id']) {
					$region_name = $term->name;
					$location_term = $term;
				}
			}
		}
		if(!isset($location_term)) $location_term = get_term(69);
	}
	
	if(isset($_GET['checkin_date'])) $parameters['checkin_date'] = $_GET['checkin_date'];
	else $parameters['checkin_date'] = $now->add(new DateInterval('P1W'))->format('Y-m-d');
	
	if(isset($_GET['checkout_date'])) $parameters['checkout_date'] = $_GET['checkout_date'];
	else $parameters['checkout_date'] = $now->add(new DateInterval('P1D'))->format('Y-m-d');
	

	if(isset($_GET['dest_type'])) $parameters['dest_type'] = $_GET['dest_type'];
	elseif(isset($location_term)) $parameters['dest_type'] = get_field('booking-data', $location_term)['city-region'];
	else $parameters['dest_type'] = get_field('booking-data', get_field('locations')[0])['city-region'];
	
	if(isset($_GET['dest_id'])) $parameters['dest_id'] = $_GET['dest_id'];
	elseif(isset($location_term)) $parameters['dest_id'] = get_field('booking-data', $location_term)['id'];
	else $parameters['dest_id'] = get_field('booking-data', get_field('locations')[0])['id'];
	
	if(isset($_GET['adults_number'])) $parameters['adults_number'] = $_GET['adults_number'];
	else $parameters['adults_number'] = "2";
	
	if(isset($_GET['children_number'])) $parameters['children_number'] = $_GET['children_number'];
	else $parameters['children_number'] = "0";
	
	if(isset($_GET['room_number'])) $parameters['room_number'] = $_GET['room_number'];
	else $parameters['room_number'] = "1";
	
	if(isset($_GET['filters'])) $parameters['filters'] = $_GET['filters'];
	else $parameters['filters'] = "";
	
	if(isset($_GET['sort'])) $parameters['sort'] = $_GET['sort'];
	else $parameters['sort'] = "class_descending";
	

	
?>


<?php 
	global $page_title_h1;
	$page_title_h1 = true;
	
	global $page_title;
	$page_title = "בתי מלון ב";
	$region_name = "";
	$items = get_field('locations', 8);

	$region_name = $location_term->name;

	$page_title .= $region_name;
	get_template_part( 'template-parts/top-inner' ); 
?>


<?php

$request_data_raw = Array(
	'checkin_date' => $parameters['checkin_date'],
	'checkout_date' => $parameters['checkout_date'],
	'dest_type' => $parameters['dest_type'],
	'dest_id' => $parameters['dest_id'],
	'adults_number' => $parameters['adults_number'],
	'room_number' => $parameters['room_number'],
	'filter_by_currency' => 'AED',
	'locale' => 'he',
	'page_number' => '0',
	'include_adjacency' => 'true',
	'units' => 'metric',
	'order_by' => $parameters['sort'],
);


if($parameters['filters']) $request_data_raw['categories_filter_ids'] = $parameters['filters'];
if($parameters['children_number']) $request_data_raw['children_number'] = $parameters['children_number'];

$loaded_data = load_data_from_booking_api('v1/hotels/search', $request_data_raw );


$hotels = $loaded_data -> result;


?>

<section class="hotels">
	<div class="section-inner">
		<?php if(get_field('content-seo-hotels', $location_term ) && get_field('content-seo-hotels', $location_term )['content']) : ?>
		<div class="content-top">
			<div class="content">
				<?=get_field('content-seo-hotels', $location_term )['content']?>
			</div>
		</div>
		<?php endif; ?>
		
		<div class="hotels-panel-top">
			<?php 
				$item = get_field('booking-data', $location_term);
			?>
			
			<div class="selector region" default-dest-id="<?=$item['id']?>" default-dest-type="<?=$item['city-region']?>">
				<div class="title" style="background-image: url(<?=$td?>/images/icons/hotels-panel/bed.svg);">
					<span><?=$region_name?></span>
				</div>
				<div class="modal">
					<div class="inner">
						<div class="items">
							<?php 
								$items = get_field('locations', 8);
								foreach($items as $term):
								$item = get_field('booking-data', $term);
							?>
								<div class="item city <?php if($parameters['dest_id'] == $item['id']) echo "selected" ?>" term-slug='<?=$term->slug?>' dest-id="<?=$item['id']?>" dest-type="<?=$item['city-region']?>"><?=$term->name?></div>
							<?php endforeach; ?>
						</div>
					</div>
				</div>
			</div>
			<div class="selector date">
				<div class="title" style="background-image: url(<?=$td?>/images/icons/hotels-panel/calendar.svg);">
					<input type="text" name="daterange" value="" />
				</div>
			</div>
			<div class="selector numbers">
				<div class="title" style="background-image: url(<?=$td?>/images/icons/hotels-panel/people.svg);">
					<span> חדרים ומספר אנשים</span>
				</div>
				<div class="modal">
					<div class="inner">
						<div class="counters">
							<div class="wrapper-counter">
								<p class="label">מבוגרים</p>
								<div class="counter adults-number" min="1" max="30">
									<div class="btn btn-minus">-</div>
									<div class="num"><?=$parameters['adults_number']?></div>
									<div class="btn btn-plus">+</div>
								</div>
							</div>
							<div class="wrapper-counter">
								<p class="label">ילדים</p>
								<div class="counter children-number" min="0" max="30">
									<div class="btn btn-minus">-</div>
									<div class="num"><?=$parameters['children_number']?></div>
									<div class="btn btn-plus">+</div>
								</div>
							</div>
							<div class="wrapper-counter">
								<p class="label">חדרים</p>
								<div class="counter room-number" min="1" max="30">
									<div class="btn btn-minus">-</div>
									<div class="num"><?=$parameters['room_number']?></div>
									<div class="btn btn-plus">+</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="button submit button-viva">
				<span>VIVA...</span>
			</div>
		</div>
		<div class="grid">
			<div class="sidebar">
				<p class="main-title">צמצום החיפוש שלך</p>
				<div class="hotels-filters">
				
					<div class="filter" filter-title="class">
						<h4 class="title">דירוג כוכבים</h4>
						<div class="items">
							<div class="item" filter-value="5">
								<div class="stars">
									<?php for($i=0; $i<5; $i++):?><img src="<?=$td?>/images/icons/box-hotel/star.svg"><?php endfor; ?>
								</div>
							</div>
							<div class="item" filter-value="4">
								<div class="stars">
									<?php for($i=0; $i<4; $i++):?><img src="<?=$td?>/images/icons/box-hotel/star.svg"><?php endfor; ?>
								</div>
							</div>
							<div class="item" filter-value="3">
								<div class="stars">
									<?php for($i=0; $i<3; $i++):?><img src="<?=$td?>/images/icons/box-hotel/star.svg"><?php endfor; ?>
								</div>
							</div>
							<div class="item" filter-value="2">
								<div class="stars">
									<?php for($i=0; $i<2; $i++):?><img src="<?=$td?>/images/icons/box-hotel/star.svg"><?php endfor; ?>
								</div>
							</div>
							<div class="item" filter-value="1">
								<div class="stars" >
									<img src="<?=$td?>/images/icons/box-hotel/star.svg">
								</div>
							</div>
						</div>
					</div>
					
					<div class="filter" filter-title="property_type">
						<h4 class="title">סוג נכס</h4>
						<div class="items">
							<div class="item" filter-value="201">דירות</div>
							<div class="item" filter-value="204">בתי מלון</div>
							<div class="item" filter-value="220">בתי נופש</div>
							<div class="item" filter-value="216">בתי הארחה</div>
							<div class="item" filter-value="213">וילות</div>
							<div class="item" filter-value="206">אתרי נופש</div>
							<div class="item" filter-value="208">מקומות אירוח B&B</div>
							<div class="item" filter-value="203">אכסניות</div>
							<div class="item" filter-value="221">בתים כפריים</div>
						</div>
					</div>
					
					<div class="filter" filter-title="mealplan">
						<h4 class="title">ארוחות</h4>
						<div class="items">
							<div class="item" filter-value="999">שירות עצמי</div>
							<div class="item" filter-value="breakfast_included">ארוחת בוקר כלולה</div>
							<div class="item" filter-value="full_board">כל הארוחות כלולות</div>
							<div class="item" filter-value="all_inclusive">הכל-כלול</div>
							<div class="item" filter-value="breakfast_and_lunch">כולל ארוחות בוקר וצהריים</div>
							<div class="item" filter-value="breakfast_and_dinner">כולל ארוחות בוקר וערב</div>
							
							
						</div>
					</div>

				</div>
				
				<div class="button submit button-viva">
					<span>VIVA...</span>
				</div>
			</div>
			<div class="main">
				<div class="panel-results">
					<h2 class="count">
						<?=$location_term->name?>: נמצאו <span><?=$loaded_data -> total_count_with_filters?></span> בתי מלון ומקומות אירוח
					</h2>
					<div class="sort">
						<p class="label">מיין לפי:</p>
						<select value="<?=$parameters['sort']?>" id="sort">
							<?php 
								$items = $loaded_data -> sort;
								foreach($items as $item):
								$item_id = $item->id;
								if($item_id == "bayesian_review_score") $item_id = "review_score";
								
							?>
								<option value="<?=$item_id;?>" <?php if($parameters['sort'] == $item_id) echo "selected" ?>><?=$item->name;?></option>
							<?php endforeach; ?>
							
						</select>
					</div>
				</div>
				<div class="boxes">
					<?php 
						$currency = Array(
							"cur" => "₪",
							"rate" => round((float)get_field('coins', 4127)[1]['rate'])
						);
			
						
						foreach($hotels as $item){
							template_hotel_search_box($item, $location_term->term_id, $currency, 'h3');
						}
					?>

				</div>
				<?php if($loaded_data -> total_count_with_filters > 20) : ?>
				<div class="centered">
					<div class="load-more">טען עוד תוצאות ...</div>
				</div>
				<?php endif; ?>
			</div>
		</div>
		
		
		<?php if(get_field('content-seo-hotels', $location_term ) && get_field('content-seo-hotels', $location_term )['content-bottom']) : ?>
		<div class="content-bottom">
			<div class="content">
				<?=get_field('content-seo-hotels', $location_term )['content-bottom']?>
			</div>
		</div>
		<?php endif; ?>
	</div>
</section>

<script>
	var daterangepicker;
	$(document).ready(function ($) {
		daterangepicker = $('input[name="daterange"]').daterangepicker({
			startDate: "<?=$parameters['checkin_date']?>",
			endDate: "<?=$parameters['checkout_date']?>",
			minDate: "<?=$parameters['today_date']?>",
			opens: 'center',
			autoApply: true,
			locale: {
				"format": "YYYY-MM-DD",
				"separator": " - ",
				"applyLabel": "Apply",
				"cancelLabel": "Cancel",
				"fromLabel": "From",
				"toLabel": "To",
				"customRangeLabel": "Custom",
				"weekLabel": "W",
				"daysOfWeek": [
					"א",
					"ב",
					"ג",
					"ד",
					"ה",
					"ו",
					"ש"
				],
				"monthNames": [
					"ינואר",
					"פברואר",
					"מרץ",
					"אפריל",
					"מאי",
					"יוני",
					"יולי",
					"אוגוסט",
					"ספטמבר",
					"אוקטובר",
					"נובמבר",
					"צדמבר"
				],
				"firstDay": 0
			},
		}, function(start, end, label) {
			console.log("A new date selection was made: " + start.format('YYYY-MM-DD') + ' to ' + end.format('YYYY-MM-DD'));
		});
		
		if($(window).width() <= 950) {
			$(".sidebar .main-title").on("click", function(){
				$(".sidebar .hotels-filters").slideToggle();
			});
		}
		
		
		$(".hotels-panel-top .selector .title").on("click", function(){
			let cont = $(this).closest(".selector");
			$(cont).toggleClass("open");
		});

		$(document).click(function(event) { 
			$target = $(event.target);
			if(!$target.closest('.hotels-panel-top .selector').length) {
				$(".hotels-panel-top .selector").removeClass("open");
			}
		});

		$(".hotels-panel-top .selector .items .item").click(function(){
			let cont = $(this).closest(".selector");
			$(".items .item", cont).removeClass("selected");
			$(this).addClass("selected");

			let ttl = $(this).text();
			let val = $(this).attr("value");

			$(".title span", cont).text(ttl);
			$(cont).attr("value", val);

			$(cont).removeClass("open");
		});


		$(".counter .btn-plus").on("click", function(){
			let cont = $(this).closest(".counter");
			let min = parseInt($(cont).attr('min'));
			let max = parseInt($(cont).attr('max'));
			let num = parseInt($(".num", cont).text());
			num += 1;
			if(num > max ) num = max;
			$(".num", cont).text(num)
		});

		$(".counter .btn-minus").on("click", function(){
			let cont = $(this).closest(".counter");
			let min = parseInt($(cont).attr('min'));
			let max = parseInt($(cont).attr('max'));
			let num = parseInt($(".num", cont).text());
			num -= 1;
			if(num < min ) num = min;
			$(".num", cont).text(num)
		});
		
		
		var getFilters = "<?=$parameters['filters']?>";
		var getFiltersArray = getFilters.split(",");
		
		getFiltersArray.forEach(function(el){
			var elAr = el.split("::");
			
			$(".hotels-filters .filter[filter-title='"+elAr[0]+"'] .item[filter-value='"+elAr[1]+"']").addClass("selected");
		});
		
		$(".hotels-filters .filter .items .item").on("click", function(){
			$(this).toggleClass("selected");
		});
		
		$(".button.submit").on("click", function(){
			loadResults();
			$(this).addClass("loading");
		});
		
		$("select#sort").on("change", function(){
			loadResults();
		});
		
		$(".selector.date").on("click", function(event){
			$target = $(event.target);
			if(!$target.closest('input[name="daterange"]').length) {
				event.stopPropagation();
				$('input[name="daterange"]').click();
			}
			
		});
		
		$(".load-more").on("click", function(){
			let parameters = getParameters();

			$.ajax({
				type: "POST",
				url: ajax_object.ajaxurl,
				data: parameters,
				beforeSend: function(){
					$(".load-more").addClass("loading");
				},
				success: function(answer){
					$(".load-more").removeClass("loading");
					
					var hotels_shown = (page_number + 1) * 20;
					if(hotels_shown >= <?=$loaded_data -> total_count_with_filters ?>) {
						$(".load-more").hide();
					}
					
					$("section.hotels .boxes .box").addClass("shown");
					$("section.hotels .boxes").append(answer);	
					
					$("section.hotels .boxes .box").not(".shown").hide();
					$("section.hotels .boxes .box").not(".shown").fadeIn();
					
				},
				complete: function(answer){
					
				},
				eror: function() {console.log("error during ajax request");},
			});
		});
		
	});
	
	var page_number = 0;
	function getParameters(){
		let parameters = {
			action: 'load_hotels'
		}
		
		page_number ++;

		parameters.page_number = page_number;
		parameters.dest_id = "<?=$parameters['dest_id']?>";
		parameters.dest_type = "<?=$parameters['dest_type']?>";
		parameters.checkin_date = "<?=$parameters['checkin_date']?>";
		parameters.checkout_date = "<?=$parameters['checkout_date']?>";
		parameters.adults_number = "<?=$parameters['adults_number']?>";
		parameters.children_number = "<?=$parameters['children_number']?>";
		parameters.room_number = "<?=$parameters['room_number']?>";
		parameters.filters = "<?=$parameters['filters']?>";
		parameters.sort = "<?=$parameters['sort']?>";
		parameters.term_id = "<?=$location_term->term_id?>";
		
		
	
		return parameters;
	}
	
	
	function loadResults() {
		$(".button-viva").addClass("loading");
		let urlVars = "?";
		
		let dest_id = $(".selector.region .item.selected").attr("dest-id");
		if(!dest_id) dest_id = $(".selector.region").attr("default-dest-id");
		urlVars += "&dest_id=" + dest_id;
		
		let dest_type = $(".selector.region .item.selected").attr("dest-type");
		if(!dest_type) dest_type = $(".selector.region").attr("default-dest-type");
		urlVars += "&dest_type=" + dest_type;
		
		let checkin_date = daterangepicker.data('daterangepicker').startDate.format('YYYY-MM-DD');
		urlVars += "&checkin_date=" + checkin_date;
		
		let checkout_date = daterangepicker.data('daterangepicker').endDate.format('YYYY-MM-DD');
		urlVars += "&checkout_date=" + checkout_date;
		
		let adults_number = $(".counter.adults-number .num").text();
		urlVars += "&adults_number=" + adults_number;
		
		let children_number = $(".counter.children-number .num").text();
		urlVars += "&children_number=" + children_number;
		
		let room_number = $(".counter.room-number .num").text();
		urlVars += "&room_number=" + room_number;
		
		let filtersString = "";
		
		$(".hotels-filters .filter[filter-title]").each(function(){
			let filterTitle = $(this).attr('filter-title');
			$(".item.selected", this) .each(function(){
				let filterValue = $(this).attr('filter-value');
				if(filtersString != "") filtersString += ",";
				filtersString += filterTitle + "::" + filterValue;
			});
		});
	
		if(filtersString) urlVars += "&filters=" + filtersString;
		
		
		let sort = $("select#sort").val();
		urlVars += "&sort=" + sort;
		
		urlVars = encodeURI(urlVars);
		let url = window.location.href.split('?')[0];
		if($(".selector.region .item.selected").attr("term-slug")) url = "<?=get_home_url();?>/בתי-מלון/" + $(".selector.region .item.selected").attr("term-slug") + "/";
		
		window.location = url + urlVars;
	}
	
</script>



<?php 
	/*
	checkin_monthday=22
	checkin_month=6
	checkin_year=2023
	checkout_monthday=21
	checkout_month=6
	checkout_year=2023
	no_rooms=2
	group_adults=2
	group_children=2
	*/
	
	
	$checkin_date = new DateTime($parameters['checkin_date']);
	$checkout_date = new DateTime($parameters['checkout_date']);
?>
<script>
	var searchHotelObj = {};
	searchHotelObj.checkin_monthday = "<?=$checkin_date->format('j')?>";
	searchHotelObj.checkin_month = "<?=$checkin_date->format('n')?>";
	searchHotelObj.checkin_year = "<?=$checkin_date->format('Y')?>";
	searchHotelObj.checkout_monthday = "<?=$checkout_date->format('j')?>";
	searchHotelObj.checkout_month = "<?=$checkout_date->format('n')?>";
	searchHotelObj.checkout_year = "<?=$checkout_date->format('Y')?>";
	searchHotelObj.no_rooms = "<?=$parameters['room_number']?>";
	searchHotelObj.group_adults = "<?=$parameters['adults_number']?>";
	<?php if($parameters['children_number']) : ?>
	searchHotelObj.group_children = "<?=$parameters['children_number']?>";
	<?php endif; ?>
	
	searchHotelObj.checkin_date = "<?=$checkin_date->format('d.m.Y')?>";
	searchHotelObj.checkout_date = "<?=$checkout_date->format('d.m.Y')?>";
	searchHotelObj.travel_location = "<?=$region_name?>";
	
	window.localStorage.setItem("searchHotelObj", JSON.stringify(searchHotelObj));
	
</script>