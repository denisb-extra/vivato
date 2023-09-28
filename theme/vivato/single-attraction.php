<?php $td = get_template_directory_uri(); ?>

<?php 
	global $meta_description;
	$meta_description = make_short($post->post_content, 30);
	
	$location_terms = get_the_terms($post, "location");
	if($location_terms) {
		$location_term = $location_terms[0];
		global $g_location_term;
		$g_location_term = $location_term;
	}
	
	$category_terms = get_the_terms($post, "attraction_category");
	if($category_terms) {
		$category_term = $category_terms[0];
	}
	
	
	if(isset($location_term) && isset($category_term)) {
		global $my_bradcrumbs;
		$my_bradcrumbs = [];
		$my_bradcrumbs[] = array(
			'url' => get_home_url(),
			'text' => 'בית',
		);
		$my_bradcrumbs[] = array(
			'url' => get_home_url() . "/אטרקציות/" .  $location_term->slug . "/",
			'text' => 'אטרקציות ב' . $location_term->name,
		);
		$my_bradcrumbs[] = array(
			'url' => get_home_url() . "/אטרקציות/" .  $location_term->slug . "/" . $category_term->slug . "/",
			'text' => $category_term->name . " ב" . $location_term->name,
		);
		
		$my_bradcrumbs[] = array(
			'url' => '',
			'text' => $post -> post_title,
		);
	}
?>

<?php get_header(); ?>

<?php 
	
	get_template_part( 'template-parts/top-inner' ); 
	$id = $post->ID;
?>


