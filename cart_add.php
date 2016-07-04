<?php
require_once("configs/path.php");
//echo 'sdfad';

if(!$_SESSION[user_id]):
		$action="login.html";
	else:
		$action="checkout.html";
	endif;

$value=$_REQUEST['value'];

$value=explode('_',$value);
$menu_id=$value[0];
$price=$value[1];
$rest_id=$value[2];
$qnty=$_REQUEST['qnty'];
$total=$qnty*$price;




if($menu_id):

    	$r1=mysql_query("insert into " . $prev . "cart set 
  		 menu_id='" . $menu_id . "',
		 rest_id='" . $rest_id . "',
  		 qty='" . $qnty . "',
  		 price='" .  $price . "',total='" . $total . "',
  		 ip_address='".$_SERVER['REMOTE_ADDR']."',
  		`date`='".date("Y-m-d")."',purchased='N',OrderID='" . GetCartId() . "'");
		?>
<script>
		/*function change_pro(val){
			 var id='#'+val;
			 var qty=$(id).val();
			 var id=$(id).attr("name");
			 var rest_id=$('#rest_id').val();
			  var dataString='id='+id+'&qty='+qty+'&rest_id='+rest_id;
				 $.ajax({
					type:"POST",
					data:dataString,
					url:"cart_quantity.php",
					success:function(return_data)
					{
						//alert(return_data)
						$('#ajax_cat_dt').html(return_data);
						 //$('#'+loader).css("display", "none");
						//alert('Product added successfully..')
					}
				});

			
		}*/
$(document).ready(function(){
		/************************Shipping Charges Add***************************/
		$('#shipping_charges').click(function(){
			//alert('aaa');
		var value=$(this).val();
		$('#shipping_chages_id').css('display','');
			
			  var dataString='value='+value;
				 $.ajax({
					type:"POST",
					data:dataString,
					url:"<?=$vpath?>ajax_shipping.php",
					success:function(return_data)
					{
						//alert(return_data);
						$('#ajax_shipping_charge').html(return_data);
					}
				});


		});
		
		
		$('#shipping_pickup').click(function(){
			//alert('aaa');
		var value=$(this).val();
		$('#shipping_chages_id').css('display','none');
			
			
			  var dataString='value='+value;
				 $.ajax({
					type:"POST",
					data:dataString,
					url:"<?=$vpath?>ajax_shipping.php",
					success:function(return_data)
					{
						//alert(return_data);
						$('#ajax_shipping_charge').html(return_data);
					}
				});


		});

	/**************************End************************/
	
	})		
		
</script>
        <?php
		
	
/********************************Restaurant Tax/delivery/min order****************************************************/	
	$sql_tax=mysql_query("SELECT rest_tax FROM ".$prev."resturant_info  WHERE rest_id=".$rest_id);
	$row_tax=mysql_fetch_object($sql_tax);
   
	$sql_delivery=mysql_query("SELECT rest_del_charge FROM ".$prev."resturant_delivery_info  WHERE rest_id=".$rest_id);	
	$row_delivery=mysql_fetch_object($sql_delivery);	
/********************************Cart Value listing*********************************************/		
 
 $r=mysql_query("select P.qty,P.price,P.total,S.memu_name,P.id from " . $prev . "cart P," . $prev . "menu S where P.menu_id=S.menu_id and P.OrderID='" . GetCartId() . "' and P.purchased='N'");
  
   
  

?>
<form name="check_out" action="<?= $vpath.$action;?>" method="post">
<input type="hidden" id="rest_id" name="rest_id" value="<?=$rest_id?>" />
<div class="contain">
		<ul class="detritenewcont1ul">
			<li class="item"><label class="bgnew">Item</label></li>
			<li class="Qty"><label class="bgnew">Qty</label></li>
			<li class="price"><label class="bgnew">Price</label></li>
            <li class="price"><label class="bgnew">Total</label></li>
			
             
               <?php
				  $total=0;
				  $i=0;
				  $total_qty=0;
				  while($d=mysql_fetch_array($r)){
				 
				  ?>   
           <div class="itemtab">           
            <table align="left" width="100%" border="0" cellspacing="0" cellpadding="0" class="tab_text3">
            
            <tr>
            <td width="35%" height="8"></td>
             <td width="14%"></td>
             <td width="23%"></td>
             <td width="21%"></td>
             <td width="0%"></td>
            </tr>
            <tr>
              <td valign="top"><?=$d['memu_name']?>
      <br />
<span>&nbsp;</span></td>
              <td valign="top" align="center"><input type="text" name="<?=$d[id]?>" id="quantity_<?=$d[id]?>" style="width:30px; height:20px; border:1px solid #666666; text-align:center; margin:0px auto;" value="<?=$d[qty]?>" onkeyup="change_pro(this.id)" /></td>
              <td align="center" valign="top"><?=$d['price']?></td>
               <input type="hidden" id="amount_<?=$d[id]?>" value="<?=$d['price'];?>" />
               <td align="right" valign="top"><?=$d[price]*$d[qty];?></td>
              <td align="right" valign="top">
              <img src="<?=$vpath;?>images/fancy_close.png" id="delete_pro_<?=$d[id]?>" name="<?=$d[id].'_'.$rest_id;?>" alt="" style="cursor:pointer;" onclick="delete_pro(this.id)" />
             
              
              
              </td>
            </tr>
            <tr>
              <td height="8"></td>
              <td></td>
              <td></td>
              <td></td>
            </tr>
             </table> 
           </div>
           
           <? 
		    $total=$total+($d[price]*$d[qty]); 
		   }?>
            </ul> 
<div class="detmidheighttop">
<table align="left" width="100%" border="0" cellspacing="0" cellpadding="0" class="tab_text">
  <tr>
    <td width="74%%" height="8"></td>
    <td width="10%"></td>
    <td width="16%"></td>
  </tr>
  <tr>
    <td align="right"><strong>Subtotal :</strong></td>
    <td>&nbsp;</td>
    <td align="left"><strong><?=$total?></strong></td>
  </tr>
    <tr>
    <td height="5"></td>
    <td></td>
    <td></td>
    </tr>
    <tr>
    <td align="right"><strong>
      <label>Tax(<?=$row_tax->rest_tax;?> %) :</label>
      <label></label>
    </strong></td>
    <td>&nbsp;</td>
    <td align="left"><strong><?php echo $tax=($total*$row_tax->rest_tax)/100;?></strong></td>
    </tr>
    <tr>
    <td height="5"></td>
    <td></td>
    <td></td>
    </tr>
    <tr id="shipping_chages_id" style="display:none;">
    <td align="right"><strong>Delivery Charge :</strong></td>
    <td>&nbsp;</td>
    <td align="left"><strong><?= $del_charge=$row_delivery->rest_del_charge;?></strong></td>
    </tr>
  
    <tr>
    <td height="5"></td>
    <td></td>
    <td></td>
    </tr>
  <tr>
    <td height="8"></td>
    <td></td>
    <td></td>
  </tr>
</table>

</div>

<div class="detmidheighttop2">
  <table width="100%" border="0" cellspacing="0" cellpadding="0" class="tab_text">
    <tr>
      <td height="6"></td>
    </tr>
    <tr>
      <td>
     <div id="ajax_shipping_charge">
      <table width="100%" border="0" cellspacing="0" cellpadding="0" class="tab_text">
        <tr>
          <td width="72%" align="right"><strong>Estimate Total :</strong></td>
          <td width="10%" align="left">&nbsp;</td>
          <td width="28%" align="left"><strong><?= $total+$tax;?></strong></td>
        </tr>
      </table>
      </div>
      
      </td>
    </tr>
    <tr>
      <td height="15"></td>
    </tr>
    <tr>
      <td><table width="100%" border="0" cellspacing="0" cellpadding="0" class="tab_text">
        <tr>
          <td width="32%"><input name="shipping_charges"  type="radio" id="shipping_pickup" checked="checked" value="<?=$tax.'_'.$total;?>" /> Pickup</td>
          <td width="21%" align="left"><img src="<?=$vpath?>images/pickup-icon.png" width="20" height="18" /></td>
          <td width="34%" align="left"><input name="shipping_charges" id="shipping_charges" type="radio" value="<?=$tax.'_'.$total.'_'.$del_charge;?>" />
            Delivery</td>

          <td width="13%" align="left"><img src="<?=$vpath?>images/delivery-icon.png" width="25" height="20" /></td>
        </tr>
      </table></td>
    </tr>
    <tr>
      <td height="15"></td>
    </tr>
    <tr>
      <td>The minimum order for delivery is : <?=$setting['currency'].getRestaurantOrder($rest_id);?> No minimum on Pickup orders</td>
    </tr>
    <tr>
      <td height="15"></td>
    </tr>
    <tr>
      <td align="center">
      <div id="ajax_addcart">
            <input type="submit" id="checkout" name="checkout" value="Check Out"  class="log_bnt"  >
     
      </div>
      </td>
    </tr>
    <tr>
      <td height="20"></td>
    </tr>
  </table>
</div>
</div>
</form>
<!--<div class="contain">
		<ul class="detritenewcont1ul">
			<li class="item"><label class="bgnew">Item</label></li>
			<li class="Qty"><label class="bgnew">Qty</label></li>
			<li class="price"><label class="bgnew">Price</label></li>
			<li class="del"><label class="bgnew">Del</label></li> 
             
               <?php
				  $total=0;
				  $i=0;
				  $total_qty=0;
				  while($d=mysql_fetch_array($r)){
				 
				  ?>   
           <div class="itemtab">           
            <table align="left" width="100%" border="0" cellspacing="0" cellpadding="0" class="tab_text3">
            <tr>
            <td width="57%" height="8"></td>
             <td width="14%"></td>
             <td width="15%"></td>
             <td width="14%"></td>
            </tr>
            <tr>
              <td valign="top"><?=$d['memu_name']?>
      <br />
<span>&nbsp;</span></td>
              <td valign="top"><input type="text" name="<?=$d[id]?>" id="quantity_<?=$d[id]?>" style="width:30px; height:20px; border:1px solid #666666; text-align:center; margin:0px auto;" value="<?=$d[qty]?>" onkeyup="change_pro(this.id)" /></td>
              <td align="right" valign="top"><?=$d['price']?></td>
              <td align="center" valign="top"> <img src="<?=$vpath;?>images/fancy_close.png" id="delete_pro_<?=$d[id]?>" name="<?=$d[id].'_'.$rest_id;?>" alt="" width="20" height="19" style="cursor:pointer;" onclick="delete_pro(this.id)" /></td>
            </tr>
            <tr>
              <td height="8"></td>
              <td></td>
              <td></td>
              <td></td>
            </tr>
             </table> 
           </div>
           
           <? 
		    $total=$total+($d[price]*$d[qty]); 
		   }?>
            </ul> 
<div class="detmidheighttop">
<table align="left" width="100%" border="0" cellspacing="0" cellpadding="0" class="tab_text">
  <tr>
    <td width="62%" height="8"></td>
    <td width="10%"></td>
    <td width="28%"></td>
  </tr>
  <tr>
    <td align="right"><strong>Subtotal :</strong></td>
    <td>&nbsp;</td>
    <td align="left"><strong><?=$total?></strong></td>
  </tr>
    <tr>
    <td height="5"></td>
    <td></td>
    <td></td>
    </tr>
    <tr>
    <td align="right"><strong>
      <label>Tax(<?=$row->rest_tax;?> %) :</label>
      <label></label>
    </strong></td>
    <td>&nbsp;</td>
    <td align="left"><strong><?php echo $tax=($total*$row->rest_tax)/100;?></strong></td>
    </tr>
    <tr>
    <td height="5"></td>
    <td></td>
    <td></td>
    </tr>
    <tr>
    <td align="right"><strong>Delivery Charge :</strong></td>
    <td>&nbsp;</td>
    <td align="left"><strong><?= $del_charge=$row->rest_del_charge;?></strong></td>
    </tr>
  
    <tr>
    <td height="5"></td>
    <td></td>
    <td></td>
    </tr>
  <tr>
    <td height="8"></td>
    <td></td>
    <td></td>
  </tr>
</table>

</div>

<div class="detmidheighttop2">
  <table width="100%" border="0" cellspacing="0" cellpadding="0" class="tab_text">
    <tr>
      <td height="6"></td>
    </tr>
    <tr>
      <td><table width="100%" border="0" cellspacing="0" cellpadding="0" class="tab_text">
        <tr>
          <td width="62%" align="right"><strong>Total :</strong></td>
          <td width="10%" align="left">&nbsp;</td>
          <td width="28%" align="left"><strong><?= $total+$tax+$del_charge;?></strong></td>
        </tr>
      </table></td>
    </tr>
    <tr>
      <td height="15"></td>
    </tr>
    <tr>
      <td><table width="100%" border="0" cellspacing="0" cellpadding="0" class="tab_text">
        <tr>
          <td width="32%"><input name="" type="radio" value="" /> Pickup</td>
          <td width="21%" align="left"><img src="images/pickup-icon.png" width="20" height="18" /></td>
          <td width="34%" align="left"><input name="" type="radio" value="" />
            Delivery</td>

          <td width="13%" align="left"><img src="images/delivery-icon.png" width="25" height="20" /></td>
        </tr>
      </table></td>
    </tr>
    <tr>
      <td height="15"></td>
    </tr>
    <tr>
      <td>The minimum order for delivery is : Rs. <?=$row->rest_order;?> No minimum on Pickup orders</td>
    </tr>
    <tr>
      <td height="15"></td>
    </tr>
    <tr>
      <td align="center"><input type="button" value="Check Out" class="log_bnt"></td>
    </tr>
    <tr>
      <td height="20"></td>
    </tr>
  </table>
</div>
</div>-->
<?php endif;?>