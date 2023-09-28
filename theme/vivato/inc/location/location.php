<div class="panel-side">
	<div class="items">
		<div class="item active" scroll-to-id="s1">
			<div class="icon">
				<img src="<?=$td?>/images/icons/attraction/info.svg" alt="מידע כללי">
			</div>
			<span>מידע כללי</span>
		</div>
		<div class="item" scroll-to-id="s2">
			<div class="icon">
				<img src="<?=$td?>/images/icons/attraction/marker.svg" alt="מלונות">
			</div>
			<span>מלונות</span>
		</div>
		<div class="item" scroll-to-id="s3">
			<div class="icon">
				<img src="<?=$td?>/images/icons/attraction/ball.svg" alt="אטרקציות">
			</div>
			<span>אטרקציות</span>
		</div>
		<div class="item" scroll-to-id="s4">
			<div class="icon">
				<img src="<?=$td?>/images/icons/attraction/map.svg" alt="מדריכים">
			</div>
			<span>מדריכים</span>
		</div>
		
		<div class="item" scroll-to-id="s5">
			<div class="icon">
				<img src="<?=$td?>/images/icons/attraction/puzzle.svg" alt="טיפים">
			</div>
			<span>טיפים</span>
		</div>
		<div class="item" scroll-to-id="s6">
			<div class="icon">
				<img src="<?=$td?>/images/icons/attraction/question.svg" alt="שאלות נפוצות">
			</div>
			<span>שאלות נפוצות</span>
		</div>
		<div class="item" scroll-to-id="s7">
			<div class="icon">
				<img src="<?=$td?>/images/icons/attraction/chat.svg" alt="בלוגרים">
			</div>
			<span>בלוגרים</span>
		</div>
		<div class="item" scroll-to-id="s8">
			<div class="icon">
				<img src="<?=$td?>/images/icons/attraction/chat-2.svg" alt="פורום">
			</div>
			<span>פורום</span>
		</div>
		
	</div>
</div>

<section class="location-top" id="s1">
	<div class="section-inner">
		<div class="parts ai-center">
			<div class="part">
				<div class="content">
					<?=term_description($cur_term);?>
				</div>
			</div>
			<div class="part">
				<div class="image">
					<div class="image-shadow">
						<?php 
							$f = get_field('image-main', $cur_term); 
							$size = 'slider-attraction';
							if(wp_is_mobile()) $size = 'thumb-location';
						?> 
						<img src="<?=$f["sizes"][$size]?>" alt="<?=$f["alt"]?>" title="<?=$f["title"]?>">
					</div>
				</div>
			</div>
		</div>
	</div>
</section>

<section class="location-hotels" id="s2">
	<div class="section-inner">
		<h2 class="section-title">מלונות <span>ב<?=$cur_term->name;?></span></h2>
		
		<div class="boxes">
			<?php 
				$args = Array(
					'post_type' => 'hotel',
					'numberposts' => 3,
					'fields' => 'ids',
					'tax_query' => array(
						array(
							'taxonomy' => 'location',
							'field' => 'term_id', 
							'terms' => $cur_term -> term_id
						)
					)
				);

				$items = get_posts($args);
				
				foreach($items as $item){
					template_box_hotel_location(0, $item, 'h3');
				}
			?>
		</div>
		<?php 
			$link = "/בתי-מלון/" . $cur_term->slug . "/";;
		?>
		<div class="cont-button">
			<a href="<?=$link;?>" class="button-icon">
				<div class="inner">
					<img src="<?=$td?>/images/icons/attraction/case.svg" alt="לכל בתי המלון">
					<span>לכל בתי המלון</span>
				</div>
			</a>
		</div>
	</div>
</section>

