<?php
    // Template Name: Home Page
?>
<?php $td = get_template_directory_uri(); ?>
<?php get_header(); ?>

<section class="slider-top">
	<div class="bg">
		<div class="swiper-container slider-top-main">
			<div class="swiper-wrapper">
				<?php 
					$items = get_field('section-top')['images'];
					foreach($items as $f):
					$url = $f["sizes"]['slider-index-top'];
					if(wp_is_mobile()) $url = $f["sizes"]['slider-main-mobile'];
				?>
					<div class="swiper-slide">
						<img src="<?=$url?>" alt="<?=$f["alt"]?>" title="<?=$f["title"]?>">
					</div>
				<?php endforeach; ?>
			</div>
		</div>
	</div>

	<div class="section-inner">
		<div class="vawe">
			<img src="<?=$td?>/images/index/top-slider-vawe.svg">
		</div>
		<h1 class="text">
			<?=get_field('section-top')['text']?>
		</h1>
		
		<a scroll-to="section.plan" class="button-arrow"><?=get_field('section-top')['button']['text']?></a>


		<div class="hotels-panel-top">
			<?php 
				$terms = get_terms( array(
					'taxonomy'   => 'location',
					'hide_empty' => true,
				));
				$term = $terms[0];
				
				$att_cat_terms = get_terms( array(
					'taxonomy'   => 'attraction_category',
					'hide_empty' => true,
				));
			?>
			
			<div class="selector cities" value="">
				<div class="title" style="background-image: url(<?=$td?>/images/icons/hotels-panel/pin.svg);">
					<span>בחרו יעד</span>
				</div>
				<div class="modal">
					<div class="inner">
						<div class="items">
							<?php 
								foreach($terms as $term):
								$args = array(
									'post_type'             => 'attraction',
									'posts_per_page'        => -1,
									'post_status'           => 'publish',
									'ignore_sticky_posts'   => 1,
									'fields'				=> 'ids',
									'tax_query' => array()
								);
								$args['tax_query'][] = array(
									'taxonomy' => 'location',
									'field' => 'term_id', 
									'terms' => $term -> term_id
								);
								$posts = get_posts($args);
								if(!sizeof($posts)) continue;
							?>
								<div class="item city" value="<?=$term->slug?>">
									<span class="item-title"><?=$term->name?></span>
									<div class="data" style="display:none">
										<?php 
											foreach($att_cat_terms as $att_cat_term):
												$args['tax_query'] = array();
												$args['tax_query'][] = array(
													'taxonomy' => 'location',
													'field' => 'term_id', 
													'terms' => $term -> term_id
												);
												$args['tax_query'][] = array(
													'taxonomy' => 'attraction_category',
													'field' => 'term_id', 
													'terms' => $att_cat_term -> term_id
												);
												
												$posts = get_posts($args);
												if(sizeof($posts)) :
										?>
										<div class="item city" value="<?=$att_cat_term->slug?>"><span class="item-title"><?=$att_cat_term->name?></span></div>
										<?php endif; ?>
										<?php endforeach; ?>
										<div class="item city" value="hotels"><span class="item-title">בתי מלון</span></div>
									</div>
								</div>
							<?php endforeach; ?>
						</div>
					</div>
				</div>
			</div>
			

			<div class="selector attractions" value="">
				<div class="title" style="background-image: url(<?=$td?>/images/icons/hotels-panel/star.svg);">
					<span>מה בא לכם לעשות?</span>
				</div>
				<div class="modal">
					<div class="inner">
						<div class="items">
							<div class="item city" value="" style="pointer-events:none">יש לבחור יעד</div>
						</div>
					</div>
				</div>
			</div>
			<div class="button button-viva">
				<span>VIVA...</span>
			</div>
		</div>
	</div>
</section>

