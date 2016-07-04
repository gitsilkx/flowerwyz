<?php
include("configs/path.php");
include("getProducts.php");
$amt = 0;
$j = 0;
$weight = 0;
$r = mysql_query("select " . $prev . "cart.*,products.name,products.price,products.product_no,products.id as product_id,products.flowerwyz_image," . $prev . "cart.type_id from " . $prev . "cart,products where " . $prev . "cart.product_id=products.id and " . $prev . "cart.OrderID='" . GetCartId() . "' and " . $prev . "cart.purchased='N'");
?>
<!DOCTYPE HTML>
<html xmlns="http://www.w3.org/1999/xhtml">
    <!--<html lang="en">-->
    <head>
        <style>
            .prev_step.disabled .btn-link {
                background-image: -webkit-gradient(linear, left 0, left 100%, from(#f5f5f5 ), to(#f1f1f1));
                background-image: -webkit-linear-gradient(top, #f5f5f5 , 0%, #f1f1f1, 100%);
                background-image: -moz-linear-gradient(top, #f5f5f5 0, #f1f1f1 100%);
                /* background-image: linear-gradient(to bottom, #f5f5f5 0, #f1f1f1 100%); */
                /* background-repeat: repeat-x; */
                border: 1px solid #f1f1f1;
                filter: progid:DXImageTransform.Microsoft.gradient(startColorstr='#f5f5f5 ', endColorstr='#f1f1f1', GradientType=0);
                filter: progid:DXImageTransform.Microsoft.gradient(enabled=false);
            }


            label.warning {
                color: red;
                font-size:12px;
                margin-bottom:0px;
            }
            p.warning {
                color: #F00;
                font-size: 12px;
                margin-bottom: 0px;
            }
			.HideTodayButton .ui-datepicker-buttonpane .ui-datepicker-current
                        {
                            visibility:hidden;
                        }

                        .hide-calendar .ui-datepicker-calendar
                        {
                            display:none!important;
                            visibility:hidden!important
                        }
        </style>
        <!-- bootstrap framework-->
        <meta name="viewport" content="width=device-width, initial-scale=1" />
        <link rel="stylesheet" href="<?= $vpath ?>bootstrap/css/bootstrap.min.css">
            <title>FlowerWyz Secure Checkout</title>
            <!-- ebro styles -->
            <link rel="stylesheet" href="<?= $vpath ?>css/flower.css">
                <meta name="robots" content="noindex,nofollow" />

                <link rel="stylesheet" type="text/css" href="<?= $vpath ?>css/layout.css"/>
                <!-- jQuery -->
                <script type="text/javascript" src="<?= $vpath ?>js/jquery.min.js"></script>
                <!-- bootstrap framework -->
                <script type="text/javascript" src="<?= $vpath ?>bootstrap/js/bootstrap.min.js"></script>
                <!-- jQuery resize event -->
                <script type="text/javascript" src="<?= $vpath ?>js/jquery.ba-resize.min.js"></script>
                <!-- jquery cookie -->
                <script type="text/javascript" src="<?= $vpath ?>js/jquery_cookie.min.js"></script>
                <!-- retina ready -->
                <script type="text/javascript" src="<?= $vpath ?>js/retina.min.js"></script>
                <!-- tinyNav -->
                <script type="text/javascript" src="<?= $vpath ?>js/tinynav.js"></script>
                <!-- sticky sidebar -->
                <script type="text/javascript" src="<?= $vpath ?>js/jquery.sticky.js"></script>
                <!-- Navgoco -->
                <script type="text/javascript" src="<?= $vpath ?>js/lib/navgoco/jquery.navgoco.min.js"></script>
                <!-- jMenu -->
                <script type="text/javascript" src="<?= $vpath ?>js/lib/jMenu/js/jMenu.jquery.js"></script>
                <!-- typeahead -->
                <script type="text/javascript" src="<?= $vpath ?>js/lib/typeahead.js/typeahead.min.js"></script>
                <script type="text/javascript" src="<?= $vpath ?>js/lib/typeahead.js/hogan-2.0.0.js"></script>
                <script type="text/javascript" src="<?= $vpath ?>js/ebro_common.js"></script>

                <!-- clender -->
                <link  type="text/css" rel="stylesheet" href="<?= $vpath ?>css/jquery-ui.css">

                    <script type="text/javascript" src="<?= $vpath ?>js/jquery-ui.js"></script>

                    <!-- jquery steps -->
                    <script type="text/javascript" src="<?= $vpath ?>js/lib/jquery-steps/jquery.steps.min.js"></script>
                    <!-- parsley -->

                    <script type="text/javascript" src="<?= $vpath ?>js/jquery.validate.js"></script>

                    <script>
                        $(function() {
                            $("#datepicker").datepicker({
                                changeMonth: true,
                                changeYear: true,
                                minDate: 0,
                                maxDate: 30,
                                dateFormat: 'mm/dd/yy'
                            });

                            $(".monthPicker").datepicker({
                                dateFormat: 'mm-yy',
                                changeMonth: true,
                                changeYear: true,
                                showButtonPanel: true,
                                onClose: function(dateText, inst) {
                                    // var month = $("#ui-datepicker-div .ui-datepicker-month :selected").val();
                                    //var year = $("#ui-datepicker-div .ui-datepicker-year :selected").val();
                                    $(this).val($.datepicker.formatDate('mm/y', new Date(inst.selectedYear, inst.selectedMonth, 1)));
                                    //$(this).val($.datepicker.formatDate('mm/yy', new Date(year, month, 1)));
                                }
                            });

                            $(".monthPicker").focus(function() {
                                $(".ui-datepicker-calendar").hide();
                                $("#ui-datepicker-div").position({
                                    my: "center top",
                                    at: "center bottom",
                                    of: $(this)
                                });
                            });



                        });


                        $(function() {
                            var flagOne = false;
                            var flagTwo = false;
                            var flagThree = false;
                            var flagFour = false;
                            var FULL_BASE_URL = $('#hidden_site_baseurl').val(); // For base path of value;
                           

                            var v = $(".cmxform").validate({
                                errorClass: "warning",
                                onkeyup: false,
                                onfocusout: false,
                                submitHandler: function() {
                                    v.submit();
                                }
                            });

                            $("#accorBodyTwo").hide();
                            $("#accorBodyThree").hide();
                            $("#accorBodyFour").hide();

                            $("#goAccorTwo").click(function() {

                                $("#accorBodyTwo").show(400);
                                $("#accorBodyOne").hide(400);
                                $("#accorHeadOne").removeClass("selected");
                                $('#accorHeadOne').find('span').remove();
                                $("#accorHeadOne").prepend('<span class="label-green glyphicon glyphicon-ok"></span>');
                                $("#accorHeadTwo").addClass("selected");
                                flagOne = true;
                            });
                            $("#goAccorThree").click(function() {
                                if (v.form()) {

                                    $("#accorBodyThree").show(400);
                                    $("#accorBodyTwo").hide(400);
                                    $("#accorHeadTwo").removeClass("selected");
                                    $('#accorHeadTwo').find('span').remove();
                                    $("#accorHeadTwo").prepend('<span class="label-green glyphicon glyphicon-ok"></span>');
                                    $("#accorHeadThree").addClass("selected");

                                    flagTwo = true;
                                }
                            });
                            $("#goAccorFour").click(function() {
                                if (v.form()) {
                                    
                                var zip_code = $('#rzip').val();
                                var itemCode = $('#itemCode').val();
                                var dataString = 'zip_code=' + zip_code + '&itemCode=' + itemCode;
                                $('#ajaxCartSummary').addClass('loader1');
                              
                                    $("#accorBodyFour").show(400);
                                    $("#accorBodyThree").hide(400);
                                    $("#accorHeadThree").removeClass("selected");
                                    $('#accorHeadThree').find('span').remove();
                                    $("#accorHeadThree").prepend('<span class="label-green glyphicon glyphicon-ok"></span>');
                                    $("#accorHeadFour").addClass("selected");
                                    
                                    
                                    
                                    flagThree = true;
                                    //flagFour = true;
                                }
                            });
                            $("#finalPay").click(function() {
                                if (v.form()) {

                                    flagFour = true;


                                }

                            });

                            $("#accorHeadOne").click(function() {
                                if (flagOne == true) {

                                    $("#accorBodyOne").show(400);
                                    $("#accorBodyTwo").hide(400);
                                    $("#accorBodyThree").hide(400);
                                    $("#accorBodyFour").hide(400);
                                    $("#accorBodyFour").hide(400);
                                    $("#goAccorTwo").click(function() {
                                        $("#accorBodyTwo").show(400);
                                        $("#accorBodyOne").hide(400);
                                        $("#accorHeadOne").removeClass("selected");
                                        $('#accorHeadOne').find('span').remove();
                                        $("#accorHeadOne").prepend('<span class="label-green glyphicon glyphicon-ok"></span>');
                                        $("#accorHeadTwo").addClass("selected");
                                        flagOne = true;
                                    });
                                    $('#accorHeadOne').find('span').remove();
                                    $("#accorHeadOne").prepend('<span class="label label-dark">1</span>');
                                    $("#accorHeadOne").addClass("selected");
                                    $('#accorHeadTwo').find('span').remove();
                                    $("#accorHeadTwo").removeClass("selected");
                                    $("#accorHeadTwo").prepend('<span class="label label-dark">2</span>');
                                    $('#accorHeadThree').find('span').remove();
                                    $("#accorHeadThree").removeClass("selected");
                                    $("#accorHeadThree").prepend('<span class="label label-dark">3</span>');
                                    $('#accorHeadFour').find('span').remove();
                                    $("#accorHeadFour").removeClass("selected");
                                    $("#accorHeadFour").prepend('<span class="label label-dark">4</span>');
                                    flagTwo = false;
                                    flagThree = false;
                                    flagFour = false;
                                }

                            });
                            $("#accorHeadTwo").click(function() {
                                if (flagTwo == true) {

                                    if (v.form()) {

                                        $("#accorBodyTwo").show(400);
                                        $("#accorBodyOne").hide(400);
                                        $("#accorBodyThree").hide(400);
                                        $("#accorBodyFour").hide(400);
                                        $("#goAccorThree").click(function() {
                                            $("#accorBodyThree").show(400);
                                            $("#accorBodyTwo").hide(400);
                                            $("#accorHeadTwo").removeClass("selected");
                                            $('#accorHeadTwo').find('span').remove();
                                            $("#accorHeadTwo").prepend('<span class="label-green glyphicon glyphicon-ok"></span>');
                                            $("#accorHeadThree").addClass("selected");

                                            flagTwo = true;
                                        });
                                        $('#accorHeadTwo').find('span').remove();
                                        $("#accorHeadTwo").addClass("selected");
                                        $("#accorHeadTwo").prepend('<span class="label label-dark">2</span>');
                                        $('#accorHeadThree').find('span').remove();
                                        $("#accorHeadThree").removeClass("selected");
                                        $("#accorHeadThree").prepend('<span class="label label-dark">3</span>');
                                        $('#accorHeadFour').find('span').remove();
                                        $("#accorHeadFour").removeClass("selected");
                                        $("#accorHeadFour").prepend('<span class="label label-dark">4</span>');
                                        flagThree = false;
                                        flagFour = false;
                                    }

                                }
                            })
                            $("#accorHeadThree").click(function() {
                                if (flagThree == true) {

                                    if (v.form()) {
                                        $("#accorBodyThree").show(400);
                                        $("#accorBodyOne").hide(400);
                                        $("#accorBodyTwo").hide(400);
                                        $("#accorBodyFour").hide(400);
                                        $("#goAccorFour").click(function() {
                                            $("#accorBodyFour").show(400);
                                            $("#accorBodyThree").hide(400);
                                            $("#accorHeadThree").removeClass("selected");
                                            $('#accorHeadThree').find('span').remove();
                                            $("#accorHeadThree").prepend('<span class="label-green glyphicon glyphicon-ok"></span>');
                                            $("#accorHeadFour").addClass("selected");
                                            flagThree = true;
                                            //flagFour = true;
                                        });
                                        $('#accorHeadThree').find('span').remove();
                                        $("#accorHeadThree").addClass("selected");
                                        $("#accorHeadThree").prepend('<span class="label label-dark">3</span>');
                                        $('#accorHeadFour').find('span').remove();
                                        $("#accorHeadFour").removeClass("selected");
                                        $("#accorHeadFour").prepend('<span class="label label-dark">4</span>');
                                        flagFour = false;
                                    }

                                }
                            })
                            $("#accorHeadFour").click(function() {
                                if (flagFour == true) {

                                    if (v.form()) {
                                        $("#accorBodyFour").show(400);
                                        $("#accorBodyThree").hide(400);
                                        $("#accorBodyOne").hide(400);
                                        $("#accorBodyTwo").hide(400);
                                    }



                                }
                            })



                        });

                        function formatPhone(obj) {

                            var numbers = obj.value.replace(/\D/g, ''),
                                    char = {0: '(', 3: ') ', 6: ' '};

                            obj.value = '';
                            for (var i = 0; i < numbers.length; i++) {
                                obj.value += (char[i] || '') + numbers[i];
                            }

                        }
                        
                        function masking(input, textbox,e) {
                                    if (input.length == 4 || input.length == 9 || input.length == 14) {
                                        if(e.keyCode != 8){
                                          input = input + '-';
                                        }
                                        textbox.value = input;
                                    }
                        }
                        
                        function validatePhone(phoneText) {
	
                            str = phoneText.replace(/[^0-9#]/g, '');
                            var filter = /^[0-9]{10}$/;
                            if (!filter.test(str)) {
                                $('#val-rphone-error').text('Invalid Phone Number.');
                            //alert('Invalid Phone Number.');
                            $("#rphone").focus();
                            $('#rphone').val('');
                            
                            }
                            else{
                                $('#val-rphone-error').text('');
                            }
                            
                        }
                        
                        function validateCPhone(phoneText) {
	
                            str = phoneText.replace(/[^0-9#]/g, '');
                            var filter = /^[0-9]{10}$/;
                            if (!filter.test(str)) {
                                $('#val-cphone-error').text('Invalid Phone Number.');
                            //alert('Invalid Phone Number.');
                            $("#cphone").focus();
                            $('#cphone').val('');
                            
                            }
                            else{
                                $('#val-cphone-error').text('');
                            }
                            
                        }
                        
                        function validateCard(cardText) {
	
                            str = cardText.replace(/[^0-9#]/g, '');                     
                            var filter = /^[0-9]{16}$/;
                            if (!filter.test(str)) {
                                $('#Vali-ccardnum-error').text('Invalid Card Number.');
                            //alert('Invalid Phone Number.');
                            $("#ccardnum").focus();
                            $('#ccardnum').val('');
                            
                            }
                            else{
                                $('#Vali-ccardnum-error').text('');
                            }
                            
                        }
                    </script>
                    <style>

                        .HideTodayButton .ui-datepicker-buttonpane .ui-datepicker-current
                        {
                            visibility:hidden;
                        }

                        .hide-calendar .ui-datepicker-calendar
                        {
                            display:none!important;
                            visibility:hidden!important
                        }

                    </style>

                    <script type="text/javascript">

                        var ThumbImageWidth = 183;
                        var ThumbImageHeight = 183;

                        (function(i, s, o, g, r, a, m) {
                            i['GoogleAnalyticsObject'] = r;
                            i[r] = i[r] || function() {
                                (i[r].q = i[r].q || []).push(arguments)
                            }, i[r].l = 1 * new Date();
                            a = s.createElement(o),
                                    m = s.getElementsByTagName(o)[0];
                            a.async = 1;
                            a.src = g;
                            m.parentNode.insertBefore(a, m)
                        })(window, document, 'script', '//www.google-analytics.com/analytics.js', 'ga');

                        ga('create', 'UA-57269771-1', 'auto');
                        ga('send', 'pageview');
                   </script>
             </head>



                    <div class="container page-container">
                        <div class="row">
                            <div class="col-sm-12">
                                <h2 class="page-heading">FlowerWyz Secure Checkout</h2>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-9">

                                <div class="panel panel-default checkout-panel">
                                    <div class="panel-body">
                                        <h3>Secure Checkout</h3>
                                        <form class="cmxform" id="cmxform" method="post" action="<?= $vpath; ?>notify.php">
                                            <input type="hidden" name='itemCode' id="itemCode" value="<?php echo $_GET['code']; ?>">
                                                <input type="hidden" name='action_type' id="ActionType" value="0">

                                                    <input type="hidden" name='save' value="Continue" >
                                                        <input type="hidden" name='hidden_site_baseurl' id="hidden_site_baseurl" value="<?php echo $vpath; ?>">
                                                            <div class="panel panel-default accord-container" style="border-radius:0px;">
                                                                <div class="panel-heading selected" id="accorHeadOne"><span class="label label-dark">1</span>Review Cart</div>
                                                                <div class="panel-body" id="accorBodyOne">
                                                                    <fieldset data-step="0">
                                                                        <div class="row">
                                                                            <div class="col-sm-12" id="review-cart">
                                                                                <table class="table cart-contents">
                                                                                    <tbody>
                                                                                        <tr class="background">
                                                                                            <th>Item</th>
                                                                                           <th style="width: 28%;text-align: center;">Delivery Date</th>
                                                                                            <th class="text-center">Quantity</th>
                                                                                            <th class="text-right">Unit Price</th>
                                                                                             <th class="text-right">&nbsp;</th>
                                                                                        </tr>
                                                                                        <?php
                                                                                        $amt = 0;
                                                                                        $j = 0;
                                                                                        $weight = 0;
                                                                                        $r = mysql_query("select " . $prev . "cart.*,products.name,products.price,products.product_no,products.id as product_id,products.flowerwyz_image," . $prev . "cart.type_id from " . $prev . "cart,products where " . $prev . "cart.product_id=products.id and " . $prev . "cart.OrderID='" . GetCartId() . "' and " . $prev . "cart.purchased='N'");
                                                                                        $totRow = mysql_num_rows($r);
                                                                                        while ($product = @mysql_fetch_array($r)):                                                                                       
                                                                                        ?>
                                                                                       <tr id="cart_<?=$product[id]?>">
                                                                                            <td><span style="text-transform:uppercase"><b><?php echo $product['name']; ?></b></span><br />Delivered to All Zip Codes, USA & Canada.</td>
                                                                                            <td class="text-left">
                                                                                               17/04/2016
                                                                                            </td>
                                                                                            <td class="text-center"><?php echo $product['qty']; ?></td>
                                                                                            <td class="text-right"><?= $setting['currency'] ?> <?php echo $product['total']; ?>&nbsp;&nbsp;</td>
                                                                                            <td class="text-right"><img src="<?=$vpath?>images/cut.png" alt="" style="border:0; padding:0; float:none; margin:0; cursor:pointer"  onclick="removepr('<?=$product[id]?>,<?=$product[product_id]?>')"/></td>
                                                                                        </tr>
                                                                                        <?php 
                                                                                        $amt+=$product[qty] * $product[price];
                                                                                        endwhile;?>
                                                                                        <tr>
                                                                                            <td>&nbsp;</td>
                                                                                            <td colspan="4" class="text-right"><span style="font-size:18px; font-weight:bold;">Current Total <span class="td1bg3" id="td1bg3p"><?=$setting[currency]." " . sprintf("%01.2f",$amt)?></span></span></td>
                                                                                        </tr>
                                                                                    </tbody>
                                                                                </table>
                                                                            </div>
                                                                        </div>
                                                                    </fieldset>
                                                                    <!--<small class="pull-left" style="font-size:10px; color:#6f889b; margin:12px 0 0 10px;">*Before service charges and taxes</small>--><button type="button" class="green-btn pull-right" id="goAccorTwo">Continue to Recipient Information</button>
                                                                </div>
                                                            </div>

                                                            <div class="panel panel-default accord-container" style="border-radius:0px; margin-top:-1px;">
                                                                <div class="panel-heading" id="accorHeadTwo"><span class="label label-dark">2</span>Recipient Information</div>
                                                                <div class="panel-body" id="accorBodyTwo">
                                                                    <fieldset data-step="1">

                                                                        <div class="row">
                                                                            <div class="col-sm-6">
                                                                                <div class="form_sep">

                                                                                    <input id="rfirstname" name="rfirstname" placeholder="First Name*" type="text" class="form-control" required="required">
                                                                                </div>
                                                                            </div>
                                                                            <div class="col-sm-6">
                                                                                <div class="form_sep">

                                                                                    <input id="rlastname" name="rlastname" placeholder="Last Name*" type="text" class="form-control" required="required">
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="row">
                                                                            <div class="col-sm-6">
                                                                                <div class="form_sep">

                                                                                    <input id="rattention" name="rattention" placeholder="Institution" type="text" class="form-control">
                                                                                </div>
                                                                            </div>
                                                                            <div class="col-sm-6">
                                                                                <div class="form_sep">

                                                                                    <input id="rphone" name="rphone" type="text" placeholder="Phone*" class="form-control" onKeyUp="formatPhone(this);" onBlur="validatePhone(this.value)" maxlength="14" required="required" autocomplete="off">
                                                                                    <p for="rphone" class="warning" id="val-rphone-error"></p>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="row">
                                                                            <div class="col-sm-6">
                                                                                <div class="form_sep">

                                                                                    <input id="raddress1" name="raddress1" type="text" placeholder="Address*" class="form-control" required="required">
                                                                                </div>
                                                                            </div>
                                                                            <div class="col-sm-6">
                                                                                <div class="form_sep">

                                                                                    <input id="raddress2" name="raddress2" type="text" placeholder="Address 2" class="form-control">
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="row">
                                                                            <div class="col-sm-6">
                                                                                <div class="form_sep cust-select">

                                                                                    <select id="rcountry" onChange="this.className=this.options[this.selectedIndex].className" class="greenText" required="required" name="rcountry">
                                                                                        <option value="" class="first_option">--Select Country*--</option>
                                                                                        <option value="US">United States</option>
                                                                                        <option value="CA">Canada</option>
                                                                                    </select>
                                                                                </div>
                                                                            </div>
                                                                            <div class="col-sm-6">
                                                                                <div class="form_sep cust-select">

                                                                                    <select onChange="this.className=this.options[this.selectedIndex].className"
    class="greenText" id="rstate"  name="rstate" required="required">
                                                                                        <option value="">--Select State*--</option>
                                                                                        <option value="x" disabled="disabled">&nbsp;</option>
                                                                                        <option value="x" disabled="disabled">--United States--</option>
                                                                                        <option value="AP">APO/FPO</option>
                                                                                        <option value="AL">Alabama</option>
                                                                                        <option value="AK">Alaska</option>
                                                                                        <option value="AZ">Arizona</option>
                                                                                        <option value="AR">Arkansas</option>
                                                                                        <option value="CA">California</option>
                                                                                        <option value="CO">Colorado</option>
                                                                                        <option value="CT">Connecticut</option>
                                                                                        <option value="DE">Delaware</option>
                                                                                        <option value="DC">District of Columbia</option>
                                                                                        <option value="FL">Florida</option>
                                                                                        <option value="GA">Georgia</option>
                                                                                        <option value="HI">Hawaii</option>
                                                                                        <option value="ID">Idaho</option>
                                                                                        <option value="IL">Illinois</option>
                                                                                        <option value="IN">Indiana</option>
                                                                                        <option value="IA">Iowa</option>
                                                                                        <option value="KS">Kansas</option>
                                                                                        <option value="KY">Kentucky</option>
                                                                                        <option value="LA">Louisiana</option>
                                                                                        <option value="ME">Maine</option>
                                                                                        <option value="MD">Maryland</option>
                                                                                        <option value="MA">Massachusetts</option>
                                                                                        <option value="MI">Michigan</option>
                                                                                        <option value="MN">Minnesota</option>
                                                                                        <option value="MS">Mississippi</option>
                                                                                        <option value="MO">Missouri</option>
                                                                                        <option value="MT">Montana</option>
                                                                                        <option value="NC">North Carolina</option>
                                                                                        <option value="ND">North Dakota</option>
                                                                                        <option value="NE">Nebraska</option>
                                                                                        <option value="NV">Nevada</option>
                                                                                        <option value="NH">New Hampshire</option>
                                                                                        <option value="NJ">New Jersey</option>
                                                                                        <option value="NM">New Mexico</option>
                                                                                        <option value="NY">New York</option>
                                                                                        <option value="OH">Ohio</option>
                                                                                        <option value="OK">Oklahoma</option>
                                                                                        <option value="OR">Oregon</option>
                                                                                        <option value="PA">Pennsylvania</option>
                                                                                        <option value="PR">Puerto Rico</option>
                                                                                        <option value="RI">Rhode Island</option>
                                                                                        <option value="SC">South Carolina</option>
                                                                                        <option value="SD">South Dakota</option>
                                                                                        <option value="TN">Tennessee</option>
                                                                                        <option value="TX">Texas</option>
                                                                                        <option value="UT">Utah</option>
                                                                                        <option value="VT">Vermont</option>
                                                                                        <option value="VI">Virgin Islands</option>
                                                                                        <option value="VA">Virginia</option>
                                                                                        <option value="WV">West Virginia</option>
                                                                                        <option value="WA">Washington</option>
                                                                                        <option value="WI">Wisconsin</option>
                                                                                        <option value="WY">Wyoming</option>
                                                                                        <option value="x" disabled="disabled">&nbsp;</option>
                                                                                        <option value="x" disabled="disabled">--Canada--</option>
                                                                                        <option value="AB">Alberta</option>
                                                                                        <option value="BC">British Columbia</option>
                                                                                        <option value="MB">Manitoba</option>
                                                                                        <option value="NB">New Brunswick</option>
                                                                                        <option value="NF">Newfoundland</option>
                                                                                        <option value="NT">North West Territory</option>
                                                                                        <option value="NS">Nova Scotia</option>
                                                                                        <option value="ON">Ontario</option>
                                                                                        <option value="PE">Prince Edward Island</option>
                                                                                        <option value="PQ">Quebec</option>
                                                                                        <option value="SK">Saskatchewan</option>
                                                                                        <option value="YT">Yukon Territory</option>
                                                                                        <option value="x" disabled="disabled">&nbsp;</option>
                                                                                        <option value="OS">Other State / Province</option>
                                                                                    </select>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="row">
                                                                            <div class="col-sm-6">
                                                                                <div class="form_sep">

                                                                                    <input id="rcity" name="rcity" type="text" placeholder="City*" class="form-control" required="required">
                                                                                </div>
                                                                            </div>
                                                                            <div class="col-sm-6">
                                                                                <div class="form_sep">

                                                                                    <input id="rzip" name="rzip" type="text" placeholder="Zip Code*" class="form-control" required="required">
                                                                                </div>
                                                                            </div>
                                                                        </div>



                                                                        <div class="row">
                                                                            <div class="col-sm-12">
                                                                                <div class="form_sep">
                                                                                    <label class="req">Message On Card</label>
                                                                                    <textarea id="renclosure" class="form-control" rows="3" required="required" name="renclosure" maxlength="200" placeholder="Please enter your personalized message here. Don't forget to add your name."></textarea>
                                                                                </div>
                                                                                <div class="form_sep">
                                                                                    <label>Special Delivery Instructions</label>
                                                                                    <textarea id="rinstructions" class="form-control" rows="3" name="rinstructions" placeholder="If you have specific instructions for our delivery team, you may add them here." maxlength="200"></textarea>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="row">
                                                                            <div class="col-sm-6">
                                                                                <div class="form_sep cust-select">
                                                                                       <!-- <input type="text" name="deliverydate" id="datepicker"  data-required="true" placeholder="Select Delivery Date*" class="form-control" />-->
                                                                                    <select onChange="this.className=this.options[this.selectedIndex].className"
    class="greenText" name="deliverydate" id="deliverydate" required="required">
                                                                                        <option value="">Select Delivery Date *</option>

                                                                                    </select>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </fieldset>
                                                                    <button type="button" style="margin-top:10px;" class="green-btn pull-right" id="goAccorThree">Continue to Billing Information</button>
                                                                </div>
                                                            </div>

                                                            <div class="panel panel-default accord-container" style="border-radius:0px; margin-top:-1px;">
                                                                <div class="panel-heading" id="accorHeadThree"><span class="label label-dark">3</span>Billing Information</div>
                                                                <div class="panel-body" id="accorBodyThree">
                                                                    <fieldset data-step="2">

                                                                        <div class="row">
                                                                            <div>
                                                                                <label class="checkbox inline" style="padding: 0;margin: 0px 0px 5px 37px;">
                                                                                    <input name="shipping_chk" id="shipping_chk" type="checkbox" >
                                                                                        Same as recipient information.</label>
                                                                            </div>
                                                                            <div class="col-sm-6">
                                                                                <div class="form_sep">

                                                                                    <input id="cfirstname" name="cfirstname" placeholder="First Name*" type="text" class="form-control" required="required">
                                                                                </div>
                                                                            </div>
                                                                            <div class="col-sm-6">
                                                                                <div class="form_sep">

                                                                                    <input id="clastname" name="clastname" type="text" placeholder="Last name*" class="form-control" required="required" data-minlength="3">
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="row">
                                                                            <div class="col-sm-6">
                                                                                <div class="form_sep">

                                                                                    <input id="caddress1" name="caddress1" type="text" placeholder="Address*" class="form-control" required="required">
                                                                                </div>
                                                                            </div>
                                                                            <div class="col-sm-6">
                                                                                <div class="form_sep">

                                                                                    <input id="caddress2" name="caddress2" placeholder="Address 2" type="text" class="form-control">
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="row">
                                                                            <div class="col-sm-6">
                                                                                <div class="form_sep cust-select">
                                                                                    <select onChange="this.className=this.options[this.selectedIndex].className"
    class="greenText" id="ccountry" required="required" name="ccountry">

                                                                                        <option value="" selected="selected">--Select Country--</option>

                                                                                        <option value="US">United States</option>

                                                                                        <option value="CA">Canada</option>

                                                                                        <option value="x" disabled="disabled">-----------------------</option>

                                                                                        <option value="AF">Afghanistan</option>

                                                                                        <option value="AL">Albania</option>

                                                                                        <option value="DZ">Algeria</option>

                                                                                        <option value="AS">American Samoa</option>

                                                                                        <option value="AD">Andorra</option>

                                                                                        <option value="AO">Angola</option>

                                                                                        <option value="AI">Anguilla</option>

                                                                                        <option value="AQ">Antarctica</option>

                                                                                        <option value="AG">Antigua and Barbuda</option>

                                                                                        <option value="AR">Argentina</option>

                                                                                        <option value="AM">Armenia</option>

                                                                                        <option value="AW">Aruba</option>

                                                                                        <option value="AU">Australia</option>

                                                                                        <option value="AT">Austria</option>

                                                                                        <option value="AZ">Azerbaijan</option>

                                                                                        <option value="BS">Bahamas</option>

                                                                                        <option value="BH">Bahrain</option>

                                                                                        <option value="BD">Bangladesh</option>

                                                                                        <option value="BB">Barbados</option>

                                                                                        <option value="BY">Belarus</option>

                                                                                        <option value="BE">Belgium</option>

                                                                                        <option value="BZ">Belize</option>

                                                                                        <option value="BJ">Benin</option>

                                                                                        <option value="BM">Bermuda</option>

                                                                                        <option value="BT">Bhutan</option>

                                                                                        <option value="BO">Bolivia</option>

                                                                                        <option value="BA">Bosnia - Herzegovina</option>

                                                                                        <option value="BW">Botswana</option>

                                                                                        <option value="BV">Bouvet Island</option>

                                                                                        <option value="BR">Brazil</option>

                                                                                        <option value="IO">British Indian Ocean Ter.</option>

                                                                                        <option value="BN">Brunei Darussalam</option>

                                                                                        <option value="BG">Bulgaria</option>

                                                                                        <option value="BF">Burkina Faso</option>

                                                                                        <option value="BI">Burundi</option>

                                                                                        <option value="KH">Cambodia</option>

                                                                                        <option value="CM">Cameroon</option>

                                                                                        <option value="CA">Canada</option>

                                                                                        <option value="CV">Cape Verde</option>

                                                                                        <option value="KY">Cayman Islands</option>

                                                                                        <option value="CF">Central African Republic</option>

                                                                                        <option value="TD">Chad</option>

                                                                                        <option value="CL">Chile</option>

                                                                                        <option value="CN">China</option>

                                                                                        <option value="CX">Christmas Island</option>

                                                                                        <option value="CC">Cocos (Keeling) Islands</option>

                                                                                        <option value="CO">Colombia</option>

                                                                                        <option value="KM">Comoros</option>

                                                                                        <option value="CG">Congo</option>

                                                                                        <option value="CK">Cook Islands</option>

                                                                                        <option value="CR">Costa Rica</option>

                                                                                        <option value="CI">Cote D'Ivoire(Ivory Coast)</option>

                                                                                        <option value="HR">Croatia</option>

                                                                                        <option value="CU">Cuba</option>

                                                                                        <option value="CY">Cyprus</option>

                                                                                        <option value="CZ">Czech Republic</option>

                                                                                        <option value="DK">Denmark</option>

                                                                                        <option value="DJ">Djibouti</option>

                                                                                        <option value="DM">Dominica</option>

                                                                                        <option value="DO">Dominican Republic</option>

                                                                                        <option value="TP">East Timor</option>

                                                                                        <option value="EC">Ecuador</option>

                                                                                        <option value="EG">Egypt</option>

                                                                                        <option value="SV">El Salvador</option>

                                                                                        <option value="GQ">Equatorial Guinea</option>

                                                                                        <option value="ER">Eritrea</option>

                                                                                        <option value="EE">Estonia</option>

                                                                                        <option value="ET">Ethiopia</option>

                                                                                        <option value="FK">Falkland Islands</option>

                                                                                        <option value="FO">Faroe Islands</option>

                                                                                        <option value="FJ">Fiji</option>

                                                                                        <option value="FI">Finland</option>

                                                                                        <option value="FR">France</option>

                                                                                        <option value="GF">French Guyana</option>

                                                                                        <option value="PF">French Polynesia</option>

                                                                                        <option value="GA">Gabon</option>

                                                                                        <option value="GM">Gambia</option>

                                                                                        <option value="GE">Georgia</option>

                                                                                        <option value="DE">Germany</option>

                                                                                        <option value="GH">Ghana</option>

                                                                                        <option value="GI">Gibraltar</option>

                                                                                        <option value="GR">Greece</option>

                                                                                        <option value="GL">Greenland</option>

                                                                                        <option value="GD">Grenada</option>

                                                                                        <option value="GP">Guadeloupe</option>

                                                                                        <option value="GU">Guam</option>

                                                                                        <option value="GT">Guatemala</option>

                                                                                        <option value="GN">Guinea</option>

                                                                                        <option value="GW">Guinea-Bissau</option>

                                                                                        <option value="GY">Guyana</option>

                                                                                        <option value="HT">Haiti</option>

                                                                                        <option value="HM">Heard &amp; McDonald Islands</option>

                                                                                        <option value="VA">Holy See (Vatican City)</option>

                                                                                        <option value="HN">Honduras</option>

                                                                                        <option value="HK">Hong Kong</option>

                                                                                        <option value="HU">Hungary</option>

                                                                                        <option value="IS">Iceland</option>

                                                                                        <option value="IN">India</option>

                                                                                        <option value="ID">Indonesia</option>

                                                                                        <option value="IR">Iran</option>

                                                                                        <option value="IE">Ireland</option>

                                                                                        <option value="IL">Israel</option>

                                                                                        <option value="IT">Italy</option>

                                                                                        <option value="JM">Jamaica</option>

                                                                                        <option value="JP">Japan</option>

                                                                                        <option value="JO">Jordan</option>

                                                                                        <option value="KZ">Kazakstan</option>

                                                                                        <option value="KE">Kenya</option>

                                                                                        <option value="KI">Kiribati</option>

                                                                                        <option value="KR">Korea, Republic of</option>

                                                                                        <option value="KW">Kuwait</option>

                                                                                        <option value="KG">Kyrgyzstan</option>

                                                                                        <option value="LA">Laos</option>

                                                                                        <option value="LV">Latvia</option>

                                                                                        <option value="LB">Lebanon</option>

                                                                                        <option value="LS">Lesotho</option>

                                                                                        <option value="LR">Liberia</option>

                                                                                        <option value="LY">Libyan Arab Jamahiriya</option>

                                                                                        <option value="LI">Liechtenstein</option>

                                                                                        <option value="LT">Lithuania</option>

                                                                                        <option value="LU">Luxembourg</option>

                                                                                        <option value="MO">Macau</option>

                                                                                        <option value="MK">Macedonia</option>

                                                                                        <option value="MG">Madagascar</option>

                                                                                        <option value="MW">Malawi</option>

                                                                                        <option value="MY">Malaysia</option>

                                                                                        <option value="MV">Maldives</option>

                                                                                        <option value="ML">Mali</option>

                                                                                        <option value="MT">Malta</option>

                                                                                        <option value="MH">Marshall Islands</option>

                                                                                        <option value="MQ">Martinique</option>

                                                                                        <option value="MR">Mauritania</option>

                                                                                        <option value="MU">Mauritius</option>

                                                                                        <option value="YT">Mayotte</option>

                                                                                        <option value="MX">Mexico</option>

                                                                                        <option value="FM">Micronesia</option>

                                                                                        <option value="MD">Moldavia</option>

                                                                                        <option value="MC">Monaco</option>

                                                                                        <option value="MN">Mongolia</option>

                                                                                        <option value="MS">Montserrat</option>

                                                                                        <option value="MA">Morocco</option>

                                                                                        <option value="MZ">Mozambique</option>

                                                                                        <option value="MM">Myanmar</option>

                                                                                        <option value="NA">Namibia</option>

                                                                                        <option value="NR">Nauru</option>

                                                                                        <option value="NP">Nepal</option>

                                                                                        <option value="NL">Netherlands</option>

                                                                                        <option value="AN">Netherlands Antilles</option>

                                                                                        <option value="NC">New Caledonia</option>

                                                                                        <option value="NZ">New Zealand</option>

                                                                                        <option value="NI">Nicaragua</option>

                                                                                        <option value="NE">Niger</option>

                                                                                        <option value="NG">Nigeria</option>

                                                                                        <option value="NU">Niue</option>

                                                                                        <option value="MP">Northern Mariana Islands</option>

                                                                                        <option value="NO">Norway</option>

                                                                                        <option value="OM">Oman</option>

                                                                                        <option value="PK">Pakistan</option>

                                                                                        <option value="PW">Palau</option>

                                                                                        <option value="PA">Panama</option>

                                                                                        <option value="PG">Papua New Guinea</option>

                                                                                        <option value="PY">Paraguay</option>

                                                                                        <option value="PE">Peru</option>

                                                                                        <option value="PH">Philippines</option>

                                                                                        <option value="PN">Pitcairn Island</option>

                                                                                        <option value="PL">Poland</option>

                                                                                        <option value="PT">Portugal</option>

                                                                                        <option value="PR">Puerto Rico</option>

                                                                                        <option value="QA">Qatar</option>

                                                                                        <option value="RE">Reunion</option>

                                                                                        <option value="RO">Romania</option>

                                                                                        <option value="RU">Russian Federation</option>

                                                                                        <option value="RW">Rwanda</option>

                                                                                        <option value="KN">Saint Kitts &amp; Nevis</option>

                                                                                        <option value="LC">Saint Lucia</option>

                                                                                        <option value="VC">Saint Vincent &amp; Grenadines</option>

                                                                                        <option value="WS">Samoa</option>

                                                                                        <option value="SM">San Marino</option>

                                                                                        <option value="ST">Sao Tome and Principe</option>

                                                                                        <option value="SA">Saudi Arabia</option>

                                                                                        <option value="SN">Senegal</option>

                                                                                        <option value="SC">Seychelles</option>

                                                                                        <option value="SL">Sierra Leone</option>

                                                                                        <option value="SG">Singapore</option>

                                                                                        <option value="SK">Slovakia</option>

                                                                                        <option value="SI">Slovenia</option>

                                                                                        <option value="SB">Solomon Islands</option>

                                                                                        <option value="SO">Somalia</option>

                                                                                        <option value="ZA">South Africa</option>

                                                                                        <option value="ES">Spain</option>

                                                                                        <option value="LK">Sri Lanka</option>

                                                                                        <option value="SH">St. Helena</option>

                                                                                        <option value="PM">St. Pierre and Miquelon</option>

                                                                                        <option value="SD">Sudan</option>

                                                                                        <option value="SR">Suriname</option>

                                                                                        <option value="SJ">Svalbard &amp; Jan Mayen Isl.</option>

                                                                                        <option value="SZ">Swaziland</option>

                                                                                        <option value="SE">Sweden</option>

                                                                                        <option value="CH">Switzerland</option>

                                                                                        <option value="SY">Syrian Arab Republic</option>

                                                                                        <option value="TW">Taiwan</option>

                                                                                        <option value="TJ">Tajikistan</option>

                                                                                        <option value="TZ">Tanzania</option>

                                                                                        <option value="TH">Thailand</option>

                                                                                        <option value="TG">Togo</option>

                                                                                        <option value="TK">Tokelau</option>

                                                                                        <option value="TO">Tonga</option>

                                                                                        <option value="TT">Trinidad and Tobago</option>

                                                                                        <option value="TN">Tunisia</option>

                                                                                        <option value="TR">Turkey</option>

                                                                                        <option value="TM">Turkmenistan</option>

                                                                                        <option value="TC">Turks &amp; Caicos Islands</option>

                                                                                        <option value="TV">Tuvalu</option>

                                                                                        <option value="UG">Uganda</option>

                                                                                        <option value="UA">Ukraine</option>

                                                                                        <option value="AE">United Arab Emirates</option>

                                                                                        <option value="GB">United Kingdom</option>

                                                                                        <option value="US">United States</option>

                                                                                        <option value="UY">Uruguay</option>

                                                                                        <option value="UZ">Uzbekistan</option>

                                                                                        <option value="VU">Vanuatu</option>

                                                                                        <option value="VE">Venezuela</option>

                                                                                        <option value="VN">Vietnam</option>

                                                                                        <option value="VG">Virgin Islands, British</option>

                                                                                        <option value="VI">Virgin Islands, U.S.</option>

                                                                                        <option value="WF">Wallis and Futuna Islands</option>

                                                                                        <option value="EH">Western Sahara</option>

                                                                                        <option value="YE">Yemen</option>

                                                                                        <option value="YU">Yugoslavia</option>

                                                                                        <option value="ZM">Zambia</option>

                                                                                        <option value="ZW">Zimbabwe</option>

                                                                                    </select>
                                                                                                                                      <!--  <select id="ccountry" required="required" name="ccountry">
                                                                                                                                            <option value="">--Select Country*--</option>
                                                                                                                                            <option value="US">United States</option>
                                                                                                                                            <option value="CA">Canada</option>
                                                                                                                                        </select>-->
                                                                                </div>
                                                                            </div>
                                                                            <div class="col-sm-6">
                                                                                <div class="form_sep cust-select">

                                                                                    <select onChange="this.className=this.options[this.selectedIndex].className"
    class="greenText" id="cstate" name="cstate" required="required">
                                                                                        <option value="">--Select State*--</option>
                                                                                        <option value="x" disabled="disabled">&nbsp;</option>
                                                                                        <option value="x" disabled="disabled">--United States--</option>
                                                                                        <option value="AP">APO/FPO</option>
                                                                                        <option value="AL">Alabama</option>
                                                                                        <option value="AK">Alaska</option>
                                                                                        <option value="AZ">Arizona</option>
                                                                                        <option value="AR">Arkansas</option>
                                                                                        <option value="CA">California</option>
                                                                                        <option value="CO">Colorado</option>
                                                                                        <option value="CT">Connecticut</option>
                                                                                        <option value="DE">Delaware</option>
                                                                                        <option value="DC">District of Columbia</option>
                                                                                        <option value="FL">Florida</option>
                                                                                        <option value="GA">Georgia</option>
                                                                                        <option value="HI">Hawaii</option>
                                                                                        <option value="ID">Idaho</option>
                                                                                        <option value="IL">Illinois</option>
                                                                                        <option value="IN">Indiana</option>
                                                                                        <option value="IA">Iowa</option>
                                                                                        <option value="KS">Kansas</option>
                                                                                        <option value="KY">Kentucky</option>
                                                                                        <option value="LA">Louisiana</option>
                                                                                        <option value="ME">Maine</option>
                                                                                        <option value="MD">Maryland</option>
                                                                                        <option value="MA">Massachusetts</option>
                                                                                        <option value="MI">Michigan</option>
                                                                                        <option value="MN">Minnesota</option>
                                                                                        <option value="MS">Mississippi</option>
                                                                                        <option value="MO">Missouri</option>
                                                                                        <option value="MT">Montana</option>
                                                                                        <option value="NC">North Carolina</option>
                                                                                        <option value="ND">North Dakota</option>
                                                                                        <option value="NE">Nebraska</option>
                                                                                        <option value="NV">Nevada</option>
                                                                                        <option value="NH">New Hampshire</option>
                                                                                        <option value="NJ">New Jersey</option>
                                                                                        <option value="NM">New Mexico</option>
                                                                                        <option value="NY">New York</option>
                                                                                        <option value="OH">Ohio</option>
                                                                                        <option value="OK">Oklahoma</option>
                                                                                        <option value="OR">Oregon</option>
                                                                                        <option value="PA">Pennsylvania</option>
                                                                                        <option value="PR">Puerto Rico</option>
                                                                                        <option value="RI">Rhode Island</option>
                                                                                        <option value="SC">South Carolina</option>
                                                                                        <option value="SD">South Dakota</option>
                                                                                        <option value="TN">Tennessee</option>
                                                                                        <option value="TX">Texas</option>
                                                                                        <option value="UT">Utah</option>
                                                                                        <option value="VT">Vermont</option>
                                                                                        <option value="VI">Virgin Islands</option>
                                                                                        <option value="VA">Virginia</option>
                                                                                        <option value="WV">West Virginia</option>
                                                                                        <option value="WA">Washington</option>
                                                                                        <option value="WI">Wisconsin</option>
                                                                                        <option value="WY">Wyoming</option>
                                                                                        <option value="x" disabled="disabled">&nbsp;</option>
                                                                                        <option value="x" disabled="disabled">--Canada--</option>
                                                                                        <option value="AB">Alberta</option>
                                                                                        <option value="BC">British Columbia</option>
                                                                                        <option value="MB">Manitoba</option>
                                                                                        <option value="NB">New Brunswick</option>
                                                                                        <option value="NF">Newfoundland</option>
                                                                                        <option value="NT">North West Territory</option>
                                                                                        <option value="NS">Nova Scotia</option>
                                                                                        <option value="ON">Ontario</option>
                                                                                        <option value="PE">Prince Edward Island</option>
                                                                                        <option value="PQ">Quebec</option>
                                                                                        <option value="SK">Saskatchewan</option>
                                                                                        <option value="YT">Yukon Territory</option>
                                                                                        <option value="x" disabled="disabled">&nbsp;</option>
                                                                                        <option value="OS">Other State / Province</option>
                                                                                    </select>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="row">
                                                                            <div class="col-sm-6">
                                                                                <div class="form_sep">

                                                                                    <input id="ccity" name="ccity" type="text" placeholder="City*" class="form-control"  required="required">
                                                                                </div>
                                                                            </div>
                                                                            <div class="col-sm-6">
                                                                                <div class="form_sep">

                                                                                    <input id="czip" name="czip" type="text" placeholder="Zip Code*" class="form-control" required="required">
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="row">
                                                                            <div class="col-sm-6">
                                                                                <div class="form_sep">
                                                                                    <select name="phone_code" class="form-control" required="required" style="width: 38%;float: left;">
                                                                                        <option value="">--Select--</option>
                                                                                        <?php
                                                                                        $result = mysql_query("SELECT * FROM country_code where code <> ''"); //Count from local API dynamic data
                                                                                        while($row = mysql_fetch_array($result)){?>
                                                                                                <option value="<?php echo $row['code'];?>"><?php echo $row['code'].' - '.$row['value'];?></option>
                                                                                            <?php }
                                                                                        ?>
                                                                                    </select>    
                                                                                    <input name="cphone" placeholder="Phone*" type="text" class="form-control" required="required" autocomplete="off" style='width: 62%;'>
                                                                                        <p for="cphone" class="warning" id="val-cphone-error"></p>
                                                                                </div>
                                                                            </div>
                                                                            <div class="col-sm-6">
                                                                                <div class="form_sep">

                                                                                    <input id="cemail" name="cemail"  placeholder="Email*" class="form-control"  required="required" type="email">
                                                                                </div>
                                                                            </div>
                                                                        </div>

                                                                    </fieldset>
                                                                    <button type="button" style="margin-top:10px;" class="green-btn pull-right" id="goAccorFour">Continue to Payment Methods</button>
                                                                </div>
                                                            </div>

                                                            </form>
                                                            </div>
                                                            </div>

                                                            </div>
                                                            <div class="col-sm-3 pull-right right_sidebar">

                                                                <div class="security"> <a target="_blank" href="/static/checkout/vbv_toolkit/service_desc_popup.htm">This website is secure. Your personal details are safe. </a>

                                                                    <a target="_blank" href="https://www.export.gov/safeharbor"></a><br />

                                                                    <img src="<?php echo $vpath ?>images/security.png" />
                                                                    <div class="clear"></div>
                                                                    <img src="<?php echo $vpath ?>images/comodo.png"  />
                                                                    <div class="clear"></div>
                                                                </div>
                                                                <div class="global-options">
                                                                    <label for="lang">Applied Language</label>
                                                                    <select id="lang" name="lang">
                                                                        <option value="en" selected="">English</option>

                                                                    </select>
                                                                    <label for="tco_currency">Applied Currency</label>
                                                                    <select id="tco_currency" name="tco_currency">

                                                                        <option value="USD" selected="selected">USD - U.S. Dollar</option>

                                                                    </select>
                                                                    <div class="clear"></div>
                                                                </div>
                                                                <div class="panel panel-default" id="ajaxCartSummary">
                                                                    <div class="panel-body questions">
                                                                        <div class="summary">
                                                                            <h3>Cart Summary</h3>
                                                                            <table class="summary-table">
                                                                                <tbody>
                                                                                    <tr>
                                                                                        <td class="item">All Items</td>
                                                                                        <td class="price"><span class="purchase_display_currency">$</span><?php echo $product['price']; ?></td>
                                                                                        
                                                                                    </tr>                                                                                    
                                                                                </tbody>
                                                                            </table>
                                                                        </div>
                                                                    </div>
                                                                    <div class="panel-footer summary">
                                                                        <div class="summary-total">
                                                                            <div class="total-label">Total (USD)</div>
                                                                            <div class="total-price"><span class="purchase_display_currency">$</span><?php echo $product['price']; ?></div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                     
                                                            </div>
                                                            <div class="clear"></div>

                                                            <p class="text-center" style="margin-bottom:0px;">
                                                                <img src="<?php echo $vpath ?>images/comodo_seal_recolored.png" style="max-width:250px;" />

                                                            </p>

                                                            </div>
                                                            </div>





                                                            <script>
                        $(document).ready(function() {


                            var FULL_BASE_URL = $('#hidden_site_baseurl').val(); // For base path of value;





                            $("#renclosure").focus(function() {
                                if ($(this).val() == "Please enter your personalized message here. Don't forget to add your name.") {
                                    $(this).val('');
                                }
                            });

                            $("#renclosure").blur(function() {
                                if ($(this).val() == "") {
                                    $(this).val("Please enter your personalized message here. Don't forget to add your name.");
                                }
                            });
                            $("#rinstructions").focus(function() {
                                if ($(this).val() == "If you have specific instructions for our delivery team, you may add them here.") {
                                    $(this).val('');
                                }
                            });

                            $("#rinstructions").blur(function() {
                                if ($(this).val() == "") {
                                    $(this).val("If you have specific instructions for our delivery team, you may add them here.");
                                }
                            });
                            $('.btn-default').click(function() {
                                // alert('df');
                                //return false;
                            });


                        });
                                                            </script>

                                                           
                                                            </body>
                                                            </html>