<section class="attractions-location" id="s3">
	<div class="decor">
		<img src="<?=$td?>/images/inner/decor/attractions-location.png" alt="אטרקציות">
	</div>
	<div class="section-inner">
		<h2 class="section-title centered">אטרקציות <span>ב<?=$cur_term->name;?></span></h2>
		
		<?php if(isset(get_field('section-attractions', $cur_term)['cats'])) : ?>
		<div class="panel-menu">
			<?php 
				$items = get_field('section-attractions', $cur_term)['cats'];
				$item = $items[0];
			?>
			
			<p class="title-mobile">
				<span><?=$item['cat']?></span>
			</p>
			<div class="items">
				<?php 
					$i = 0;
					foreach($items as $item):
					$i++;
				?>
					<h4 class="item <?php if($i==1) echo "active"; ?>">
						<span><?=$item['cat']?></span>
					</h4>
				<?php endforeach; ?>
			</div>
		</div>
		
		<div class="tabs">
			<?php 
				$i = 0;
				foreach($items as $item):
				$i++;
				$style = 'display:none;';
				if($i == 1) $style = 'display:block;';
			?>
				<div class="tab" style="<?=$style?>">
					<div class="parts">
						<div class="part">
							<div class="boxes">
								<?php 
									$atts = $item['attractions'];
									$count = sizeof($atts);
									$half = round($count/2);
									$j = 0;
									foreach($atts as $att):
									$j++;
								?>
								<?php 
									template_attraction_location_box($att, 'h3');
								?>
								<?php if($j == $half ) : ?>
									</div>
									</div>
									<div class="part">
									<div class="boxes">
								<?php endif; ?>
								<?php endforeach; ?>
							</div>
						</div>
					</div>
				</div>
			<?php endforeach; ?>
		</div>
		<?php else : ?>
			<div class="panel-menu">
				<?php 
					$terms = get_terms( array(
						'taxonomy'   => 'attraction_category',
						'hide_empty' => false,
					));
					$term = $terms[0];
				?>
				
				<p class="title-mobile">
					<span><?=$term->name?></span>
				</p>
				<div class="items">
					<?php 
						$i = 0;
						foreach($terms as $term):
						$i++;
					?>
						<div class="item <?php if($i==1) echo "active"; ?>">
							<span><?=$term->name?></span>
						</div>
					<?php endforeach; ?>
				</div>
			</div>
			
			<div class="tabs">
				<?php 
					$i = 0;
					foreach($terms as $term):
					$i++;
					$style = 'display:none;';
					if($i == 1) $style = 'display:block;';
				?>
					<div class="tab" style="<?=$style?>">
						<div class="parts">
							<div class="part">
								<div class="boxes">
									<?php 
										$args = Array(
											'post_type' => 'attraction',
											'numberposts' => 6,
											'tax_query' => array(
												array(
													'taxonomy' => 'attraction_category',
													'field' => 'term_id', 
													'terms' => $term -> term_id
												)
											)
										);
										$atts = get_posts($args);
										$count = sizeof($atts);
										$half = round($count/2);
										$j = 0;
										foreach($atts as $att):
										$j++;
									?>
									<?php 
										template_attraction_location_box($att, 'h3');
									?>
									<?php if($j == $half ) : ?>
										</div>
										</div>
										<div class="part">
										<div class="boxes">
									<?php endif; ?>
									<?php endforeach; ?>
								</div>
							</div>
						</div>
					</div>
				<?php endforeach; ?>
			</div>
		<?php endif; ?>
		
		
	
		<div class="cont-button">
			<?php 
				$link = "/אטרקציות/" . $cur_term->slug . "/";
			?>
			<a href="<?=$link?>" class="button-icon">
				<div class="inner">
					<img src="<?=$td?>/images/icons/attraction/ball.svg" alt="לכל האטרקציות">
					<span>לכל האטרקציות</span>
				</div>
			</a>
		</div>
	</div>
</section>

