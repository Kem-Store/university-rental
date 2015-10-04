<?php
$control = new Session();
$database = new SyncDatabase();
if(!$control->Value('USER_RENTAL') && !isset($_POST['login_submit'])):
?>
<center><table width="800" border="0" cellspacing="0" cellpadding="20" bgcolor="#FFFFFF" style="border-left:#cfcfcf solid 1px; border-right:#cfcfcf solid 1px; border-bottom:#cfcfcf solid 1px;">
  <tr>
    <td height="100" align="center" valign="top"><img src="images/Logo.png" width="620" height="100" border="0" />
    </td>
  </tr>
  <tr>
    <td valign="top"><div align="center"><table width="375" border="0" cellspacing="0" cellpadding="0" class="login-card">
      <tr><td id="module_ablove"></td></tr>
      <tr>
        <td id="module_main" align="center">
          <table width="100%" border="0" cellspacing="0" cellpadding="0">
            <tr>
              <td width="160" align="center" valign="top" id="user_picture">
                <img id="image_user" src="images/employee/user_none.jpg" width="110" height="128" border="0" />
              </td>
              <td align="left" valign="top" id="login_form">
               <div align="left" style="font-weight:bold; font-size:12px; background:url(images/module_line.png) -15px 25px no-repeat; width:180px; height:25px; padding:5px">
			   <?php echo _INPUT_TITLE; ?></div>
               <form name="login-form" id="login-form" method="post" action="<?php echo $control->Value('LOGIN_VAILD'); ?>">
               <div><input type="text" id="username" name="username" value="<?php echo _INPUT_LOGIN; ?>" maxlength="20" /></div>
               <div><input type="password" id="password" name="password" value="<?php echo _INPUT_LOGIN; ?>" maxlength="20" /></div>
               <div align="right"><input type="submit" id="login" name="login_submit" value="<?php echo _INPUT_SUBMIT; ?>" disabled="disabled" /></div></form>
              </td>
            </tr>
            <tr>
              <td colspan="2" valign="top">
                <div align="center" style="background-color:#3c3c3c; height:30px; margin:3px; padding:7px 10px 0 5px; color:#E00; font-weight:bold" id="error_massage">
                <?php if($control->Value('LOGIN_VAILD')) { echo _SUBMIT_TIMEUP; $control->Delete('LOGIN_VAILD'); } ?>
                </div>
              </td>
            </tr>
          </table>        
        </td>
      </tr>
      <tr><td id="module_below"></td></tr></table></div>
      <br /><p><hr width="80%" /><center><?php echo _SITE_FOOTER; ?></center></p><br />
    </td>
  </tr>
</table></center>
<?php
// Auto Login
if(isset($_GET['admin'])) { $control->setCookie('USER_RENTAL','admin', $GLOBALS['TIME_COOKIE']); }
?>
<script>
$(document).ready(function() {
	$('#username, #password').focus(function() {
		if($(this).val()=='<?php echo _INPUT_LOGIN; ?>') 
		{ 
			$(this).val(''); 
			$(this).css({'color': '#333333'});
		}
	});
	/*
	$('#username, #password').unfocus(function() {
		if($(this).val()=='')
			$(this).val('USERNAME');
	});
	*/
	var loginVaild = 0;
	var loginError = 'Login';
	$('#username, #password').keyup(function(){
		if($('#username').val()=='' || $('#password').val()=='' || $('#username').val()=='<?php echo _INPUT_LOGIN; ?>' || $('#password').val()=='<?php echo _INPUT_LOGIN; ?>') 
		{ $('#login').attr('disabled','disabled'); } else { $('#login').removeAttr('disabled','disabled'); }
		$.ajax({ url: 'index.php?ajax=login',
			data: ({ user_vaild : $('#username').val(), pass_vaild: $('#password').val() }),
			error: function (data){
				$('#error_massage').html('Success');
			},
			success: function (data){
				loginVaild = data.vaild;
				loginError = data.error; 
				$('#user_picture').html(data.image);
			},
		});
	});

	$('#username, #password').keydown(function(){
		if($('#username').val()=='' || $('#password').val()=='' || $('#username').val()=='<?php echo _INPUT_LOGIN; ?>' || $('#password').val()=='<?php echo _INPUT_LOGIN; ?>') 
		{ $('#login').attr('disabled','disabled'); } else { $('#login').removeAttr('disabled','disabled'); } 
		$.ajax({ url: 'index.php?ajax=login',
			data: ({ user_vaild : $('#username').val(), pass_vaild: $('#password').val() }),
			error: function (data){
				$('#error_massage').html('Success');
			},
			success: function (data){
				loginVaild = data.vaild;
				loginError = data.error;
				$('#user_picture').html(data.image);
			},
		});
	});
	
	$('#login-form').submit(function(){
		if(loginVaild==1) { 
			return true;
		} else {
			$('#error_massage').html(loginError);
			return false;
		}		
	});
});
</script>

