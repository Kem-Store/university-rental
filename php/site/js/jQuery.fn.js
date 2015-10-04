// JavaScript Document
jQuery.fn.multiVal = function(){ 
	var vals = []; 
	var i = 0; 
	this.each(function(){ 
		vals[i++] = jQuery(this).val(); 
	}); 
	return vals; 
} 

jQuery.fn.href = function(url){ 
	window.location = "?"+url;
} 
jQuery.fn.caleDay = function(day, month, year){ 
	$.ajax({ url: 'index.php?ajax=calendar',
		data: ({ get: 'day', cale_day: day, cale_month: month, cale_year: year }),
		error: function (data){
			$('#month_today').html('Error');
		},
		success: function (data){
			$('#month_today').html(data.list);
			$('#isMonthName').val(data.mName);
			$('#yearSelected').val(data.date);
			$('#timestamp').val(data.stamp);
			$('#signup_year').val(data.date);
			$('#timestamp_signup').val(data.stamp);
			$('#expire_year').val(data.exdate);
			$('#timestamp_expire').val(data.exstamp);
		},
	});
}
jQuery.fn.caleMonth = function(day, month, year){ 
	$.ajax({ url: 'index.php?ajax=calendar',
		data: ({ get: 'month', cale_day: day, cale_month: month, cale_year: year }),
		error: function (data){
			$('#month_today').html('Error');
		},
		success: function (data){
			$('#month_today').html(data.list);
			$('#isMonthName').val(data.mName);
			$('#yearSelected').val(data.date);
			$('#timestamp').val(data.stamp);
			$('#signup_year').val(data.date);
			$('#timestamp_signup').val(data.stamp);
			$('#expire_year').val(data.exdate);
			$('#timestamp_expire').val(data.exstamp);
		},
	});
} 
jQuery.fn.monthSelect = function(day, month, year){ 	
	$('#mChange').val(0);
	$('#month_today').animate({
		opacity: 0,
		top: '-=20',
	},200,function() {
		$('#month_today').caleDay(day, month, year);
		$('#isMonthName').removeAttr('disabled','disabled');
		// Show Animate
		$('#month_today').animate({
			opacity: 0,
			top: '+=40',
		},0,function() {
			$('#month_today').animate({
				opacity: 1,
				top: '-=20',
			},200,function() {
	
			});
		});
	});
} 