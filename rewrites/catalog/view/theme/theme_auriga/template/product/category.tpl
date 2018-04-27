<?php echo $header; ?>
<div class="container text-container">
    <ul class="breadcrumb">
        <?php foreach ($breadcrumbs as $breadcrumb) { ?>
        <li><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a></li>
        <?php } ?>
    </ul>
    <div class="row"><?php echo $column_left; ?>
        <?php if ($column_left && $column_right) { ?>
        <?php $class = 'col-sm-6'; ?>
        <?php } elseif ($column_left || $column_right) { ?>
        <?php $class = 'col-sm-9'; ?>
        <?php } else { ?>
        <?php $class = 'col-sm-12'; ?>
        <?php } ?>
        <div id="content" class="<?php echo $class; ?>"><?php echo $content_top; ?>
           <!-- <h1><?php echo $heading_title; ?></h1>-->
            <div class="row category-description">
                    <?php if($parent_category_info['image']){ ?>
                        <div class="col-xs-12 col-sm-4 category-image">
                            <div class="brand-logo">
                                <img src="<?php echo $parent_category_info['image']; ?>" alt="<?php echo $parent_category_info['name']; ?>">
                            </div>

                            <?php  if ($thumb && (int) $parent !== 0) { ?>
                            <div>
                                <a class="thumbnail popup-gallery" href="<?php echo $category_image; ?>" title="<?php echo $heading_title; ?>">
                                    <img src="<?php echo $thumb ?>" title="<?php echo $heading_title; ?>"  alt="<?php echo $heading_title; ?>">
                                </a>
                            </div>
                            <?php } ?>
                        </div>
                    <?php } ?>



                <div class="col-xs-12 <?php if($parent_category_info['image']) { echo 'col-sm-8'; } ?>">
                    <div class="category-list">
                    <?php if ($categories) {
                            $actual_link = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
                            ?>
                        <?php foreach ($categories as $category) { ?>
                            <div class="col-sm-6 col-md-4"><a class="button <?php if($category['href'] == $actual_link) echo 'disabled';?>" href="<?php echo $category['href']; ?>"><?php echo $category['name']; ?></a></div>
                        <?php } ?>
                    <?php } ?>
                    </div>
                </div>

            </div>


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
                <div class="product-layout product-list col-xs-12 ">
                    <div class="product-container">
                        <div class="item-inner">
                            <div class="left-block">
                                <div class="image"><a href="<?php echo $product['href']; ?>"><img src="<?php echo $product['thumb']; ?>" alt="<?php echo $product['name']; ?>" title="<?php echo $product['name']; ?>" class="img-responsive" /></a></div>
                            </div>
                            <div class="right-block">
                                <div class="caption">
                                    <div class="name"><a href="<?php echo $product['href']; ?>"><?php echo $product['name']; ?></a></div>
                                    <?php if ($product['price']) { ?>
                                    <p class="price">
                                        <?php if (!$product['special']) { ?>
                                        <?php echo $product['price']; ?>
                                        <?php } else { ?>
                                        <span class="price-new"><?php echo $product['special']; ?></span> <span class="price-old"><?php echo $product['price']; ?></span>
                                        <?php } ?>
                                        <?php if ($product['tax']) { ?>
                                        <span class="price-tax"><?php echo $text_tax; ?> <?php echo $product['tax']; ?></span>
                                        <?php } ?>
                                    </p>
                                    <?php } ?>
                                    <div class="item-container">
                                        <div class="name"><a href="<?php echo $product['href']; ?>"><?php echo $product['name']; ?></a></div>
                                        <?php if (isset($product['rating'])) { ?>
                                        <div class="rating"><img src="catalog/view/theme/default/image/stars-<?php echo $product['rating']; ?>.png"  /></div>
                                        <?php } ?>
                                        <p class="description"><?php echo $product['description']; ?></p>
                                        <div class="actions">
                                            <div class="button-group">
                                                <div class="add-to-links">
                                                    <div class="cart"><button type="button" data-toggle="tooltip" title="<?php echo $button_cart; ?>" onclick="cart.add('<?php echo $product['product_id']; ?>');"><span><?php echo $button_cart; ?></span></button></div>
                                                    <div class="wishlist"><button type="button" data-toggle="tooltip" title="<?php echo $button_wishlist; ?>" onclick="wishlist.add('<?php echo $product['product_id']; ?>');"><span><?php echo $button_wishlist; ?></span></button></div>
                                                    <div class="compare"><button type="button" data-toggle="tooltip" title="<?php echo $button_compare; ?>" onclick="compare.add('<?php echo $product['product_id']; ?>');"><span><?php echo $button_compare; ?></span></button></div>
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
            <div class="row">
                <div class="col-sm-6 text-left"><?php echo $results; ?></div>
                <div class="col-sm-6 text-right"><?php echo $pagination; ?></div>
            </div>



            <?php } ?>

            <div class="row">

                <div class="col-xs-12 category-description">
                    <?php if ($description) { echo $description; }?>
                </div>
            </div>



            <?php if (!$categories && !$products) { ?>
            <p style="display: none"><?php echo $text_empty; ?></p>
            <div class="buttons" style="display: none;">
                <div class="pull-right"><a href="<?php echo $continue; ?>" class="btn btn-primary"><?php echo $button_continue; ?></a></div>
            </div>
            <?php } ?>
            <?php echo $content_bottom; ?></div>
        <?php echo $column_right; ?></div>
</div>

<?php echo $footer; ?>
