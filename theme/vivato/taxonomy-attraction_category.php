<?php $td = get_template_directory_uri(); ?>
<?php get_header(); ?>

<?php 
	$cur_term = get_queried_object();
	
	global $page_title;
	$page_title = $cur_term->name . " ב" . "יוון";
	
	global $page_title_h1;
	$page_title_h1 = true;
	get_template_part( 'template-parts/top-inner' ); 
?>


<section class="attractions">
	<div class="section-inner">
		
		<div class="part-top">
			<?php 
				if(isset($location_term)):
				$content = get_content_of_attraction_category_in_location($cur_term->term_id, $location_term->term_id);
			?>
			<div class="content">
				<?=$content?>
			</div>
			<?php endif; ?>
			<?php 
				$child_terms = get_terms( array(
					'taxonomy' => 'attraction_category',
					'hide_empty' => false,
					'parent' => $cur_term->term_id
				));
				if($child_terms):
			?>
			
			<div class="filter">
				<p class="label">סנן:</p>
				<select name="filter" id="filter">
					<option value="">בחר מהרשימה</option>
					<?php 
						foreach($child_terms as $child_term):
					?>
						<option value="<?=$child_term->term_id?>"><?=$child_term->name?></option>
					<?php endforeach; ?>
				</select>
			</div>
			<?php endif; ?>
		</div>

		<div class="boxes">
			<?php 
				$args = Array(
					'post_type' => 'attraction',
					'numberposts' => -1,
					'tax_query' => array(
						array(
							'taxonomy' => 'attraction_category',
							'field' => 'term_id', 
							'terms' => $cur_term -> term_id
						)
					)
				);

								
				if(isset($location_term)) {
					$args['tax_query'][] = array(
							'taxonomy' => 'location',
							'field' => 'term_id', 
							'terms' => $location_term -> term_id
						);
				}
				
				$items = get_posts($args);
				foreach($items as $item) {
					template_attraction_box($item->ID, true);
				}
			?>
		</div>
	</div>
</section>


<script>
	$(document).ready(function ($) {
		$('select#filter').on('change', function() {
			filterProducts(this.value);
		});
	});
	
	function filterProducts(termId) {
		$(".boxes").animate({'opacity': 0}, function(){
			if(termId) {
				$(".boxes .box").each(function(){	
					var ids = $(this).attr("attraction_category").split(",");
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
<?php get_footer(); ?>