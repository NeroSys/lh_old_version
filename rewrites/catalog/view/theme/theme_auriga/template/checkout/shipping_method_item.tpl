<li class="shipping-method-item-item-variant <?php if($shipping_method["code"] === $code) { echo 'active';}?>">

<?php foreach ($shipping_method['quote'] as $quote) {

?>
        <a href="#del-method-descr_<?=$shipping_method["code"]?>" data-toggle="tab">
            <label>
                <?php if($shipping_method["code"] === $code) { ?>
                <input type="radio" name="shipping_method" value="<?php echo $quote['code']; ?>" checked="checked" />
                <?php } else { ?>
                <input type="radio" name="shipping_method" value="<?php echo $quote['code']; ?>" />
                <?php } ?>

                <?php echo $quote['title']; ?>
            </label>

        </a>

<?php } ?>

</li>



