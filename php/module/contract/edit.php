<?php 
$database = new SyncDatabase();
$contract = $database->Value('contract', array('contract_id'=>$_GET['id']),0);
if(!isset($_GET['action'])) { $_GET['action'] = ''; }
if($_GET['action']=='confirm'): 
$editContract = array(
			'cancel_date'	=> $_REQUEST['timestamp'],
			);
$database->Update('contract', $editContract, array('contract_id'=>$_GET['id']));
?><script>
$(document).ready(function() {
	$(this).href('contract=edit&id=<?php echo $_GET['id']; ?>');
});
</script><?php
elseif($_GET['action']=='canceled'): 


$isToday = getdate(time());
?>
<form name="canceled" method="post" action="?contract=edit&id=<?php echo $_GET['id']; ?>&action=confirm">
<table width="100%" cellpadding="5" cellspacing="0" border="0">
    <tr>
      <td width="180" align="center" valign="top" style="border-right:#CCC dashed 1px;">
       <input type="submit" name="register_save" id="register_save" value=" " title="<?php echo _IMAGE_TAG_SAVE; ?>" />
       <input type="reset" name="register_back" id="register_back" value=" " title="<?php echo _IMAGE_TAG_BACK; ?>" />
      </td>
      <td align="left" valign="top">
       <h4><?php echo _REGISTER_CONTRACT_CVANCELED; ?></h4>
        <table border="0" cellspacing="0" cellpadding="3">
          <tr>
            <td align="right" valign="top">&nbsp;</td>
            <td align="left" valign="top">&nbsp;</td>
          </tr>
          <tr>
            <td width="200" align="right" valign="top"><strong><?php echo _CONTRACT_REQUEST_CANCELED; ?>:</strong></td>
            <td width="150" align="left" valign="top"><input type="hidden" id="timestamp" name="timestamp" value="" />
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
              </div>
            </td>
          </tr>
          <tr>
            <td align="right" valign="top">&nbsp;</td>
            <td align="left"><input type="text" id="yearSelected" value="" size="25" /></td>
          </tr>
          <tr>
            <td align="right" valign="top">&nbsp;</td>
            <td align="left" valign="top">&nbsp;</td>
          </tr>
        </table>
      </td>
    </tr>
  </table>
</form>
<script>
$(document).ready(function() {
	
	$('#register_back').click(function(){
		$(this).href('contract=edit&id=<?php echo $_GET['id']; ?>');
	});
	
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
		
	//$('#calendar tr:last').after('<tr><td>&nbsp;</td></tr>');
	//$('#calendar td:last').after('<td>&nbsp;</td>');
});
</script>
<?php else: ?>
<?php if($contract!=NULL): 
	$customer = $database->Value('customer', array('cus_id'=>$contract['cus_id']),0);
	$employee = $database->Value('employee', array('emp_id'=>$contract['emp_id']),0);
	$object = $database->Value('object_rental', array('object_id'=>$contract['object_id']),0);
	$type = $database->Value('object_type', array('type_id'=>$object['type_id']),0);
