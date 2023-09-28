<?php
    // Template Name: Currency Converter Page
?>
<?php $td = get_template_directory_uri(); ?>
<?php get_header(); ?>

<?php 
	global $page_title_h1;
	$page_title_h1 = true;
	get_template_part( 'template-parts/top-inner' ); 
?>

<section class="currency">
	<div class="section-inner">
		<p class="section-subtitle centered"><?=get_field('title')?></p>
	
		<div class="wrapper-converter">
			<div class="row-item">
				<input type="number" id="input-sum" placeholder="הזן סכום">
			</div>
			<div class="row-item">
				<?php 
					$items = get_field('coins');
					$item = $items[1];
				?>
				
				<div class="selector" id="cur-1">
					<p class="title">
						<?php $f = $item['flag']; ?> 
						<img src="<?=$f["url"]?>" alt="<?=$f["alt"]?>" title="<?=$f["title"]?>">
						<span><?=$item['name']?></span>
					</p>
					<div class="dropdown">
						<div class="items">
							<?php 
								$i = 0;
								foreach($items as $item):
								$i++;
							?>
								<div class="item <?php if($i==2) echo "selected" ?>" rate="<?=$item['rate']?>" cid="<?=$item['id']?>">
									<?php $f = $item['flag']; ?> 
									<img src="<?=$f["url"]?>" alt="<?=$f["alt"]?>" title="<?=$f["title"]?>">
									<span><?=$item['name']?></span>
								</div>
							<?php endforeach; ?>
						</div>
					</div>
				</div>
			</div>

			<div class="row-item no-grow icon">
				<div class="button-convert">
					<img src="<?=$td?>/images/icons/flip.svg">
				</div>
			</div>

			<div class="row-item">
				<?php 
					$item = $items[0];
				?>
				
				<div class="selector" id="cur-2">
					<p class="title">
						<?php $f = $item['flag']; ?> 
						<img src="<?=$f["url"]?>" alt="<?=$f["alt"]?>" title="<?=$f["title"]?>">
						<span><?=$item['name']?></span>
					</p>
					<div class="dropdown">
						<div class="items">
							<?php 
								$i = 0;
								foreach($items as $item):
								$i++;
							?>
								<div class="item <?php if($i==1) echo "selected" ?>" rate="<?=$item['rate']?>" cid="<?=$item['id']?>">
									<?php $f = $item['flag']; ?> 
									<img src="<?=$f["url"]?>" alt="<?=$f["alt"]?>" title="<?=$f["title"]?>">
									<span><?=$item['name']?></span>
								</div>
							<?php endforeach; ?>
						</div>
					</div>
				</div>
			</div>

			<div class="row-item">
				<div class="button-yellow">
					<span>חשב</span>
				</div>
			</div>
		</div>

		<div class="wrapper-result">
			<p class="result"></p>
		</div>
		<p class="remark">השער עדכני ל: <?= date(get_option( 'date_format' )); ?></p>
	</div>
</section>

<script>
	$(document).ready(function ($) {
		$(".selector .title").on("click", function(){
			let cont = $(this).closest(".selector");
			$(".dropdown", cont).toggleClass("open");
		});

		$(document).click(function(event) { 
			$target = $(event.target);
			if(!$target.closest('.selector').length) {
				$(".selector .dropdown").removeClass("open");
			}
		});

		$(".selector .items .item").click(function(){
			let cont = $(this).closest(".selector");
			$(".items .item", cont).removeClass("selected");
			$(this).addClass("selected");

			let cn = $(this).html();

			$(".title", cont).html(cn);
		
			$(".dropdown", cont).removeClass("open");
			calculate();
		});
		
		$('#input-sum').keyup(function() {
			calculate();
		});
		
		$(".button-yellow").on("click", function() {
			calculate();
		});
		
		
		calculate();
		
		$(".button-convert").on("click", function(){
			var curNameFrom = $("#cur-1 .items .item.selected").attr('cid');
			var curNameTo = $("#cur-2 .items .item.selected").attr('cid');
			
			$("#cur-1 .items .item").removeClass("selected");
			$("#cur-1 .items .item[cid="+curNameTo+"]").click();
			
			$("#cur-2 .items .item").removeClass("selected");
			$("#cur-2 .items .item[cid="+curNameFrom+"]").click();
			
			
			$(".button-convert").addClass("spin");
			setTimeout(function(){
				$(".button-convert").removeClass("spin");
			}, 500);
			calculate();
		});
		
	});
	
	function calculate() {
		console.log('calc');
		
		var inputSum = Number($('#input-sum').val());
		if(!inputSum) inputSum = 1;
		console.log(inputSum);
		
		var curNameFrom = $("#cur-1 .items .item.selected").attr('cid');
		var curNameTo = $("#cur-2 .items .item.selected").attr('cid');
		
		
		var rateFrom = Number($("#cur-1 .items .item.selected").attr('rate'));
		var rateTo = Number($("#cur-2 .items .item.selected").attr('rate'));
		console.log(rateFrom);
		console.log(rateTo);
		var convertedSum = (rateFrom / rateTo) * inputSum;
		convertedSum = Math.round(convertedSum * 100) / 100;
		var textResult = inputSum + " " + curNameFrom + " = " + convertedSum + " " + curNameTo;
		
		$(".result").text(textResult);
	}
</script>
	
<?php get_footer(); ?>