<?php 
$control = new Session();
$database = new SyncDatabase();
if(isset($_GET['action']) && isset($_POST['register_apply'])): 
	$customer = $database->Value('customer', array('cus_id'=>$_REQUEST['regis_customer']), 0);
	$object = $database->Value('object_rental', array('object_id'=>$_REQUEST['regis_object']), 0);
	$type = $database->Value('object_type', array('type_id'=>$object['type_id']), 0);
	$user = $database->Value('employee', array('username'=>$control->Value('USER_RENTAL')), 0);
	$newContract = array(
				'cus_id'		=> $_REQUEST['regis_customer'],
				'emp_id'		=> $user['emp_id'],
				'object_id'		=> $_REQUEST['regis_object'],
				'cost'			=> $type['rentalcost'],
				'deposite'		=> ($type['rentalcost']*3),
				'signup_date'	=> $_REQUEST['timestamp_signup'],
				'expire_date'	=> $_REQUEST['timestamp_expire'],
				);

	$database->Insert('contract', $newContract);
	
	$idContract= $database->Value('contract',array('signup_date'=>$_REQUEST['timestamp_signup']),0);
	$newPayment = array(
				'contract_id'	=> $idContract['contract_id'],
				'amount'		=> ($type['rentalcost']*3),
				'pay_date'		=> $_REQUEST['timestamp_signup'],
				);
	$database->Insert('payment', $newPayment);
	$database->Update('object_rental', array('status_object'=>1), array('object_id'=>$object['object_id']));
?>
<table width="100%" cellpadding="5" cellspacing="0" border="0">
    <tr>
      <td width="180" align="center" valign="top" style="border-right:#CCC dashed 1px;">
       <input type="button" name="register_pay" id="register_pay" value=" " title="<?php echo _IMAGE_TAG_PAY; ?>"  />
       <input type="button" name="register_success" id="register_success" value=" " title="<?php echo _IMAGE_TAG_BACK; ?>"  />
      </td>
      <td align="left" valign="top">
       <h4><?php echo _REGISTER_CUSTOMER_ADD; ?></h4>
        <table border="0" cellspacing="0" cellpadding="3">
          <tr>
            <td align="right" valign="top">&nbsp;</td>
            <td align="left" valign="top">&nbsp;</td>
          </tr>
          <tr>
            <td align="right" valign="top"><strong><?php echo _REGISTER_FULLNAME; ?>:</strong></td>
            <td align="left" valign="top"><?php echo $customer['fullname']; ?></td>
          </tr>
          <tr>
            <td width="200" align="right" valign="top"><strong><?php echo _CONTRACT_STATUS_RENT; ?>:</strong></td>
            <td width="300" align="left" valign="top"><?php echo $type['type_name'].' '.$object['detail']; ?></td>
          </tr>
          <tr>
            <td align="right" valign="top"><strong><?php echo _CONTRACT_SINGUP; ?>:</strong></td>
            <td align="left" valign="top"><?php echo $_REQUEST['signup_year']; ?></td>
          </tr>
          <tr>
            <td align="right" valign="top"><strong><?php echo _CONTRACT_EXPIRE; ?>:</strong></td>
            <td align="left" valign="top"><?php echo $_REQUEST['expire_year']; ?></td>
          </tr>
          <tr>
            <td align="right" valign="top">&nbsp;</td>
            <td align="left" valign="top">&nbsp;</td>
          </tr>
        </table>
      </td>
    </tr>
  </table>
<?php
$idContract= $database->Value('contract',array('signup_date'=>$_REQUEST['timestamp_signup']),0);
$idPayment = $database->Value('payment', array('contract_id'=>$idContract['contract_id']),0);
?>
<script>
$(document).ready(function(){
	$('#register_pay').click(function(){
		$(this).href('pay=money&id=<?php echo $idPayment['pay_id']; ?>');
	});
	
	$('#register_success').click(function(){
		$(this).href('contract=list');
	});
});
</script>
<?php else: ?>
<?php
$miniMonth = array(1=>_JA,2=>_FE,3=>_MA,4=>_AP,5=>_MY,6=>_JN,7=>_JL,8=>_AU,9=>_SE,10=>_OC,11=>_NO,12=>_DE);
$month = each($miniMonth);
$isToday = getdate(time());
?>
<form action="?contract=register&action=success" method="POST" name="employee_register" id="employee_register">
  <table width="100%" cellpadding="5" cellspacing="0" border="0">
    <tr>
      <td width="180" align="center" valign="top" style="border-right:#CCC dashed 1px;">
       <input type="submit" name="register_apply" id="register_apply" value="" title="<?php echo _IMAGE_TAG_SUBMIT; ?>" />
       <input type="reset" name="register_reset" id="register_reset" value="" title="<?php echo _IMAGE_TAG_BACK; ?>" /></td>
      <td align="left" valign="top">
        <h4><?php echo _REGISTER_USER_DATA; ?><span class="vaild_info2" id="form_comment">&nbsp;</span></h4>
        <table border="0" cellspacing="0" cellpadding="3">
          <tr>
            <td width="200" align="right"><?php echo _REGISTER_FULLNAME; ?></td>
            <td align="left">
            <select name="regis_customer" id="regis_customer">
              <?php foreach($database->Select('customer', 0, 0) as $customer): ?>
              <option value="<?php echo $customer['cus_id']; ?>"><?php echo $customer['fullname']; ?></option>
              <?php endforeach; ?>
            </select>
            </td>
          </tr>
          <tr>
            <td align="right"><?php echo _CONTRACT_STATUS_RENT; ?></td>
            <td align="left">
            <select name="regis_object" id="regis_object">
              <?php foreach($database->Select('object_type', 0, 0) as $type): ?>
				  <?php foreach($database->Select('object_rental', array('status_object'=>0, 'type_id'=>$type['type_id']), 0) as $rental): ?>
                  <option value="<?php echo $rental['object_id']; ?>"><?php echo $type['type_name'].' '.$rental['detail']; ?></option>
                  <?php endforeach; ?>
              <?php endforeach; ?>
            </select>
            </td>
          </tr>
          <tr>
            <td align="right"><?php echo _CONTRACT_SINGUP; ?></td>
            <td align="left">
              <div style="margin:3px;"><input name="signup_year" type="text" id="signup_year" value="" size="25" /><input type="hidden" name="timestamp_signup" id="timestamp_signup" value="" /></div>
            </td>
          </tr>
          <tr>
            <td align="right">&nbsp;</td>
            <td align="left">
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
            </td>
          </tr>
          <tr>
            <td align="right"><?php echo _CONTRACT_EXPIRE; ?></td>
            <td align="left"><input name="expire_year" type="text" id="expire_year" value="" size="25" /><input type="hidden" name="timestamp_expire" id="timestamp_expire" value="" /></td>
          </tr>
        </table>
      </td>
    </tr>
  </table>
</form>
<script>
$(document).ready(function() {
	var isDay = parseFloat($('#jDay').val());
	var isMonth = parseFloat($('#jMonth').val());
	var isYear = parseFloat($('#jYear').val());
	$('#month_today').caleDay(isDay, isMonth, isYear);
	
	$('#register_reset').click(function(){
		$(this).href('contract=list');
	});
	
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
<?php endif; ?>