<section class="articles more" id="s4">
	<div class="section-inner">
		<h2 class="section-title">מאמרים ומדריכים <span>ל<?=$cur_term->name;?></span></h2>
		<div class="boxes">
			<?php 
				if(isset(get_field('section-articles', $cur_term)['articles'])) {
					$items = get_field('section-articles', $cur_term)['articles'];
				}
				else {
					$args = Array(
						'post_type' => 'post',
						'numberposts' => 3,
						'fields' => 'ids',
						'tax_query' => array(
							array(
								'taxonomy' => 'location',
								'field' => 'term_id', 
								'terms' => $cur_term -> term_id
							)
						)
					);

					$items = get_posts($args);
				}
				foreach($items as $item) {
					template_post_box($item, 'h3');
				}
			?>
		</div>
		<?php 
			$link = "/מדריכים/" . $cur_term->slug . "/";;
		?>
		
		<div class="cont-button">
			<a href="<?=$link;?>" class="button-icon">
				<div class="inner">
					<img src="<?=$td?>/images/icons/attraction/map.svg" alt="לכל המאמרים ומדריכים">
					<span>לכל המאמרים ומדריכים</span>
				</div>
			</a>
		</div>
	</div>
</section>

<section class="location-tips" id="s5">
	<div class="section-inner">
		<h2 class="section-title">טיפים לטיול <span>ב<?=$cur_term->name;?></span></h2>
		<div class="boxes">
			<?php 
				if(isset(get_field('section-tips', $cur_term)['tips'])) $items = get_field('section-tips', $cur_term)['tips'];
				else {
					$args = Array(
						'post_type' => 'tip',
						'numberposts' => 6,
						'fields' => 'ids',
						'tax_query' => array(
							array(
								'taxonomy' => 'location',
								'field' => 'term_id', 
								'terms' => $cur_term -> term_id
							)
						)
					);

					$items = get_posts($args);
				}
				if($items) {
					foreach($items as $item) {
						template_tip_location_box($item, 'h3');
					}
				}
			?>
		</div>
		<div class="cont-button ">
			<?php 
				$link = "/טיפים/" . $cur_term->slug . "/";;
			?>
			<a href="<?=$link?>" class="button-icon">
				<div class="inner">
					<img src="<?=$td?>/images/icons/attraction/puzzle.svg" alt="לכל הטיפים">
					<span>לכל הטיפים</span>
				</div>
			</a>
		</div>
	</div>
</section>

<section class="questions" id="s6">
	<div class="decor">
		<img src="<?=$td?>/images/inner/decor/questions.png">
	</div>
	<div class="section-inner">
		<div class="wrapper">
			<h2 class="section-title">שאלות נפוצות על <span><?=$cur_term->name;?></span></h2>
			<?php if(isset(get_field('section-questions', $cur_term)['questions'])) : ?>
			<div class="tabs accordion">
				<?php 
					$i=0;
					$items = get_field('section-questions', $cur_term)['questions'];
					foreach($items as $item):
					$i++;
				?>
					<div class="tab <?php if($i==1) echo  'active'?>">
						<h5 class="tab-title"><?=$item['question']?></h5>
						<div class="tab-content" <?php if($i==1) echo 'style="display: block;"' ?>>
							<div class="content">
								<?=$item['answer']?>
							</div>
						</div>
					</div>
				<?php endforeach; ?>
			</div>
			<?php endif; ?>
		</div>
	</div>
</section>
<script type="application/ld+json">
{
	"@context": "https://schema.org",
	"@type": "FAQPage",
	"mainEntity": [
		<?php
			$i=0;
			$items = get_field('section-questions', $cur_term)['questions'];
			foreach($items as $item):
			$i++;
		?>
		{ 
			"@type": "Question",
			"name": "<?=str_replace('"',"״",sanitize_text_field($item["question"]));?>",
			"acceptedAnswer": {
				"@type": "Answer",
				"text": "<?=str_replace('"',"״",sanitize_text_field($item["answer"]));?>"
			}
		}<?php if ($i < sizeof($items)) echo ",";?>
		<?php endforeach; ?>
	]
}
</script>

<?php 
	if(isset(get_field('section-stories', $cur_term)['stories'])) $items = get_field('section-stories', $cur_term)['stories'];
	else {
		$args = Array(
			'post_type' => 'blogger-story',
			'numberposts' => 3,
			'fields' => 'ids',
			'tax_query' => array(
				array(
					'taxonomy' => 'location',
					'field' => 'term_id', 
					'terms' => $cur_term -> term_id
				)
			)
		);

		$items = get_posts($args);
	};
	if($items) :
?>

