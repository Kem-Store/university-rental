<?php
$database = new SyncDatabase();
$contract = $database->Value('contract', array('contract_id'=>$_GET['id']),0);
$customer = $database->Value('customer', array('cus_id'=>$contract['cus_id']),0);
$employee = $database->Value('employee', array('emp_id'=>$contract['emp_id']),0);
$object = $database->Value('object_rental', array('object_id'=>$contract['object_id']),0);
$type = $database->Value('object_type', array('type_id'=>$object['type_id']),0);

$isPaydate = $database->Value('payment', array('contract_id'=>$contract['contract_id'],'amount'=>$contract['cost']), array(0,0,'ORDER BY pay_date DESC LIMIT 0,1'));

$payTotal = 0;
$changeTotal = 0;
foreach($database->Select('payment', array('contract_id'=>$contract['contract_id'],'paid'=>0), 0) as $payment) {
	$changeTotal += $payment['charge'];
	$payTotal += $payment['amount'] + $payment['charge'];
}
?>

<form action="" method="POST" name="employee_register" id="employee_register">
  <table width="100%" cellpadding="5" cellspacing="0" border="0">
    <tr>
      <td width="180" align="center" valign="top" style="border-right:#CCC dashed 1px;">
      <input type="reset" name="register_reset" id="register_reset" value="" title="<?php echo _IMAGE_TAG_BACK; ?>" />
        <input type="button" name="register_print" id="register_print" value="" title="<?php echo _IMAGE_TAG_PRINT; ?>" /></td>
      <td align="left" valign="top">
        <table border="0" cellspacing="0" cellpadding="3"<?php if($contract['cancel_date']!=0 && $contract['cancel_date']<time()) { echo ' style="background:url(images/canceled.jpg) 100% 100% no-repeat;"';} ?>>
          <tr>
            <td colspan="2" align="right" valign="middle"><strong><?php echo _INVOICE_PAY_DUE.ThaiDate::Full($isPaydate['pay_date']); ?></strong></td>
          </tr>
          <tr>
            <td colspan="2" align="right" valign="middle"><strong><?php echo _INVOICE_DAY.ThaiDate::Full(time()); ?></strong></td>
          </tr>
          <tr>
            <td colspan="2" align="center" valign="middle"><h1><?php echo _INVOICE_HEAD; ?></h1></td>
          </tr>
          <tr>
            <td colspan="2" align="left" valign="middle"><h4><?php echo _REGISTER_USER_CUSTOMER; ?></h4></td>
          </tr>
          <tr>
            <td align="right" valign="middle"><strong><?php echo _INVOICE_CONTRACT_NUMBER; ?></strong></td>
            <td align="left"><div style="width:400px;word-wrap:break-word;"><?php echo $contract['cus_id'].$contract['object_id'].$contract['emp_id'].'-'.$contract['contract_id']; ?></div>
          </td>
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
            <td align="right" valign="middle"><strong><?php echo _REGISTER_FULLNAME; ?></strong></td>
            <td align="left"><div style="width:400px;word-wrap:break-word;"><?php echo $customer['fullname']; ?></div></td>
          </tr>
          <tr>
            <td align="right" valign="top"><strong><?php echo _REGISTER_ADDRESS; ?></strong></td>
            <td align="left"><div style="width:400px;word-wrap:break-word;"><?php echo $customer['address']; ?></div></td>
          </tr>
          <tr>
            <td colspan="2" align="left" valign="middle">&nbsp;</td>
          </tr>
          <tr>
            <td colspan="2" align="left" valign="middle"><h4><?php echo _INVOICE_PAY_HEADTOTAL; ?></h4></td>
          </tr>
          <tr>
            <td align="right" valign="top"><strong><?php echo _INVOICE_PAY_CHARGE; ?></strong></td>
            <td align="left"><div style="width:400px;word-wrap:break-word;"><?php echo number_format($changeTotal,2)._CONTRACT_PRINT_BAHT; ?></div></td>
          </tr>
          <tr>
            <td align="right" valign="top"><strong><?php echo _PAYMENT_TOTAL; ?></strong></td>
            <td align="left"><div style="width:400px;word-wrap:break-word;"><?php echo number_format($payTotal,2)._CONTRACT_PRINT_BAHT; ?></div></td>
          </tr>
          <tr>
            <td colspan="2" align="left" valign="middle">&nbsp;</td>
          </tr>
          <tr>
            <td colspan="2" align="left" valign="middle"><h4><?php echo _INVOICE_PAY_HEADLIST; ?></h4></td>
          </tr>
          <tr>
            <td colspan="2" align="left" valign="middle">
              <table align="left" width="100%" border="0" cellspacing="0" cellpadding="3" style="font-size:9px;">
                <tr style="height:20px">
                  <td align="center"><div style="width:5px;"></div></td>
                  <td align="left"><div style="width:250px;word-wrap:break-word;"><strong><?php echo _INVOICE_PAY_DAY; ?></strong></div></td>
                  <td align="right"><div style="width:100px;"><strong><?php echo _PAYMENT_LIST_COST; ?></strong></div></td>
                  <td align="right"><div style="width:100px;word-wrap:break-word;"><strong><?php echo _PAYMENT_LIST_CHARGE; ?></strong></div></td>
                  <td align="right"><div style="width:100px;"><strong><?php echo _PAYMENT_LIST_TOTAL; ?></strong></div></td>
                </tr>
              </table>
			  <?php foreach($database->Select('payment', array('contract_id'=>$contract['contract_id'],'paid'=>0), 0) as $payment): ?>
              <table align="left" width="100%" border="0" cellspacing="0" cellpadding="3" style="font-size:9px;">
                <tr style="height:20px">
                  <td align="center"><div style="width:5px;"></div></td>
                  <td align="left"><div style="width:250px;word-wrap:break-word;"><?php
				  if($payment['amount']==1000 || $payment['amount']==2000) {
					  echo _PAYMENT_PAYRENT;
				  } else {
					  echo _PAYMENT_DEPOSITE;
				  }
				  ?></div></td>
                  <td align="right"><div style="width:100px;"><?php echo number_format($payment['amount'],2); ?></div></td>
                  <td align="right"><div style="width:100px;word-wrap:break-word;"><?php echo number_format($payment['charge'],2); ?></div></td>
                  <td align="right"><div style="width:100px;"><?php echo number_format(($payment['amount']+$payment['charge']),2); ?></div></td>
                </tr>
              </table>
              <?php endforeach; ?></td>
          </tr>
          <tr>
            <td colspan="2" align="left" valign="middle">&nbsp;</td>
          </tr>
        </table></td>
    </tr>
  </table>
