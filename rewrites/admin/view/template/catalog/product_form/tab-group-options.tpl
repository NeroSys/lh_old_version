<div class="row">
    <div class="col-sm-12">
        <table class="table table-bordered">
            <thead>
            <tr>
                <th>ID_erp</th>
                <th>Базовая цена</th>
                <th>Цена по скидке</th>
                <th>Тип Скидки</th>
                <th>Количество</th>
            </tr>
            </thead>
            <tbody>
            <?php foreach($product_option_groups as $option_group){
         ?>
            <tr>
                <td><?php echo $option_group->id_erp?></td>
                <td><?php echo $option_group->price_base?></td>
                <td><?php echo $option_group->price_discount?></td>
                <td><?php echo $option_group->price_discount_type?></td>
                <td><?php echo $option_group->quantity?></td>
            </tr>

            <?php } ?>
            </tbody>
        </table>
    </div>
</div>


