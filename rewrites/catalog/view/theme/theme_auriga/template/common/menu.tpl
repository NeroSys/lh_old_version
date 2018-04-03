<?php if ($categories) { ?>
<div class="container">
    <div class="nav-container visible-lg visible-md">
        <div class="nav1">
            <div id="pt_custommenu" class="pt_custommenu">
                <div id="pt_menu_home" class="pt_menu">
                    <div class="pt_menu parentMenu">
                        <a href="<?php HTTP_SERVER ?>"><span><i class="fa fa-home" aria-hidden="true"></i></span></a>
                    </div>
                </div>
                <?php
                $cat_menu_num = 0;
                foreach ($categories as $category) { $cat_menu_num++;?>
                    <?php if ($category['children']) { ?>
                    <div id="pt_menu<?php echo $cat_menu_num?>" class="pt_menu-with-childs-child pt_menu nav-<?php echo $cat_menu_num?>">
                        <div class="parentMenu">
                            <a href="<?php echo $category['href']; ?>">
                                <span><?php echo $category['name']; ?></span>
                            </a>
                        </div>

                        <div id="popup<?php echo $cat_menu_num?>" class="popup"  style="display: none; width: 1228px;">
                            <div class="block1" id="block1<?php echo $cat_menu_num?>">
                                <div class="column last col1">
                                    <div class="itemMenu level1">
                                <?php foreach (array_chunk($category['children'], ceil(count($category['children']) / $category['column'])) as $children) { ?>
                                <?php foreach ($children as $child) { ?>

                                        <a class="itemMenuName level0"
                                           href="<?php echo $child['href']?>"><span><?php echo $child['name']?></span></a>

                                <?php } ?>
                                <?php } ?>
                                    </div>
                                </div>
                                <div class="clearBoth"></div>
                            </div>
                        </div>
                    </div>
                        <?php } else { ?>
                        <div class="pt_menu parentMenu">
                            <a href="<?php echo $category['href']; ?>"><span><?php echo $category['name']; ?></span></a>
                        </div>
                        <?php } ?>

                    <?php } ?>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    $(document).ready(function(){
        var body_class = $('body').attr('class');
        if(body_class == 'common-home') {
            $('#pt_menu_home').addClass('act');
        }
        else {
            var url = document.location.href;
            $.each($("#pt_custommenu .pt_menu-with-childs-child a"), function () {
                if (url.indexOf(this.href) >= 0) {
                    $(this).parent().parent().addClass('act');
                }
                ;
            });
        }
    });
</script>
<script type="text/javascript">
        //<![CDATA[
        var CUSTOMMENU_POPUP_EFFECT = 1;
        var CUSTOMMENU_POPUP_TOP_OFFSET = Math.round ($('#pt_custommenu').height())-1;
        //]]>
    </script>
    <?php } ?>