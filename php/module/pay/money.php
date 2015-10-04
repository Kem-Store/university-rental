<?php 
$database = new SyncDatabase();
if(!isset($_GET['action'])) { $_GET['action'] = ''; }
if($_GET['action']=='pay'): 
if(isset($_GET['id']))
{
	$database->Update('payment', array('paid'=>1), array('pay_id'=>$_GET['id']));
	header("Location:?pay=ment");
	exit();
} elseif(isset($_GET['customer'])) {
	foreach($database->Select('contract', array('cus_id'=>$_GET['customer']),0) as $contract) {
		$database->Update('payment', array('paid'=>1), array('contract_id'=>$contract['contract_id']));
	}
	header("Location:?pay=ment");
	exit();
}
?>
<?php else: ?>
<?php if(isset($_GET['customer'])): ?>
<?php
	$customer = $database->Value('customer', array('cus_id'=>$_GET['customer']),0);
	$listCustomer['pay'] = 0;
	$listCustomer['charge'] = 0;
	$listCustomer['total'] = 0;
	
	foreach($database->Select('contract', array('cus_id'=>$customer['cus_id']),0) as $contract)
	{
		foreach($database->Select('payment', array('contract_id'=>$contract['contract_id'],'paid'=>0), 0) as $payment)
		{
			$listCustomer['pay'] += $payment['amount'];
			$listCustomer['charge'] += $payment['charge'];
			$listCustomer['total'] += ($payment['amount'] + $payment['charge']);
		}
	}
?>
<form action="" method="POST" name="employee_register" id="employee_register">
  <table width="100%" cellpadding="5" cellspacing="0" border="0">
    <tr>
      <td width="180" align="center" valign="top" style="border-right:#CCC dashed 1px;">
       <input type="button" name="register_save" id="register_save" value="" title="<?php echo _IMAGE_TAG_SUBMIT; ?>" />
       <input type="reset" name="register_reset" id="register_reset" value="" title="<?php echo _IMAGE_TAG_BACK; ?>" />
      </td>
      <td align="left" valign="top">
        <table border="0" cellspacing="0" cellpadding="3">
          <tr>
            <td colspan="2" align="left" valign="middle"><h4><?php echo _REGISTER_USER_CUSTOMER; ?></h4></td>
          </tr>
          <tr>
            <td align="right" valign="middle"><strong><?php echo _REGISTER_FULLNAME; ?></strong></td>
            <td align="left"><div style="width:400px;word-wrap:break-word;"><?php echo $customer['fullname']; ?></div></td>
          </tr>
          <tr>
            <td align="right" valign="top"><strong><?php echo _PAYMENT_COST; ?></strong></td>
            <td align="left"><div style="width:400px;word-wrap:break-word;"><?php echo number_format($listCustomer['pay'],2)._CONTRACT_PRINT_BAHT; ?></div></td>
          </tr>
          <tr>	
            <td width="120" align="right" valign="middle"><strong><?php echo _PAYMENT_CHARGE; ?></strong></td>
            <td align="left"><div style="width:400px;word-wrap:break-word;"><?php echo number_format($listCustomer['charge'],2)._CONTRACT_PRINT_BAHT; ?></div></td>
          </tr>
          <tr>	
            <td width="120" align="right" valign="middle"><strong><?php echo _PAYMENT_TOTAL; ?></strong></td>
            <td align="left"><div style="width:400px;word-wrap:break-word;"><?php echo number_format($listCustomer['total'],2)._CONTRACT_PRINT_BAHT; ?></div></td>
          </tr>
          <tr>
            <td colspan="2" align="left" valign="middle">&nbsp;</td>
          </tr>
          <tr>
            <td colspan="2" align="left" valign="middle">
              <table align="left" width="100%" border="0" cellspacing="0" cellpadding="3">
              <tr style="height:20px">
              <td align="left"><div style="width:250px;word-wrap:break-word;"><strong><?php echo _PAYMENT_LIST_TIME; ?></strong></div></td>
              <td align="right"><div style="width:120px;"><strong><?php echo _PAYMENT_LIST_COST; ?></strong></div></td>
              </tr></table>
            <?php
			  foreach($database->Select('contract', array('cus_id'=>$customer['cus_id']),0) as $contract)
			  {
				  foreach($database->Select('payment', array('contract_id'=>$contract['contract_id'],'paid'=>0), 0) as $payment)
				  {
					  echo '<table align="left" width="100%" border="0" cellspacing="0" cellpadding="3">';
					  echo '<tr style="height:20px">';
					  echo '<td align="left"><div style="width:250px;word-wrap:break-word;">';
					  if($payment['amount']==1000 || $payment['amount']==2000) {
						  echo _PAYMENT_PAYRENT;
					  } else {
						  echo _PAYMENT_DEPOSITE;
					  }
					  echo '</div></td>';
					  echo '<td align="right"><div style="width:120px;">'.number_format(($payment['amount']+$payment['charge']),2).'</div></td>';
					  echo '</tr></table>';
				  }
			  }
			?>
            </td>
          </tr>
          <tr>
            <td colspan="2" align="left" valign="middle">&nbsp;</td>
          </tr>
        </table>
      </td>
    </tr>
  </table>
