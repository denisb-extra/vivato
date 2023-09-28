<?php $td = get_template_directory_uri(); ?>

<?php if(get_cur_template() != "tmp-contact.php") : ?>
<?php endif; ?>


<footer>
	<div class="part-top">
		<div class="section-inner">
			<div class="cont-form subscribe">
				<div class="text">
					<p>רוצים להשאר מעודכנים <Br> הרשמו עכשיו</p>
				</div>
				<?=do_shortcode('[contact-form-7 id="65" title="טופס הרשמה"]')?>
			</div>
			<div class="cols">
				<?php
					$cols = get_field("footer", "options")['cols_footer'];
					foreach($cols as $col):
				?>
					<div class="col">
						<?php if($col['title']) : ?>
						<p class="title"><?=$col['title']?></p>
						<?php endif; ?>
						<div class="content">
							<?=$col['content']?>
						</div>
					</div>
				<?php endforeach; ?>
			</div>
		</div>
	</div>

	<div class="part-bottom">
		
		<div class="section-inner">
			<div class="top">
				<a class="logo" href="<?=get_home_url();?>/">
					<?php $f = get_field('footer', 'options')['logo']; ?> 
					<img src="<?=$f["url"]?>" alt="<?=$f["alt"]?>" title="<?=$f["title"]?>">
				</a>
				
				<?php 
					$args = array(
						'theme_location'  => 'footer-menu',
						'container_class' => 'menu-cont',
						'menu_class'      => 'main-menu',
					);
					wp_nav_menu( $args );
				?>

				<div class="social">
					<?php 
						$items = get_field('footer', 'options')['social'];
						foreach($items as $item):
					?>
						<a href="<?=$item['url']?>" class="link" target="_blank">
							<?php $f = $item['icon']; ?> 
							<img src="<?=$f["url"]?>" alt="<?=$f["alt"]?>" title="<?=$f["title"]?>">
						</a>
					<?php endforeach; ?>
				</div>
			</div>
			<div class="bottom">
				<p class="copyright">כל הזכויות שמורות ל-VIVATO GREECE 2023 </p>
				<?php 
					$items = get_field('footer', 'options')['more-links'];
					foreach($items as $item):
				?>
					 <div class="sep"></div>
					 <p class="credit"><a href="<?=$item['url']?>"><?=$item['text']?></a></p>
				<?php endforeach; ?>
           
			
			<?php if(false) : ?>
			<p class="credit">עיצוב ובניית אתרים<a class="logoextra" href="https://extra.co.il/" target="_blank">
					<svg xmlns="http://www.w3.org/2000/svg" width="44.276" height="14.007" viewBox="0 0 44.276 14.007">
						<path id="logoextra" d="M892.015,509.994V512.2h6.571v1.876l-6.271-.011L890.7,515.6v4.159l1.6,1.479,7.118.011,1.5-1.479.011-8.372-1.544-1.436-7.365.032m1.158,6.239,5.306.011V518.9l-5.306-.011V516.23m-1.983-3.988.011-2.283h-5.735l-1.522,1.351-.011,9.894h2.423l-.011-8.962H891.2m-11.5-5h-2.358l.011,12.467,1.479,1.479h3.838l.011-2.187-2.937.011v-6.764l2.98-.021v-2.3l-3.012.011-.011-2.691m-2.98,2.766L873.982,510l-2.2,3.312-2.24-3.387-2.83-.011,3.655,5.263-4.149,6.014,2.894-.011,2.616-3.934,2.723,3.988,2.841.011-4.213-5.992,3.634-5.242m-18.46-.086-1.6,1.426v8.426l1.5,1.415h7.44v-2.208l-6.5.011V517.08l6.357-.011,1.458-1.4v-4.191l-1.49-1.533-7.172-.011m.815,4.888v-2.637l5.349.011v2.616Z" transform="translate(-856.653 -507.242)" fill="#ffffff"/>
					</svg>  
			</a> דיגיטל</p>
			<?php endif; ?>
			</div>
		</div>
	</div>
</footer>


<?php if(false) : ?>
<div class="button-mistake">
	<?php 
		$f = get_field('footer', 'options')['mistake']['button-image']['desktop']; 
		if(wp_is_mobile() && get_field('footer', 'options')['mistake']['button-image']['mobile']) $f = get_field('footer', 'options')['mistake']['button-image']['mobile']; 
	?> 
	<img src="<?=$f["url"]?>" alt="<?=$f["alt"]?>" title="<?=$f["title"]?>">>
</div>
<?php endif; ?>

<div class="popup popup-mistake">
	<div class="inner">
		<div class="wrapper">
			<div class="close">
				<img src="<?=$td?>/images/icons/close-w.svg">
			</div>
			<div class="container">
				<p class="section-title centered white"><?=get_field('footer', 'options')['mistake']['title']?></p>
				<div class="content white centered">
					<?=get_field('footer', 'options')['mistake']['text']?>
				</div>

				<?=do_shortcode('[contact-form-7 id="'.get_field('footer', 'options')['mistake']['form'].'" title="טופס טעות בתוכן"]');?>
			</div>
		</div>
	</div>
</div>



</main>
<div class="scripts">
<?php wp_footer(); ?>
</div>
<script src="https://cdn.userway.org/widget.js" data-account="oXdZJS4DNj"></script>
</body>
</html>