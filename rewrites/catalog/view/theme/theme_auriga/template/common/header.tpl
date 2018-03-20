<!DOCTYPE html>
<!--[if IE]><![endif]-->
<!--[if IE 8 ]><html dir="<?php echo $direction; ?>" lang="<?php echo $lang; ?>" class="ie8"><![endif]-->
<!--[if IE 9 ]><html dir="<?php echo $direction; ?>" lang="<?php echo $lang; ?>" class="ie9"><![endif]-->
<!--[if (gt IE 9)|!(IE)]><!-->
<html dir="<?php echo $direction; ?>" lang="<?php echo $lang; ?>">
    <!--<![endif]-->
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title><?php echo $title; ?></title>
        <base href="<?php echo $base; ?>" />
        <?php if ($description) { ?>
        <meta name="description" content="<?php echo $description; ?>">
        <?php } ?>
        <?php if ($keywords) { ?>
        <meta name="keywords" content= "<?php echo $keywords; ?>">
        <?php } ?>
      
        <script src="/catalog/view/javascript/jquery/jquery-2.1.1.min.js" type="text/javascript"></script>
        <script src="/catalog/view//javascript/loadcss.js" type="text/javascript"></script>
        <link href="/catalog/view/javascript/bootstrap/css/bootstrap.min.css" rel="stylesheet" media="screen">
        <link rel="stylesheet" type="text/css" href="/catalog/view/theme/tt_auriga/stylesheet/global_red.css?d2">
        <script>
            loadCSS("/catalog/view//theme/tt_auriga/stylesheet/fonts/font-awesome-4.7.0/css/font-awesome.min.css");
            loadCSS("/catalog/view//theme/tt_auriga/stylesheet/animate.css");
        </script>
        <script>
            loadCSS("/catalog/view/javascript/Swiper-3.4.0/dist/css/swiper.min.css");
        </script>
        <script>
            loadCSS("/catalog/view/javascript/jquery/magnific/magnific-popup.css");
        </script>
        </script>

        <?php foreach ($styles as $style) { ?>
            <script>
                  loadCSS("<?php echo $style['href']; ?>");
            </script>
        <?php } ?>

        <?php foreach ($links as $link) { ?>
        <link href="<?php echo $link['href']; ?>" rel="<?php echo $link['rel']; ?>" />
        <?php } ?>

        <?php foreach ($analytics as $analytic) { ?>
        <?php echo $analytic; ?>
        <?php } ?>
    </head>
    <body class="<?php echo $class; ?>">
        <header>
            <div class="header">
                <div class="container">
                    <div class="row">


                        <div class="col-md-12  col-sm-12">
                            <ul class="list-inline links">
                                <li class="first"><a href="/about_us"> <span>О нас</span></a></li>
                                <li><a href="/shops"><span>Магазины</span></a></li>
                                <li><a href="/our_brands"><span>Бренды</span></a></li>
                                <li><a href="/our-activity"><span>Новости</span></a></li>
                                <li><a href="/our-vacancy"><span>Вакансии</span></a></li>
                                <li class="last"><a href="/contacts"><span>ОПТ</span></a></li>
                            </ul>
                        </div> 
 
                    </div>
                </div>
            </div>
            <div class="container subheader">
                <div class="row">
                     <div class="col-md-3 col-sm-5">
                        <div id="logo">
                                <?php if ($logo) { ?>
                                <a href="<?php echo $home; ?>"><img src="<?php echo $logo; ?>" title="<?php echo $name; ?>" alt="<?php echo $name; ?>" class="img-responsive" /></a>
                                <?php } else { ?>
                                <h1><a href="<?php echo $home; ?>"><?php echo $name; ?></a></h1>
                                <?php } ?>
                            </div>
                    </div>

                    <div class="address col-md-9 col-sm-7">
                            <div class="adress1"><b>ТЦ «Гулливер»</b> Киев, ул Спортивная площадь 1а</div>
                            <div class="adress2"><b>ТЦ «ЦУМ»</b> Киев, ул Крещатик, 38</div>

                                <div class="cart-search">
			<div class="top-cart">
					<?php echo $cart; ?>
				</div>
				<?php echo $search; ?>

			</div>
                    </div>
                </div>

            </div>


        </header>
        <?php echo $content_block; ?>
        <?php if ($categories) { ?>
        <?php } ?>