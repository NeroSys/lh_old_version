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
            <div class="product-view">
                <div class="row">
                    <?php if ($column_left && $column_right) { ?>
                    <?php $class = 'col-md-6 col-sm-6 col-sms-12 col-xs-12 view-zoom'; ?>
                    <?php } elseif ($column_left || $column_right) { ?>
                    <?php $class = 'col-md-6 col-sm-6 col-sms-12 col-xs-12 view-zoom'; ?>
                    <?php } else { ?>
                    <?php $class = 'col-md-6 col-sm-8'; ?>
                    <?php } ?>
                    <div class="<?php echo $class; ?>">
                        <div class="image-block">
                            <?php if ($thumb || $images) { ?>
                            <div class="thumbnail">
                                <?php if ($thumb) { ?>
                                <a href="<?php echo $popup; ?>" class="popup-gallery" title="<?php echo $heading_title; ?>">
                                    <img src="<?php echo $thumb; ?>" title="<?php echo $heading_title; ?>" alt="<?php echo $heading_title; ?>"/>
                                </a>
                                <?php } ?>
                            </div>
                            <?php if ($images) { ?>
                            <div class="image-additional" id="gallery_01">
                                <?php foreach ($images as $image) { ?>
                                <a class="popup-gallery" href="<?php echo $image['popup']; ?>" title="<?php echo $heading_title; ?>" rel="noindex">
                                    <img src="<?php echo $image['thumb']; ?>" title="<?php echo $heading_title; ?>"
                                         alt="<?php echo $heading_title; ?>"/>
                                </a>
                                <?php } ?>
                            </div>
                            <?php } ?>
                            <?php } ?>
                        </div>
                    </div>
                    <?php if ($column_left && $column_right) { ?>
                    <?php $class = 'col-md-6 col-sm-6 col-sms-12 col-xs-12'; ?>
                    <?php } elseif ($column_left || $column_right) { ?>
                    <?php $class = 'col-md-6 col-sm-6 col-sms-12 col-xs-12'; ?>
                    <?php } else { ?>
                    <?php $class = 'col-md-6 col-sm-4'; ?>
                    <?php } ?>
                    <div class="<?php echo $class; ?>">
                        <div class="product-name"><h1><?php echo $heading_title; ?></h1></div>
                        <?php if ($stock == "Нет в наличии") { ?>
                        <span class="label label-danger label-md"><?php echo $stock; ?></span>
                        <?php } ?>

                        <div id="product">

                            <script type="application/javascript">var product_id = <?php echo $product_id; ?>;</script>
                            <app-product-options></app-product-options>
                            <?php foreach ($scripts as $file) { ?>
                            <script type="text/javascript" src="<?php echo $file; ?>"></script>
                            <?php } ?>

                            <div class="add-to-links" style="display: none">
                                <div class="btn-group">
                                    <div class="wishlist">
                                        <button type="button" class="btn btn-default"
                                                title="<?php echo $button_wishlist; ?>"
                                                onclick="wishlist.add('<?php echo $product_id; ?>');">
                                            <span><?php echo $button_wishlist; ?></span></button>
                                    </div>
                                    <div class="compare">
                                        <button type="button" class="btn btn-default"
                                                title="<?php echo $button_compare; ?>"
                                                onclick="compare.add('<?php echo $product_id; ?>');">
                                            <span><?php echo $button_compare; ?></span></button>
                                    </div>
                                </div>
                            </div>

                            <div class="product-information">
                                <div class="lazy-load-text" data-href="delivery-info"></div>
                                <a href="/delivery?ajax=true" class="popup-ajax inline md-popup">Оплата и доставка (подробнее)</a>
                            </div>
                        </div>
                        <?php if ($review_status) { ?>
                        <div class="rating">
                            <p>
                                <?php for ($i = 1; $i <= 5; $i++) { ?>
                                <?php if ($rating < $i) { ?>
                                <span class="fa fa-stack"><i class="fa fa-star-o fa-stack-1x"></i></span>
                                <?php } else { ?>
                                <span class="fa fa-stack"><i class="fa fa-star fa-stack-1x"></i><i
                                            class="fa fa-star-o fa-stack-1x"></i></span>
                                <?php } ?>
                                <?php } ?>
                                <a href=""
                                   onclick="$('a[href=\'#tab-review\']').trigger('click'); return false;"><?php echo $reviews; ?></a>
                                / <a href=""
                                     onclick="$('a[href=\'#tab-review\']').trigger('click'); return false;"><?php echo $text_write; ?></a>
                            </p>
                            <hr>
                        </div>
                        <?php } ?>
                    </div>
                </div>
                <div class="tab-view">
                    <ul class="nav nav-tabs">
                        <?php $first_tab = false; if (!empty($description)) { $first_tab = true; ?>
                        <li class="active">
                            <a href="#tab-description" data-toggle="tab"><?php echo $tab_description; ?></a>
                        </li>
                        <?php } ?>
                        <?php if ($attribute_groups) { ?>
                        <li><a href="#tab-specification" data-toggle="tab"><?php echo $tab_attribute; ?></a></li>
                        <?php } ?>
                        <?php if ($review_status) { ?>
                        <li><a href="#tab-review" data-toggle="tab"><?php echo $tab_review; ?></a></li>
                        <?php } ?>
                    </ul>
                    <div class="tab-content">
                        <?php if ($first_tab) { ?>
                        <div class="tab-pane active" id="tab-description"><?php echo $description; ?></div>
                        <?php } ?>
                        <?php if ($attribute_groups) { ?>
                        <div class="tab-pane  <?php if (!$first_tab) { ?>active<?php } ?>" id="tab-specification">
                            <table class="table table-bordered">
                                <?php foreach ($attribute_groups as $attribute_group) { ?>
                                <thead>
                                <tr>
                                    <td colspan="2"><strong><?php echo $attribute_group['name']; ?></strong></td>
                                </tr>
                                </thead>
                                <tbody>
                                <?php foreach ($attribute_group['attribute'] as $attribute) { ?>
                                <tr>
                                    <td><?php echo $attribute['name']; ?></td>
                                    <td><?php echo $attribute['text']; ?></td>
                                </tr>
                                <?php } ?>
                                </tbody>
                                <?php } ?>
                            </table>
                        </div>
                        <?php } ?>
                        <?php if ($review_status) { ?>
                        <div class="tab-pane" id="tab-review">
                            <form class="form-horizontal">
                                <div id="review"></div>
                                <h2><?php echo $text_write; ?></h2>
                                <div class="form-group required">
                                    <div class="col-sm-12">
                                        <label class="control-label" for="input-name"><?php echo $entry_name; ?></label>
                                        <input type="text" name="name" value="" id="input-name" class="form-control"/>
                                    </div>
                                </div>
                                <div class="form-group required">
                                    <div class="col-sm-12">
                                        <label class="control-label"
                                               for="input-review"><?php echo $entry_review; ?></label>
                                        <textarea name="text" rows="5" id="input-review"
                                                  class="form-control"></textarea>
                                        <div class="help-block"><?php echo $text_note; ?></div>
                                    </div>
                                </div>
                                <div class="form-group required">
                                    <div class="col-sm-12">
                                        <label class="control-label"><?php echo $entry_rating; ?></label>
                                        &nbsp;&nbsp;&nbsp; <?php echo $entry_bad; ?>&nbsp;
                                        <input type="radio" name="rating" value="1"/>
                                        &nbsp;
                                        <input type="radio" name="rating" value="2"/>
                                        &nbsp;
                                        <input type="radio" name="rating" value="3"/>
                                        &nbsp;
                                        <input type="radio" name="rating" value="4"/>
                                        &nbsp;
                                        <input type="radio" name="rating" value="5"/>
                                        &nbsp;<?php echo $entry_good; ?></div>
                                </div>
                                <div class="form-group required">
                                    <div class="col-sm-12">
                                        <label class="control-label"
                                               for="input-captcha"><?php echo $entry_captcha; ?></label>
                                        <input type="text" name="captcha" value="" id="input-captcha"
                                               class="form-control"/>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-sm-12"><img src="index.php?route=tool/captcha" alt="" id="captcha"/>
                                    </div>
                                </div>
                                <div class="buttons">
                                    <div class="pull-right">
                                        <button type="button" id="button-review"
                                                data-loading-text="<?php echo $text_loading; ?>"
                                                class="btn btn-primary"><?php echo $button_continue; ?></button>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <?php } ?>
                    </div>
                </div>
                <?php if ($products) { ?>

                <?php if ($tags) { ?>
                <p class="view-tag"><?php echo $text_tags; ?>
                    <?php for ($i = 0; $i < count($tags); $i++) { ?>
                    <?php if ($i < (count($tags) - 1)) { ?>
                    <a href="<?php echo $tags[$i]['href']; ?>"><?php echo $tags[$i]['tag']; ?></a>,
                    <?php } else { ?>
                    <a href="<?php echo $tags[$i]['href']; ?>"><?php echo $tags[$i]['tag']; ?></a>
                    <?php } ?>
                    <?php } ?>
                </p>
                <?php } ?>

                <div class="related-title"><h2><?php echo $text_related; ?></h2></div>
                <div class="row view-related">
                    <?php foreach ($products as $product) { ?>
                    <div class="related-items">
                        <div class="product-thumb transition item-inner">
                            <div class="image"><a href="<?php echo $product['href']; ?>"><img
                                            src="<?php echo $product['thumb']; ?>" alt="<?php echo $product['name']; ?>"
                                            title="<?php echo $product['name']; ?>" class="img-responsive"/></a></div>
                            <div class="name"><a
                                        href="<?php echo $product['href']; ?>"><?php echo $product['name']; ?></a></div>
                            <?php if ($product['price']) { ?>
                            <div class="price">
                                <?php if (!$product['special']) { ?>
                                <?php echo $product['price']; ?>
                                <?php } else { ?>
                                <span class="price-new"><?php echo $product['special']; ?></span> <span
                                        class="price-old"><?php echo $product['price']; ?></span>
                                <?php } ?>
                                <?php if ($product['tax']) { ?>
                                <span class="price-tax"><?php echo $text_tax; ?> <?php echo $product['tax']; ?></span>
                                <?php } ?>
                            </div>
                            <?php } ?>
                            <div class="item-container">
                                <div class="item-description" >
                                    <div class="name">
                                        <a href="<?php echo $product['href']; ?>"><?php echo $product['name']; ?></a>
                                    </div>
                                    <?php if ($product['price']) { ?>
                                    <div class="price">
                                        <?php if (!$product['special']) { ?>
                                        <?php echo $product['price']; ?>
                                        <?php } else { ?>
                                        <span class="price-new"><?php echo $product['special']; ?></span> <span
                                                class="price-old"><?php echo $product['price']; ?></span>
                                        <?php } ?>
                                        <?php if ($product['tax']) { ?>
                                        <span class="price-tax"><?php echo $text_tax; ?> <?php echo $product['tax']; ?></span>
                                        <?php } ?>
                                    </div>
                                    <?php } ?>
                                    <?php if (isset($product['rating'])) { ?>
                                    <div class="rating"><img
                                                src="catalog/view/theme/default/image/stars-<?php echo $product['rating']; ?>.png"/>
                                    </div>
                                    <?php } ?>
                                    <p class="description"><?php echo $product['description']; ?></p>
                                    <div class="actions">
                                        <div class="button-group">
                                            <div class="add-to-links">
                                                <div class="cart">
                                                    <button type="button"
                                                            onclick="cart.add('<?php echo $product['product_id']; ?>');">
                                                        <span><?php echo $button_cart; ?></span></button>
                                                </div>
                                                <div class="wishlist">
                                                    <button type="button" data-toggle="tooltip"
                                                            title="<?php echo $button_wishlist; ?>"
                                                            onclick="wishlist.add('<?php echo $product['product_id']; ?>');">
                                                        <span><?php echo $button_wishlist; ?></span></button>
                                                </div>
                                                <div class="compare">
                                                    <button type="button" data-toggle="tooltip"
                                                            title="<?php echo $button_compare; ?>"
                                                            onclick="compare.add('<?php echo $product['product_id']; ?>');">
                                                        <span><?php echo $button_compare; ?></span></button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php } ?>
                </div>
                <?php } ?>
                <?php echo $content_bottom; ?></div>
        </div>
        <?php echo $column_right; ?></div>