<?php else:
if(isset($_POST['login_submit'])) {
	$control->setCookie('USER_RENTAL',$_POST['username'], $GLOBALS['TIME_COOKIE']);		
}
if($control->Value('USER_RENTAL')) { 
	$control->setCookie('USER_RENTAL',$control->Value('USER_RENTAL'), $GLOBALS['TIME_COOKIE']);		
	$control->setSession('LOGIN_VAILD',$_SERVER['REQUEST_URI']);
	foreach($database->Select('contract', array('canceled'=>0), 0) as $contract)
	{		
		$isToday = getdate(time());
		$isCharge = 50;
		$isChargeMonth = 3;		
		
		// Canceled Contract Expire
		if(($contract['cancel_date']!=0 && $contract['cancel_date']<time()) || $contract['expire_date']<time())
		{
			$database->Update('contract', array('canceled'=>1), array('contract_id'=>$contract['contract_id']));
			$database->Update('object_rental', array('status_object'=>0), array('object_id'=>$contract['object_id']));
		} else {				
			// Canceled Contract Over 3 Month
			if($database->Count('payment', array('contract_id'=>$contract['contract_id'],'amount'=>$contract['cost'],'paid'=>0),0)>$isChargeMonth) {
				$database->Update('contract', array('cancel_date'=>time(),'canceled'=>1), array('contract_id'=>$contract['contract_id']));
				$database->Update('object_rental', array('status_object'=>0), array('object_id'=>$contract['object_id']));	
			} else {		
				// Payment Month Insert
				if($database->Count('payment', array('contract_id'=>$contract['contract_id'],'amount'=>$contract['cost']),0)==0) {
					$isSignup = getdate($contract['signup_date']);
					$isSignup['mon'] += 1;
					if($isSignup['mon']>12) { $isSignup['mon']=1; $isSignup['year'] += 1; }
					$paymentInsert = array(
										'contract_id'=>$contract['contract_id'],	
										'amount'=>$contract['cost'],	
										'pay_date'=>ThaiDate::TimeStamp(7, $isSignup['mon'], $isSignup['year']),	
										);
					$database->Insert('payment', $paymentInsert);
				}
				
				foreach($database->Select('payment', array('contract_id'=>$contract['contract_id'],'amount'=>$contract['cost']), array(0,0,'ORDER BY pay_date DESC LIMIT 0,1')) as $payment) {
					$isPaydate = getdate($payment['pay_date']);
					while($isPaydate['mon']<=$isToday['mon'] || $isPaydate['year']<$isToday['year']) {
						$isPaydate['mon'] += 1;
						if($isPaydate['mon']>12) { $isPaydate['mon'] = 1; $isPaydate['year'] += 1; }				
						$paymentInsert = array(
											'contract_id'=>$contract['contract_id'],	
											'amount'=>$contract['cost'],	
											'pay_date'=>ThaiDate::TimeStamp(7, $isPaydate['mon'], $isPaydate['year']),	
											);
						$database->Insert('payment', $paymentInsert);
					}
				}
				
				// Payment Charge Now
				foreach($database->Select('payment', array('contract_id'=>$contract['contract_id'],'amount'=>$contract['cost'],'paid'=>0), 0) as $payment) {
					$isPaydate = getdate($payment['pay_date']);
					if($isPaydate['mon']<$isToday['mon'] || $isPaydate['year']<$isToday['year']) {
						$isNextMonth = $isPaydate['mon'] + 1;
						$isNextYear = $isPaydate['year'];
						if($isNextMonth>12) { $isNextMonth = 1; $isNextYear += 1; }
						$chargeMoney = ((ThaiDate::TimeStamp(7, $isNextMonth, $isNextYear) - $payment['pay_date'])/86400)*$isCharge;
						$database->Update('payment', array('charge'=>$chargeMoney), array('pay_id'=>$payment['pay_id']));
					} elseif($isPaydate['mon']==$isToday['mon'] && $isPaydate['year']==$isToday['year']) {
						$chargeMoney = (int)floor((time() - $payment['pay_date']) / 86400) * $isCharge;
						$database->Update('payment', array('charge'=>$chargeMoney), array('pay_id'=>$payment['pay_id']));
					}
				}				
			}//endif		
		}//endif	
	}//endforeach	
	foreach($database->Select('contract', array('canceled'=>1), 0) as $contract)
	{		
		// Payment Delete
		foreach($database->Select('payment', array('contract_id'=>$contract['contract_id'],'amount'=>$contract['cost'],'paid'=>0), 0) as $payment) {
			if($payment['pay_date']>time()) {
				$database->Delete('payment', array('pay_id'=>$payment['pay_id']));
			}
		}	
	}
}
$listMenu = array(
		_MENU_FRONTPAGE			=> '?',
		_MENU_OBJECT 			=> '?object=view',
		_MENU_RENTAL			=> '?contract=list',
		_MENU_INVOICE			=> '?invoice=view',
		_MENU_PAY				=> '?pay=ment',
		_MENU_DATA_EMPLOYEE		=> '?employee=view',
		_MENU_DATA_CUSTOMER 	=> '?customer=view',
		_MENU_REPORT			=> '?report=selected',
		_MENU_LOGOUT			=> '?logout=confirm',
		);