</form>
<?php
$idObject = $object['object_id'];
while(strlen($idObject)<3) { $idObject = '0'.$idObject; }
$dueDate = 0;
$listMoney = '<table width="100%" border="0" cellpadding="0" cellspacing="0">';
$moneyTotal = 0;
foreach($database->Select('payment', array('contract_id'=>$contract['contract_id'],'paid'=>0), 0) as $payment) {
	$listMoney .= '<tr><td align="left" valign="middle"><span style="margin-left:40px;">';
	if($payment['amount']==1000 || $payment['amount']==2000) {
		$listMoney .=  _PAYMENT_PAYRENT;
	} else {
		$listMoney .= _PAYMENT_DEPOSITE;
	}
	$listMoney .= '</span></td>';
    $listMoney .= '<td align="right" valign="middle"><span style="margin-left:40px;">'.number_format(($payment['amount']+$payment['charge']),2).'</span></td></tr>';
	if($payment['pay_date']>$dueDate) {
		$dueDate = $payment['pay_date'];
	}
	$moneyTotal += $payment['amount']+$payment['charge'];
}
$listMoney .= '</table>';

$data = array(
		'head'=>_CONTRACT_PRINT_HEAD,
		'today'=>_INVOICE_DAY.ThaiDate::Full(time()),
		'invoice'=>_INVOICE_HEAD,
		'contract_id'=>'<strong>'._INVOICE_CONTRACT_NUMBER.'</strong> '.$contract['cus_id'].$contract['object_id'].$contract['emp_id'].'-'.$contract['contract_id'],
		'object_id'=>'<strong>'._CONTRACT_PRINT_OBJECT.$type['type_name'].'</strong> '.$type['type_id'].$idObject,
		'name'=>'<strong>'._REGISTER_FULLNAME.'</strong> '.$customer['fullname'],
		'address'=>'<strong>'._REGISTER_ADDRESS.'</strong> '.$customer['address'],
		'due_date'=>'<strong>'._INVOICE_PAY_DUE.'</strong> '.ThaiDate::Full($dueDate),
		'pay_head'=>'<strong>'._INVOICE_PAY_HEADTOTAL.'</strong>',
		'list'=>$listMoney,
		'pay_total'=>'<strong>'._INVOICE_PAY_TOTAL.'</strong>',
		'pay_money_total'=>'<strong>'.number_format($moneyTotal, 2).'</strong>',
		'personal'=>_INVOICE_PAY_MONEY,
	);

$printButton = '<div style="position:fixed;top:10px;right:10px;"><input type="button" name="print" value="Print" onClick="javascript:window.print()">
				<input type="button" name="close" value="Close" onClick="javascript:window.close()"></div>';		

$content = site::Content('invoice',$data);
$targetDirectory = "document/";
$targetName = "invoice";
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
		$(this).href('invoice=view');
	});

	$('#register_print').popupWindow({ 
		windowURL:'?doc=<?php echo $targetName.'_'.$targetID; ?>', 
		centerBrowser:1,
		height:750,
		width:800,
	});
});
</script>