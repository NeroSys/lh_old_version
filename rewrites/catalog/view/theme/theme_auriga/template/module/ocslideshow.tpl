<div class="banner7">
<div class= "oc-banner7-container">
	<div class="flexslider oc-nivoslider">
        <div class="oc-loading"></div>
		<div id="oc-inivoslider" class="slides">
			
				<?php
					$slides = $data['ocslideshows']; 
					$config = $slide_setting[0]; 
				
					$i = 1;
					foreach($slides as $s) {
					
				?>
						<a href="<?php echo $s['link']?>" title="<?php echo 'Перейти' ?>"><img style="display: none;" src="<?php echo $s['image']; ?>" alt="" title="#banner7-caption<?php echo $i; ?>"  /></a>
				<?php 		
					$i ++;				
			        } 
				?>
		</div>

				<?php
					$i = 1;
					foreach($slides as $s) { ?>

							<div id="banner7-caption<?php echo $i; ?>" class="banner7-caption nivo-html-caption nivo-caption">
								<?php if($s['title']) { ?>
								<div class="banner7-title">
							
									<h3><?php echo $s['title']; ?></h3>
								
								</div>
								<?php  } ?>	
								<div class="banner7-des">
									<?php echo $s['description']; ?>
								</div>
								<?php if( $s['link'] ) { ?>
									<div class="banner7-readmore">
										<a href="<?php echo $s['link']?>" title="<?php echo 'Read more' ?>"><?php echo 'Read more'; ?></a>	
									</div>
								<?php } ?>
							</div>						
				<?php
					$i++;
					}
				?>
		<script type="text/javascript">
            $(window).load(function() {
                $('#oc-inivoslider').nivoSlider({
					effect: '<?php if($config['effect']) { echo $config['effect'];} else { echo 'random'; } ?>',
                    slices: 15,
                    boxCols: 8,
                    boxRows: 4,
                    animSpeed:500,
                    pauseTime: '<?php  if($config['delay']) { echo $config['delay']; } else { echo 3000;} ?>',
                    startSlide: 0,
					controlNav:  <?php  if(isset($config['contrl']) && $config['contrl'] == 1) { echo 'true' ; } else { echo 'false';} ?>,
					directionNav:  <?php  if(isset($config['nextback'])&& $config['nextback'] == 1) { echo 'true' ; } else { echo 'false';} ?>,
                    controlNavThumbs: false,
                    pauseOnHover:  <?php  if(isset($config['hover'])&& $config['hover'] == 1) { echo 'true' ; } else { echo 'false';} ?>,
                    ocnualAdvance: false,
                    prevText: 'Prev',
                    nextText: 'Next',
                    afterLoad: function(){
                        $('.oc-loading').css("display","none");
                        },     
                   // beforeChange: function(){ 
                   //     $('.banner7-title, .banner7-des').css("left","-550px" );
                   //     $('.banner7-readmore').css("left","-1500px"); 
                   // }, 
                  //  afterChange: function(){ 
                   //     $('.banner7-title, .banner7-des, .banner7-readmore').css("left","100px") 
                   // }
                });
            });
		</script>
	</div>
</div>
</div>