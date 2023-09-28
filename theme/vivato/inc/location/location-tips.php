
<?php 
	$text = "כל היעדים";
	if(isset($location_term)) $cur_term = $location_term;
	if(isset($cur_term)) {
		$text = $cur_term->name;
	}
?>

<section class="tips-inner">
	<div class="section-inner">
		<h2 class="section-title">טיפים והמלצות על <span><?=$text?></span></h2>

		<div class="panel-top">
			<div class="filters">
				<div class="filter">
					<p class="label">סנן לפי יעד</p>
					<select name="" id="location-select">
						<option value="<?=get_permalink(456);?>">כל היעדים</option>
						<?php 
							$terms = get_terms( array(
								'taxonomy' => 'location',
								'hide_empty' => false,
							));
							
							foreach($terms as $term):
							$url = "/טיפים/" . $term->slug;
						?>
						<option value="<?=$url?>" <?php if(isset($cur_term)) if($cur_term->term_id == $term->term_id) echo "selected" ?>><?=$term->name?></option>
						<?php endforeach; ?>
					</select>
				</div>
				<div class="filter">
					<p class="label">סנן לפי נושא</p>
					<select name="" id="subject-select">
						<option value="">כל הנושאים</option>
						<?php 
							$terms = get_terms( array(
								'taxonomy' => 'tip_subject',
								'hide_empty' => false,
							));
							
							foreach($terms as $term):
						?>
						<option value="<?=$term->term_id?>"><?=$term->name?></option>
						<?php endforeach; ?>
					</select>
				</div>
			</div>

			<a href="<?=get_permalink(442);?>" class="button-icon">
				<div class="inner">
					<img src="<?=$td?>/images/icons/attraction/pencil.svg">
					<span>הוסף טיפ</span>
				</div>
			</a>
		</div>
		<div class="boxes">
			<?php 
				$args = array(
					'post_type'             => 'tip',
					'posts_per_page'        => -1,
					'post_status'           => 'publish',
					'ignore_sticky_posts'   => 1,
					'fields' => 'ids'
				);
				
				if(isset($cur_term)) {
					$args['tax_query'] = array(
						array(
							'taxonomy' => 'location',
							'field' => 'term_id', 
							'terms' => $cur_term -> term_id
						)
					);
				}
				$items = get_posts($args);
				foreach($items as $item) {
					template_tip_inner_box($item, 'h3');
				}
			?>

		</div>
	</div>
</section>

<script>
	$(document).ready(function ($) {
		$("select#location-select").on("change", function(){
			var url = $(this).val();
			window.location = url;
		});
		
		$('select#subject-select').on('change', function() {
			filterTips(this.value);
		});
	});
	
	function filterTips(termId) {
		$(".boxes").animate({'opacity': 0}, function(){
			if(termId) {
				$(".boxes .box").each(function(){	
					var ids = $(this).attr("subject-id").split(",");
					if(ids.includes(termId)) $(this).show();
					else $(this).hide();
				});
			}
			else {
				$(".boxes .box").show();
			}
			
			$(".boxes").animate({'opacity': 1});
		});
	}
</script>