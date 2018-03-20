<?php if (count($currencies) > 1) { ?>
<div class="pull-left">
<form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="currency">
  <div class="btn-group">
    <label>Currency:</label>
	<button class="btn btn-link dropdown-toggle" data-toggle="dropdown">
    <?php foreach ($currencies as $currency) { ?>
    <?php if ($currency['symbol_left'] && $currency['code'] == $code) { ?>
    <strong><?php echo $currency['code']; ?></strong>
    <?php } elseif ($currency['symbol_right'] && $currency['code'] == $code) { ?>
    <strong><?php echo $currency['symbol_right']; ?></strong>
    <?php } ?>
    <?php } ?>
   </button>
    <ul class="dropdown-menu dropdown-currency">
		<?php foreach ($currencies as $currency) { ?>
		<?php if ($currency['code']) { ?>
		<li><button class="currency-select btn btn-link btn-block" type="button" name="<?php echo $currency['code']; ?>"><span><?php echo $currency['code']; ?></span></button></li>
		<?php } else { ?>
		<li><button class="currency-select btn btn-link btn-block" type="button" name="<?php echo $currency['code']; ?>"><span><?php echo $currency['symbol_right']; ?></span></button></li>
		<?php } ?>
		<?php } ?>
    </ul>
  </div>
  <input type="hidden" name="code" value="" />
  <input type="hidden" name="redirect" value="<?php echo $redirect; ?>" />
</form>
</div>
<?php } ?>
