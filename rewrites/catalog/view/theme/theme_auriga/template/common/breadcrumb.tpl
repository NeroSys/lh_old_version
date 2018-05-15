<?php $breadcrumb_count = count($breadcrumbs); $i=0; ?>
<ul class="breadcrumb" itemscope itemtype="http://schema.org/BreadcrumbList">
    <?php foreach ($breadcrumbs as $k=>$breadcrumb) { $i++; ?>
    <li itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem">
        <a itemprop="item" <?php if($i<$breadcrumb_count) {echo 'href="' . $breadcrumb['href'] . '"';} ?> >
            <span itemprop="name"><?php echo $breadcrumb['text']; ?></span></a>
        <meta itemprop="position" content="<?php echo $k+1; ?>" />
    </li>
    <?php } ?>
</ul>
