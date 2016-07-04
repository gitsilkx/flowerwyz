$(document).ready(function() {
	//Hotel List
	
$('.srch-acc h5').bind('click',function(e){
	e.preventDefault();
	$(this).next().slideToggle(300);
	if($(this).find('i').hasClass("icon-chevron-up")){
		$(this).find('i').addClass("icon-chevron-down");
		$(this).find('i').removeClass("icon-chevron-up");
	}
	else{
    	$(this).find('i').addClass("icon-chevron-up");
		$(this).find('i').removeClass("icon-chevron-down");
    }
});
$('.shw-pri').bind('click',function(e){
	e.preventDefault();
	if($(this).parents(".htl-info").next().is(":visible")){
		$(this).text("Show Room Rates");
	}
	else{
		$(this).text("Hide Room Rates");
	}
	$(this).parents(".htl-info").next().slideToggle(300);
});
$('.table a').tooltip({});
$('.srch-dots a').tooltip({});
$('li.nav-toggle > button').click(function(e){
    e.preventDefault();
    $('.hidden-minibar').toggleClass("hide");
    $('#wrapper_all').toggleClass("mini-sidebar");
	});
if($('#wrapper_all.mini-sidebar')){    
  $('#icon_nav_v li a').tooltip({});
 }
 else
 {
  $('#icon_nav_v li a').tooltip('destroy');
 } 
  
$('#wrapper_all').addClass("mini-sidebar");
	$('li.nav-toggle > button').click(function(e){
	$('.fa-angle-double-left').toggleClass("open");
});
$('table').footable();
$("#toggle_search_panel").click(function(){
		var CurrentClass = $(this).attr('class');
		$(this).removeClass(CurrentClass);
		if(CurrentClass == 'icon-plus')
		 	$(this).addClass("icon-minus");
		else
			$(this).addClass("icon-plus");
		  
		  $("#search_panel_controls").toggle();
		});
$(".theme_sel").bind('click',function(e){
		$(".jd_menu").toggle();
	});
	$(".jd_menu li a").bind('click',function(e){
		var text=$(this).html();
		$(".theme_sel").html(text);
		$(".jd_menu").hide();
	});
$('select.select').each(function(){
	var title = $(this).attr('title');
	if( $('option:selected', this).val() != ''  ) title = $('option:selected',this).text();
	$(this)
		.css({'z-index':10,'opacity':0,'-khtml-appearance':'none'})
		.after('<span class="select">' + title + '</span>')
		.change(function(){
			val = $('option:selected',this).text();
			$(this).next().text(val);
			})
	});
$('#monthpicker').monthpicker();
$('.htl-desc .icon-heart').click(function(e){
	$(this).toggleClass("icon-minus");
});
});
$(function() {
    $( "#slider-range" ).slider({
      range: true,
      min: 0,
      max: 500,
      values: [ 75, 300 ],
      slide: function( event, ui ) {
        $( "#amount" ).val( "$" + ui.values[ 0 ] + " - $" + ui.values[ 1 ] );
      }
    });
    $( "#amount" ).val( "$" + $( "#slider-range" ).slider( "values", 0 ) +
      " - $" + $( "#slider-range" ).slider( "values", 1 ) );
  });
