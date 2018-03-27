<div class="footer">
    <div class="container">
        <div class="row">
            <div class="column col col-xs-12 col-sm-12 col-md-9">
                <div class="footer-title">
                    <h3>Новости наших брендов на facebook</h3>
                </div>
                <div class="footer-content soc-icons">
                    <a target="_blank" href="https://www.facebook.com/FalkeUkraine/"><img alt="Falke on Facebook" src="/catalog/view/theme/tt_auriga/image/soc-icons-fb-footer/falke.png"/></a>
                    <a target="_blank" href="https://www.facebook.com/ROECKLUkraine/">
                        <img alt="Roeckl on Facebook" src="/catalog/view/theme/tt_auriga/image/soc-icons-fb-footer/roeckl.png"/>
                    </a>
                     <a target="_blank" href="https://www.facebook.com/HANROua-585181891687618/">
                        <img alt="Elsy on Facebook" src="/catalog/view/theme/tt_auriga/image/soc-icons-fb-footer/hanro.png"/>
                    </a>
                    <a  target="_blank" href="https://www.facebook.com/steiff.ua/">
                        <img alt="Steiff on Facebook" src="/catalog/view/theme/tt_auriga/image/soc-icons-fb-footer/steiff.png"/>
                    </a>
                    <a target="_blank" href="https://www.facebook.com/SanettaUkraine/">
                        <img alt="Sanetta on Facebook" src="/catalog/view/theme/tt_auriga/image/soc-icons-fb-footer/sanetta.png"/>
                    </a>
                    <a target="_blank" href="https://www.facebook.com/ELSYUkraine/">
                        <img alt="Elsy on Facebook" src="/catalog/view/theme/tt_auriga/image/soc-icons-fb-footer/elsy.png"/>
                    </a>
                    
                    
                    <a target="_blank" href="https://www.facebook.com/TOPModelUkraine/">
                        <img alt="Top Model on Facebook" src="/catalog/view/theme/tt_auriga/image/soc-icons-fb-footer/top-model.png"/>
                    </a>

                </div>
            </div>
            <div class="column col2 col-xs-12 col-sm-12 col-md-3">
                <div class="">   
                    <div class="footer-title">
                        <h3>Магазины</h3>
                    </div>
                    <div class="adress1"><b>ТЦ «Гулливер»</b> Киев,<br>ул. Спортивная площадь 1а</div>
                    <div class="adress2"><b>ТЦ «ЦУМ»</b> Киев, ул. Крещатик, 38</div>
                </div>
            </div>

    <!--
    <div class="column col2 col-xs-12 col-sm-6 col-md-3">
       <div class="footer-title"><h3><?php echo $text_extra; ?></h3></div>
      <div class="footer-content">
       <ul class="toggle-footer">
         <li><a href="<?php echo $contact; ?>"><?php echo $text_contact; ?></a></li>
         <li><a href="<?php echo $special; ?>"><?php echo $text_special; ?></a></li>
         <li><a href="<?php echo $newsletter; ?>"><?php echo $text_newsletter; ?></a></li>
       </ul>
      </div>
    </div>
    <div class="column col3 col-xs-12 col-sm-6 col-md-3">
      <div class="footer-title"><h3><?php echo $text_account; ?></h3></div>
      <div class="footer-content">
       <ul class="toggle-footer">
         <li><a href="<?php echo $account; ?>"><?php echo $text_account; ?></a></li>
         <li><a href="<?php echo $order; ?>"><?php echo $text_order; ?></a></li>
         <li><a href="<?php echo $wishlist; ?>"><?php echo $text_wishlist; ?></a></li>
         
       </ul>
      </div>
    </div>
        -->
    </div>
  </div>
</div>
<div class="powered">
	<div class="container">
		<div class="row">
			<div class="col-md-6 col-sm-6 col-sms-12">
				<div class="left-powered">© <?=date('Y')?> little-house.com.ua</div>
			</div>
			<div class="col-md-6 col-sm-6 col-sms-12">
				<div class="right-powered text-right">
					
				</div>
			</div>
		</div>
	</div>
</div>
<div id="back-top" class="hidden-phone" style="display: block;"> </div>
<!--
OpenCart is open source software and you are free to remove the powered by OpenCart if you want, but its generally accepted practise to make a small donation.
Please donate via PayPal to donate@opencart.com
//--> 

<!-- Theme created by Welford Media for OpenCart 2.0 www.welfordmedia.co.uk -->
<script type="text/javascript">
	$(document).ready(function(){

	 // hide #back-top first
	 $("#back-top").hide();
	 
	 // fade in #back-top
	 $(function () {
	  $(window).scroll(function () {
	   if ($(this).scrollTop() > 100) {
		$('#back-top').fadeIn();
	   } else {
		$('#back-top').fadeOut();
	   }
	  });
	  // scroll body to 0px on click
	  $('#back-top').click(function () {
	   $('body,html').animate({
		scrollTop: 0
	   }, 800);
	   return false;
	  });
	 });

	});
</script>



<script src="/catalog/view/javascript/opentheme/hozmegamenu/custommenu.js" type="text/javascript"></script>
<script src="/catalog/view/javascript/opentheme/hozmegamenu/mobile_menu.js" type="text/javascript"></script>
<script src="/catalog/view/javascript/jquery/elevatezoom/jquery.elevatezoom.js" type="text/javascript"></script>
<script src="/catalog/view/javascript/common.js" type="text/javascript"></script>

<?php foreach ($scripts as $script) { ?>
<script src="<?php echo $script; ?>" type="text/javascript"></script>
<?php } ?>

<script src="/catalog/view/javascript/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>

<script src="/catalog/view/javascript/opentheme/ocslideshow/jquery.nivo.slider.js" type="text/javascript"></script>
<script src="catalog/view/javascript/jquery/owl-carousel/owl.carousel.js" type="text/javascript"></script>
<script src="/catalog/view/javascript/Swiper-3.4.0/dist/js/swiper.min.js" type="text/javascript"></script>
<script src="/catalog/view/javascript/jquery/magnific/jquery.magnific-popup.min.js" type="text/javascript"></script>
<script type="text/javascript">
    $(document).ready(function () {
        $('.popup-gallery').magnificPopup({
            type: 'ajax'
        });
    });
</script>


<!-- Yandex.Metrika counter -->
<script type="text/javascript">
    (function (d, w, c) {
        (w[c] = w[c] || []).push(function() {
            try {
                w.yaCounter41869979 = new Ya.Metrika({
                    id:41869979,
                    clickmap:true,
                    trackLinks:true,
                    accurateTrackBounce:true,
                    trackHash:true
                });
            } catch(e) { }
        });

        var n = d.getElementsByTagName("script")[0],
            s = d.createElement("script"),
            f = function () { n.parentNode.insertBefore(s, n); };
        s.type = "text/javascript";
        s.async = true;
        s.src = "https://mc.yandex.ru/metrika/watch.js";

        if (w.opera == "[object Opera]") {
            d.addEventListener("DOMContentLoaded", f, false);
        } else { f(); }
    })(document, window, "yandex_metrika_callbacks");
</script>
<noscript><div><img src="https://mc.yandex.ru/watch/41869979" style="position:absolute; left:-9999px;" alt="" /></div></noscript>
<!-- /Yandex.Metrika counter -->

<script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','https://www.google-analytics.com/analytics.js','ga');

  ga('create', 'UA-89568513-1', 'auto');
  ga('send', 'pageview');

</script>


</body></html>