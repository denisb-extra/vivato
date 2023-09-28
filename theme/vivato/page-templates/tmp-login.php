<?php
    // Template Name: Login Page
?>

<?php $td = get_template_directory_uri(); ?>

<?php get_header(); ?>
<section class="login">
	<div class="section-inner">
		<p class="section-title centered">התחברות <span>למערכת</span></p>
		<br>
		<div class="content white centered">
			<?php 
				$user = wp_get_current_user();
				if(isset($user->data->ID)):
			?>
			<p>אתה כבר מחובר למערכת</p>
			<div class="buttons-panel">
				<a class="button" href="<?=wp_logout_url(get_home_url());?>">התנתק</a>
			</div>
			<?php else : ?>
			
			<?=do_shortcode('[login-form]')?>
			<div class="buttons-panel">
				<a class="button" href="<?=get_permalink(464);?>">הרשמה לאתר</a>
				<a class="button" href="<?=get_permalink(401);?>">הרשם כבלוגר</a>
			</div>
			<?php endif; ?>
		</div>
	</div>
</section>
<?php get_footer(); ?>