</div>
<script type="text/javascript"><!--
    $('select[name=\'recurring_id\'], input[name="quantity"]').change(function () {
        $.ajax({
            url: 'index.php?route=product/product/getRecurringDescription',
            type: 'post',
            data: $('input[name=\'product_id\'], input[name=\'quantity\'], select[name=\'recurring_id\']'),
            dataType: 'json',
            beforeSend: function () {
                $('#recurring-description').html('');
            },
            success: function (json) {
                $('.alert, .text-danger').remove();

                if (json['success']) {
                    $('#recurring-description').html(json['success']);
                }
            }
        });
    });
    //--></script>
<script type="text/javascript">

    $('button[id^=\'button-upload\']').on('click', function () {
        var node = this;

        $('#form-upload').remove();

        $('body').prepend('<form enctype="multipart/form-data" id="form-upload" style="display: none;"><input type="file" name="file" /></form>');

        $('#form-upload input[name=\'file\']').trigger('click');

        $('#form-upload input[name=\'file\']').on('change', function () {
            $.ajax({
                url: 'index.php?route=tool/upload',
                type: 'post',
                dataType: 'json',
                data: new FormData($(this).parent()[0]),
                cache: false,
                contentType: false,
                processData: false,
                beforeSend: function () {
                    $(node).button('loading');
                },
                complete: function () {
                    $(node).button('reset');
                },
                success: function (json) {
                    $('.text-danger').remove();

                    if (json['error']) {
                        $(node).parent().find('input').after('<div class="text-danger">' + json['error'] + '</div>');
                    }

                    if (json['success']) {
                        alert(json['success']);

                        $(node).parent().find('input').attr('value', json['code']);
                    }
                },
                error: function (xhr, ajaxOptions, thrownError) {
                    alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
                }
            });
        });
    });
    //--></script>
