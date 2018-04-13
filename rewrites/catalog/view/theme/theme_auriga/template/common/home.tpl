<?php echo $header; ?>
<div class="banner-slider">
    <div class="container">
        <div class="row">
            <div class="col-md-4 col-sm-4 col-sms-12 homepage-content_block2">
                <?php
                for ($baner_num = 0; $baner_num < 2; $baner_num++) { 
                ?>
                <div id="banner-box<?=$baner_num+1?>" class="banner-box banner-box1" onclick="location.href = '<?=$banners_in_top[$baner_num]['link']?>'">
                    <a title="<?=$banners_in_top[$baner_num]['title']?>" href="<?=$banners_in_top[$baner_num]['link']?>"><img alt="<?=$banners_in_top[$baner_num]['title']?>" src="<?=$banners_in_top[$baner_num]['image']?>"></a>
                    <div class="banner-hover">
                        <div class="bg-top"></div>
                        <div class="bg-bottom">
                            <div class="title-banner"><?=$banners_in_top[$baner_num]['title']?></div>
                            <div class="content"><?=$banners_in_top[$baner_num]['text']?></div>
                        </div>
                    </div>
                </div>                            
                <?php 
                }
                ?>
            </div>
            <div class="col-md-8 col-sm-8 col-sms-12 homepage-content_block3">

                <div class="banner7">
                    <div class= "oc-banner7-container">
                        <div class="flexslider oc-nivoslider">
                            <div class="oc-loading"></div>
                            <div id="oc-inivoslider" class="slides">

                                <?php
                                foreach($premium_slider_in_top as $key=>$s) {
                                ?>
                                <a href="<?php echo $s['link']?>" title="<?php echo $s['title']?>"><img style="display: none;" src="<?php echo $s['image']; ?>" alt="" title="#banner7-caption<?php echo $key; ?>"  /></a>
                                <?php 						
                                } 
                                ?>
                            </div>


                            <script type="text/javascript">
                                $(window).load(function() {
                                $('#oc-inivoslider').nivoSlider({
                                effect: 'random',
                                        slices: 15,
                                        boxCols: 8,
                                        boxRows: 4,
                                        animSpeed:500,
                                        pauseTime: '5000',
                                        startSlide: 0,
                                        controlNav:  true,
                                        directionNav:  false,
                                        controlNavThumbs: false,
                                        pauseOnHover:  true,
                                        ocnualAdvance: false,
                                        prevText: 'Prev',
                                        nextText: 'Next',
                                        afterLoad: function(){
                                        $('.oc-loading').css("display", "none");
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

            </div>
        </div>
    </div>
</div>
<div class="cmsblock">
    <div class="description"><div class="banner-static-contain">
            <div class="container">
                <div class="row">
                    <div class="home-banner-static col-md-12">
                          <!-- Swiper -->
                         <div class="swiper-container">
        <div class="swiper-wrapper">
                        <?php
                        for ($baner_num = 2; $baner_num <= count($banners_in_top)-1; $baner_num++) { 
                        ?>
                        <div class="swiper-slide">
                            <div id="banner-box<?=$baner_num+1?>" class="banner-box banner-box1" onclick="location.href = '<?=$banners_in_top[$baner_num]['link']?>'">
                                <a title="<?=$banners_in_top[$baner_num]['title']?>" href="<?=$banners_in_top[$baner_num]['link']?>"><img alt="<?=$banners_in_top[$baner_num]['title']?>" src="<?=$banners_in_top[$baner_num]['image']?>"></a>
                                <div class="banner-hover">
                                    <div class="bg-top"></div>
                                    <div class="bg-bottom">
                                        <div class="title-banner"><?=$banners_in_top[$baner_num]['title']?></div>
                                        <div class="content"><?=$banners_in_top[$baner_num]['text']?></div>
                                    </div>
                                </div>
                            </div>     
                        </div>  
                        <?php 
                        }
                        ?>
                           </div>     
                        </div>
                         <!-- Swiper end -->
                            <!-- Initialize Swiper -->
                            <script>
                            $(document).ready(function() {
                                if($( window ).width() <= 768){

                                    $('.swiper-container div').removeClass('swiper-slide');
                                    $('.swiper-container div').removeClass('swiper-wrapper');
                                }
                                else{
                                    var swiper = new Swiper('.swiper-container', {
                                        pagination: '.swiper-pagination',
                                        slidesPerView: 3,
                                        paginationClickable: true,
                                        spaceBetween: 30,
                                        freeMode: true,
                                        autoplay: 3000,
                                        speed: 1000,
                                        loop: true,
                                    });
                                }
                            });
                            </script>
                    </div>

                </div>
            </div>

        </div>

    </div>
</div>



<div class="cmsblock">
    <div class="description"><div class="container"><div class="banner-static2-contain"><div class="banner-static-2 row"><div class="col-md-4 col-sm-4 col-sms-12"><div class="banner-box banner-box1"><div class="banner-box-container">
                                <div class="banner-title">ПРОГРАММА ЛОЯЛЬНОСТИ</div>
                                <div class="banner-ico"></div>
                                <div class="banner-content">
                                    Единая Дисконтная карта действительна во всех монобрендовых бутиках Little House.
                                    <br>3% скидки от 2-й покупки. Срок действия карты не ограничен. 
Подарки, спецпредложения для владельцев Единой Дисконтной карты.
                                </div>
                                    
                            </div></div></div><div class="col-md-4 col-sm-4 col-sms-12"><div class="banner-box banner-box2"><div class="banner-box-container">
                                        <div class="banner-title">СЕРТИФИКАТЫ КАЧЕСТВА</div>
                                         <div class="banner-ico"></div>
                                        <div class="banner-content">Материалы наивысшего качества, в соответствии с гигиеническими нормами. 
                                            Сертификаты TÜV ISO 9001, Dekra, СЄ  - безопасно для здоровья потребителей и окружающей среды. <br>Независимый контроль качества.</div>
                                            
                                    </div></div></div><div class="col-md-4 col-sm-4 col-sms-12"><div class="banner-box banner-box3"><div class="banner-box-container">
                                                <div class="banner-title">ШОПИНГ ПО-ЕВРОПЕЙСКИ </div>
                                                 <div class="banner-ico"></div>
                                                 <div class="banner-content">Продукция брендов Little House производится на семейных мануфактурных предприятиях, что значит абсолютную приверженность работе, любовь к традиционному ремесленному мастерству, инновационность в дизайне и бескомпромиссное качество.</div></div></div></div></div></div></div></div>
</div>



<div class="container cmsblock">
    <div class="banner-center">
        <div class="row">
            <?php $i=0;
                foreach($information as $key=>$post){ $i++;
                ?>
                 <div class="col-md-4 col-sm-4 col-sms-12">
                     <div class="post-img img<?=$i?>" onclick="location.href='<?=$post['href']?>'"><a href="<?=$post['href']?>"><img src="<?=$post['thumb']?>" alt="<?=$post['name']?>"></a>
                        <div class="banner-title banner-title<?=$i?>"><?php echo $post['name']?></div>
                    </div>
                </div>
                <?php
                }
            ?>
        </div>     
    </div>    
</div>

<div class="container">
    <div class="row">
        <?php echo $column_left; ?>
        <?php if ($column_left && $column_right) { ?>
        <?php $class = 'col-sm-6'; ?>
        <?php } elseif ($column_left || $column_right) { ?>
        <?php $class = 'col-sm-9'; ?>
        <?php } else { ?>
        <?php $class = 'col-sm-12'; ?>
        <?php } ?>
        <div id="content" class="<?php echo $class; ?>">
            <div class="brand-text-container">
                <div class="brand-title">
                    <h2>Наши бренды</h2>
                </div>
            </div>
            <?php echo $content_top; ?><?php echo $content_bottom; ?></div>
        <?php echo $column_right; ?>
    </div>
</div>


<?php echo $footer; ?>