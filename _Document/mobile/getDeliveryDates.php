<?php
include("configs/path.php");
include("getProducts.php");

$strZipCode = $_REQUEST['zip_code'];

$ins->getDeliveryDates(API_USER, API_PASSWORD, $strZipCode);

?>
<option value="">Select Delivery Date *</option>
<?php
foreach($ins->arrDates as $key => $val){
    echo '<option value="'.date('Y-m-d',strtotime($val. " +1 days")).'">'.date('l, jS F Y',  strtotime($val. " +1 days")).'</option>';
}
?>
