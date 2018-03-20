        <div class="pos-demo-wrap">
		<h2 class="pos-demo-title">Theme Options</h2>
		<div class="pos-demo-option">
			<div class="cl-wrapper">
				<div class="cl-container">
					<div class="cl-table">
						<div class="cl-tr cl-tr-style">
							<div class="cl-td-l cl-td-layout cl-td-layout1"><a href="#" id="red" title=""><span class="cl2"></span><span class="cl1"></span>Red</a></div>
							<div class="cl-td-l cl-td-layout cl-td-layout2"><a href="#" id="blue" title=""><span class="cl2"></span><span class="cl1"></span>Blue</a></div>
						</div>
						<div class="cl-tr cl-tr-style">
							<div class="cl-td-l cl-td-layout cl-td-layout3"><a href="#" id="green" title=""><span class="cl2"></span><span class="cl1"></span>Green</a></div>
							<div class="cl-td-l cl-td-layout cl-td-layout4"><a href="#" id="pink" title=""><span class="cl2"></span><span class="cl1"></span>Pink</a></div>
						</div>
					</div>
                </div>
			</div>
		</div>
		<div class="control inactive"><a href="javascript:void(0)"></a></div>
		<script type="text/javascript">
			$(document).ready( function(){
			
				if ($.cookie('bodyBackgroundColor_cookie')!=''){
					$("#content").css('background-color','#'+$.cookie('bodyBackgroundColor_cookie'));
				}
				if ($.cookie('mainColor_cookie')!=''){
					$(".box").css('background-color','#'+ $.cookie('mainColor_cookie'));
				}
				if ($.cookie('backgroundimage_cookie')!=''){
				   $("#container").css('background-image','url("'+$.cookie('backgroundimage_cookie')+'")');
				}

				$('.control').click(function(){
					if($(this).hasClass('inactive')) {
						$(this).removeClass('inactive');
						$(this).addClass('active');
						$('.pos-demo-wrap').animate({left:'0'}, 500);
					} else {
						$(this).addClass('inactive');
						$('.pos-demo-wrap').animate({left:'-250px'}, 500);
					}
				});
				var date = new Date();
				date.setTime(date.getTime() + (1440 * 60 * 1000));
			   <?php for ($id = 1; $id <= 30; $id++) { ?>
				$('#pattern<?php echo $id;?>').click(function(){
				       $("#container").css('background-image','url("<?php echo $layout_url; ?>stylesheet/opentheme/themeoption/colortool/images/pattern/pattern<?php echo $id; ?>.png")');
						$.cookie('backgroundimage_cookie', '<?php echo $layout_url; ?>stylesheet/opentheme/themeoption/colortool/images/pattern/pattern<?php echo $id; ?>.png' , { expires: date });
						 $.cookie('id','<?php echo $id; ?>');
				});
				 <?php } ?>
				
				 $('#bodyBackgroundColor,#mainColor, #linkColor').each(function() {
						var $el = $(this);
						/* set time */
						var date = new Date();
						date.setTime(date.getTime() + (1440 * 60 * 1000));
						$el.ColorPicker({
							color: '#0000ff',
							onChange: function (hsb, hex, rgb) {
								$el.find('div').css('backgroundColor', '#' + hex);
								switch ($el.attr("id")) {
									// main color
								  case 'mainColor' :
									$(".box").css('background-color', '#' + hex);
									// set cookie
									$.cookie('mainColor_cookie', hex , { expires: date });
									break;
									case 'bodyBackgroundColor' :
										$("#content").css('background-color', '#' + hex);
										$.cookie('bodyBackgroundColor_cookie', hex , { expires: date });
									case 'linkColor' :
									$("a").css('background-color', '#' + hex);
									// set cookie
									$.cookie('linkColor_cookie', hex , { expires: date });
									break;	
								}
							}
						});
					});

					$('<link rel="stylesheet" type="text/css" href="'+$.cookie('theme_color_cookie')+'" />').appendTo('head');
					$('.cl-td-layout a').click(function(){
						$('<link rel="stylesheet" type="text/css" href="<?php echo $layout_url;?>stylesheet/global_'+this.id+'.css" />').appendTo('head');
						$.cookie('theme_color_cookie', '<?php echo $layout_url;?>stylesheet/global_'+this.id+'.css', { expires: date });
					});
					
					//reset button
					$('.cl-reset').click(function(){
						$.cookie('font_cookie','');
						$.cookie('bodyBackgroundColor_cookie','');
						$.cookie('link_color_cookie','');
						$.cookie('mainColor_cookie','');
						$.cookie('backgroundimage_cookie','');
						$("#container").css('background-image', '');
					   //reset main
						$(".box").css('background-color', '<?php echo $color_main;?>');
						//reset background
						$("#content").css('background-color', '<?php echo $color_bg;?>');
						$("a").css('color', '<?php echo $color_link;?>');
					});

					
				
			});
		</script>
		
	   
	</div> <!-- pos-demo-wrap -->




