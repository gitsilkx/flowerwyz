

<div class="cboth"></div>
<div id="footer">
    <div class="innerWrap">
        <div class="f_newsletter_inner row-fluid">
            <div class="Block NewsletterSubscription Moveable Panel" id="SideNewsletterBox">
                <h6>Sign up for newsletter</h6>
                <form action="<?= $vpath ?>subscribe.php" method="post" id="subscribe_form" name="subscribe_form">
                    <input name="action" value="subscribe" type="hidden"/>
                    <input id="nl_first_name" name="nl_first_name" value="your first name" onfocus="if (this.value == 'enter your full name')
                                this.value = ''" onblur="if (this.value == '')
                                this.value = 'enter your full name'" type="text" />
                    <input id="nl_email" name="nl_email" value="your email address" onfocus="if (this.value == 'your email address')
                                this.value = ''" onblur="if (this.value == '')
                                this.value = 'your email address'" type="text" />
                    <input type="submit" value="Subscribe" name="signup" />
                </form>
            </div>

            <script type="text/javascript">

                        // <!--

                        $('#subscribe_form').submit(function() {

                            if ($('#nl_first_name').val() == '') {

                                alert('You forgot to type in your first name.');

                                $('#nl_first_name').focus();

                                return false;

                            }



                            if ($('#nl_email').val() == '') {

                                alert('You forgot to type in your email address.');

                                $('#nl_email').focus();

                                return false;

                            }



                            if ($('#nl_email').val().indexOf('@') == -1 || $('#nl_email').val().indexOf('.') == -1) {

                                alert('Email address is not valid.');

                                $('#nl_email').focus();

                                $('#nl_email').select();

                                return false;

                            }



                            // Set the action of the form to stop spammers

                            $('#subscribe_form').append("<input type=\"hidden\" name=\"check\" value=\"1\" \/>");

                            return true;



                        });

                        // -->

            </script>



        </div>

        <div class="f_downarea row-fluid">

            <div class="f-navigation">

                <!--<a href="<?= $vpath ?>sitemap/"><span>Sitemap</span></a> |--><ul><li class="f-compArea"><h5>Flowers Delivered In</h5><ul>

                            <li><a href="<?= $vpath ?>">Atlanta</a></li>
                            <li><a href="<?= $vpath ?>">Baltimore</a></li>
                            <li><a href="<?= $vpath ?>">Boston</a></li>
                            <li><a href="<?= $vpath ?>">Chicago</a></li>
                            <li><a href="<?= $vpath ?>">Dallas</a></li>
                            <li><a href="<?= $vpath ?>">Denver</a></li>
                            <li><a href="<?= $vpath ?>">Houston</a></li>
                            <li><a href="<?= $vpath ?>">Los Angeles</a></li>
                            <li><a href="<?= $vpath ?>">Minneapolis</a></li>
                            <li><a href="<?= $vpath ?>">New York</a></li>
                            <li><a href="<?= $vpath ?>">Pittsburgh</a></li>
                            <li><a href="<?= $vpath ?>">San Diego</a></li>
                            <li><a href="<?= $vpath ?>">San Francisco</a></li>
                            <li><a href="<?= $vpath ?>">Seattle</a></li>
                            <li><a href="<?= $vpath ?>">St louis</a></li>
                            <li><a href="<?= $vpath ?>">Tulsa</a></li>
                            <li><a href="<?= $vpath ?>">ANYWHERE IN USA</a></li>
                            <li><a href="<?= $vpath ?>">ANYWHERE IN CANADA</a></li>

                        </ul></li><li class="f-OccasionArea"><h5>Flower Delivery Services</h5><ul>

                            <li><a href="<?= $vpath ?>">Floral Arrangements</a></li>
                            <li><a href="<?= $vpath ?>">Plant Delivery</a></li>
                            <li><a href="<?= $vpath ?>">Flower Bouquets</a></li>
                            <li><a href="<?= $vpath ?>">Discount Flowers</a></li>
                            <li><a href="<?= $vpath ?>">Wholesale Flowers</a></li>
                            <li><a href="<?= $vpath ?>">Exotic Flowers</a></li>
                            <li><a href="<?= $vpath ?>">Flower Shops</a></li>
                            <li><a href="<?= $vpath ?>">Order Flowers</a></li>
                            <li><a>&nbsp;</a></li>
                            </ul>
			    <h5>Sympathy Flowers</h5><ul>

                            <li><a href="<?= $vpath ?>">Sympathy</a></li>
                            <li><a href="<?= $vpath ?>">Funerals</a></li>
                            <li><a href="<?= $vpath ?>">Casket Flowers</a></li>
                            <li><a href="<?= $vpath ?>">Gift Baskets</a></li>
                            <li><a href="<?= $vpath ?>">Plants</a></li>
                            <li><a href="<?= $vpath ?>">Sprays</a></li>
                            <li><a href="<?= $vpath ?>">Wreaths</a></li>

                        </ul></li>

                    <li class="f-FlowerTypeArea"><h5>Flowers by Occassion</h5><ul>

                            <li><a href="<?= $vpath ?>">Anniversaries</a></li>
                            <li><a href="<?= $vpath ?>">Birthdays</a></li>
                            <li><a href="<?= $vpath ?>">Get Well</a></li>
                            <li><a href="<?= $vpath ?>">Funerals</a></li>
                            <li><a href="<?= $vpath ?>">Love &amp; Romance</a></li>
                            <li><a href="<?= $vpath ?>">New Baby</a></li>
                            <li><a href="<?= $vpath ?>">Thank You</a></li>
                            <li><a href="<?= $vpath ?>">Weddings</a></li>
                            <li><a>&nbsp;</a></li>
                            </ul>
                            <h5>Special Flowers</h5><ul>

                            <li><a href="<?= $vpath ?>">Christmas</a></li>
                            <li><a href="<?= $vpath ?>">Easter</a></li>
                            <li><a href="<?= $vpath ?>">Mothers Day</a></li>
                            <li><a href="<?= $vpath ?>">Valentines Day</a></li>
                            <li><a href="<?= $vpath ?>">Everyday Fresh</a></li>
                            <li><a href="<?= $vpath ?>">All Occassion Roses</a></li>
                            <li><a href="<?= $vpath ?>">Garden Fresh Centerpieces</a></li>




                        </ul></li><li class="f-ExpressYourselfArea"><h5>More Information</h5><ul>

                            <li><a href="<?= $vpath ?>">Home</a></li>
                            <li><a href="<?= $vpath ?>">About Us</a></li>
                            <li><a href="<?= $vpath ?>">Contact Us</a></li>
                            <li><a href="<?= $vpath ?>">About Same Day</a></li>
                            <li><a href="<?= $vpath ?>">About Next Day</a></li>
                            <li><a href="<?= $vpath ?>">Terms and Conditions</a></li>
                            <li><a href="<?= $vpath ?>">Privacy Policy</a></li>
                            <li><a href="<?= $vpath ?>">Sitemap</a></li>
                        </ul></li>

                </ul>

                    <div class="logo_area_footer">
                        

                        <div class="f_logo">
                            <span class="f_logo_name">Flower WyZ</span>
                        </div>
                        <div class="f_social_icon">
                            <ul>
                                <li><a href="#" class="fb"></a></li>
                                <li><a href="#" class="gplus"></a></li>
                                <li><a href="#"  class="insti"></a></li>
                                <li><a href="#"  class="pintit"></a></li>
                                <li><a href="#"  class="twitter"></a></li>
                            </ul>
                            <img src="<?php echo $vpath; ?>images/flower-delivery2.png" alt="Send Flower Online" style="margin:10px 0px" />
                            <img src="<?php echo $vpath; ?>images/buy-online-flower-delivery.png" alt="Online Flower Delivery" style="margin:10px 0px" />
                        </div>
                    </div>



            </div>

        </div>

        <div class="f_bottomarea">
            <div class="innerWrap">
                <div class="f-Txt"> <h3><?php echo $footer_content;?></h3></div>        
            </div>

            

        </div>

    </div>

</div>


</div><!--Wrapper-->

</div><!--Container-->

</body>
</html>