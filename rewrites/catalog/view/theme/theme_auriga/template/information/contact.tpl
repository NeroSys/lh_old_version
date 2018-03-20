<?php echo $header; ?>
<div class="container text-container">
  
    <div class="row"><?php echo $column_left; ?>
        <?php if ($column_left && $column_right) { ?>
        <?php $class = 'col-sm-6'; ?>
        <?php } elseif ($column_left || $column_right) { ?>
        <?php $class = 'col-sm-9'; ?>
        <?php } else { ?>
        <?php $class = 'col-sm-12'; ?>
        <?php } ?>
        <div id="content" class="<?php echo $class; ?>"><?php echo $content_top; ?>
            
              <ul class="breadcrumb">
        <?php foreach ($breadcrumbs as $breadcrumb) { ?>
        <li><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a></li>
        <?php } ?>
    </ul>
            <div class="row">
                <?php if ($image) { ?>
                <div class="col-md-6 col-sm-12">
                    <h1><?php echo $text_location; ?></h1>


                </div>
                <?php } ?>

            </div>
            <div class="row">
                <div class="col-md-12">
                    <p>Компания Little House является официальным представителем на Украине таких брендов, как Falke, Hanro, Roeckl, Sanetta, Steiff, Elsy, TOPModel.</p>

                    <p>Мы активно развиваем оптовую деятельность в регионах Украины и будем рады сотрудничать с клиентами, имеющими магазины в городах-миллионниках: Одесса, Днепр, Львов, Харьков, а также в других городах Украины.</p>

                    <p>Вся продукция доступна с наших складов в Киеве, а также по предзаказу с Европы.</p>

                    <p>По вопросам сотрудничества и предложений обращайтесь: <a href="mailto:opt@little-house.com.ua">opt@little-house.com.ua</a></p>

                    <p>С удовольствием ответим на возможные вопросы!</p> <br><br>

                </div>
            </div>
            <div class="row">
                <div class="col-sm-8"> <script type="text/javascript" charset="utf-8" async src="https://api-maps.yandex.ru/services/constructor/1.0/js/?sid=PVrlWPW4uvoVC0iYWQ1x9zsuko5VhQK8&amp;width=100%&amp;height=400&amp;lang=ru_RU&amp;sourceType=constructor&amp;scroll=true"></script>
                </div>

                <div class="col-md-4">
                    <h2><?php echo $text_address; ?></h2>
                    
                            <b>- БЦ «ТОРУС», 4 этаж</b>
                            <br>ул.Глубочицкая, 17-Д,
                            <br>г.Киев, Украина, 04050
                        
                    </ul>
                    <br><br>
                    <h2><?=$text_telephone?></h2>
                        - <a tel="(044) 593-33-53">(044) 593-33-53</a>
         <br><br><h2>Отзывы и пожелания</h2>             
        Отправляйте нам на адрес: <b><a href="mailto:info@little-house.com.ua">info@little-house.com.ua</a><b>
                </div>
            </div>

            <div class="row">
                <div class="col-md-12">
           
                </div>
            </div>
            <?php echo $content_bottom; ?></div>
        <?php echo $column_right; ?></div>
</div>
<?php echo $footer; ?>
