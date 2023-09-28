<?php
    // Template Name: Profile Page
?>

<?php $td = get_template_directory_uri(); ?>
<?php get_header(); ?>

<?php 
	global $page_title_h1;
	$page_title_h1 = true;
	get_template_part( 'template-parts/top-inner' ); 
?>


<?php 
	$role = "";
	$user = wp_get_current_user();
	if(isset($user->data->ID)) {

		if(in_array("blogger", $user->roles)) $role = "blogger";
		elseif(in_array("subscriber", $user->roles)) $role = "subscriber";
	}
	
	$author_id = $user -> ID;
	$author_display_name = get_the_author_meta('display_name', $author_id);
?>

<?php if($role == "blogger") : ?>
<section class="profile profile-blogger wpuf-form">
	<div class="section-inner">
		<div class="content">
			<?=do_shortcode('[wpuf_profile type="profile" id="393"]')?>
			
			<div class="buttons-panel">
				<a class="button" href="<?=get_permalink(384);?>">כתיבת סיפור בלוגר</a>
				<a class="button" href="<?=wp_logout_url(get_home_url());?>">התנתק</a>
			</div>
		</div>
	</div>
</section>
<?php else : ?>
<section class="profile profile-subscriber wpuf-form">
	<div class="section-inner">
		<div class="content">
			<?=do_shortcode('[wpuf_profile type="profile" id="466"]')?>
			
			<div class="buttons-panel">
				<a class="button" href="<?=get_permalink(442);?>">כתיבת טיפ לטיול</a>
				<a class="button" href="<?=wp_logout_url(get_home_url());?>">התנתק</a>
			</div>
		</div>
	</div>
</section>
<?php endif; ?>

<?php if($post->post_content) : ?>
<section class="post">
	<div class="section-inner">
		<div class="content">
			<?php the_content(); ?>
		</div>
	</div>
</section>
<?php endif; ?>


<?php 
	$args = array(
		'post_type'             => 'tip',
		'posts_per_page'        => -1,
		'post_status'           => 'publish',
		'ignore_sticky_posts'   => 1,
		'author' =>  $author_id,
		'fields' => 'ids'
	);

	$items = get_posts($args);
	if($items) :
?>

<section class="tips-inner">
	<div class="section-inner">
		<h2 class="section-title">טיפים והמלצות של <span><?=$author_display_name?></span></h2>

		<div class="boxes">
			<?php 
				
				foreach($items as $item) {
					template_tip_inner_profile_box($item);
				}
			?>

		</div>
	</div>
</section>
<?php endif; ?>

<?php 
	$args = Array(
		'post_type' => 'blogger-story',
		'numberposts' => -1,
		'author' =>  $author_id,
		'fields' => 'ids',
	);
	$items = get_posts($args);
	if($items) :
?>

<section class="blogger-stories">
	<div class="section-inner">
		<h2 class="section-title">סיפורי בלוג של <span><?=$author_display_name?></span></h2>
		<div class="boxes">
			<?php 
				foreach($items as $item) {
					template_blogger_story_profile_page_box($item);
				}
			?>	
		</div>
	</div>
</section>
<?php endif; ?>
<?php get_footer(); ?>