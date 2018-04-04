<ul>
    <?php if ($categories) { ?>
    <li>
        <span>Каталог</span>
        <ul>
            <?php
            foreach ($categories as $category):?>
            <li>
                <a href="<?php echo $category['href']; ?>"><?php echo $category['name']; ?></a>
                <?php if ($category['children']): ?>
                <ul>
                    <?php foreach (array_chunk($category['children'], ceil(count($category['children']) / $category['column'])) as $children) { ?>
                    <?php foreach ($children as $child) { ?>
                    <li><a href="<?php echo $child['href']?>"><?php echo $child['name']?></a></li>
                    <?php } ?>
                    <?php } ?>
                </ul>
                <?php else: ?>
                <?php endif; ?>
            </li>
            <?php endforeach; ?>
        </ul>
    </li>

    <?php } ?>
    <li class="first"><a href="/about_us"> <span>О нас</span></a></li>
    <li><a href="/contacts"><span>Магазины</span></a></li>
    <li><a href="/our_brands"><span>Бренды</span></a></li>
    <li><a href="/our-activity"><span>Новости</span></a></li>
    <li><a href="/press"><span>Пресс-центр</span></a></li>
    <li class="last"><a href="/opt"><span>Опт</span></a></li>
</ul>