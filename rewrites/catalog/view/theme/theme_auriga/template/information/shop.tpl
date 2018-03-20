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
                <div class="col-md-12 col-sm-12">
                    <h1><?=$heading_title?></h1>
                </div>

            </div>

            <?php 

            $row=0;
            echo '<div class="row list">';
            foreach($shops as $shop){ 
            if($row % 2 == 0){ 
            echo '</div><div class="row list">';
            }
            ?>
            <div class="col-md-3 shop-image"> 
                <a class="popup-gallery" href="<?=$shop['image']?>"> <img alt="<?=$shop['title']?>" src="<?=$shop['thumb']?>"></a>
            </div>

            <div class="col-md-3 shop-address"> 
                <div><b><?=$shop['title']?></b></div>
                <?=$shop['preview']?>
            </div>
            <?php
            $row++; 
            }
            echo '</div>';
            ?>

            <script>
                $(document).ready(function () {
                    $('.popup-gallery').magnificPopup({
                        type: 'image',
                        gallery: {
                            enabled: true
                        }
                    });
                });

            </script>
            <?php echo $content_bottom; ?>
        </div>
        <?php echo $column_right; ?></div>
</div>
<?php echo $footer; ?>
