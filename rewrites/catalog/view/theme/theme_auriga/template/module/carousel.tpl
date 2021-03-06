<div class="carousel-contain">
	<div class="brand-slider-contain">
			<div id="carousel1<?php echo $module; ?>" class="">
				  <ul class="slides">
					<?php foreach ($banners as $banner) { ?>
					<?php if ($banner['link']) { ?>
					<li><a href="<?php echo $banner['link']; ?>"><img src="<?php echo $banner['image']; ?>" alt="<?php echo $banner['title']; ?>" class="img-responsive" /></a></li>
					<?php } else { ?>
					<li><img src="<?php echo $banner['image']; ?>" alt="<?php echo $banner['title']; ?>" class="img-responsive" /></li>
					<?php } ?>
					<?php } ?>
				  </ul>
			</div>
	</div>
</div>

<script type="text/javascript">$( document ).ready(function() {
$('#carousel1<?php echo $module; ?> .slides').owlCarousel({
	autoPlay: 5000, //Set AutoPlay to 3 seconds
	slideSpeed :1000,
	navigation : true,
	paginationNumbers : true,
	pagination : false,
	stopOnHover : false,
	items :4, //10 items above 1000px browser width
	itemsDesktop : [1000,4], //5 items between 1000px and 901px
	itemsDesktopSmall : [900,3], // betweem 900px and 601px
	itemsTablet: [600,2], //2 items between 600 and 0
	itemsMobile : [320,1] // itemsMobile disabled - inherit from itemsTablet option
	});
});
</script>
