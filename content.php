<?php 
include ("include/header.php"); 
$pg_id=$_REQUEST[pg_id];

$res_content=mysql_query("select * from ".$prev."contents where id='".$pg_id."' and status='Y'");
$n=mysql_num_rows($res_content);
$row_content=mysql_fetch_array($res_content);
?>
<!-----------Header End-----------------------------> 
<!----Start Container----->

<div id="container">
	<div class="login">
	<?php
	if($n>0)
	{
	?>
		<h2><?php echo $row_content['cont_title'];?></h2>
		<div style="float:left;">
			<?php echo html_entity_decode($row_content['contents']);?>
		</div>
	<?php
	}
	else
	{
	?>
		<h2>No Content found</h2>
	<?php
	}
	?>
	</div>
</div>
<!----End Container----->

<!--FOOTER BOX-->

<?php include ("include/footer.php");?> 

<!--FOOTER BOX END-->