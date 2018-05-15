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
            <h1><?php echo $heading_title; ?></h1>
            <div class="row">
                <div class="col-md-4 col-sm-6 col-xs-12  press-post-item float-left">
                    <div class="press-post-item-wrapper">
                        <a class="press-post-popup mfp-iframe" href="<?php echo $original; ?>">
                            <img class="img-responsive" src="<?php echo $thumb; ?>" />
                        </a>
                    </div>
                </div>

                <?php if($preview) { ?>
                <i>
                <?php echo $preview; ?>
                </i>
                <hr />
                <?php } ?>
                <?php echo $description; ?>
            </div>
            <div class="row">
                <div class="col-md-12">

                </div>
            </div>

            <?php echo $content_bottom; ?>
        </div>
        <?php echo $column_right; ?></div>
        <script type="text/javascript">
            $(document).ready(function() {
                $('.press-post-popup').magnificPopup({
                    type:'ajax',
                    mainClass: 'magnific-iframe'
                });
            });
        </script>
</div>
<?php echo $footer; ?>
