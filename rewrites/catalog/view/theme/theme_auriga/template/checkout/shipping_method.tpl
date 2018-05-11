<?php if ($error_warning) { ?>
<div class="alert alert-warning"><i class="fa fa-exclamation-circle"></i> <?php echo $error_warning; ?></div>
<?php } ?>
<?php if ($shipping_methods) { ?>

<h2><?php echo $text_shipping_method; ?></h2>
<div class="row">
    <div class="col-sm-12">
        <ul class="nav nav-tabs" id="shipping-methods-tabs">
        <?php foreach ($shipping_methods as $shipping_method) {
              include("shipping_method_item.tpl");
          } ?>
        </ul>
        <div class="tab-content clearfix">
        <?php foreach ($shipping_methods as $shipping_method) { ?>
                <div class="tab-pane <?php if($shipping_method["code"] === $code) { echo 'active';}?>" id="del-method-descr_<?=$shipping_method["code"]?>">
                            <div class='shipping-method-inner' id='shipping-method-<?=$shipping_method["code"]?>-inner-container'>
                                    <?php echo !empty($shipping_method['error']) ? '<div class="alert alert-danger">'.$shipping_method['error'].'</div>' : ''; ?>

                                    <?php echo !empty($shipping_method["method_html"]) ? $shipping_method["method_html"]: ''; ?>
                            </div>
                </div>

        <?php } ?>
        </div>
    </div>
</div>
<?php } ?>
<div class="row">
    <div class="col-sm-12">
        <p><strong><?php echo $text_comments; ?></strong></p>
        <p>
          <textarea name="comment" rows="8" class="form-control"><?php echo $comment; ?></textarea>
        </p>
    </div>
</div>
<div class="buttons">
  <div class="pull-right">
    <input type="button" value="<?php echo $button_continue; ?>" id="button-shipping-method" data-loading-text="<?php echo $text_loading; ?>" class="btn btn-primary" />
  </div>
</div>
