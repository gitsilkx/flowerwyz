<script src="js/jquery.min.js"></script>
<script src="bootstrap/js/bootstrap.min.js"></script>
<script type="text/javascript">
$(function() {
    $(".logo")
        .mouseover(function() { 
            $(this).attr("src", "picture/logo-hover.png");
        })
        .mouseout(function() {
            $(this).attr("src", "picture/logo.png");
        });
});
</script>
</body>
</html>