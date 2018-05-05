
        <div class="form-group required">
            <label class="control-label" for="novapochta_region">Область</label>
            <select id="novapochta_region" name="novapochta_region" class="form-control">
                <option value="0">Выберите регион</option>
                <?php
                    foreach($areas as $area){
                        $selected = "";
                        if(true === $area['selected']){
                               $selected = "selected";
                        }
                        echo '<option value="'.$area['Description'].'" '.$selected.'>'.$area['Description'].'</option>';
                    }
                ?>
            </select>
        </div>

        <div class="form-group required">
            <label class="control-label" for="novapochta_city">Населенный пункт</label>
            <select id="novapochta_city" name="novapochta_city" class="form-control" <?php if(empty($cities)){ echo "disabled";}?>>
                <option value="0">Выберите город</option>
                <?php
                    foreach($cities as $city){
                        $selected = "";
                        if(true === $city['selected']){
                               $selected = "selected";
                        }
                        echo '<option value="'.$city['Ref'].'" '.$selected.'>'.$city['Description'].'</option>';
                }
                ?>
            </select>
        </div>

        <div class="form-group required">
            <label class="control-label" for="novaposhta_warehouse">Отделение Новой Почты</label>
            <select id="novaposhta_warehouse" name="novaposhta_warehouse" class="form-control" <?php if(empty($warehouses)){ echo "disabled";}?>>
                <option value="0">Выберите склад</option>
                <?php
                    foreach($warehouses as $warehouse){
                        $selected = "";
                        if(true === $warehouse['selected']){
                               $selected = "selected";
                        }
                        echo '<option value="'.$warehouse['Ref'].'" '.$selected.'>'.$warehouse['Description'].'</option>';
                }
                ?>
            </select>
        </div>

