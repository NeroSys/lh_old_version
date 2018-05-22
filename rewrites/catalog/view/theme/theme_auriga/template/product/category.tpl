<?php echo $header; ?>
<div class="container text-container">
    <?php $template = __DIR__ . "/../common/breadcrumb.tpl"; if(file_exists($template)){ include_once($template); } ?>

    <div class="row swap">
        <?php if(mb_strlen($description) > 40 && $page<=1){ ?>
        <!-- CATEGORY DESCRIPTION -->
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 swap-middle spoiler">
            <div class="row category-description">
                <div class="col-xs-12">
                    <h1><?php echo $heading_title; ?></h1>
                    <?php  if ($thumb && (int) $parent === 0) { ?>
                    <img class="pull-right img-thumbnail" style="margin-left: 10px;" src="<?php echo $thumb ?>" title="<?php echo $heading_title; ?>"  alt="<?php echo $heading_title; ?>">
                    <?php } ?>

                    <?php echo $description; ?>
                </div>
            </div>
        </div>
        <!-- /CATEGORY DESCRIPTION -->
        <?php } ?>

        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 swap-top">
            <div class="row"><?php echo $column_left; ?>
                <?php if ($column_left && $column_right) { ?>
                <?php $class = 'col-sm-6'; ?>
                <?php } elseif ($column_left || $column_right) { ?>
                <?php $class = 'col-sm-9'; ?>
                <?php } else { ?>
                <?php $class = 'col-sm-12'; ?>
                <?php } ?>
                <div id="content" class="<?php echo $class; ?>"><?php echo $content_top; ?>
                    <?php if ($products) { ?>
                    <div class="row-compare"><a href="<?php echo $compare; ?>" id="compare-total"><?php echo $text_compare; ?></a></div>
                    <div class="product-filter">
                        <div class="btn-group">
                            <button type="button" id="list-view" class="btn btn-default"  title="<?php echo $button_list; ?>"><i class="fa fa-th-list"></i></button>
                            <button type="button" id="grid-view" class="btn btn-default"  title="<?php echo $button_grid; ?>"><i class="fa fa-th"></i></button>
                        </div>
                        <div class="sort">
                            <label class="control-label" for="input-sort"><?php echo $text_sort; ?></label>
                            <select id="input-sort" class="form-control col-sm-3" onchange="location = this.value;">
                                <?php foreach ($sorts as $sorts) { ?>
                                <?php if ($sorts['value'] == $sort . '-' . $order) { ?>
                                <option value="<?php echo $sorts['href']; ?>" selected="selected"><?php echo $sorts['text']; ?></option>
                                <?php } else { ?>
                                <option value="<?php echo $sorts['href']; ?>"><?php echo $sorts['text']; ?></option>
                                <?php } ?>
                                <?php } ?>
                            </select>
                        </div>
                        <div class="limit">
                            <label class="control-label" for="input-limit"><?php echo $text_limit; ?></label>
                            <select id="input-limit" class="form-control" onchange="location = this.value;">
                                <?php foreach ($limits as $limits) { ?>
                                <?php if ($limits['value'] == $limit) { ?>
                                <option value="<?php echo $limits['href']; ?>" selected="selected"><?php echo $limits['text']; ?></option>
                                <?php } else { ?>
                                <option value="<?php echo $limits['href']; ?>"><?php echo $limits['text']; ?></option>
                                <?php } ?>
                                <?php } ?>
                            </select>
                        </div>
                    </div>
                    <div class="row products-category grid">
                        <?php foreach ($products as $product) { ?>
                        <div class="product-layout product-grid col-lg-4 col-md-4 col-sm-6 col-xs-6 col-mobile">
                            <div class="product-container effect-overflow">
                                <div class="item-inner">
                                    <div class="product-cover">
                                        <div class="image"><a href="<?php echo $product['href']; ?>"><img src="<?php echo $product['thumb']; ?>" alt="<?php echo $product['name']; ?>" title="<?php echo $product['name']; ?>" class="img-responsive" /></a></div>
                                        <div class="name"><a href="<?php echo $product['href']; ?>"><?php echo $product['name']; ?></a></div>
                                        <?php if ($product['price']) { ?>
                                        <div class="price ticket">
                                            <?php if (!empty($product['prices'])) { ?>
                                                <?php echo $product['prices']['min'] . ' - ' . $product['prices']['max']; ?>
                                            <?php } else { ?>
                                                <?php echo $product['price']; ?>
                                            <?php } ?>
                                        </div>
                                        <?php } ?>
                                    </div>
                                    <div class="product-caption">
                                        <div class="product-caption-inner">
                                            <div class="image"><a href="<?php echo $product['href']; ?>"><img src="<?php echo $product['thumb']; ?>" alt="<?php echo $product['name']; ?>" title="<?php echo $product['name']; ?>" class="img-responsive" /></a></div>
                                            <div class="name"><a href="<?php echo $product['href']; ?>"><?php echo $product['name']; ?></a></div>

                                            <div class="item-container">
                                                <?php if (isset($product['rating'])) { ?>
                                                <div class="rating"><img src="catalog/view/theme/default/image/stars-<?php echo $product['rating']; ?>.png"  /></div>
                                                <?php } ?>
                                                <?php if (isset($product['options'])) { ?>
                                                <div class="product-description">
                                                    <?php foreach ($product['options'] as $option_group) { ?>
                                                    <?php
                                                    switch($option_group['name']){
                                                        case 'Размер':
                                                            $class_color = 'opt-style-1';
                                                            $option_name = 'Размеры';
                                                            break;
                                                        case 'Цвет':
                                                            $class_color = 'opt-style-2';
                                                            $option_name = 'Цвета';
                                                            break;
                                                        default:
                                                            $class_color = '';
                                                            $option_name = $option_group['name'];
                                                    }
                                                    ?>
                                                    <div class="product-grid-options">
                                                        <p><b><?php echo $option_name; ?>:</b></p>
                                                        <ul class="<?php echo $class_color; ?>">
                                                            <?php foreach ($option_group['product_option_value'] as $option) { ?>
                                                            <li><?php echo $option; ?></li>
                                                            <?php } ?>
                                                        </ul>
                                                    </div>
                                                    <?php } ?>
                                                </div>
                                                <?php } ?>
                                                <div class="product-actions">
                                                    <div class="button-group">
                                                        <div class="price">
                                                            <?php if (!$product['special']) { ?>
                                                            <?php echo $product['price']; ?>
                                                            <?php } else { ?>
                                                            <span class="price-new"><?php echo $product['special']; ?></span> <span class="price-old"><?php echo $product['price']; ?></span>
                                                            <?php } ?>
                                                            <?php if ($product['tax']) { ?>
                                                            <span class="price-tax"><?php echo $text_tax; ?> <?php echo $product['tax']; ?></span>
                                                            <?php } ?>
                                                        </div>
                                                        <div class="button">
                                                            <a class="btn btn-lg btn-primary" href="<?php echo $product['href']; ?>"><i class="fa fa-eye" aria-hidden="true"></i><span class="md-visible lg-visible"> Просмотр</span></a>
                                                        </div>

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
                    <div class="row row-pagination">
                        <div class="col-sm-6 text-left"><?php echo $results; ?></div>
                        <div class="col-sm-6 text-right"><?php echo $pagination; ?></div>
                    </div>
                    <?php } ?>

                    <?php if (!$categories && !$products) { ?>
                    <p style="display: none"><?php echo $text_empty; ?></p>
                    <div class="buttons" style="display: none;">
                        <div class="pull-right"><a href="<?php echo $continue; ?>" class="btn btn-primary"><?php echo $button_continue; ?></a></div>
                    </div>
                    <?php } ?>
                    <?php echo $content_bottom; ?>
                </div>
                <?php echo $column_right; ?>
            </div>
        </div>
    </div>

</div>

<?php echo $footer; ?>
