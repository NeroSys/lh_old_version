<?php echo $header; ?>
<div class="container text-container">
    <?php $template = __DIR__ . "/../common/breadcrumb.tpl"; if(file_exists($template)){ include_once($template); } ?>
  <div class="row"><?php echo $column_left; ?>
    <?php if ($column_left && $column_right) { ?>
    <?php $class = 'col-sm-6'; ?>
    <?php } elseif ($column_left || $column_right) { ?>
    <?php $class = 'col-sm-9'; ?>
    <?php } else { ?>
    <?php $class = 'col-sm-12'; ?>
    <?php } ?>
    <div id="content" class="<?php echo $class; ?>"><?php echo $content_top; ?>
      <div class="row">
        <div class="col-sm-8">
        	<h1><?php echo $heading_title; ?></h1>
          	<?php echo $preview;?>

          	<?php echo $description; ?>
                    
                   <?php if ($images) { ?>
                   <div class="popup-gallery">
	            <?php foreach ($images as $image) { ?>
	            <a class="thumbnail-additional thumbnail" href="<?php echo $image['popup']; ?>" title="<?php echo $heading_title; ?>"> <img src="<?php echo $image['thumb']; ?>" title="<?php echo $heading_title; ?>" alt="<?php echo $heading_title; ?>" /></a>
	            <?php } ?>
                    </div>
	            <?php } ?>
        </div>

        <div class="col-sm-4">
        	<?php if ($thumb || $images) { ?>
          	<div class="popup-gallery thumbnails">
	            <?php if ($thumb) { ?>
	            <a class="thumbnail" href="<?php echo $popup; ?>" title="<?php echo $heading_title; ?>"><img src="<?php echo $thumb; ?>" title="<?php echo $heading_title; ?>" alt="<?php echo $heading_title; ?>" /></a>
	            <?php } ?>
	         
          	</div>
          	<?php } ?>

          	<?php if ($attributes) { ?>
	      		
	            <?php foreach ($attributes as $attribute_group) { ?>
	              	<?php foreach ($attribute_group['attribute'] as $attribute_item) { ?>
                   		<b><?php echo $attribute_item['name'];?>:</b> <?php echo $attribute_item['text'];?><br />
	                <?php } ?>
	          	<?php } ?>
            <?php } ?>
        </div>
          <div class="col-md-12"><p><br>Пожалуйста, отправьте на адрес <b><a href="mailto:hr@little-house.com.ua">hr@little-house.com.ua</a></b> Ваше резюме с сопроводительным письмом, ответив на вопрос: <br><b>“Почему именно Вас мы должны взять в нашу команду?”.</b></p></div>
      </div>

  

      <?php echo $content_bottom; ?></div>
    <?php echo $column_right; ?></div>
</div>

<?php echo $footer; ?>