<section class="blogger-stories" id="s7">
	<div class="section-inner">
		<h2 class="section-title centered">סיפורי בלוגרים <span>מובילים</span></h2>
		<div class="boxes">
			<?php 
				foreach($items as $item) {
					template_blogger_story_box($item);
				}
			?>
		</div>
		<div class="wrapper-button">
			<a href="<?=get_permalink(16);?>" class="button-icon">
				<div class="inner">
					<img src="<?=$td?>/images/icons/attraction/chat.svg" alt="לכל הסיפורים">
					<span>לכל הסיפורים</span>
				</div>
			</a>
		</div>
	</div>
</section>
<?php endif; ?>




<?php 
	global $wpdb;
	if(isset(get_field('section-forum', $cur_term)['forum-id'])) $forum_id = get_field('section-forum', $cur_term)['forum-id'];
	else $forum_id = 2;
	$topics = $wpdb->get_results("SELECT * FROM `thf_forum_topics` WHERE `thf_forum_topics`.`parent_id` = " . $forum_id);
	
	if($topics) :
?>
<section class="location-forum" id="s8">
	<div class="section-inner">
		<h2 class="section-title">פורום <span><?=$cur_term->name;?></span></h2>
		<div class="boxes">
			<?php 
				$i=0;
				foreach(array_reverse($topics) as $topic) {
					$i++;
					if($i>3) break;
					template_forum_box($topic);
				}
			?>
		</div>
		<div class="cont-button">
			<a href="<?=get_permalink(12)?>" class="button-icon">
				<div class="inner">
					<img src="<?=$td?>/images/icons/attraction/chat-2.svg" alt="לכל הפורום">
					<span>לכל הפורום</span>
				</div>
			</a>
		</div>
	</div>
</section>
<?php endif; ?>

<script>
	$(document).ready(function ($) {
		$(".title-mobile").on("click", function(){
			var cont = $(this).closest(".panel-menu");
			$(".items", cont).slideToggle();
		});
		
		$(".panel-menu .items .item").on("click", function(){
			var cont = $(this).closest(".panel-menu");
			
			$(".item", cont).removeClass("active");
			$(this).addClass("active");
			
			var index = $(".item", cont).index(this);
			var text = $("span", this).text();
			$(".title-mobile span", cont).text(text);
			
			$(".attractions-location .tabs").animate({'opacity':0}, function(){
				$(".attractions-location .tabs .tab").hide();
				$(".attractions-location .tabs .tab").eq(index).show();
				$(".attractions-location .tabs").animate({'opacity':1});
			});
			
			if($(window).width() <= 950) {
				$(".items", cont).slideUp();
			}
			
		});
		
		
	});
</script>

<script>
	$(document).ready(function ($) {
		var d = $(document).height();
		var c = $(window).height();
		var s = $(window).scrollTop();
		var yend;
		var position;
		var ystart;
		var sh;
		var curSectionId;
		var curSideItem;
		$(window).on('scroll', function(){
			s = $(window).scrollTop();
			position = s + c;

			$("section").each(function(){
				sh = $(this).height();

				ystart = $(this).offset().top + sh/2;
				yend = ystart + sh;

				if(position >= ystart && position <= yend) {
					curSectionId = $(this).attr("id");

					curSideItem = $(".panel-side .item[scroll-to-id='"+curSectionId+"']");

					$(".panel-side .item").each(function(){
						if($(this)[0] != curSideItem[0]) {
							$(this).removeClass("active");

							if($(".panel-side .item").index(this) < $(".panel-side .item").index(curSideItem)) {
								$(this).addClass("before-active");
							}
							else {
								$(this).removeClass("before-active");
							}
						}
						else {
							$(this).addClass("active");
							$(this).removeClass("before-active");
						}
					});
				}
			});
		});

		$("[scroll-to-id]").each(function(){
			var trgt = "#" + $(this).attr('scroll-to-id');
			if(!$(trgt).length)$(this).hide();
		});
		
		$("[scroll-to-id]").on("click", function(){
			var trgt = "#" + $(this).attr('scroll-to-id');
			$('html, body').animate({
				scrollTop: $(trgt).offset().top
			}, 1000);
		});
	});
</script>