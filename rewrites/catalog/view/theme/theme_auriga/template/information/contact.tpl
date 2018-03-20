<?php echo $header; ?>
<div class="container">
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
            <h1><?php echo $heading_title; ?></h1>

            <?php if ($locations) { ?>
                <?php $i = 0; ?>
                <?php foreach ($locations as $location) {  ?>
                <?php $i++; ?>
                <?php if ($i%2 !== 0) { ?>
                <div class="row list">
                <?php } ?>
                    <div class="col-md-3 shop-image">
                        <?php if ($location['image']) { ?>
                            <a class="popup-gallery mfp-iframe lightbox-added" href="https://maps.google.com/maps?q=<?php echo $location['address']; ?>&hl=ru&iframe=true"> <img alt="<?php echo $location['name']; ?>" src="<?php echo $location['image']; ?>"></a>
                        <?php } else { ?>
                            <img alt="<?php echo $location['name']; ?>" src="/image/no_image.png">
                        <?php } ?>
                    </div>
                    <div class="col-md-3 shop-address">
                        <strong><?php echo $location['name']; ?></strong>
                        <address>
                            <?php echo $location['address']; ?>
                        </address>

                        <strong><?php echo $text_telephone; ?>:</strong>
                        <?php echo $location['telephone']; ?>
                        <br />
                        <?php if ($location['fax']) { ?>
                        <strong><?php echo $text_fax; ?></strong>
                        <?php echo $location['fax']; ?>
                        <?php } ?>
                        <?php if ($location['open']) { ?>
                        <strong><?php echo $text_open; ?>:</strong>
                        <?php echo $location['open']; ?><br />
                        <?php } ?>
                        <?php if ($location['comment']) { ?>
                        <strong><?php echo $text_comment; ?>:</strong><br />
                        <?php echo $location['comment']; ?>
                        <?php } ?>
                    </div>

                <?php if ($i%2 == 0) { ?>
                </div>
                <?php } ?>
                <?php } ?>

                <?php if ($i%2 != 0) { ?>
                </div>
                <?php } ?>
            <?php } ?>

            <?php echo $content_bottom; ?></div>
        <?php echo $column_right; ?></div>
</div>
<script src="http://maps.google.com/maps/api/js?sensor=false&key=AIzaSyCLMYSWmhRhzAMf-hLcMafs3S-E3ifStjE" type="text/javascript"></script>
<div id="map" style="height:500px; width:100%"></div>
<script type="text/javascript">

    var locations = <?php echo $map; ?>;

    var map = new google.maps.Map(document.getElementById('map'), {
        zoom: 12,
        center: new google.maps.LatLng(50.4507781, 30.5236861),
        mapTypeId: google.maps.MapTypeId.ROADMAP
    });

    var infowindow = new google.maps.InfoWindow();

    var marker, i, allMarkers = [];

    for (i = 0; i < locations.length; i++) {
        marker = new google.maps.Marker({
            position: new google.maps.LatLng(locations[i].location.lat, locations[i].location.lng),
            map: map
        });

        allMarkers.push(marker);

        google.maps.event.addListener(marker, 'click', (function(marker, i) {
            var stores = locations[i].stores;
            var html = '<div class="store-map-block">';
            for (s = 0; s < stores.length; s++) {
                html +=
                    '<div class="row store-map">' +
                    '<div class="col-sm-4"><img src="'+ stores[s].src +'" width="100" /></div>' +
                    '<div class="col-sm-8">' +
                    '<p><b>' + stores[s].name + '</b></p>' +
                    '<p>' + stores[s].address + '</p>' +
                    '<p><i>' + stores[s].description + '</i></p>';
                for (p = 0; p < stores[s].phones.length; p++) {
                    html +=
                        '<p>тел. <a href"tel:stores[s].phones[p]">' + stores[s].phones[p] + '</a></p>';
                }
                html +=
                    '</div>' +
                    '</div>';
            }
            html += '</div>';
            return function() {
                infowindow.setContent(html);
                infowindow.open(map, marker);

            }
        })(marker, i));
    };
</script>
<?php echo $footer; ?>