<section class="attraction">
	<div class="section-inner">
		<div class="parts">
			<div class="part">

				<h1 class="title-main">
					<?=$post -> post_title?>
					<Br>
					<?=$post -> post_excerpt?>
				</h1>
				
				<?php if(wp_is_mobile()) : ?>
				<div class="swiper-container slider-attraction">
					<?php if($location_term) : ?>
						<div class="caption-location"><?=$location_term->name?></div>
					<?php endif; ?>
					<div class="swiper-wrapper">
						<?php 
							$video = get_field('video');
							$video_url = "";
							if($video['file']) $video_url = $video['file']['url'];
							if($video['url']) $video_url = $video['url'];
								
							$size = 'slider-attraction';
							if(wp_is_mobile()) $size = 'thumb-location';
							
							$items = get_field('gallery');
							$main_image = get_the_post_thumbnail_url($post, $size);
							if(!$main_image) $main_image = get_field("general", 'options')['image-placeholder']['sizes'][$size];
							
							if($main_image && !$items) {
								$items[] = Array(
									'alt' => $post->post_title,
									'title' => $post->post_title,
									'url' => get_the_post_thumbnail_url($post, 'full') ?: get_field("general", 'options')['image-placeholder']['url'],
									'sizes' => Array(
										'slider-attraction' => $main_image,
										'thumb-location' => $main_image,
									),
								);
							}
							
							$i=0;
							foreach($items as $f):
							$i++;
						?>
							<?php if($video_url && $i==1) : ?>
							<a class="swiper-slide" href="<?=$video_url?>" data-fancybox="gallery">
								<img src="<?=$f["sizes"][$size]?>" alt="<?=$f["alt"]?>" title="<?=$f["title"]?>">
								<div class="play">
									<img src="<?=$td?>/images/icons/play.svg">
								</div>
							</a>
							<?php else : ?>
							<a class="swiper-slide" href="<?=$f['url']?>" data-fancybox="gallery">
								<img src="<?=$f["sizes"][$size]?>" alt="<?=$f["alt"]?>" title="<?=$f["title"]?>">
							</a>
							<?php endif; ?>
						<?php endforeach; ?>
					</div>
					<div class="pagination"></div>
				</div>
				<?php endif; ?>
				
				<div class="info">
					<?php if(get_field('contacts')['address']) : ?>
					<div class="item">
						<div class="icon">
							<img src="<?=$td?>/images/icons/attraction/marker.svg">
						</div>
						<div class="text">
							<p><?=get_field('contacts')['address']?></p>
						</div>
					</div>
					<?php endif; ?>
					<?php if(get_field('links')['map'] && wp_is_mobile()) : ?>
					<a target="_blank" href="<?=get_field('links')['map']?>" class="button-icon">
						<div class="inner">
							<img src="<?=$td?>/images/icons/attraction/map.svg">
							<span>צפייה במפה</span>
						</div>
					</a>
					<?php if(get_field('links')['location'] && wp_is_mobile()) : ?>
					<a href="<?=get_field('links')['location']?>" class="button-icon">
						<div class="inner">
							<img src="<?=$td?>/images/icons/attraction/nav.svg">
							<span>נווטו ליעד</span>
						</div>
					</a>
					<?php endif; ?>
					<?php endif; ?>
					<?php if(get_field('contacts')['tel']) : ?>
					<div class="item">
						<div class="icon">
							<img src="<?=$td?>/images/icons/attraction/tel.svg">
						</div>
						<div class="text">
							<p><?=get_field('contacts')['tel']?></p>
						</div>
					</div>
					<?php endif; ?>
					<?php if(get_field('contacts')['website']) : ?>
					<a target="_blank" class="item" rel="nofollow" href="<?=get_field('contacts')['website']?>">
						<div class="icon">
							<img src="<?=$td?>/images/icons/attraction/earth.svg">
						</div>
						<div class="text">
							<p>אתר אינטרנט</p>
						</div>
					</a>
					<?php endif; ?>
					<?php if(get_field('contacts')['hours']) : ?>
					<div class="item">
						<div class="icon">
							<img src="<?=$td?>/images/icons/attraction/clock.svg">
						</div>
						<div class="text">
							<?=get_field('contacts')['hours']?>
						</div>
					</div>
					<?php endif; ?>
					<?php if(get_field('contacts')['email']) : ?>
					<div class="item">
						<div class="icon">
							<img src="<?=$td?>/images/icons/attraction/envelope.svg">
						</div>
						<div class="text">
							<p><?=get_field('contacts')['email']?></p>
						</div>
					</div>
					<?php endif; ?>
				</div>

				<div class="about">
					<div class="content">
						<?php 
							the_content();
						?>
					</div>
				</div>
			</div>
			<div class="part">
				<?php if(!wp_is_mobile()) : ?>
				<div class="swiper-container slider-attraction">
					<?php if($location_term) : ?>
						<div class="caption-location"><?=$location_term->name?></div>
					<?php endif; ?>
					<div class="swiper-wrapper">
						<?php 
							$video = get_field('video');
							$video_url = "";
							if($video['file']) $video_url = $video['file']['url'];
							if($video['url']) $video_url = $video['url'];
								
								
							$items = get_field('gallery');
							$main_image = get_the_post_thumbnail_url($post, 'slider-attraction');
							if(!$main_image) $main_image = get_field("general", 'options')['image-placeholder']['sizes']['slider-attraction'];
							
							if($main_image && !$items) {
								$items[] = Array(
									'alt' => $post->post_title,
									'title' => $post->post_title,
									'url' => get_the_post_thumbnail_url($post, 'full') ?: get_field("general", 'options')['image-placeholder']['url'],
									'sizes' => Array(
										'slider-attraction' => $main_image
									),
								);
							}
							
							$i=0;
							foreach($items as $f):
							$i++;
						?>
							<?php if($video_url && $i==1) : ?>
							<a class="swiper-slide" href="<?=$video_url?>" data-fancybox="gallery">
								<img src="<?=$f["sizes"]['slider-attraction']?>" alt="<?=$f["alt"] ?: $post->post_title?>" title="<?=$f["title"]?>">
								<div class="play">
									<img src="<?=$td?>/images/icons/play.svg">
								</div>
							</a>
							<?php else : ?>
							<a class="swiper-slide" href="<?=$f['url']?>" data-fancybox="gallery">
								<img src="<?=$f["sizes"]['slider-attraction']?>" alt="<?=$f["alt"] ?: $post->post_title?>" title="<?=$f["title"]?>">
							</a>
							<?php endif; ?>
						<?php endforeach; ?>
					</div>
					<div class="pagination"></div>
				</div>
				<?php endif; ?>
				<div class="buttons">
					<?php if(is_user_logged_in()) : ?>
					<div  class="button-icon cont-like">
						<div class="inner">
							<?= do_shortcode("[wp_ulike id='$id']"); ?>
							<span>להוסיף לטיול שלי</span>
						</div>
					</div>
					<?php else : ?>
						<a href="<?=get_permalink(462)?>" class="button-icon">
							<div class="inner">
								<img src="<?=$td?>/images/icons/heart-empty.svg">
								<span>להוסיף לטיול שלי</span>
							</div>
						</a>
					<?php endif; ?>
					<?php if(get_field('links')['location'] && !wp_is_mobile()) : ?>
					<a href="<?=get_field('links')['location']?>" class="button-icon">
						<div class="inner">
							<img src="<?=$td?>/images/icons/attraction/nav.svg">
							<span>נווטו ליעד</span>
						</div>
					</a>
					<?php endif; ?>
					<?php if(get_field('links')['map'] && !wp_is_mobile()) : ?>
					<a target="_blank" href="<?=get_field('links')['map']?>" class="button-icon">
						<div class="inner">
							<img src="<?=$td?>/images/icons/attraction/map.svg">
							<span>צפייה במפה</span>
						</div>
					</a>
					<?php endif; ?>
				</div>
			</div>
		</div>
	</div>
