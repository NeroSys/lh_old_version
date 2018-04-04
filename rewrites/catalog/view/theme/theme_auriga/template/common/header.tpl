<!DOCTYPE html>
<!--[if IE]><![endif]-->
<!--[if IE 8 ]>
<html dir="<?php echo $direction; ?>" lang="<?php echo $lang; ?>" class="ie8"><![endif]-->
<!--[if IE 9 ]>
<html dir="<?php echo $direction; ?>" lang="<?php echo $lang; ?>" class="ie9"><![endif]-->
<!--[if (gt IE 9)|!(IE)]><!-->
<html dir="<?php echo $direction; ?>" lang="<?php echo $lang; ?>">
<!--<![endif]-->
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="theme-color" content="#000">
    <title><?php echo $title; ?></title>
    <base href="<?php echo $base; ?>"/>
    <?php if ($description) { ?>
    <meta name="description" content="<?php echo $description; ?>">
    <?php } ?>
    <?php if ($keywords) { ?>
    <meta name="keywords" content="<?php echo $keywords; ?>">
    <?php } ?>

    <script src="/catalog/view/javascript/jquery/jquery-2.1.1.min.js" type="text/javascript"></script>
    <script src="/catalog/view//javascript/loadcss.js" type="text/javascript"></script>
    <link href="/catalog/view/javascript/bootstrap/css/bootstrap.min.css" rel="stylesheet" media="screen">
    <link rel="stylesheet" type="text/css" href="/catalog/view/theme/tt_auriga/stylesheet/global_red.css?d23">
    <script>
        loadCSS("/catalog/view//theme/tt_auriga/stylesheet/fonts/font-awesome-4.7.0/css/font-awesome.min.css");
        loadCSS("/catalog/view//theme/tt_auriga/stylesheet/animate.css");
        loadCSS("/catalog/view/javascript/Swiper-3.4.0/dist/css/swiper.min.css");
        loadCSS("/catalog/view/javascript/jquery/magnific/magnific-popup.css");
        loadCSS("/catalog/view/javascript/mmenu/jquery.mmenu.all.css");
        loadCSS("/catalog/view//theme/tt_auriga/stylesheet/hamburgers.css");
    </script>

    <?php foreach($styles as $style):?>
    <script>
        loadCSS("<?php echo $style['href']; ?>");
    </script>
    <?php endforeach; ?>

    <?php foreach ($links as $link) { ?>
    <link href="<?php echo $link['href']; ?>" rel="<?php echo $link['rel']; ?>"/>
    <?php } ?>

    <?php foreach ($analytics as $analytic) { ?>
    <?php echo $analytic; ?>
    <?php } ?>
</head>
<body class="<?php echo $class; ?>">
<div id="page">

<div class="header Fixed">
    <span id="hamburger" class="Sticky">
        <a href="#menu" class="hamburger hamburger--collapse">
            <span class="hamburger-box">
                <span class="hamburger-inner"></span>
            </span>
        </a>
    </span>
    <div>
        <div class="container">
            <div class="row">

                <div class="col-md-9 hidden-xs hidden-sm pull-right">
                    <ul class="list-inline links">
                        <li class="first"><a href="/about_us"> <span>О нас</span></a></li>
                        <li><a href="/contacts"><span>Магазины</span></a></li>
                        <li><a href="/our_brands"><span>Бренды</span></a></li>
                        <li><a href="/our-activity"><span>Новости</span></a></li>
                        <li><a href="/press"><span>Пресс-центр</span></a></li>
                        <li class="last"><a href="/opt"><span>Опт</span></a></li>
                    </ul>
                </div>
                <div class="col-md-3 pull-right">
                    <ul class="list-inline phones">
                        <li><a href="tel:+38(044)593-33-53"><i class="fa fa-phone-square"></i> (044) 593-33-53</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

</div>

<div class="content">
    <div class="container subheader">
        <div class="row">
            <div class="col-md-3 col-sm-4 col-xs-5 col-logo">
                <div id="logo">
                    <?php if ($logo) { ?>
                    <a href="<?php echo $home; ?>">
                        <img src="<?php echo $logo; ?>" title="<?php echo $name; ?>" alt="<?php echo $name; ?>"
                             class="img-responsive"/>
                    </a>
                    <?php } else { ?>
                    <h1><a href="<?php echo $home; ?>"><?php echo $name; ?></a></h1>
                    <?php } ?>
                </div>
            </div>

            <div class="col-md-9 col-sm-5 col-xs-7" style="display: none !important;">
                <div class="cart-search">
                    <div class="top-cart">
                        <?php echo $cart; ?>
                    </div>
                    <?php echo $search; ?>
                </div>
            </div>
        </div>
    </div>
<?php include_once("menu.tpl")?>