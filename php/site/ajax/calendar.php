<?php
$isToday['mday'] = $_POST['cale_day'];
$isToday['mon'] = $_POST['cale_month'];
$isToday['year'] = $_POST['cale_year'];

if($_POST['get']=='day'):
$nameMonth = array(_January,_February,_March,_April,_Mays,_June,_July,_August,_September,_October,_November,_December);

$firstDay = date('w', ThaiDate::TimeStamp(1, $isToday['mon'], $isToday['year']));
$limitDay = date('t', ThaiDate::TimeStamp(1, $isToday['mon'], $isToday['year']));
$startDay = false;
$oldMonth = $isToday['mon'] - 1;
$oldYear = $isToday['year'];
if($oldMonth<1) { $oldMonth = 12; $oldYear = $isToday['year'] - 1; }
$oldMonthLimit = date('t', ThaiDate::TimeStamp(1, $oldMonth, $oldYear)) - $firstDay;

$DayLoop = 1;
$DayNext = 1;
$iRowStop = true;
$stopDay = 0;
$tmpString = '<table id="calendar-day" border="0" cellspacing="1" cellpadding="0"><thead><tr align="center" style="font-weight:bold;">
				<td width="24" style="color:#C30;">'._SUN.'</td>
				<td width="24">'._MON.'</td>
				<td width="24">'._TUS.'</td>
				<td width="24">'._WEN.'</td>
				<td width="24">'._THU.'</td>
				<td width="24">'._FIR.'</td>
				<td width="24">'._SUT.'</td>
			  </tr></thead><tbody>';
while($iRowStop)
{
	$tmpString .= '<tr align="right">';
	for($iDay=0;$iDay<7;$iDay++)
	{
		if(($iDay>=$firstDay || $startDay) && $DayLoop<=$limitDay)
		{
			$startDay = true;
			if($iDay==0 && $DayLoop==$isToday['mday']) {
				$idDay = 'isDay-st';
			} elseif($iDay==0) {
				$idDay = 'isDay-s';
			} elseif($DayLoop==$isToday['mday']) {
				$idDay = 'isDay-t'; 
			} else { 
				$idDay = 'isDay';
			}
			$tmpString .= '<td><input id="'.$idDay.'" type="button" value="'.$DayLoop.'" 
			onclick="$(\'#jDay\').val($(this).val());$(\'#month_today\').caleDay($(this).val(),$(\'#jMonth\').val(),$(\'#jYear\').val());" /></td>';
			$DayLoop++;
			$stopDay = $iDay;
		} elseif($DayLoop<$firstDay ) {
			$oldMonthLimit++;
			$tmpString .= '<td><input id="unDay" type="button" value="'.$oldMonthLimit.'" /></td>';
		} else {
			$tmpString .= '<td><input id="unDay" type="button" value="'.$DayNext.'" /></td>';
			$DayNext++;
		}
		if($DayLoop>$limitDay) { $iRowStop = false; }
	}
	$tmpString .= '</tr>';
}
$tmpString .= '</tbody></table>';
echo json_encode(array(
					'list'=>$tmpString,
					'mName'=>$nameMonth[$isToday['mon']-1].' '.($isToday['year']+543),
					'date'=>ThaiDate::Full(ThaiDate::TimeStamp($_POST['cale_day'], $_POST['cale_month'], $_POST['cale_year'])),
					'stamp'=>ThaiDate::TimeStamp($_POST['cale_day'], $_POST['cale_month'], $_POST['cale_year']),
					'exdate'=>ThaiDate::Full(ThaiDate::TimeStamp($_POST['cale_day'], $_POST['cale_month'], ($_POST['cale_year'] + 1))),
					'exstamp'=>ThaiDate::TimeStamp($_POST['cale_day'], $_POST['cale_month'], ($_POST['cale_year'] + 1)),
					));
elseif($_POST['get']=='month'):
$miniMonth = array(1=>_JA,2=>_FE,3=>_MA,4=>_AP,5=>_MY,6=>_JN,7=>_JL,8=>_AU,9=>_SE,10=>_OC,11=>_NO,12=>_DE);

$tmpString = '<table width="100%" border="0" cellspacing="0" cellpadding="0">';
$iMonth = 1;
for($iRow=0;$iRow<3;$iRow++)
{
	$tmpString .= '<tr>';
	for($iCol=0;$iCol<4;$iCol++)
	{
		$tmpString .= '<td><input type="button" id="isMonth" value="'.($miniMonth[$iMonth]).'" 
		onclick="$(\'#jMonth\').val('.$iMonth.');$(\'#month_today\').monthSelect($(\'#jDay\').val(), '.$iMonth.', $(\'#jYear\').val());" /></td>';
		$iMonth++;
	}
	$tmpString .= '</tr>';
}
$tmpString .= '</table>';
echo json_encode(array(
					'list'=>$tmpString,
					'mName'=>$nameMonth[$isToday['mon']-1].' '.($isToday['year']+543),
					'date'=>ThaiDate::Full(ThaiDate::TimeStamp($_POST['cale_day'], $_POST['cale_month'], $_POST['cale_year'])),
					'stamp'=>ThaiDate::TimeStamp($_POST['cale_day'], $_POST['cale_month'], $_POST['cale_year']),
					'exdate'=>ThaiDate::Full(ThaiDate::TimeStamp($_POST['cale_day'], $_POST['cale_month'], ($_POST['cale_year'] + 1))),
					'exstamp'=>ThaiDate::TimeStamp($_POST['cale_day'], $_POST['cale_month'], ($_POST['cale_year'] + 1)),
					));

endif;

?>