<section class="attractions-slider">
	<div class="decor">
		<img src="<?=$td?>/images/index/decor/slider-attraction.png">
	</div>
	<div class="section-inner">
		<h2 class="section-title"><?=get_field('section-attractions')['title']?></h2>
	</div>
	<div class="wrapper-slider">
		<div class="part-text">
			<div class="content">
				<?=get_field('section-attractions')['text']?>
			</div>
			<?php if(!wp_is_mobile()) : ?>
			<a href="<?=get_permalink(10);?>" class="button-icon">
				<div class="inner">
					<img src="<?=$td?>/images/icons/attraction/ball.svg">
					<span>לכל האטרקציות</span>
				</div>
			</a>

			<div class="nav">
				<div class="arrow arrow-right">
					<img src="<?=$td?>/images/icons/arrow-right-long.svg">
				</div>
				<div class="arrow arrow-left">
					<img src="<?=$td?>/images/icons/arrow-left-long.svg">
				</div>
			</div>
			<?php endif; ?>
		</div>

		<div class="part-slider">
			<div class="swiper-container slider-attractions">
				<div class="swiper-wrapper">
					<?php 
						$items = get_field('section-attractions')['attractions'];
						foreach($items as $item):
					?>
						<div class="swiper-slide">
							<?php 
								template_attraction_slide_box($item);
							?>	
						</div>
					<?php endforeach; ?>
				</div>
			</div>
			
			<?php if(wp_is_mobile()) : ?>
			<div class="centered">
				<div class="nav nav-mobile">
					<div class="arrow arrow-right">
						<img src="<?=$td?>/images/icons/arrow-right-long.svg">
					</div>
					<div class="arrow arrow-left">
						<img src="<?=$td?>/images/icons/arrow-left-long.svg">
					</div>
				</div>
				<a href="<?=get_permalink(10);?>" class="button-icon">
					<div class="inner">
						<img src="<?=$td?>/images/icons/attraction/ball.svg">
						<span>לכל האטרקציות</span>
					</div>
				</a>
			</div>
			<?php endif; ?>
		</div>
	</div>
</section>

<section class="banners">
	<div class="section-inner">
		<div class="boxes">
			<?php 
				$items = get_field('banners-1')['banners'];
				foreach($items as $item):
			?>
				<a class="box" href="<?=$item['url']?>" >
					<div class="inner">
						<?php 
							$f = $item['image-desktop']; 
							if(wp_is_mobile() && $item['image-mobile']) $f = $item['image-mobile']; 
							
							$url = $f["url"];
							if(wp_is_mobile()) $url = $f["sizes"]['banner-mobile'];
						?> 
						<img src="<?=$url?>" alt="<?=$f["alt"]?>" title="<?=$f["title"]?>">
					</div>
				</a>
			<?php endforeach; ?>
		</div>
	</div>
</section>

<section class="articles-index">
	<div class="decor">
		<img src="<?=$td?>/images/index/decor/articles.png">
	</div>
	<div class="section-inner">
		<h2 class="section-title">מדריכים ומידע <span>יוון והאיים</span></h2>

		<div class="wrapper-articles">
			<div class="boxes">
				<?php 
					$items = get_field('section-articles')['articles'];
					foreach($items as $item) {
						template_post_box($item);
					}
				?>
			</div>
			<div class="wrapper-button right">
				<a href="<?=get_permalink(20);?>" class="button-icon">
					<div class="inner">
						<img src="<?=$td?>/images/icons/attraction/map.svg">
						<span>לכל המאמרים ומדריכים</span>
					</div>
				</a>
			</div>
		</div>
	</div>
</section>



<section class="hotels-index">
	<div class="section-inner">
		<div class="wrapper-hotels">
			<h2 class="section-title"><?=get_field('section-hotels')['title']?></h2>
			<div class="boxes">
				<?php 
					$items = get_field('section-hotels')['hotels'];
					foreach($items as $item){
						template_box_hotel_index($item['id']);
					}
				?>
			</div>

			<div class="wrapper-button">
				<a href="<?=get_permalink(8);?>" class="button-icon">
					<div class="inner">
						<img src="<?=$td?>/images/icons/attraction/case.svg">
						<span>לכל המלונות</span>
					</div>
				</a>
			</div>
		</div>
	</div>
</section>

