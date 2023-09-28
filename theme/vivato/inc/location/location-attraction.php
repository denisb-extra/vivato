<?php 
	$terms = get_terms( array(
		'taxonomy'   => 'attraction_category',
		'parent' => 0,
		'hide_empty' => true,
	));
?>

<div class="panel-side">
	<div class="items">
		<?php 
			$i = 0;
			foreach($terms as $term):
			$i++;
		?>
		<div class="item" scroll-to-id="s<?=$i?>">
			<div class="icon">
				<?php 
					$f = get_field("icon", $term);
				?>
				<img src="<?=$f["url"]?>" alt="<?=$f["alt"]?>" title="<?=$f["title"]?>">
			</div>
			<span><?=$term->name?></span>
		</div>
		<?php endforeach; ?>
	</div>
</div>

<?php 
	$i = 0;
	foreach($terms as $term):
	$i++;
	
	$args = Array(
		'post_type' => 'attraction',
		'numberposts' => 8,
		'tax_query' => array(
			array(
				'taxonomy' => 'location',
				'field' => 'term_id', 
				'terms' => $location_term -> term_id
			),
			array(
				'taxonomy' => 'attraction_category',
				'field' => 'term_id', 
				'terms' => $term -> term_id
			),
		)
	);
	$items = get_posts($args);
	if($items) :
?>

<section class="attractions" id="s<?=$i?>">
	<div class="section-inner">
		<h2 class="section-title centered"><?=hl_last_word($term->name . " ב" . $location_term->name)?></h2>

		<div class="boxes">
			<?php 
				
				foreach($items as $item) {
					template_attraction_box($item->ID);
				}
			?>
		</div>

		<div class="cont-button">
			<?php 
				$link = "/אטרקציות/" . $location_term->slug . "/" . $term->slug . "/";
			?>
			
			<a href="<?=$link?>" class="button-icon">
				<div class="inner">
					<?php 
						$f = get_field("icon", $term);
						if(!$f) $f = get_field("general", 'options')['image-placeholder'];
					?> 
					<img src="<?=$f["url"]?>" alt="<?=$f["alt"]?>" title="<?=$f["title"]?>">
					<span>לכל ה<?=$term->name?> ב<?=$location_term->name?></span>
				</div>
			</a>
		</div>
	</div>
</section>
<?php endif; ?>
<?php endforeach; ?>

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
		
		$(".panel-side .item").each(function(){
			$("span", this).height($("span", this).height());
			$(this).height($(this).height());
		});
		
		$("[scroll-to-id]").each(function(){
			var trgt = "#" + $(this).attr('scroll-to-id');
			if(!$(trgt).length)$(this).hide();
		});
		
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


		$("[scroll-to-id]").on("click", function(){
			var trgt = "#" + $(this).attr('scroll-to-id');
			$('html, body').animate({
				scrollTop: $(trgt).offset().top
			}, 1000);
		});
	});
</script>