?>
<form action="" method="POST" name="employee_register" id="employee_register">
  <table width="100%" cellpadding="5" cellspacing="0" border="0">
    <tr>
      <td width="180" align="center" valign="top" style="border-right:#CCC dashed 1px;">
       <input type="button" name="register_cancel" id="register_cancel" value=""<?php if($contract['cancel_date']!=0) { echo 'disabled="disabled"';} ?> title="<?php echo _IMAGE_TAG_CANCEL; ?>" />
       <input type="reset" name="register_reset" id="register_reset" value="" title="<?php echo _IMAGE_TAG_BACK; ?>" />
       <p>&nbsp;</p>
       <input type="button" name="register_print" id="register_print" value="" title="<?php echo _IMAGE_TAG_PRINT; ?>" />
      </td>
      <td align="left" valign="top">
        <h3 align="left"><?php echo _CONTRACT_PASS.$contract['cus_id'].$contract['object_id'].$contract['emp_id'].'-'.$contract['contract_id']; ?></h3>
        <table border="0" cellspacing="0" cellpadding="3"<?php if($contract['cancel_date']!=0 && $contract['cancel_date']<time()) { echo ' style="background:url(images/canceled.jpg) 100% 100% no-repeat;"';} ?>>
          <tr>
            <td colspan="2" align="right" valign="middle"><strong><?php echo _CONTRACT_TIME.ThaiDate::Full($contract['signup_date']);; ?></strong></td>
          </tr>
          <tr>
            <td colspan="2" align="right" valign="middle"><strong>
			<?php 
			if($contract['cancel_date']==0) {
				echo _CONTRACT_EXPIRE.ThaiDate::Full($contract['expire_date']); 
			} elseif($contract['cancel_date']!=0 && $contract['cancel_date']>time()) {
				echo _CONTRACT_EXPIRE.ThaiDate::Full($contract['cancel_date']); 
			} else {
				echo _CONTRACT_CANCELED.ThaiDate::Full($contract['cancel_date']); 
			}
			?>
            </strong></td>
          </tr>
          <tr>
            <td colspan="2" align="center" valign="middle"><h1><?php echo _CONTRACT_HEAD.$type['type_name']; ?></h1></td>
          </tr>
          <tr>
            <td colspan="2" align="left" valign="middle"><h4><?php echo _REGISTER_USER_CUSTOMER; ?></h4></td>
          </tr>
          <tr>
            <td align="right" valign="middle"><strong><?php echo _REGISTER_FULLNAME; ?></strong></td>
            <td align="left"><div style="width:400px;word-wrap:break-word;"><?php echo $customer['fullname']; ?></div></td>
          </tr>
          <tr>
            <td align="right" valign="top"><strong><?php echo _REGISTER_ADDRESS; ?></strong></td>
            <td align="left"><div style="width:400px;word-wrap:break-word;"><?php echo $customer['address']; ?></div></td>
          </tr>
          <tr>	
            <td width="120" align="right" valign="middle"><strong><?php echo _REGISTER_TELEPHONE; ?></strong></td>
            <td align="left"><div style="width:400px;word-wrap:break-word;"><?php echo $customer['telephone']; ?></div></td>
          </tr>
          <tr>
            <td colspan="2" align="left" valign="middle">&nbsp;</td>
          </tr>
          <tr>
            <td colspan="2" align="left" valign="middle"><h4><?php echo _REGISTER_USER_RENT; ?></h4></td>
          </tr>
          <tr>	
            <td width="120" align="right" valign="middle"><strong><?php echo _CONTRACT_TYPE; ?></strong></td>
            <td align="left"><?php echo $type['type_name'].$object['detail']; ?></td>
          </tr>
          <tr>	
            <td width="120" align="right" valign="middle"><strong><?php echo _CONTRACT_PRICE; ?></strong></td>
            <td align="left"><div style="width:400px;word-wrap:break-word;"><?php echo number_format($type['rentalcost'],0)._CONTRACT_BAHT; ?></div></td>
          </tr>
          <tr>	
            <td width="120" align="right" valign="middle"><strong><?php echo _CONTRACT_STATUS; ?></strong></td>
            <td align="left"><?php 
			if($contract['cancel_date']==0 && $contract['expire_date']>time()) {
				echo _CONTRACT_STATUS_RENT;
			} elseif($contract['cancel_date']!=0 && $contract['cancel_date']>time()) {
				echo _CONTRACT_STATUS_CANCEL;
			} elseif($contract['cancel_date']<time()) {
				echo _CONTRACT_STATUS_CANCELED;
			} elseif($contract['expire_date']<time()) {
				echo _CONTRACT_STATUS_EXPIRE;
			}
			
			?></td>
          </tr>
          <tr>
            <td colspan="2" align="left" valign="middle">&nbsp;</td>
          </tr>
          <tr>
            <td colspan="2" align="left" valign="middle">&nbsp;</td>
          </tr>
        </table>
      </td>
    </tr>
  </table>
</form>
<?php
if($contract['cancel_date']==0 && $contract['expire_date']>time()) {
	$status = _CONTRACT_STATUS_RENT;
} elseif($contract['cancel_date']!=0 && $contract['cancel_date']>time()) {
	$status = _CONTRACT_STATUS_CANCEL;
} elseif($contract['cancel_date']<time()) {
	$status = _CONTRACT_STATUS_CANCELED;
} elseif($contract['expire_date']<time()) {
	$status = _CONTRACT_STATUS_EXPIRE;
}

if($contract['cancel_date']==0) {
	$expire = _CONTRACT_EXPIRE.ThaiDate::Full($contract['expire_date']); 
} elseif($contract['cancel_date']!=0 && $contract['cancel_date']>time()) {
	$expire = _CONTRACT_EXPIRE.ThaiDate::Full($contract['cancel_date']); 
} else {
	$expire = _CONTRACT_CANCELED.ThaiDate::Full($contract['cancel_date']); 
}
$name = explode(' ', $customer['fullname']);

