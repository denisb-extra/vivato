<?php $td = get_template_directory_uri(); ?>

<?php 
	global $wp_query;
	
	if(isset($wp_query->query_vars['blogger_slug'])) {
		$blogger_slug = $wp_query->query_vars['blogger_slug'];
		$user = get_user_by( 'slug', $blogger_slug );
		
		$author_id = $user -> ID;
	}
	else {
		$author_id = 1;
	}
	
	$author_display_name = get_the_author_meta('display_name', $author_id);

	
	$meta = get_user_meta($author_id);
	$avatar_id = $meta['user_avatar'][0];
	$avatar_url = wp_get_attachment_image_src( $avatar_id, 'thumb-cube-bigger' )[0];
	
	$text_about = get_user_meta($author_id, "about", true);
	$profession = get_user_meta($author_id, "profession", true);
	$phone = get_user_meta($author_id, "phone", true);
	$website = get_user_meta($author_id, "website", true);
	$facebook = get_user_meta($author_id, "facebook", true);
	$linked_in = get_user_meta($author_id, "linked_in", true);
	$instagram = get_user_meta($author_id, "instagram", true);
	

	$blogger_post_id = get_blogger_post_id($author_id);
	
	$count = get_posts_views_likes_number_of_author($author_id);
	
	global $meta_title;
	$meta_title = "הבלוג של " . $author_display_name . " - " . get_bloginfo( 'name' ) . ", השער שלך ליוון!";
	global $meta_description;
	$meta_description = make_short($text_about, 30);
	
	
	
	global $meta_canonical;
	$meta_canonical = get_home_url() . "/בלוגר/" .  $blogger_slug . "/";
	
	
	global $my_bradcrumbs;
	$my_bradcrumbs = [];
	$my_bradcrumbs[] = array(
		'url' => get_home_url(),
		'text' => 'בית',
	);
	$my_bradcrumbs[] = array(
		'url' => get_permalink(16),
		'text' => 'בלוג מטיילים',
	);

	$my_bradcrumbs[] = array(
		'url' => '',
		'text' => "הבלוג של " . $author_display_name,
	);
?>

<?php get_header(); ?>

<?php 
	global $page_title;
	$page_title = "בלוג מטיילים";
	
	get_template_part( 'template-parts/top-inner' ); 
?>


<section class="blogger-info">
	<div class="section-inner">
		<div class="part-image">
			<div class="image">
				<img src="<?=$avatar_url?>">
			</div>
		</div>
		<div class="part-text">
			<div class="part-top">
				<h1 class="title">
					בלוג של
					<?=$author_display_name?>
				</h1>
				<div class="reward">
					<img src="<?=$td?>/images/icons/prize.svg">
				</div>
				
				<?php if(is_user_logged_in()) : ?>
				<div class="button-follow cont-like">
					<?= do_shortcode("[wp_ulike id='$blogger_post_id']"); ?>
					<span>עקבו אחריי</span>
				</div>
				<?php else : ?>
					<a href="<?=get_permalink(462)?>" class="button-follow">
						<img src="<?=$td?>/images/icons/heart-empty.svg">
						<span>עקבו אחריי</span>
					</a>
				<?php endif; ?>
				
			</div>
			<div class="content">
				<?=$text_about?>
			</div>

			<div class="part-bottom">
				<div class="info">
					<p><strong>שם:</strong> <?=$author_display_name?></p>
					<?php if($profession) : ?>
						<p><strong>מקצוע:</strong> <?=$profession?></p>
					<?php endif; ?>
					<?php if($phone) : ?>
						<p><strong>טלפון:</strong> <?=$phone?></p>
					<?php endif; ?>
					<?php if($website) : ?>
						<p><strong>כתובת אתר:</strong> <?=$website?></p>
					<?php endif; ?>
					<?php if($facebook || $linked_in || $instagram) : ?>
					<div class="social">
						<span><strong>רשתות חברתיות:</strong></span>
						<?php if($facebook) : ?>
							<a href="<?=$facebook?>" target="_blank"><img src="<?=$td?>/images/icons/social-dark/fb.svg"></a>
						<?php endif; ?>
						<?php if($linked_in) : ?>
							<a href="<?=$linked_in?>" target="_blank"><img src="<?=$td?>/images/icons/social-dark/ln.svg"></a>
						<?php endif; ?>
						<?php if($instagram) : ?>
							<a href="<?=$instagram?>" target="_blank"><img src="<?=$td?>/images/icons/social-dark/inst.svg"></a>
						<?php endif; ?>
					</div>
					<?php endif; ?>
				</div>

				<div class="boxes-numbers">
					<div class="boxes">
						<div class="box">
							<div class="inner">
								<p class="number"><?=$count['likes'];?></p>
								<p class="text">לייקים</p>
							</div>
						</div>
						<div class="box">
							<div class="inner">
								<p class="number"><?=get_followers_number_of_author($author_id);?></p>
								<p class="text">עוקבים</p>
							</div>
						</div>
						<div class="box">
							<div class="inner">
								<p class="number"><?=$count['views'];?></p>
								<p class="text">צפיות</p>
							</div>
						</div>
						<div class="box">
							<div class="inner">
								<p class="number"><?=$count['posts']?></p>
								<p class="text">פוסטים</p>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>

<section class="blogger-stories">
	<div class="section-inner">
		<div class="boxes">
			<?php 
				$args = Array(
					'post_type' => 'blogger-story',
					'numberposts' => -1,
					'author' =>  $author_id,
					'fields' => 'ids',
				);
				
				$items = get_posts($args);
				foreach($items as $item) {
					template_blogger_story_blogger_page_box($item);
				}
			?>	
		</div>
	</div>
</section>



<?php get_footer(); ?>