$(window).load(function(){
	$("#icon_nav_v").sticky({ topSpacing: 0 });
  });
        $(document).ready(function () {
            $("#datepicker").datepicker();
			 $("#datepicker2").datepicker();
			 $("#datepicker3").datepicker();
			 $('#timepicker').timepicker();

            $('#pax_plus, #pax_minus').click(function () {

                var elm = $(this).siblings('.mid_div');

                var number_of_pax = parseInt($(elm).children('#mySpan').text());

                if ($(this).attr('id') == 'pax_plus') number_of_pax += 1;

                else if (number_of_pax > 0) number_of_pax -= 1;

                $(elm).children('#mySpan').text(number_of_pax);
            })



            $('#night_plus, #night_minus').click(function () {

                var elm = $(this).siblings('.mid_div');

                var number_of_nights = parseInt($(elm).children('#mySpan').text());

                if ($(this).attr('id') == 'night_plus') number_of_nights += 1;

                else if (number_of_nights > 0) number_of_nights -= 1;

                $(elm).children('#mySpan').text(number_of_nights);

                var joindate = $('#datepicker').datepicker("getDate");

                joindate.setDate(joindate.getDate() + number_of_nights);

                $('#final_date').datepicker({ dateFormat: "m/dd/yy" });

                $('#final_date').datepicker('setDate', joindate);

                $("#final_date").datepicker("destroy");


            })



            $('#room_plus, #room_minus').click(function () {

                var elm = $(this).siblings('.mid_div');

                var number_of_rooms = parseInt($(elm).children('#mySpan').text());

                if ($(this).attr('id') == 'room_plus') {
                    number_of_rooms += 1;
                    $('#room_list').append($('#room_template').html());

                    if (document.getElementById('room_list').style.display == 'none') {
                        document.getElementById('room_list').style.display = '';
                        document.getElementById('config_btnSearch').style.display = '';
                    }
                }

                else if (number_of_rooms > 0) {
                    number_of_rooms -= 1;
                    $('#room_list').children(':last').remove();

                    if (number_of_rooms == 0) {
                        if (document.getElementById('room_list').style.display == '') {
                            document.getElementById('room_list').style.display = 'none';
                            document.getElementById('config_btnSearch').style.display = 'none';
                        }
                    }
                }

                $(elm).children('#mySpan').text(number_of_rooms);


            })




        });





        //2ND

        $(document).ready(function () {
            $("#datepicker2").datepicker();

            $('#pax_plus2, #pax_minus2').click(function () {

                var elm = $(this).siblings('.mid_div');

                var number_of_pax = parseInt($(elm).children('#mySpan2').text());

                if ($(this).attr('id') == 'pax_plus2') number_of_pax += 1;

                else if (number_of_pax > 0) number_of_pax -= 1;

                $(elm).children('#mySpan2').text(number_of_pax);
            })



            $('#night_plus2, #night_minus2').click(function () {

                var elm = $(this).siblings('.mid_div');

                var number_of_nights = parseInt($(elm).children('#mySpan_N2').text());

                if ($(this).attr('id') == 'night_plus2') number_of_nights += 1;

                else if (number_of_nights > 0) number_of_nights -= 1;

                $(elm).children('#mySpan_N2').text(number_of_nights);

                var joindate = $('#datepicker2').datepicker("getDate");

                joindate.setDate(joindate.getDate() + number_of_nights);

                $('#final_date2').datepicker({ dateFormat: "m/dd/yy" });

                $('#final_date2').datepicker('setDate', joindate);

                $("#final_date2").datepicker("destroy");


            })

            $('#room_plus2, #room_minus2').click(function () {

                var elm = $(this).siblings('.mid_div');

                var number_of_rooms = parseInt($(elm).children('#mySpan_R2').text());

                if ($(this).attr('id') == 'room_plus2') {
                    number_of_rooms += 1;
                    $('#room_list2').append($('#room_template2').html());

                }

                else if (number_of_rooms > 0) {
                    number_of_rooms -= 1;
                    $('#room_list2').children(':last').remove();

                }

                $(elm).children('#mySpan_R2').text(number_of_rooms);


            })
        });

        //3RD

        $(document).ready(function () {
            $("#datepicker3").datepicker();

            $('#pax_plus3, #pax_minus3').click(function () {

                var elm = $(this).siblings('.mid_div');

                var number_of_pax = parseInt($(elm).children('#mySpan3').text());

                if ($(this).attr('id') == 'pax_plus3') number_of_pax += 1;

                else if (number_of_pax > 0) number_of_pax -= 1;

                $(elm).children('#mySpan3').text(number_of_pax);
            })



            $('#night_plus3, #night_minus3').click(function () {

                var elm = $(this).siblings('.mid_div');

                var number_of_nights = parseInt($(elm).children('#mySpan_N3').text());

                if ($(this).attr('id') == 'night_plus3') number_of_nights += 1;

                else if (number_of_nights > 0) number_of_nights -= 1;

                $(elm).children('#mySpan_N3').text(number_of_nights);

                var joindate = $('#datepicker3').datepicker("getDate");

                joindate.setDate(joindate.getDate() + number_of_nights);

                $('#final_date3').datepicker({ dateFormat: "m/dd/yy" });

                $('#final_date3').datepicker('setDate', joindate);

                $("#final_date3").datepicker("destroy");


            })

            $('#room_plus3, #room_minus3').click(function () {

                var elm = $(this).siblings('.mid_div');

                var number_of_rooms = parseInt($(elm).children('#mySpan_R3').text());

                if ($(this).attr('id') == 'room_plus3') {
                    number_of_rooms += 1;
                    $('#room_list3').append($('#room_template3').html());

                }

                else if (number_of_rooms > 0) {
                    number_of_rooms -= 1;
                    $('#room_list3').children(':last').remove();

                }

                $(elm).children('#mySpan_R3').text(number_of_rooms);


            })
        });

        //4RD

        $(document).ready(function () {
            $("#datepicker4").datepicker();

            $('#pax_plus4, #pax_minus4').click(function () {

                var elm = $(this).siblings('.mid_div');

                var number_of_pax = parseInt($(elm).children('#mySpan4').text());

                if ($(this).attr('id') == 'pax_plus4') number_of_pax += 1;

                else if (number_of_pax > 0) number_of_pax -= 1;

                $(elm).children('#mySpan4').text(number_of_pax);
            })



            $('#night_plus4, #night_minus4').click(function () {

                var elm = $(this).siblings('.mid_div');

                var number_of_nights = parseInt($(elm).children('#mySpan_N4').text());

                if ($(this).attr('id') == 'night_plus4') number_of_nights += 1;

                else if (number_of_nights > 0) number_of_nights -= 1;

                $(elm).children('#mySpan_N4').text(number_of_nights);

                var joindate = $('#datepicker4').datepicker("getDate");

                joindate.setDate(joindate.getDate() + number_of_nights);

                $('#final_date4').datepicker({ dateFormat: "m/dd/yy" });

                $('#final_date4').datepicker('setDate', joindate);

                $("#final_date4").datepicker("destroy");


            })


        });

        //5TH

        $(document).ready(function () {
            $("#datepicker5").datepicker();

            $('#pax_plus5, #pax_minus5').click(function () {

                var elm = $(this).siblings('.mid_div');

                var number_of_pax = parseInt($(elm).children('#mySpan5').text());

                if ($(this).attr('id') == 'pax_plus5') number_of_pax += 1;

                else if (number_of_pax > 0) number_of_pax -= 1;

                $(elm).children('#mySpan5').text(number_of_pax);
            })



            $('#night_plus5, #night_minus5').click(function () {

                var elm = $(this).siblings('.mid_div');

                var number_of_nights = parseInt($(elm).children('#mySpan_N5').text());

                if ($(this).attr('id') == 'night_plus5') number_of_nights += 1;

                else if (number_of_nights > 0) number_of_nights -= 1;

                $(elm).children('#mySpan_N5').text(number_of_nights);

                var joindate = $('#datepicker5').datepicker("getDate");

                joindate.setDate(joindate.getDate() + number_of_nights);

                $('#final_date5').datepicker({ dateFormat: "m/dd/yy" });

                $('#final_date5').datepicker('setDate', joindate);

                $("#final_date5").datepicker("destroy");


            })




            $('#room_plus5, #room_minus5').click(function () {

                var elm = $(this).siblings('.mid_div');

                var number_of_rooms = parseInt($(elm).children('#mySpan_R5').text());

                if ($(this).attr('id') == 'room_plus5') {
                    number_of_rooms += 1;
                    $('#room_list5').append($('#room_template5').html());

                    if (document.getElementById('room_list5').style.display == 'none') {
                        document.getElementById('room_list5').style.display = '';
                        document.getElementById('config_btnSearch').style.display = '';
                    }
                }

                else if (number_of_rooms > 0) {
                    number_of_rooms -= 1;
                    $('#room_list5').children(':last').remove();

                    if (number_of_rooms == 0) {
                        if (document.getElementById('room_list5').style.display == '') {
                            document.getElementById('room_list5').style.display = 'none';
                            document.getElementById('config_btnSearch').style.display = 'none';
                        }
                    }
                }

                $(elm).children('#mySpan_R5').text(number_of_rooms);


            })




        });
			
        $(document).ready(function () {
            $("#flip").click(function () {
                $("#panel").slideToggle("slow");
            });
        });
        $(document).ready(function () {
            $("#flip1").click(function () {
                $("#panel1").slideToggle("slow");
            });
        });
        $(document).ready(function () {
            $("#flip2").click(function () {
                $("#panel2").slideToggle("slow");
            });
        });
        $(document).ready(function () {
            $("#flip3").click(function () {
                $("#panel3").slideToggle("slow");
            });
        });
        $(document).ready(function () {
            $("#flip4").click(function () {
                $("#panel4").slideToggle("slow");
            });
        });
        $(document).ready(function () {
            $("#flip5").click(function () {
                $("#panel5").slideToggle("slow");
            });
        });
        $(document).ready(function () {
            $("#flipA").click(function () {
                if (document.getElementById('price_per_night').src == 'http://www.doodleiinc.com/wtb/Images/Price_icon_bl.png')
                    document.getElementById('price_per_night').src = 'http://www.doodleiinc.com/wtb/Images/Price_icon.png';
                else
                    document.getElementById('price_per_night').src = 'http://www.doodleiinc.com/wtb/Images/Price_icon_bl.png';

                $("#panelA").slideToggle("slow");
            });
        });
        $(document).ready(function () {
            $("#flip1B").click(function () {
                if (document.getElementById('star_rating').src == 'http://www.doodleiinc.com/wtb/Images/Price_icon_bl.png')
                    document.getElementById('star_rating').src = 'http://www.doodleiinc.com/wtb/Images/Price_icon.png';
                else
                    document.getElementById('star_rating').src = 'http://www.doodleiinc.com/wtb/Images/Price_icon_bl.png';

                $("#panel1B").slideToggle("slow");
            });
        });
        $(document).ready(function () {
            $("#flip2C").click(function () {
                if (document.getElementById('hotel_faci').src == 'http://www.doodleiinc.com/wtb/Images/Price_icon_bl.png')
                    document.getElementById('hotel_faci').src = 'http://www.doodleiinc.com/wtb/Images/Price_icon.png';
                else
                    document.getElementById('hotel_faci').src = 'http://www.doodleiinc.com/wtb/Images/Price_icon_bl.png';

                $("#panel2C").slideToggle("slow");
            });
        });
        $(document).ready(function () {
            $("#flip3D").click(function () {
                if (document.getElementById('accom_type').src == 'http://www.doodleiinc.com/wtb/Images/Price_icon_bl.png')
                    document.getElementById('accom_type').src = 'http://www.doodleiinc.com/wtb/Images/Price_icon.png';
                else
                    document.getElementById('accom_type').src = 'http://www.doodleiinc.com/wtb/Images/Price_icon_bl.png';

                $("#panel3D").slideToggle("slow");
            });
        });
        $(document).ready(function () {
            $("#flip4E").click(function () {
                //alert(document.getElementById('hotel_area').src);
                if (document.getElementById('hotel_area').src == 'http://www.doodleiinc.com/wtb/Images/Price_icon_bl.png')
                    document.getElementById('hotel_area').src = 'http://www.doodleiinc.com/wtb/Images/Price_icon.png';
                else
                    document.getElementById('hotel_area').src = 'http://www.doodleiinc.com/wtb/Images/Price_icon_bl.png';

                $("#panel4E").slideToggle("slow");
            });
        });
        $(document).ready(function () {
            $("#flip5F").click(function () {
                if (document.getElementById('hotel_chain').src == 'http://www.doodleiinc.com/wtb/Images/Price_icon_bl.png')
                    document.getElementById('hotel_chain').src = 'http://www.doodleiinc.com/wtb/Images/Price_icon.png';
                else
                    document.getElementById('hotel_chain').src = 'http://www.doodleiinc.com/wtb/Images/Price_icon_bl.png';

                $("#panel5F").slideToggle("slow");
            });
        });
