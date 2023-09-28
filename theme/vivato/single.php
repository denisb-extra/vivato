<?php $td = get_template_directory_uri(); ?>
<?php get_header(); ?>

<?php 
	$location_query = Array();
	$location_terms = get_the_terms($post, "location");
	if($location_terms) {
		$location_term = $location_terms[0];
		
		global $g_location_term;
		$g_location_term = $location_term;
		
		$location_query = array(
			array(
				'taxonomy' => 'location',
				'field' => 'term_id', 
				'terms' => $location_term -> term_id
			)
		);
	}
	
	
	
	global $page_title;
	$page_title = "מדריכים";
	get_template_part( 'template-parts/top-inner' ); 
?>


<section class="post">
	<div class="section-inner">
		<div class="parts">
			<div class="part part-main">
				<div class="content">
					<h1 class="section-title"><?=$post->post_title?></h1>
					<?php the_content(); ?>
				</div>
				<?php 
					require get_template_directory() . '/inc/panel-like-share.php';
				?>
			</div>
			<?php 
				
			?>
			
			
			<?php if(!wp_is_mobile()) : ?>
			<div class="part part-sidebar">
				<?php 
					$author_id = $post->post_author;
					$author_display_name = get_the_author_meta('display_name', $author_id);
				?>
				
				<p class="title-articles">כתבות נוספות</p>

				<div class="boxes">
					<?php 
						$args = Array(
							'post_type' => 'post',
							'numberposts' => 7,
							'author' =>  $author_id,
							'fields' => 'ids',
							'post__not_in'   => array( get_the_ID() ),
							'tax_query' => $location_query,
						);
						
						$items = get_posts($args);
						
						if(!sizeof($items)) {
							$args = Array(
								'post_type' => 'post',
								'numberposts' => 7,
								'author' =>  $author_id,
								'fields' => 'ids',
								'post__not_in'   => array( get_the_ID() ),
							);
							
							$items = get_posts($args);
						}
						foreach($items as $item) {
							template_post_sidebar_box($item);
						}
					?>
				</div>
			</div>
			<?php endif; ?>
		</div>
		
		
	</div>
</section>

<?php if(get_field('section-questions')['questions']) : ?>
<section class="questions">
	<div class="decor">
		<img src="<?=$td?>/images/inner/decor/questions.png">
	</div>
	<div class="section-inner">
		<div class="wrapper">
			<p class="section-title">שאלות <span>ותשובות</span></p>
			<div class="tabs accordion">
				<?php 
					$i=0;
					$items = get_field('section-questions')['questions'];
					foreach($items as $item):
					$i++;
				?>
					<div class="tab <?php if($i==1) echo  'active'?>">
						<div class="tab-title"><?=$item['question']?></div>
						<div class="tab-content" <?php if($i==1) echo 'style="display: block;"' ?>>
							<div class="content">
								<?=$item['answer']?>
							</div>
						</div>
					</div>
				<?php endforeach; ?>
			</div>
		</div>
	</div>
</section>
<script type="application/ld+json">
{
	"@context": "https://schema.org",
	"@type": "FAQPage",
	"isPartOf": [
		<?php
			$i=0;
			$items = get_field('section-questions')['questions'];
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
<?php endif; ?>


<section class="articles more">
	<div class="section-inner">
		<p class="section-title centered">עוד מאמרים <span>בנושא</span></p>
		<div class="boxes">
			<?php 
				$p_p = 3;
				if(wp_is_mobile()) $p_p = 4;
				$args = array(
					'post_type'             => 'post',
					'posts_per_page'        => $p_p,
					'post_status'           => 'publish',
					'ignore_sticky_posts'   => 1,
					'orderby'   => 'rand',
					'tax_query' => $location_query,
					'post__not_in'   => array( get_the_ID() ),
				);

				$posts = get_posts($args);
				
				if(!sizeof($posts)) {
					$args = array(
						'post_type'             => 'post',
						'posts_per_page'        => $p_p,
						'post_status'           => 'publish',
						'ignore_sticky_posts'   => 1,
						'orderby'   => 'rand',
						'post__not_in'   => array( get_the_ID() ),
					);

					$posts = get_posts($args);
				}
				
				foreach($posts as $mpost) {
					template_post_box($mpost->ID);
				}
			?>
		</div>
	</div>
</section>
	

<?php get_footer(); ?>