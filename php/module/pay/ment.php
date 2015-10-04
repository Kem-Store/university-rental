<br /><div align="left"><h1><?php echo _HEAD_LIST_PAY; ?></h1></div>
<table align="left" width="100%" border="0" cellspacing="0" cellpadding="0" style="border-top:#999 dashed 1px;">
  <tr>
    <td align="center"><div>&nbsp;</div>
      <table align="left" width="100%" border="0" cellspacing="0" cellpadding="3" id="list-user">
        <tr style="background-color:#666;color:#FFF;">
          <td width="35" align="center" id="head-text"><strong><?php echo _REGISTER_USERID; ?></strong></td>
          <td width="5" align="center">&nbsp;</td>
          <td width="300" align="left"><strong><?php echo _REGISTER_FULLNAME; ?></strong></td>
          <td width="100" align="right"><strong><?php echo _PAYMENT_LIST_COST; ?></strong></td>
          <td width="100" align="right"><strong><?php echo _PAYMENT_LIST_CHARGE; ?></strong></td>
          <td width="100" align="right"><strong><?php echo _PAYMENT_LIST_TOTAL; ?></strong></td>
        </tr>
      </table>
      <?php
      $database = new SyncDatabase();
	  $colorRow = 1;
      foreach($database->Select('customer',0,0) as $customer)
      {
	      $listCustomer[$customer['cus_id']] = array();
		  $listCustomer[$customer['cus_id']]['pay'] = 0;
		  $listCustomer[$customer['cus_id']]['charge'] = 0;
		  $listCustomer[$customer['cus_id']]['total'] = 0;
		  $listCustomer[$customer['cus_id']]['list'] = 0;
		  foreach($database->Select('contract', array('cus_id'=>$customer['cus_id']),0) as $contract)
		  {
			  $listCustomer[$customer['cus_id']]['object'] = $database->Value('object_rental', array('object_id'=>$contract['object_id']), 0);
			  $listCustomer[$customer['cus_id']]['type'] = $database->Value('object_type', array('type_id'=>$listCustomer[$customer['cus_id']]['object']['type_id']), 0);
			  $listCustomer[$customer['cus_id']]['payment'] = $database->Value('payment', array('contract_id'=>$contract['contract_id'],'paid'=>0), 0);
			  $listCustomer[$customer['cus_id']]['object'] = $listCustomer[$customer['cus_id']]['object']['detail'];
			  $listCustomer[$customer['cus_id']]['type'] = $listCustomer[$customer['cus_id']]['type']['type_name'];
			  $listCustomer[$customer['cus_id']]['payment'] = $listCustomer[$customer['cus_id']]['payment']['pay_date'];
			  $listCustomer[$customer['cus_id']]['paid'] = $database->Count('payment', array('contract_id'=>$contract['contract_id'],'amount'=>$contract['cost'],'paid'=>0),0);
			  
			  foreach($database->Select('payment', array('contract_id'=>$contract['contract_id'],'paid'=>0), 0) as $payment)
			  {
				  $listCustomer[$customer['cus_id']]['list']++;
				  $listCustomer[$customer['cus_id']]['pay'] += $payment['amount'];
				  $listCustomer[$customer['cus_id']]['charge'] += $payment['charge'];
				  $listCustomer[$customer['cus_id']]['total'] += ($payment['amount'] + $payment['charge']);
			  }
		  }
		  if($listCustomer[$customer['cus_id']]['total']!=0) {
			  if($listCustomer[$customer['cus_id']]['paid']>2) {
				  $style = 'style="background-color:#f6aaaa;"';
			  } else if($listCustomer[$customer['cus_id']]['paid']>1) {
				  $style = 'style="background-color:#f6f3aa;"';
			  } else {
				  $style = 'style="background-color:#ccffcc;"';
			  }			  
			  echo '<a href="?pay=money&customer='.$customer['cus_id'].'">';
			  echo '<table align="left" width="100%" border="0" cellspacing="0" cellpadding="3" class="list-space" id="user_'.$customer['cus_id'].'" '.$style.'>';
			  echo '<tr style="height:30px" class="list-select">';
			  echo '<td align="center"><div style="width:35px;" id="img_'.$customer['cus_id'].'">'.$colorRow.'</div></td>';
			  echo '<td align="center"><div style="width:5px;" id="id'.$customer['cus_id'].'"></div></td>';
			  echo '<td align="left"><div style="width:300px;word-wrap:break-word;"><strong>'.$customer['fullname'].'</strong> <span style="font-size:9px;">';
			  echo '</span></div></td>';
			  echo '<td align="right"><div style="width:100px;">'.number_format($listCustomer[$customer['cus_id']]['pay'],2).'</div></td>';
			  echo '<td align="right"><div style="width:100px;word-wrap:break-word;">'.number_format($listCustomer[$customer['cus_id']]['charge'],2).'</div></td>';
			  echo '<td align="right"><div style="width:100px;">'.number_format($listCustomer[$customer['cus_id']]['total'],2).'</div></td>';
			  echo '</tr></table></a>';
		  }
		  
		  foreach($database->Select('contract', array('cus_id'=>$customer['cus_id']),0) as $contract)
		  {
			  $object = $database->Value('object_rental', array('object_id'=>$contract['object_id']), 0);
			  $objectType = $database->Value('object_type', array('type_id'=>$object['type_id']), 0);
			  foreach($database->Select('payment', array('contract_id'=>$contract['contract_id'],'paid'=>0), 0) as $payment)
			  {
				  echo '<a href="?pay=money&id='.$payment['pay_id'].'">';
				  echo '<table align="left" width="100%" border="0" cellspacing="0" cellpadding="3" class="list-drop" style="background-color:#EEE;">';
				  echo '<tr style="height:20px" class="list-drop">';
				  echo '<td align="center"><div style="width:25px;" id="img_'.$payment['pay_id'].'">&nbsp;</div></td>';
				  echo '<td align="center"><div style="width:35px;" id="id'.$payment['pay_id'].'"></div></td>';
				  echo '<td align="left"><div style="width:270px;word-wrap:break-word;">'.$objectType['type_name'].$object['detail'].' ('.ThaiDate::Full($payment['pay_date']).')</div></td>';
				  echo '<td align="right"><div style="width:100px;">'.number_format($payment['amount'],2).'</div></td>';
				  echo '<td align="right"><div style="width:100px;word-wrap:break-word;">'.number_format($payment['charge'],2).'</div></td>';
				  echo '<td align="right"><div style="width:100px;">'.number_format(($payment['amount']+$payment['charge']),2).'</div></td>';
				  echo '</tr></table></a>';
			  }
		  }

		  if($listCustomer[$customer['cus_id']]['total']!=0) {
			  $colorRow++;
		  }

      }
	  if($database->Count('payment',array('paid'=>0),0)==0) {
          echo '<table align="right" width="100%" border="0" cellspacing="0" cellpadding="3" id="list-user"><tr style="height:30px"><td align="center" align="center" colspan="8">';
          echo '<strong>'._REGISTER_NONE.'</strong>';
		  echo '</td></tr></table>';
	  }
      ?>
    </td>
  </tr>
</table>