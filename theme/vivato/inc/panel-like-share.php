<?php 
	$id = $post->ID;
?>

<div class="pannel-like-share">
	<p class="title">אהבתם? <span>שתפו</span></p>

	<div class="share">
		<!-- AddToAny BEGIN -->
		<div class="a2a_kit a2a_kit_size_32 a2a_default_style">
		<a class="a2a_button_whatsapp"></a>
		<a class="a2a_button_facebook"></a>
		<a class="a2a_button_telegram"></a>
		</div>
		<script async src="https://static.addtoany.com/menu/page.js"></script>
		<!-- AddToAny END -->
	</div>
	
	
	<?php if(is_user_logged_in()) : ?>
		<div  class="button-icon cont-like">
			<div class="inner">
				<?= do_shortcode("[wp_ulike id='$id']"); ?>
				<span>להוסיף לטיול שלי</span>
			</div>
		</div>
	<?php else : ?>
		<a href="<?=get_permalink(462)?>" class="button-icon">
			<div class="inner">
				<img src="<?=$td?>/images/icons/heart-empty.svg">
				<span>להוסיף לטיול שלי</span>
			</div>
		</a>
	<?php endif; ?>
</div>

<a class="button-popup">התוכן עזר לכם? יש לכם הערות? <span>לחצו כאן</span></a>