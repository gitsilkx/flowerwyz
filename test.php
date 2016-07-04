<?php
include("include/header.php");
?>

<script>
    $(document).ready(function(){
        alert('df');
        $( "#zip_code" ).autocomplete({
            minLength: 0,
            source: "<?=$vpath?>ajax/get_search_occasion.php",		  
                //source: projects,	
            focus: function( event, ui ) {
              $( "#zip_code" ).val( ui.item.label );
              return false;
            },
            select: function( event, ui ) {
              $( "#zip_code" ).val( ui.item.label );
              $( "#zip_id" ).val( ui.item.value );
                      return false;
            }
          });
    });
</script>
 <span class="item_code" style="z-index: 9999;">Wish :<input type="text" name="occasion" id="zip_code"> </span>