</section>

<section class="comments">
	<div class="decor">
		<img src="<?=$td?>/images/inner/decor/decor-comments.png">
	</div>
	<div class="section-inner">
		<p class="section-title">הוסיפו המלצה <span>אישית</span></p>
		<div class="content">
			<?php comments_template(); ?>
		</div>
		
		<a class="button-popup">התוכן עזר לכם? יש לכם הערות? <span>לחצו כאן</span></a>
	</div>
</section>

<?php if(false) : ?>
<section class="opinion">
	<div class="section-inner">
		<p class="section-title">חוות <span>דעת</span></p>
		<div class="content">
			<p>יש לך משהו לכתוב?</p>
		</div>
		<a href="#" class="button-icon">
			<div class="inner">
				<img src="<?=$td?>/images/icons/attraction/pencil.svg">
				<span>כתוב חוות דעת</span>
			</div>
		</a>
	</div>
</section>
<?php endif; ?>
<?php 
	$title = "יוון";	
	if($location_term) {
		$title = $location_term -> name;
	}
?>

<section class="attractions">
	<div class="section-inner">
		<p class="section-title">אטרקציות נוספות <span>ב<?=$title?></span></p>

		<div class="boxes">
			<?php 
				$tax_query = Array();
				if($location_term) {
					$tax_query = array(
						array(
							'taxonomy' => 'location',
							'field' => 'term_id', 
							'terms' => $location_term -> term_id
						)
					);
				}
				
				$args = array(
					'post_type'             => 'attraction',
					'posts_per_page'        => 4,
					'post_status'           => 'publish',
					'ignore_sticky_posts'   => 1,
					'orderby'   => 'rand',
					'tax_query' => $tax_query,
					'post__not_in'   => array( get_the_ID() ),
				);

				$posts = get_posts($args);
				foreach($posts as $mpost) {
					template_attraction_box($mpost->ID);
				}
			?>
		</div>
	</div>
</section>

<script>
	$(document).ready(function ($) {
		var mySwiper = new Swiper('.slider-attraction', {
			slidesPerView: 5,
			spaceBetween: 50,
			loop: true,
			effect: 'fade',
			fadeEffect: {
				crossFade: true
			},
			autoplay: {
				delay: 3000,
			},
			speed: 1000,

			pagination: {
				el: '.pagination',
				type: 'bullets',
				clickable: true,
			},
			breakpoints: {
				0: {
					spaceBetween: 35,
				},
				1360: {
					spaceBetween: 55,
				},
			}
		});
	});
</script>

<?php get_footer(); ?>