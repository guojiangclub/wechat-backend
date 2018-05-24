<script>
    @if(isset($menu))
    $(function () {
        $("span").each(function() {
            if ($(this).text() == "{{$menu}}") {
                $(this).parent().parent().addClass("active");
            }
        });
    })
    @endif
</script>