<?php if(get_field('section-blogger-stories')['stories']) : ?>
<section class="blogger-stories">
	<div class="section-inner">
		<p class="section-title centered"><?=get_field('section-blogger-stories')['title']?></p>
		<div class="boxes">
			<?php 
				$items = get_field('section-blogger-stories')['stories'];
				foreach($items as $item) {
					template_blogger_story_box($item);
				}
			?>
		</div>
		<div class="wrapper-button flex">
			<a href="<?=get_permalink(401);?>" class="button-icon">
				<div class="inner">
					<img src="<?=$td?>/images/icons/attraction/fav.svg">
					<span>הרשם לאתר כבלוגר</span>
				</div>
			</a>
			
			<a href="<?=get_permalink(16);?>" class="button-icon">
				<div class="inner">
					<img src="<?=$td?>/images/icons/attraction/chat.svg">
					<span>לכל הבלוגים</span>
				</div>
			</a>
		</div>
	</div>
</section>
<?php endif; ?>

<section class="banners">
	<div class="section-inner">
		<div class="boxes">
			<?php 
				$items = get_field('banners-2')['banners'];
				foreach($items as $item):
			?>
				<a class="box" href="<?=$item['url']?>" >
					<div class="inner">
						<?php 
							$f = $item['image-desktop']; 
							if(wp_is_mobile() && $item['image-mobile']) $f = $item['image-mobile']; 
							
							$url = $f["url"];
							if(wp_is_mobile()) $url = $f["sizes"]['banner-mobile'];
						?> 
						<img src="<?=$url?>" alt="<?=$f["alt"]?>" title="<?=$f["title"]?>">
					</div>
				</a>
			<?php endforeach; ?>
		</div>
	</div>
</section>

<section class="plan">
	<div class="section-inner">
		<div class="wrapper-content">
			<h2 class="section-title"><?=get_field('section-about')['title']?></h2>

			<div class="boxes">
				<?php 
					$items = get_field('section-about')['advantages'];
					foreach($items as $item):
				?>
					<div class="box box-plan">
						<div class="inner">
							<div class="icon">
								<?php $f = $item['icon']; ?> 
								<img src="<?=$f["url"]?>" alt="<?=$f["alt"]?>" title="<?=$f["title"]?>">
							</div>
							<p class="title"><?=$item['title']?></p>
							<div class="content">
								<?=$item['text']?>
							</div>
						</div>
					</div>
				<?php endforeach; ?>
			</div>
		</div>
	</div>
</section>

<section class="tips">
	<div class="section-inner">
		<div class="part-top">
			<h2 class="section-title"><?=get_field('section-tips')['title']?></h2>
			<p class="description"><?=get_field('section-tips')['subtitle']?></p>
		</div>

		<div class="parts ai-center">
			<div class="part part-map">
				<div class="image map">
					<?php $f = get_field('section-tips')['map-tips']; ?> 
					<img src="<?=$f["url"]?>" alt="<?=$f["alt"]?>" title="<?=$f["title"]?>">
					
					<?php 
						$i=0;
						$items = get_field('section-tips')['hotspot'];
						foreach($items as $item):
						$i++;
						
						$cords_array = explode(",", $item['spot']);
						$cords_top = $cords_array[1];
						$cords_left = $cords_array[0];
					?>
						<div class="hotspot <?php if($i==1) echo 'selected'; ?>" style="top:<?=$cords_top?>; left:<?=$cords_left?>;">
							<img src="<?=$td?>/images/icons/hotspot.svg">
							<?php if($item['location-text']) : ?>
							<span><?=$item['location-text']?></span>
							<?php endif; ?>
						</div>
					<?php endforeach; ?>
				</div>
			</div>
			<div class="part part-tips tabs">
				
					<?php 
						$i = 0;
						$tabs = get_field('section-tips')['hotspot'];
						foreach($tabs as $tab):
						$i++;
						$style = 'display:none;';
						if($i == 1) $style = 'display:block;';
					?>
						<div class="tab boxes" style="<?=$style?>">
							
								<?php 
									$items = $tab['tips'];
									foreach($items as $item) {
										template_tip_index_box($item);
									}
								?>
						
						</div>
					<?php endforeach; ?>
				

				
			</div>
		</div>
		
		<div class="wrapper-button">
			<a href="<?=get_permalink(456);?>" class="button-icon">
				<div class="inner">
					<img src="<?=$td?>/images/icons/attraction/puzzle.svg">
					<span>לכל הטיפים</span>
				</div>
			</a>
		</div>
	</div>
