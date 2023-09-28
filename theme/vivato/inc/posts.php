<?php
	if(isset($_GET['location_id'])) {
		$location_term = get_term($_GET['location_id']);
	}
	if(!isset($cur_term)) {
		$args = array(
			'post_type'             => 'post',
			'posts_per_page'        => -1,
			'post_status'           => 'publish',
			'ignore_sticky_posts'   => 1,
		);
	}
	else {
		$args = Array(
			'post_type' => 'post',
			'numberposts' => -1,
			'tax_query' => array(
				array(
					'taxonomy' => 'category',
					'field' => 'term_id', 
					'terms' => $cur_term -> term_id
				)
			)
		);
	}
	
	if(isset($location_term)) {
		$args['tax_query'][] = array(
					'taxonomy' => 'location',
					'field' => 'term_id', 
					'terms' => $location_term -> term_id
				);
	}
	
	$items = get_posts($args);
	if($items):
	
	wp_reset_postdata();
	wp_reset_query();
?>

<section class="articles">
	<div class="section-inner">
		<div class="grid">
			<div class="sidebar">
				<div class="filter hidden">
					<h2 class="title">יעדים</h2>
					<div class="items">
						<?php
							$terms = get_terms( array(
								'taxonomy' => 'location',
								'hide_empty' => false,
								'exclude' => 1, 
								'parent' => 0
							));
							
							foreach($terms as $term):
							$f = get_field("icon", $term);
							
							$link = "/מדריכים/" . $term->slug . "/";
							if(isset($cur_term)) $link .=  $cur_term->slug . "/";
						?>
							<a href="<?=$link?>" class="item <?php if(isset($location_term) && $location_term->term_id == $term->term_id) echo "active"?>">
								<?php if($f) : ?>
								<div class="icon">
									<img src="<?=$f["url"]?>" alt="<?=$f["alt"]?>" title="<?=$f["title"]?>">
								</div>
								<?php endif; ?>
								<h3><?=$term->name?></h3>
							</a>
						<?php endforeach; ?>
					</div>
				</div>
				
				<div class="filter">
					<h2 class="title">סינון כתבות ומדריכים</h2>
					<div class="items">
						<?php
							$terms = get_terms( array(
								'taxonomy' => 'category',
								'hide_empty' => false,
								'exclude' => 1, 
								'parent' => 0
							));
							
							foreach($terms as $term):
							$f = get_field("icon", $term);
							
							$link = get_term_link($term);
							if(isset($location_term)) $link = "/מדריכים/" . $location_term->slug . "/" . $term->slug . "/";
						?>
							<a href="<?=$link?>" class="item <?php if($cur_term->term_id == $term->term_id) echo "active"?>">
								<?php if($f) : ?>
								<div class="icon">
									<img src="<?=$f["url"]?>" alt="<?=$term->name?>" title="<?=$term->name?>">
								</div>
								<?php endif; ?>
								<h3><?=$term->name?></h3>
							</a>
						<?php endforeach; ?>
					</div>
					<?php if(isset($location_term) || isset($cur_term)) : ?>
					<a class="button button-viva" href="<?=get_permalink(20);?>">
						<span>איפוס מידע</span>
					</a>
					<?php endif; ?>
				</div>
			</div>
			<div class="main">
				<?php 
					if(isset($location_term) && isset($cur_term)):
					$content = get_content_of_posts_category_in_location($cur_term->term_id, $location_term->term_id);
					if(isset($content['content'])):
				?>
				<div class="content">
					<?=$content['content']?>
				</div>
				<br><br>
				<?php endif; ?>
				<?php endif; ?>
				
				
				<div class="boxes">
					<?php
						foreach($items as $item) {
							template_post_box($item->ID, "h3");
						}
					?>
				</div>
				
				
				<?php if(isset($content['content-bottom'])) : ?>
				<div class="content-bottom">
					<div class="content">
						<?=$content['content-bottom']?>
					</div>
				</div>
				<?php endif; ?>
			</div>
		</div>
	</div>
</section>

<script>
	$(document).ready(function ($) {
		if($(window).width() <= 950) {
			$(".sidebar .filter .title").on("click", function(){
				var cont = $(this).closest(".filter");
				$(".items", cont).slideToggle();
			});
		}
		else {
			$(".sidebar .filter.hidden .title").on("click", function(){
				var cont = $(this).closest(".filter");
				$(".items", cont).slideToggle();
			});
		}
	});
</script>
<?php endif; ?>