$(document).ready(function(e){
	$coastInput=$("#cost");
	$coastPopup=$(".costpopup");
	$coastVal=$(".costpopup td a");
	$coastInput.bind('focus',function(){
		$coastPopup.show();
		$coastVal.unbind();
		$coastVal.bind('click',function(){
			$coastInput.val($(this).text()); 
			$coastPopup.hide();
			$coastVal.removeClass("active");
			$(this).addClass("active");
		});
	});
	/**** document click ****/
			$(document).bind('click',function(e){
					if ($(e.target).is($coastVal) || $(e.target).is($coastInput) ){  
							e.stopPropagation();
							return;
					}
					if($coastPopup.is(":visible")){
						$coastPopup.hide();
						
					}
			});
});
$(document).ready(function(e){
	$typeInput=$("#type");
	$typePopup=$(".typepopup");
	$typeVal=$(".typepopup td a");
	$typeInput.bind('focus',function(){
		$typePopup.show();
		$typeVal.unbind();
		$typeVal.bind('click',function(){
			$typeInput.val($(this).text()); 
			$typePopup.hide();
			$typeVal.removeClass("active");
			$(this).addClass("active");
		});
	});
	/**** document click ****/
			$(document).bind('click',function(e){
					if ($(e.target).is($typeVal) || $(e.target).is($typeInput) ){  
							e.stopPropagation();
							return;
					}
					if($typePopup.is(":visible")){
						$typePopup.hide();
						
					}
			});
});
$(document).ready(function(e){
	$durationInput=$("#duration");
	$durationPopup=$(".durationpopup");
	$durationVal=$(".durationpopup td a");
	$durationInput.bind('focus',function(){
		$durationPopup.show();
		$durationVal.unbind();
		$durationVal.bind('click',function(){
			$durationInput.val($(this).text()); 
			$durationPopup.hide();
			$durationVal.removeClass("active");
			$(this).addClass("active");
		});
	});
	/**** document click ****/
			$(document).bind('click',function(e){
					if ($(e.target).is($durationVal) || $(e.target).is($durationInput) ){  
							e.stopPropagation();
							return;
					}
					if($durationPopup.is(":visible")){
						$durationPopup.hide();
						
					}
			});
});