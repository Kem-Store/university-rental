<br /><div align="left"><h1><?php echo _HEAD_LIST_INVOICE; ?></h1></div>
<table align="left" width="100%" border="0" cellspacing="0" cellpadding="0" style="border-top:#999 dashed 1px;">
  <tr>
    <td align="center"><div>&nbsp;</div>
      <table align="left" width="100%" border="0" cellspacing="0" cellpadding="3" id="list-user">
        <tr style="background-color:#666;color:#FFF;">
          <td width="35" align="center" id="head-text"><strong><?php echo _REGISTER_USERID; ?></strong></td>
          <td width="5" align="center">&nbsp;</td>
          <td width="200" align="left"><strong><?php echo _REGISTER_FULLNAME; ?></strong></td>
          <td width="140" align="left"><strong><?php echo _REGISTER_TYPE; ?></strong></td>
          <td width="100" align="right"><strong><?php echo _PAYMENT_LIST_COST; ?></strong></td>
          <td width="100" align="right"><strong><?php echo _PAYMENT_LIST_CHARGE; ?></strong></td>
          <td width="100" align="right"><strong><?php echo _PAYMENT_LIST_TOTAL; ?></strong></td>
        </tr>
      </table>
      <?php
      $database = new SyncDatabase();
	  $colorRow = 1;
      foreach($database->Select('contract',array('canceled'=>0),0) as $contract)
      {
		  $object = $database->Value('object_rental', array('object_id'=>$contract['object_id']), 0);
		  $objectType = $database->Value('object_type', array('type_id'=>$object['type_id']), 0);
		  
	      $listCustomer[$contract['cus_id']] = array();
		  $listCustomer[$contract['cus_id']]['pay'] = 0;
		  $listCustomer[$contract['cus_id']]['charge'] = 0;
		  $listCustomer[$contract['cus_id']]['total'] = 0;
		  $listCustomer[$contract['cus_id']]['list'] = 0;
		  foreach($database->Select('customer', array('cus_id'=>$contract['cus_id']),0) as $customer)
		  {
			  foreach($database->Select('payment', array('contract_id'=>$contract['contract_id'],'paid'=>0), 0) as $payment)
			  {
				  $listCustomer[$customer['cus_id']]['list']++;
				  $listCustomer[$customer['cus_id']]['pay'] += $payment['amount'];
				  $listCustomer[$customer['cus_id']]['charge'] += $payment['charge'];
				  $listCustomer[$customer['cus_id']]['total'] += ($payment['amount'] + $payment['charge']);
			  }
		  }
		  if($colorRow%2==0) { $style = 'style="background-color:#F7F7F7;"'; } else { $style = ''; }
		  if($listCustomer[$contract['cus_id']]['total']!=0) { echo '<a href="?invoice=print&id='.$contract['contract_id'].'">'; }
		  echo '<table align="left" width="100%" border="0" cellspacing="0" cellpadding="3" class="list-space" id="user_'.$customer['cus_id'].'" '.$style.'>';
		  echo '<tr style="height:30px"';
		  if($listCustomer[$contract['cus_id']]['total']!=0) { echo ' class="list-select"'; }
		  echo '><td align="center"><div style="width:35px;" id="img_'.$customer['cus_id'].'">'.$colorRow.'</div></td>';
		  echo '<td align="center"><div style="width:5px;" id="id'.$customer['cus_id'].'"></div></td>';
		  echo '<td align="left"><div style="width:200px;word-wrap:break-word;"><strong>'.$customer['fullname'].'</strong></div></td>';
		  echo '<td align="left"><div style="width:140px;word-wrap:break-word;"><strong>'.$objectType['type_name'].$object['detail'].'</strong></div></td>';
		  echo '<td align="right"><div style="width:100px;">'.number_format($listCustomer[$customer['cus_id']]['pay'],2).'</div></td>';
		  echo '<td align="right"><div style="width:100px;word-wrap:break-word;">'.number_format($listCustomer[$customer['cus_id']]['charge'],2).'</div></td>';
		  echo '<td align="right"><div style="width:100px;">'.number_format($listCustomer[$customer['cus_id']]['total'],2).'</div></td>';
		  echo '</tr></table>';
		  if($listCustomer[$contract['cus_id']]['total']!=0) { echo '</a>'; }
		  $colorRow++;

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