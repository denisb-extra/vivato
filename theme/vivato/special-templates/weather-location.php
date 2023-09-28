<?php $td = get_template_directory_uri(); ?>

<?php 
	global $wp_query;
	
	if(isset($wp_query->query_vars['weather_location'])) {
		$location_term = get_term_by('slug', $wp_query->query_vars['weather_location'], 'location');
		$location_title = $location_term->name;
		
		global $g_location_term;
		$g_location_term = $location_term;
	}
	
	$seo = get_field('content-seo-weather', $location_term )['seo'];
	global $meta_title;
	$meta_title = $seo['meta-title'] ?: "מזג האויר ב" . $location_term->name;
	global $meta_description;
	$meta_description = $seo['meta-description'] ?: "מזג אוויר ב" .  $location_term->name . ", הישארו מעודכנים עם תנאי מזג אוויר ב".  $location_term->name ." ותחזיות בזמן אמת ביעדים המובילים של יוון. תכנן את הטיול שלך טוב יותר עם מידע על מזג אוויר ב" . $location_term->name;	
	
	
	global $meta_canonical;
	$meta_canonical = get_home_url() . "/מזג-אוויר/" .  $location_term->slug . "/";
		
	global $my_bradcrumbs;
	$my_bradcrumbs[] = array(
		'url' => get_home_url(),
		'text' => 'בית',
	);
	$my_bradcrumbs[] = array(
		'url' => get_permalink(538),
		'text' => 'מזג האויר ביוון',
	);
	$my_bradcrumbs[] = array(
		'url' => "",
		'text' => $location_term->name,
	);
	
?>
<?php get_header(); ?>
<?php 
	global $page_title;
	$page_title = "מזג אוויר ב" . $location_title;
	
	
	global $page_title_h1;
	$page_title_h1 = true;
	get_template_part( 'template-parts/top-inner' ); 
?>



<?php 
	$request_data_raw = Array(
		'lat' => get_field('booking-data', $location_term)['location']['lat'],
		'lon' => get_field('booking-data', $location_term)['location']['lon'],
		'units' => 'metric'
	);
	
	$weather_hourly = load_data_from_weather_api('forecast/3hourly', $request_data_raw );
	$weather_hourly_data = $weather_hourly -> data;
	
	$weather_current = load_data_from_weather_api('current', $request_data_raw );
	$weather_current_data = $weather_current -> data[0];
	
	
	$weather_weekly = load_data_from_weather_api('forecast/daily', $request_data_raw );
	$weather_weekly_data = $weather_weekly -> data;
?>




<section class="weather">
	<div class="section-inner">
		<?php if(get_field('content-seo-weather', $location_term )['content']) : ?>
		<div class="content-top">
			<div class="content">
				<?=get_field('content-seo-weather', $location_term )['content']?>
			</div>
		</div>
		<?php endif; ?>
		<div class="parts small-gaps">
			<div class="part part-today">
				<div class="section-now">
					<div class="part-top">
						<p class="temp"><?=$weather_current_data->temp?>°</p>
						<div class="icon mobile">
							<img src="<?=$td?>/images/weather/a01d.png">
						</div>
						<div class="date-location">
							<p class="date"><?= date(get_option( 'date_format' )); ?></p>
							<p class="location">
								<img src="<?=$td?>/images/icons/attraction/marker.svg">
								<span><?=$location_term->name?></span>
							</p>
						</div>
						<div class="icon desktop">
							<img src="<?=$td?>/images/weather/<?=$weather_current_data->weather->icon?>.png">
						</div>
					</div>
					<div class="part-bottom">
						<div class="boxes">
							<div class="box">
								<div class="inner">
									<div class="icon">
										<img src="<?=$td?>/images/icons/weather/wind.svg">
									</div>
									<div class="text">
										<p class="desc">רוח</p>
										<p class="value"><?=$weather_current_data->wind_spd ?> קמ״ש</p>
									</div>
								</div>
							</div>

							<div class="box">
								<div class="inner">
									<div class="icon">
										<img src="<?=$td?>/images/icons/weather/feels-like.svg">
									</div>
									<div class="text">
										<p class="desc">מרגיש כמו</p>
										<p class="value"><?=$weather_current_data->app_temp?>°</p>
									</div>
								</div>
							</div>

							<div class="box">
								<div class="inner">
									<div class="icon">
										<img src="<?=$td?>/images/icons/weather/wet.svg">
									</div>
									<div class="text">
										<p class="desc">לחות</p>
										<p class="value"><?=$weather_current_data->rh ?>%</p>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>

				<div class="section-daily">
					<div class="swiper-container slider-daily">
						<div class="swiper-wrapper">
							<?php 
								$i=0;
								foreach($weather_hourly_data as $item):
								$i++;
								if($i>7) break;
								
								$time = substr($item->datetime, -2) . ":00";
							?>
							<div class="swiper-slide">
								<div class="wrapper-hour">
									<p class="time"><?=$time?></p>
									<div class="icon">
										<img src="<?=$td?>/images/weather/<?=$item->weather->icon?>.png">
									</div>
									<p class="temp"><?=$item->temp?>°</p>
								</div>
							</div>
							<?php endforeach; ?>
						</div>
						
					</div>
					<div class="nav">
						<div class="arrow arrow-right">
							<img src="<?=$td?>/images/icons/angle-right-w.svg">
						</div>
						<div class="arrow arrow-left">
							<img src="<?=$td?>/images/icons/angle-left-w.svg">
						</div>
					</div>
				</div>
			</div>
			<div class="part part-forecast ">
				<div class="wrapper-forecast">
					<?php 
						$days = ['ראשון', 'שני', 'שלישי', 'רביעי', 'חמישי', 'שישי', 'שבת'];
						$i=0;
						foreach($weather_weekly_data as $item):
						$i++;
						if($i>14) break;
				
						$dayofweek_index = date('w', strtotime($item->datetime));
						$dayofweek = $days[$dayofweek_index];
						if($i==1) $dayofweek  = 'היום';
						
						$min_temp = (float)$item->min_temp;
						$max_temp = (float)$item->max_temp;
						
						$min_temp_color = get_temp_color($min_temp);
						$max_temp_color = get_temp_color($max_temp);
					?>
						<div class="line">
							<p class="day"><?=$dayofweek ?></p>
							<div class="icon">
								<img src="<?=$td?>/images/weather/<?=$item->weather->icon?>.png">
							</div>
							<p class="temp-day"><?=$item->min_temp?>°</p>
							<div class="bar">
								<div class="thumb" style="background: linear-gradient(to left, <?=$min_temp_color?>, <?=$max_temp_color?>)"></div>
							</div>
							<p class="temp-night"><?=$item->max_temp?>°</p>
						</div>
					<?php endforeach; ?>
				</div>
			</div>
		</div>
		
		<?php if(get_field('content-seo-weather', $location_term )['content-bottom']) : ?>
		<div class="content-bottom">
			<div class="content">
				<?=get_field('content-seo-weather', $location_term )['content-bottom']?>
			</div>
		</div>
		<?php endif; ?>
	</div>
</section>

<script>
	$(document).ready(function ($) {
		var mySwiper = new Swiper('.slider-daily', {
			slidesPerView: 6,
			spaceBetween: 0,
 
	 
			speed: 500,
			navigation: {
				nextEl: '.arrow-left',
				prevEl: '.arrow-right',
			},
		
			breakpoints: {
				0: {
					slidesPerView: 4,
				},
				950: {
					slidesPerView: 6,
				},
			}
		});
	});
</script>
	
<?php get_footer(); ?>