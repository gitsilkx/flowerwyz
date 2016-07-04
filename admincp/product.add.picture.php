<?php
include("includes/access.php");
include("includes/header.php");
if($_REQUEST[del]):

   mysql_query("delete from " . $prev . "product_picture where id=" . $_REQUEST[del] . " and product_id=" . $_REQUEST[product_id]);
   //echo"delete from " . $prev . "product_picture where id=" . $_REQUEST[id] . " and product_id=" . $_REQUEST[product_id];

   @unlink("../" . $_REQUEST['product_pictures']);

endif;
$rr=mysql_query("select * from " . $prev. "products where product_id=" . $_REQUEST[product_id]);
$product_title=mysql_result($rr,0,"product_title");

$msg="";
if($_REQUEST[Upload]):
        $t=time();

        @unlink("../product_pictures/" . $_REQUEST['picture_big_dell']);
		@unlink("../product_pictures/" . $_REQUEST['picture_small_dell']);
		$ext=substr($_FILES['product_pictures'][name],-3,3);

	    if($ext=="jpeg")
		{
			$ext="jpg";
			$_REQUEST['q']=2;
		}

	    if($ext=="gif")
		{

			$_REQUEST['q']=1;
		}
		if($ext=="png")
		{

			$_REQUEST['q']=3;
		}

	 	if(@copy($_FILES['product_pictures'][tmp_name],"../product_pictures/".$t."_" . $product_id . "_big." . $ext)):

		$new_productfile="../product_pictures/".$t."_" . $product_id . "_big." . $ext;

		@chmod("$new_productfile", 0777);
		$_REQUEST['src']=$new_productfile;
		$_REQUEST['dest']= "../product_pictures/".$t."_" . $product_id . "_small." . $ext;
			$_REQUEST['dest2']= "../product_pictures/".$t."_" . $product_id . "_big." . $ext;
			$_REQUEST['dest3']= "../product_pictures/".$t."_" . $product_id . "_tiny." . $ext;
			
			$_REQUEST['q']=100;
			$_REQUEST['x']=383;
			$_REQUEST['y']=310;
            $_REQUEST['x2']=1248;
			$_REQUEST['y2']=992;
			$_REQUEST['x3']=203;
			$_REQUEST['y3']=141;


		include("thumb_creator.php");

		@mysql_query("insert into " . $prev . "product_picture set picture_big='product_pictures/".$t."_" . $product_id . "_big." . $ext."',picture_small='product_pictures/".$t."_" . $product_id . "_small." . $ext."',product_id="  .  $_REQUEST[product_id]);


		//echo"insert into " . $prev . "product_picture set picture='" . $newfile . "',product_id="  .  $_REQUEST[product_id];
		$msg=" <img src='images/success.png' align=absmiddle> <font face='verdana' size='2' color='#111111'> <b>Update Successful.</b></font>";

	    else:
        	 $msg="<img src='images/error.png' align=absmiddle> <font face='verdana' size='2' color='red'><b>Action Failure.</b><br></font>";
	 	endif;

endif;


if($msg):
   echo"<br><table align='center' cellpadding='5' align='center' cellspacing='0' width='100%' style='border:solid 1px $dark'><tr><td align='center' height='25'><div class='lnk'>" .$msg . "</div></td></tr></table><br>";
endif;
?>
<form method="post" name="prod_entry" action="" enctype="multipart/form-data" >

<input type="hidden" name="product_id" value="<?=$_REQUEST[product_id]?>">
<input type="hidden" name="product_pictures" value="<?=$d[product_pictures]?>">

<table width="100%" border="0" align="center" cellpadding="4" cellspacing="0">
	<tr bgcolor=<?=$light?>><td height="25"  class="header"  style='border-bottom:solid 1px #333333'><a href='product.list.php' class="header" target="_parent">
	<u>Product Management</u></a> >  <?=$product_title?> > Add Picture </td>
	<td style='border-bottom:solid 1px #333333' align=right>

	<?if($_REQUEST[product_id] || $product_id){?>
		<a href='product.entryform.php?product_id=<?=$_REQUEST[product_id]?>' <?=active('product.entryform.php');?>><strong>Edit </strong></a> &nbsp;
		<a href='product.add.picture.php?product_id=<?=$_REQUEST[product_id]?>' <?=active('product.add.picture.php');?>><strong>Add more pictures</strong></a>  &nbsp;
		<a href='product.add.size.php?product_id=<?=$_REQUEST[product_id]?>' <?=active('product.add.size.php');?>><strong>Add more size</strong></a>  &nbsp;
		<a href='product.add.similar.php?product_id=<?=$_REQUEST[product_id]?>' <?=active('product.add.similar.php');?>><strong>Add similar products</strong></a>  &nbsp;
		<a href='product.add.color.php?product_id=<?=$_REQUEST[product_id]?>' <?=active('product.add.color.php');?>><strong>Add colors</strong></a>
    <?}?>

	</td>
	</tr>
  </table>
  <table id="table-1" width="100%" class="sort-table" border="0" align="center" cellspacing="1" cellpadding="4"  style="border:solid 1px <?=$dark?>">
	<thead>

		<tr>

		<td height="25" width=70><b>Picture(small)</b></td>
		<td height="25" width=70><b>Picture(big)</b></td>
		<td align="right"><b>Action</b></td>
		</tr>
	</thead>
	<tbody>
	<?
	$j=0;
    $r=mysql_query("select * from " . $prev . "product_picture where product_id=" . $_REQUEST[product_id]);
	while($d=@mysql_fetch_array($r)):
		if(!($j%2)){$class="even";}else{$class="odd";}
		echo"<tr bgcolor='#ffffff' class='" . $class . "' >
		<td>";

	    if($d[picture_small]):
             echo "<img src='../viewimage.php?img=".$d[picture_small]."&size=90' border=0>";
  	    endif;
	    echo"<td><img src='../viewimage.php?img=".$d[picture_big]."&size=120' border=0> </td><td align=right><a href=\"javascript:if(confirm('Are you sure you want to delete?')){window.location='" . $_SERVER['PHP_SELF'] .
			"?product_id=" . $d[product_id] . "&product_pictures=" . $d[product_pictures] . "&del=" . $d[id] . "';}\" class='lnk'><u>Delete</u></a>
			</td></tr>";
	    $j++;
	endwhile;
	echo"<tr bgcolor='#ffffff' class='" . $class . "' >
		<td colspan=2>Add New Small Picture <br> <input type='file' size='35' name='product_pictures' clas='lnk'><br>Picture size must be [W:832XH:672]	pxl.		</td>

		<td align=right><input type=submit name='Upload' value=' Save ' class=button></td>
	   </tr></tbody>
		</table>
</form>";

include("includes/footer.php");
?>

