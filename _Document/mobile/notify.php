<?php
include("include_mobile/header.php");
include("getProducts.php");
ob_start();
$ip = $_SERVER['REMOTE_ADDR'];
$details = json_decode(file_get_contents("http://ipinfo.io/{$ip}/json"));
$header1 = "";
$header2 = "";
$header3s = "";

    if ($_REQUEST['save'] == 'Continue') {

        $deliverydate = $_POST['deliverydate'];
        $itemCode = $_POST['itemCode'];
        $experition_date = explode('/', $_POST['experition_date']);
        $ccExpMonth = $experition_date[0];
        $ccExpYear = $experition_date[1];

        $product = $ins->getProduct(API_USER, API_PASSWORD, $itemCode);
        $arrProducts = array(
            0 =>
            array(
                "code" => $product['code'],
                "price" => $product['price']
            ),
        );
        $ins->getTotal(API_USER, API_PASSWORD, $_POST['rzip'], $arrProducts, $strAffiliateServiceCharge = '', $strAffiliateTax = '');

        $arrRecipient = array("address1" => $_POST['raddress1'], "address2" => $_POST['raddress2'], "city" => $_POST['rcity'], "country" => $_POST['rcountry'], "email" => $_POST['cemail'], "institution" => $_POST['rattention'], "name" => $_POST['rfirstname'] . ' ' . $_POST['rlastname'], "phone" => $_POST['rphone'], "state" => $_POST['rstate'], "zip" => $_POST['rzip']);
        $arrCustomer = array("address1" => $_POST['caddress1'], "address2" => $_POST['caddress2'], "city" => $_POST['ccity'], "country" => $_POST['ccountry'], "email" => $_POST['cemail'], "institution" => $_POST['rattention'], "name" => $_POST['cfirstname'] . ' ' . $_POST['clastname'], "phone" => $_POST['cphone'], "state" => $_POST['cstate'], "zip" => $_POST['czip']);
        $customerIP = $ip;
        // $customerIP = '127.127.127.127';
        //$arrCCInfo = array("ccExpMonth"=>11,"ccExpYear"=>18,"ccNum"=>"4445999922225","ccSecCode"=>"999","ccType"=>"VI");$cardMsg = "I LOVE YOU LETISHA!!"; //ccNum->CreditCard Number
        $arrCCInfo = array("ccExpMonth" => $ccExpMonth, "ccExpYear" => $ccExpYear, "ccNum" => $_POST['ccardnum'], "ccSecCode" => $_POST['cvv2'], "ccType" => $_POST['ccardtype']);

        $cardMsg = trim($_POST['renclosure']); //ccNum->CreditCard Number
        $specialInstructions = trim($_POST['rinstructions']);
        $deliveryDate = $deliverydate . 'T' . date('H:i:s') . 'Z'; //"2015-04-29T05:00:00.000Z"; //you can get this value from getDeliveryDates() call... the value must be dateTime format eg: 2011-01-15T05:00:00.000Z
        $affiliateServiceCharge = "0";
        $affiliateTax = "0";
        $orderTotal = $product['price'] + $ins->arrTotal['serviceChargeTotal']; // You can get this value from getTotal() call.... $this->arrTotal['orderTotal'];
        $subAffiliateID = 0;

        $ins->placeOrder(API_USER, API_PASSWORD, $arrRecipient, $arrCustomer, $customerIP, $arrCCInfo, $arrProducts, $cardMsg, $specialInstructions, $deliveryDate, $affiliateServiceCharge, $affiliateTax, $orderTotal, $subAffiliateID); //return value stored in $this->arrOrder

        $email_message = "Flower Name - " . $product['name'] . "<br>";
        $email_message .="Price - $" . $product['price'] . "<br>";
        $email_message .="Total - $" . $orderTotal . "<br><br>";

        $email_message .="<b>SHIPPING DETAILS-</b> <br>";
        $email_message .="Delivery Date - " . $_POST['deliverydate'] . "<br>";
        $email_message .="Name - " . $_POST['rfirstname'] . " " . $_POST['rlastname'] . "<br>";
        $email_message .="Institution - " . $_POST['rattention'] . "<br>";
        $email_message .="Address1 - " . $_POST['raddress1'] . "<br>";
        $email_message .="Address2 - " . $_POST['raddress2'] . "<br>";
        $email_message .="City - " . $_POST['rcity'] . "<br>";
        $email_message .="State - " . $_POST['rstate'] . "<br>";
        $email_message .="Country - " . $_POST['rcountry'] . "<br>";
        $email_message .="Zip Code - " . $_POST['rzip'] . "<br>";
        $email_message .="Phone - " . $_POST['rphone'] . "<br><br>";

        $email_message .="<b>BILLING DETAILS-</b> <br>";
        $email_message .="Name - " . $_POST['cfirstname'] . " " . $_POST['clastname'] . "<br>";
        $email_message .="Address1 - " . $_POST['caddress1'] . "<br>";
        $email_message .="Address2 - " . $_POST['caddress2'] . "<br>";
        $email_message .="City - " . $_POST['ccity'] . "<br>";
        $email_message .="State - " . $_POST['cstate'] . "<br>";
        $email_message .="Country - " . $_POST['ccountry'] . "<br>";
        $email_message .="Zip Code - " . $_POST['czip'] . "<br>";
        $email_message .="Phone - " . $_POST['cphone'] . "<br><br>";

        $email_message .="<b>PAYMENT METHODS-</b><br>";
        $email_message .="Card - " . $_POST['ccardtype'] . "<br>";
        $email_message .="Name On Card - " . $_POST['ccardname'] . "<br>";
        $email_message .="Card No. - XXXXXXXXXX" . substr($_POST['ccardnum'], -4) . "<br>";
        $email_message .="Expriation Date - " . $_POST['experition_date'] . "<br><br>";

        $email_message .="<b>LOCATIONS-</b><br>";
        $email_message .="IP - " . $ip . "<br>";
        $email_message .="Country - " . $details->country . "<br>";
        $email_message .="State - " . $details->region . "<br>";
        $email_message .="City - " . $details->city;

        $to = 'flowerwyz@gmail.com';
        $subject = "Sending New Order";
        $headers = "From: admin@flowerwyz.com \r\n";
        $headers .= "MIME-Version: 1.0\r\n";
        $headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";
        mail($to, $subject, $email_message, $headers);



        if (count($ins->arrOrder)) {
            $header1 = "Thank You For Your Order!";
            $header2 = "We Will Get Started With It Right Away.";
            $header3 = "Your Order Number is:#".$ins->arrOrder['orderNumber'];
            $subject = "Completed New Order #" . $ins->arrOrder['orderNumber'];
            mail($to, $subject, $email_message, $headers);
        }
        else{
            $header1 = "OOPS! Your Order Didn't Go Through!";
            $header2 = "Something Went Wrong With Your Credit Card Payment.";
            $header3 = "Please Try With A Different Credit Card.";
        }
    }
    ?>
    <div class="innerWrap">         
    <div class="row-fluid">
        
         <div class="Content" id="section">
        <div class="content_first">
            <span class="header1"><?php echo $header1?></span>
            <span class="header2"><?php echo $header2; ?></span>
            <span class="header3"><?php echo $header3; ?></span>
        </div>
             <div style="clear: both"></div>
        <div class="content_secnd">
            <span class="header4">ALSO CHECK OUT SOME OF OUR BEST SELLING FLOWERS BELOW</span>
            <div class="line"></div>
            <table class="FeaturedProducts notify" width="100%" align="center" border="0" cellpadding="0" cellspacing="1">
                <tbody>
                    <tr> 
                        <td>
                            <div class="ProductImage ">
                                <a><img src="https://www.flowerwyz.com/images/send-flowers.jpg" alt="" height="211px" width="183px"></a>
                            </div>
                            <div class="ProductDetails">
                                <a>Send Flowers Anywhere</a>
                            </div>
                            <div class="ProductPriceRating">
                                <em>Lights of the Season</em>
                                <em>$49.95</em>
                            </div>
                            <div style="text-align:center; margin-top:5px;">
                                <a href="<?= $vpath; ?>item.php?code=B9-4833"  data-fancybox-type="iframe" class="splFancyIframe btn-pink">VIEW ITEM</a>
                            </div>
                        </td>
                        <td>
                            <div class="ProductImage ">
                                <a><img src="https://www.flowerwyz.com/images/online-flower-delivery.jpg" alt="" height="211px" width="183px"></a>
                            </div>
                            <div class="ProductDetails">
                                <a>Send Flowers Anywhere</a>
                            </div>
                            <div class="ProductPriceRating">
                                <em>The Winter Wishes Bouquet</em>
                                <em>$64.95</em>
                            </div>
                            <div style="text-align:center; margin-top:5px;">
                                <a href="<?= $vpath; ?>item.php?code=B17-4362"  data-fancybox-type="iframe" class="splFancyIframe btn-pink">VIEW ITEM</a>
                            </div>
                        </td>
                        <td>
                            <div class="ProductImage ">
                                <a><img src="https://www.flowerwyz.com/images/flowers-delivered.jpg" alt="" height="211px" width="183px"></a>
                            </div>
                            <div class="ProductDetails">
                                <a>Send Flowers Anywhere</a>
                            </div>
                            <div class="ProductPriceRating">
                                <em>Spirit of the Season</em>
                                <em>$49.95</em>
                            </div>
                            <div style="text-align:center; margin-top:5px;">
                                <a href="<?= $vpath; ?>item.php?code=B10-4787"  data-fancybox-type="iframe" class="splFancyIframe btn-pink">VIEW ITEM</a>
                            </div>
                        </td>
                        <td>
                            <div class="ProductImage ">
                                <a><img src="https://www.flowerwyz.com/images/deliver-flowers.jpg" alt="" height="211px" width="183px"></a>
                            </div>
                            <div class="ProductDetails">
                                <a>Send Flowers Anywhere</a>
                            </div>
                            <div class="ProductPriceRating">
                                <em>The Abundant Harvest Basket</em>
                                <em>$49.95</em>
                            </div>
                            <div style="text-align:center; margin-top:5px;">
                                <a href="<?= $vpath; ?>item.php?code=B3-4347"  data-fancybox-type="iframe" class="splFancyIframe btn-pink">VIEW ITEM</a>
                            </div>
                        </td>
                        <td>
                            <div class="ProductImage ">
                                <a><img src="https://www.flowerwyz.com/images/sending-flowers.jpg" alt="" height="211px" width="183px"></a>
                            </div>
                            <div class="ProductDetails">
                                <a>Send Flowers Anywhere</a>
                            </div>
                            <div class="ProductPriceRating">
                                <em>The Season's Glow Centerpiece</em>
                                <em>$59.95</em>
                            </div>
                            <div style="text-align:center; margin-top:5px;">
                                <a href="<?= $vpath; ?>item.php?code=B16-4830"  data-fancybox-type="iframe" class="splFancyIframe btn-pink">VIEW ITEM</a>
                            </div>
                        </td>
                    </tr>

                </tbody>
            </table>
        </div>
    </div>
        </div>
        </div>

<?php include("include_mobile/footer.php"); ?>