</form>
<script>
$(document).ready(function(){
	$('#register_save').click(function(){
		$(this).href('pay=money&customer=<?php echo $_GET['customer']; ?>&action=pay');
	});
	
	$('#register_reset').click(function(){
		$(this).href('pay=ment');
	});
});
</script>
<?php elseif(isset($_GET['id'])): ?>
<?php
	$payment = $database->Value('payment', array('pay_id'=>$_GET['id']),0);
?>
<form action="" method="POST" name="employee_register" id="employee_register">
  <table width="100%" cellpadding="5" cellspacing="0" border="0">
    <tr>
      <td width="180" align="center" valign="top" style="border-right:#CCC dashed 1px;">
       <input type="button" name="register_save" id="register_save" value="" title="<?php echo _IMAGE_TAG_SUBMIT; ?>" />
       <input type="reset" name="register_reset" id="register_reset" value="" title="<?php echo _IMAGE_TAG_BACK; ?>" />
      </td>
      <td align="left" valign="top">
        <table border="0" cellspacing="0" cellpadding="3">
          <tr>
            <td colspan="2" align="left" valign="middle"><h4><?php echo _REGISTER_USER_PAYMENT; ?></h4></td>
          </tr>
          <tr>
            <td align="right" valign="middle"><strong><?php echo _PAYMENT_LIST_TIME; ?></strong></td>
            <td align="left"><div style="width:400px;word-wrap:break-word;"><?php echo ThaiDate::Full($payment['pay_date']); ?></div></td>
          </tr>
          <tr>
            <td align="right" valign="middle"><strong><?php echo _PAYMENT_COST; ?></strong></td>
            <td align="left"><div style="width:400px;word-wrap:break-word;"><?php echo number_format($payment['amount'],2)._CONTRACT_PRINT_BAHT; ?></div></td>
          </tr>
          <tr>
            <td align="right" valign="top"><strong><?php echo _PAYMENT_CHARGE; ?></strong></td>
            <td align="left"><div style="width:400px;word-wrap:break-word;"><?php echo number_format($payment['charge'],2)._CONTRACT_PRINT_BAHT; ?></div></td>
          </tr>
          <tr>	
            <td width="120" align="right" valign="middle"><strong><?php echo _PAYMENT_TOTAL; ?></strong></td>
            <td align="left"><div style="width:400px;word-wrap:break-word;"><?php echo number_format($payment['amount']+$payment['charge'],2)._CONTRACT_PRINT_BAHT; ?></div></td>
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
<script>
$(document).ready(function(){
	$('#register_save').click(function(){
		$(this).href('pay=money&id=<?php echo $_GET['id']; ?>&action=pay');
	});
	
	$('#register_reset').click(function(){
		$(this).href('pay=ment');
	});
});
</script>
<?php endif; ?>
<?php endif; ?>