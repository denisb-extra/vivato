
<section class="attractions">
	<div class="section-inner">
		
		<div class="part-top">
			<?php 
				if(isset($location_term)):
				$content = get_content_of_attraction_category_in_location($category_term->term_id, $location_term->term_id);
				if(isset($content['content'])):
			?>
			<div class="content">
				<?=$content['content']?>
			</div>
			<?php endif; ?>
			<?php endif; ?>
			<?php 
				$child_terms = get_terms( array(
					'taxonomy' => 'attraction_category',
					'hide_empty' => false,
					'parent' => $category_term->term_id
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
							'terms' => $category_term -> term_id
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
		
		<?php if(isset($content['content-bottom'])) : ?>
		<div class="content-bottom">
			<div class="content">
				<?=$content['content-bottom']?>
			</div>
		</div>
		<?php endif; ?>
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