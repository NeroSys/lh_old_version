<?php echo $header; ?>
<div class="container text-container">
    <?php $template = __DIR__ . "/../common/breadcrumb.tpl"; if(file_exists($template)){ include_once($template); } ?>
    <div><?php echo $column_left; ?>
        <?php if ($column_left && $column_right) { ?>
        <?php $class = 'col-sm-6'; ?>
        <?php } elseif ($column_left || $column_right) { ?>
        <?php $class = 'col-sm-9'; ?>
        <?php } else { ?>
        <?php $class = 'col-sm-12'; ?>
        <?php } ?>
        <div id="content" class="<?php echo $class; ?>"><?php echo $content_top; ?>
            <h1><?php echo $heading_title; ?></h1>
            <?php if ($thumb || trim(strip_tags($description))) { ?>
            <div class="row">
                <?php if ($thumb) { ?>
                <div class="col-sm-2"><img src="<?php echo $thumb; ?>" alt="<?php echo $heading_title; ?>" title="<?php echo $heading_title; ?>" class="img-thumbnail" /></div>
                <?php } ?>
                <?php if ($description) { ?>
                <div class="col-sm-10"><?php echo $description; ?></div>
                <?php } ?>
            </div>
            <hr>
            <?php } ?>
           <!-- Articles -->
            <?php if ($articles) { ?>

            <div class="press-post-list grid">
                <div class="row">
            <?php foreach ($articles as $article) { ?>

                <div class="col-md-4 press-post-item">
                    <div class="press-post-item-wrapper">
                        <a href="<?php echo $article['href']; ?>">
                            <img class="img-responsive" src="<?php echo $article['thumb']; ?>">
                        </a>
                    </div>
                    <a class="press-post-title" href="<?php echo $article['href']; ?>">
                        <span><?php echo $article['name']; ?></span>
                    </a>
                </div>
            <?php } ?>
                </div>
            </div>
            <!--end Articles -->

            <div class="row row-pagination">
                <div class="col-sm-6 text-left"><?php echo $pagination; ?></div>
                <div class="col-sm-6 text-right"><?php echo $results; ?></div>
            </div>
            <?php } ?>



            <?php echo $content_bottom; ?></div>
        <?php echo $column_right; ?></div>
</div>
<?php echo $footer; ?>
