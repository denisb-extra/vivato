<?php
    // Template Name: Sitemap Page
?>
<?php $td = get_template_directory_uri(); ?>
<?php get_header(); ?>

<?php 
	global $page_title_h1;
	$page_title_h1 = true;
	get_template_part( 'template-parts/top-inner' ); 
?>

<section class="post sitemap">
	<div class="section-inner">
		<div class="content">
			<?php 
				$pages = [
					[2, ""],
					[4369, ""],
					[60, ""],
					[10, ""],
					[8, ""],
					[12, "פורום יוון"],
					[20, "מדריכים על יוון"],
					[16, "בלוג מטיילים ביוון"],
					[456, "טיפים לטיולים ביוון"],
					[4356, ""],
				];
			?>
			<h2>תפריט ניווט ראשי</h2>
			<ul>
				<?php 
					foreach($pages as $page_id):
					$page = get_post($page_id[0]);
					$title = $page -> post_title;
					if($page_id[1]) $title = $page_id[1];
					
				?>
					<li><a href="<?=get_permalink($page);?>"><?=$title?></a></li>
				<?php endforeach; ?>
			</ul>
			
			
			<?php 
				$pages = [
					[544, ""],
					[538, ""],
					[4127, ""],
				];
			?>
			
			<br>
			<h2>שימושון</h2>
			<ul>
				<?php 
					foreach($pages as $page_id):
					$page = get_post($page_id[0]);
					$title = $page -> post_title;
					if($page_id[1]) $title = $page_id[1];
					
				?>
					<li><a href="<?=get_permalink($page);?>"><?=$title?></a></li>
				<?php endforeach; ?>
			</ul>
			
			<br>
			<h2>מומלצים</h2>
			<ul>
			<?php 
				$args = array(
					'post_type'             => 'recommended',
					'posts_per_page'        => -1,
					'post_status'           => 'publish',
					'ignore_sticky_posts'   => 1,
				);
				
				$items = get_posts($args);
				
				foreach($items as $item):
			?>
				<li><a href="<?=get_permalink($item);?>"><?=$item->post_title?></a></li>
			<?php endforeach; ?>
			</ul>
			
			<br>
			<h2>יעדים</h2>
			<ul>
				<?php 
					$terms = get_terms( array(
						'taxonomy' => 'location',
						'hide_empty' => false,
						'exclude' => 1, 
						'parent' => 0
					));
					
					foreach($terms as $term):
				?>
				<li><a href="<?=get_term_link($term);?>"><?=$term->name?></a></li>
				<?php endforeach; ?>
			</ul>
			
			<br>
			<h2>בתי מלון לפי יעד</h2>
			<ul>
				<?php 
					$terms = get_terms( array(
						'taxonomy' => 'location',
						'hide_empty' => false,
						'exclude' => 1, 
						'parent' => 0
					));
					
					foreach($terms as $term):
					$text = "בתי מלון ב" . $term->name;
					$link = "/בתי-מלון/" . $term->slug . "/";
				?>
				<li><a href="<?=$link;?>"><?=$text?></a></li>
				<?php endforeach; ?>
			</ul>
			
			<br>
			<h2>אטרקציות לפי יעד</h2>
			<ul>
				<?php 
					$terms = get_terms( array(
						'taxonomy' => 'location',
						'hide_empty' => false,
						'exclude' => 1, 
						'parent' => 0
					));
					
					foreach($terms as $term):
					$text = "אטרקציות ב" . $term->name;
					$link = "/אטרקציות/" . $term->slug . "/";
				?>
				<li><a href="<?=$link;?>"><?=$text?></a></li>
				<?php endforeach; ?>
			</ul>
			
			<br>
			<h2>סוגי אטרקציות לפי יעד</h2>
			<ul>
				<?php 
					$terms = get_terms( array(
						'taxonomy' => 'location',
						'hide_empty' => false,
						'exclude' => 1, 
						'parent' => 0
					));
					
					$sub_terms = get_terms( array(
						'taxonomy'   => 'attraction_category',
						'hide_empty' => false,
						'parent' => 0
					));
					
					foreach($terms as $term):
					foreach($sub_terms as $sub_term):
					$text = $sub_term->name . " ב" . $term->name;
					$link = "/אטרקציות/" . $term->slug . "/" . $sub_term->slug . "/";
				?>
				<li><a href="<?=$link;?>"><?=$text?></a></li>
				<?php endforeach; ?>
				<?php endforeach; ?>
			</ul>
			
			<br>
			<h2>מדריכים לפי יעד </h2>
			<ul>
				<?php 
					$terms = get_terms( array(
						'taxonomy' => 'location',
						'hide_empty' => false,
						'exclude' => 1, 
						'parent' => 0
					));
					
					foreach($terms as $term):
					$text = "מדריכים על " . $term->name;
					$link = "/מדריכים/" . $term->slug . "/"; 
				?>
				<li><a href="<?=$link;?>"><?=$text?></a></li>
				<?php endforeach; ?>
			</ul>
			
			<br>
			<h2>פורום לפי יעד</h2>
			<ul>
				<?php 
					$terms = get_terms( array(
						'taxonomy' => 'location',
						'hide_empty' => false,
						'exclude' => 1, 
						'parent' => 0
					));
					
					foreach($terms as $term):
					$text = "פורום " . $term->name;
					$link = get_permalink(12) . "forum/" . $term->slug . "/"
				?>
				<li><a href="<?=$link;?>"><?=$text?></a></li>
				<?php endforeach; ?>
			</ul>
			
			<br>
			<h2>טיפים לפי יעד </h2>
			<ul>
				<?php 
					$terms = get_terms( array(
						'taxonomy' => 'location',
						'hide_empty' => true,
						'exclude' => 1, 
						'parent' => 0
					));
					
					foreach($terms as $term):
					$text = "טיפים על " . $term->name;
					$link = "/טיפים/" . $term->slug . "/";
				?>
				<li><a href="<?=$link;?>"><?=$text?></a></li>
				<?php endforeach; ?>
			</ul>
			
			
			<br>
			<h2>מדריכים לפי קטגוריה</h2>
			<ul>
				<?php 
					$terms = get_terms( array(
						'taxonomy' => 'category',
						'hide_empty' => false,
						'exclude' => 1, 
						'parent' => 0
					));
					
					foreach($terms as $term):
				?>
				<li><a href="<?=get_term_link($term);?>"><?=$term->name?> ביוון</a></li>
				<?php endforeach; ?>
			</ul>
			
			<br>
			<h2>מדריכים לפי קטגוריה ויעד</h2>
			<ul>
				<?php 
					$terms = get_terms( array(
						'taxonomy' => 'location',
						'hide_empty' => true,
						'exclude' => 1, 
						'parent' => 0
					));
					
					$sub_terms = get_terms( array(
						'taxonomy'   => 'category',
						'hide_empty' => true,
						'parent' => 0
					));
					
					foreach($terms as $term):
					foreach($sub_terms as $sub_term):
					$text = "מדריכים " . $sub_term->name . " ב" . $term->name;
					$link = "/מדריכים/" . $term->slug . "/" . $sub_term->slug . "/";
				?>
				<li><a href="<?=$link;?>"><?=$text?></a></li>
				<?php endforeach; ?>
				<?php endforeach; ?>
			</ul>
		</div>
	</div>
</section>
	
<?php get_footer(); ?>