<script type="text/javascript"><!--
    $('#review').delegate('.pagination a', 'click', function (e) {
        e.preventDefault();

        $('#review').fadeOut('slow');

        $('#review').load(this.href);

        $('#review').fadeIn('slow');
    });

    $('#review').load('index.php?route=product/product/review&product_id=<?php echo $product_id; ?>');

    $('#button-review').on('click', function () {
        $.ajax({
            url: 'index.php?route=product/product/write&product_id=<?php echo $product_id; ?>',
            type: 'post',
            dataType: 'json',
            data: 'name=' + encodeURIComponent($('input[name=\'name\']').val()) + '&text=' + encodeURIComponent($('textarea[name=\'text\']').val()) + '&rating=' + encodeURIComponent($('input[name=\'rating\']:checked').val() ? $('input[name=\'rating\']:checked').val() : '') + '&captcha=' + encodeURIComponent($('input[name=\'captcha\']').val()),
            beforeSend: function () {
                $('#button-review').button('loading');
            },
            complete: function () {
                $('#button-review').button('reset');
                $('#captcha').attr('src', 'index.php?route=tool/captcha#' + new Date().getTime());
                $('input[name=\'captcha\']').val('');
            },
            success: function (json) {
                $('.alert-success, .alert-danger').remove();

                if (json['error']) {
                    $('#review').after('<div class="alert alert-danger"><i class="fa fa-exclamation-circle"></i> ' + json['error'] + '</div>');
                }

                if (json['success']) {
                    $('#review').after('<div class="alert alert-success"><i class="fa fa-check-circle"></i> ' + json['success'] + '</div>');

                    $('input[name=\'name\']').val('');
                    $('textarea[name=\'text\']').val('');
                    $('input[name=\'rating\']:checked').prop('checked', false);
                    $('input[name=\'captcha\']').val('');
                }
            }
        });
    });

    //--></script>
<?php echo $footer; ?>