$text = _CONTRACT_PRINT_FIRSTNAME.$name[0]._CONTRACT_PRINT_LASTNAME.$name[1]._CONTRACT_PRINT_ADDRESS.$customer['address']._CONTRACT_PRINT_TELE.$customer['telephone'];
$text .= '<br />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'._CONTRACT_PRINT_TEXT1;
$idObject = $object['object_id'];
while(strlen($idObject)<3) { $idObject = '0'.$idObject; }
$text .= '<br/><br/><span style="margin-left:35px;">'._CONTRACT_PRINT_TEXT2.$type['type_name']._CONTRACT_PRINT_IDOBJECT.$type['type_id'].$idObject;
$text .= _CONTRACT_PRINT_SIGNUP.ThaiDate::Mid($contract['signup_date'])._CONTRACT_PRINT_TO.ThaiDate::Mid($contract['expire_date'])._CONTRACT_PRINT_EXPIRE;
$text .= _CONTRACT_PRINT_RENT.number_format($contract['cost'],0)._CONTRACT_PRINT_BAHT._CONTRACT_PRINT_TEXT3;
$text .= '</span><br/>';
$text .= '<span style="margin-left:35px;">'._CONTRACT_PRINT_TEXT4.'</span><br/>';
$text .= '<span style="margin-left:35px;">'._CONTRACT_PRINT_TEXT5.'</span><br/>';
$text .= '<span style="margin-left:35px;">'._CONTRACT_PRINT_TEXT6.'</span><br/>';
$text .= '<span style="margin-left:35px;">'._CONTRACT_PRINT_TEXT7_1.number_format($contract['deposite'],0)._CONTRACT_PRINT_TEXT7_2.'</span><br/>';
$text .= '<span style="margin-left:35px;">'._CONTRACT_PRINT_TEXT8.'</span><br/>';
$text .= '<span style="margin-left:35px;">'._CONTRACT_PRINT_TEXT9.'</span><br/>';
$text .= '<span style="margin-left:35px;">'._CONTRACT_PRINT_TEXT10.'</span><br/>';
$text .= '<span style="margin-left:35px;">'._CONTRACT_PRINT_TEXT11.'</span><br/>';
$text .= '<span style="margin-left:35px;">'._CONTRACT_PRINT_TEXT12.'</span><br/>';

			  
$data = array(
		'id'=>_CONTRACT_PASS.$contract['cus_id'].$contract['object_id'].$contract['emp_id'].'-'.$contract['contract_id'],
		'head'=>_CONTRACT_PRINT_HEAD,
		'singup'=>_CONTRACT_TIME.ThaiDate::Full($contract['signup_date']),
		'expire'=>$expire,
		'contract_type'=>_CONTRACT_HEAD.$type['type_name'],
		'text'=>$text,
		'personal'=>_CONTRACT_PRINT_PERSONAL,
		'own'=>_CONTRACT_PRINT_OWN,
	);

$printButton = '<div style="position:fixed;top:10px;right:10px;"><input type="button" name="print" value="Print" onClick="javascript:window.print()">
				<input type="button" name="close" value="Close" onClick="javascript:window.close()"></div>';		

$content = site::Content('contract',$data);
$targetDirectory = "document/";
$targetName = "contract";
$targetID = $contract['cus_id'].$contract['object_id'].$contract['emp_id'].$contract['contract_id'];
$targetExtension = ".html";
$fileName = $targetName.'_'.$targetID.$targetExtension;
$isFile = fopen($targetDirectory.$fileName, 'w');

fputs($isFile, $printButton);
fputs($isFile, $content);
fclose($isFile);
?>
<script>
$(document).ready(function(){
	$('#register_cancel').click(function(){
		$(this).href('contract=edit&id=<?php echo $_GET['id']; ?>&action=canceled');
	});
	
	$('#register_reset').click(function(){
		$(this).href('contract=list');
	});

	$('#register_print').popupWindow({ 
		windowURL:'?doc=<?php echo $targetName.'_'.$targetID; ?>', 
		centerBrowser:1,
		height:750,
		width:800,
	});
});
</script>
<?php else: ?>
	<div id="exception"><?php echo _SITE_NONE_MODULE;?></div>
<?php endif; ?>
<?php endif; ?>