?>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td background="images/bg_head.png" style="background-repeat:repeat-x;"><center>
    <table width="802" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td align="left" background="images/bg_logo.jpg" style="height:75px;"><img src="images/LogoAdmin.jpg" width="475" height="75" border="0" /></td>
      </tr>
      <tr>
        <td align="left" valign="top" style="height:32px;">
        <?php
          foreach($listMenu as $nameMenu=>$linkMenu) {
			  $urlInfo = pathinfo($_SERVER['REQUEST_URI']);
			  list($modulePath) = explode('/',$urlInfo['filename']);
			  list($selectdModule) = explode('=',$modulePath);
			  list($menuModule) = explode('=',$linkMenu);
			  if($menuModule!=$selectdModule) {
				  echo '<a href="'.$linkMenu.'"><span id="menu-list">'.$nameMenu.'</span></a>';
			  } else {
				  echo '<span id="menu-list-select" style="border-bottom:#5b0000 solid 4px;">'.$nameMenu.'</span>';
			  }
			  echo '<img src="images/menu_line.jpg" width="2" height="32" border="0" align="absmiddle" />'."\n\r    ";
          }
        ?>
        </td>
      </tr>
      <tr>
        <td id="rental_shadow"></td>
      </tr>
      <tr>
        <td align="left" valign="top" id="rental_body"><?php
			@list($tmp,$directory) = explode('?',$_SERVER['REQUEST_URI']);
			if($directory==NULL) {
				$directory = 'frontpage';
				$_GET['frontpage'] = 'frontpage';
			}
			list($directory) = explode('=',$directory);
			site::Module($directory, $_GET[$directory]);
		?></td>
      </tr>
      <tr>
        <td align="left" valign="top">
        <div id="error_ajax">&nbsp;</div>
        <p><hr width="80%" /><center><?php echo _SITE_FOOTER; ?></center></p></td>
      </tr>
    </table></center>
	</td>
  </tr>
</table>
<?php
// Auto Logout
if(isset($_GET['logout'])) { $control->Delete('USER_RENTAL');$control->Delete('LOGIN_VAILD'); header("Location:?"); exit(); }
?>
<?php endif; ?>