</section>

<?php if(get_field('section-bottom')['image']) : ?>
<section class="image-wide">
	<?php 
		$f = get_field('section-bottom')['image']; 
		$url = $f["url"];
		if(wp_is_mobile()) $url = $f["sizes"]['banner-mobile'];
	?> 
	<img src="<?=$url?>" alt="<?=$f["alt"]?>" title="<?=$f["title"]?>">
</section>
<?php endif; ?>
<script>
	$(document).ready(function ($) {
		var sh = $(".logo").height()
		
		mySwiperTop = new Swiper('.slider-top-main', {
			slidesPerView: 1,
			spaceBetween: 0,
			loop: false,
			effect: 'fade',
			fadeEffect: {
				crossFade: true
			},
			/*
			autoplay: {
				delay: 5000,
				disableOnInteraction: false,
				reverseDirection: false,
			},
			*/
			speed: 500,
		});

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

		selectorListeners();

		


		var mySwiper = new Swiper('.slider-attractions', {
			slidesPerView: 1.5,
			spaceBetween: 65,
			loop: true,

			autoplay: {
				delay: 3000,
				disableOnInteraction: false,
				reverseDirection: true,
			},
			speed: 1000,
			navigation: {
				nextEl: '.arrow-right',
				prevEl: '.arrow-left',
			},

			breakpoints: {
				0: {
					spaceBetween: 25,
					slidesPerView: 1.35,
				},
				950: {
					spaceBetween: 65,
					slidesPerView: 1.5,
				},
			}
		});
		
		$(".button-viva").on("click", function(){
			var url = "/attraction/"
			if($(".selector.cities").attr('value')) {
				url = "/אטרקציות/";
				url += $(".selector.cities").attr('value');
			}
			if($(".selector.attractions").attr('value')) url += "/" + $(".selector.attractions").attr('value');
			
			if($(".selector.attractions").attr('value') == "hotels") url = "/בתי-מלון/" + $(".selector.cities").attr('value');
			
			window.location = url;
		});
		
		
		$("section.tips .hotspot").on("click", function(e){
			e.preventDefault();
			var cont = $(this).closest(".tips");
			
			$(".hotspot", cont).removeClass("selected");
			$(this).addClass("selected");
			
			var index = $(".hotspot", cont).index(this);
			
			$("section.tips .tabs").animate({'opacity':0}, function(){
				$("section.tips .tabs .tab").hide();
				$("section.tips .tabs .tab").eq(index).show();
				$("section.tips .tabs").animate({'opacity':1});
			});
			
		});
	});
	var mySwiperTop;
	function selectorListeners() {
		$(".hotels-panel-top .selector .items .item").off('click');
		$(".hotels-panel-top .selector .items .item").click(function() {
			let cont = $(this).closest(".selector");
			$(".items .item").removeClass("selected");
			$(this).addClass("selected");

			let ttl = $(">span.item-title", this).text();
			let val = $(this).attr("value");

			$(".title span", cont).text(ttl);
			$(cont).attr("value", val);

			$(cont).removeClass("open");
		});
		
		$(".hotels-panel-top .selector.cities .items .item").click(function() {
			let cont = $(this).closest(".selector");
			let index = $(".items > .item", cont).index(this);
			console.log(index);
			mySwiperTop.slideTo(index);
			
			let items = $(".data", this).html();
			
			$(".selector.attractions").attr("value", "");
			$(".selector.attractions .title span").text("מה בא לכם לעשות?");
			$(".selector.attractions .items").html(items);
			selectorListeners();
		});
	}
</script>


<?php get_footer(); ?>
