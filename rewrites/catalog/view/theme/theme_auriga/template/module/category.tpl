<div class="box category">
    <div class="box-heading"><span><?php echo $heading_title; ?></span></div>
    <div class="box-content">
        <ul class="list-group">
            <?php echo $category_html;?>
        </ul>
    </div>
</div>


<script type="text/javascript">

    $(document).ready(function () {
        $('span.button-view').click(function () {
            if ($(this).hasClass('ttopen')) {
                $(this).removeClass("ttopen");
                $(this).addClass("ttclose");
                $(this).siblings('ul').slideDown();
            }
            else {
                $(this).removeClass("ttclose");
                $(this).addClass("ttopen");
                $(this).siblings('ul').slideUp();
            }
        });
    });

</script>

