<?php
$miniMonth = array(1=>_JA,2=>_FE,3=>_MA,4=>_AP,5=>_MY,6=>_JN,7=>_JL,8=>_AU,9=>_SE,10=>_OC,11=>_NO,12=>_DE);

$month = each($miniMonth);
$isToday = getdate(time());
?>
<div style="margin:3px;"><input type="text" id="yearSelected" value="" size="25" /><input type="text" id="timestamp" value="" /></div>
<div>
<div id="calendar-frame">
<table id="calendar" width="168" border="0" cellspacing="0" cellpadding="0">
    <tr align="center">
      <td><input id="backMonth" type="button" value="&lt;" /></td>
      <td><input id="isMonthName" type="button" value=" " /></td>
      <td><input id="nextMonth" type="button" value="&gt;" /></td>
    </tr>
    <tr>
      <td colspan="3" style="height:7px">
        <input type="hidden" id="mChange" value="0" />
        <input type="hidden" id="jDay" value="<?php echo $isToday['mday']; ?>" />
        <input type="hidden" id="jMonth" value="<?php echo $isToday['mon']; ?>" />
        <input type="hidden" id="jYear" value="<?php echo $isToday['year']; ?>" />
      </td>
    </tr>
    <tr>
      <td colspan="3"><div id="month_today"></div></td>
    </tr>
</table>
</div></div>

<script>
$(document).ready(function() {
	var isDay = parseFloat($('#jDay').val());
	var isMonth = parseFloat($('#jMonth').val());
	var isYear = parseFloat($('#jYear').val());
	$('#month_today').caleDay(isDay, isMonth, isYear);
	
	function setCurrentDate() {
		$('#jDay').val(isDay);
		$('#jMonth').val(isMonth);
		$('#jYear').val(isYear);
	}
	function getCurrentDate() {
		isDay = parseFloat($('#jDay').val());
		isMonth = parseFloat($('#jMonth').val());
		isYear = parseFloat($('#jYear').val());
	}
	
	$('#nextMonth').click(function() {
		getCurrentDate();
		$('#month_today').animate({
			opacity: 0,
			left: '-=20',
		},200,function() {
			if($('#mChange').val()==0) {
				isDay = $('#jDay').val();
				isMonth += 1;
				if(isMonth>12) { isMonth = 1; isYear += 1;}
				setCurrentDate();
				$('#month_today').caleDay($('#jDay').val(), $('#jMonth').val(), $('#jYear').val());
			} else {
				isDay = $('#jDay').val();
				isYear += 1;
				setCurrentDate();
				$('#month_today').caleMonth($('#jDay').val(), $('#jMonth').val(), $('#jYear').val());
			}
			// Show Animate
			$('#month_today').animate({
				opacity: 0,
				left: '+=40',
			},0,function() {
				$('#month_today').animate({
					opacity: 1,
					left: '-=20',
				},200);
			});
		});
	});
	
	$('#backMonth').click(function() {
		getCurrentDate();
		$('#month_today').animate({
			opacity: 0,
			left: '+=20',
		},200,function() {
			if($('#mChange').val()==0) {
				isDay = $('#jDay').val();
				isMonth -= 1;
				if(isMonth<1) { isMonth = 12; isYear -= 1;}
				setCurrentDate();
				$('#month_today').caleDay($('#jDay').val(), $('#jMonth').val(), $('#jYear').val());
			} else {
				isDay = $('#jDay').val();
				isYear -= 1;
				setCurrentDate();
				$('#month_today').caleMonth($('#jDay').val(), $('#jMonth').val(), $('#jYear').val());
			}
			// Show Animate
			$('#month_today').animate({
				opacity: 0,
				left: '-=40',
			},0,function() {
				$('#month_today').animate({
					opacity: 1,
					left: '+=20',
				},200);
			});
		});
	});
	

	$('#isMonthName').click(function() {
		$('#mChange').val(1);
		$('#month_today').animate({
			opacity: 0,
			top: '+=20',
		},200,function() {
			$('#month_today').caleMonth($('#jDay').val(), $('#jMonth').val(), $('#jYear').val());
			$('#isMonthName').attr('disabled','disabled');			
			// Show Animate
			$('#month_today').animate({
				opacity: 0,
				top: '-=40',
			},0,function() {
				$('#month_today').animate({
					opacity: 1,
					top: '+=20',
				},200,function() {
		
				});
			});
		});
	});
});
</script>