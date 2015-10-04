<?php
$control = new Session();
$database = new SyncDatabase();
$monList = array(_January,_February,_March,_April,_Mays,_June,_July,_August,_September,_October,_November,_December);
foreach($database->Select('object_type' ,0 ,0) as $type) {
	$listType[$type['type_id']] = array();
	$listSignup[$type['type_id']] = array();
	$listExpire[$type['type_id']] = array();
	foreach($database->Select('object_rental' ,array('type_id'=>$type['type_id']) ,0) as $object) {
		foreach($database->Select('contract' ,array('object_id'=>$object['object_id']) ,0) as $contract) {
			
			// signup_date
			if($contract['canceled']==0) {
				$date = getdate($contract['signup_date']);
				$found = false;
				foreach($listSignup[$type['type_id']] as $list) {
					if($list==$monList[$date['mon']-1].' '.($date['year']+543)) {
						$found = true;
					}
				}
				if(!$found) {
					$listSignup[$type['type_id']][$date['mon'].'-'.$date['year']] = $monList[$date['mon']-1].' '.($date['year']+543);
				}
			}
			
			
			// cancel_date		
			if($contract['canceled']==1) {
				$date = getdate($contract['cancel_date']);
				$found = false;
				foreach($listExpire[$type['type_id']] as $list) {
					if($list==$monList[$date['mon']-1].' '.($date['year']+543)) {
						$found = true;
					}
				}
				if(!$found) {
					$listExpire[$type['type_id']][$date['mon'].'-'.$date['year']] = $monList[$date['mon']-1].' '.($date['year']+543);
				}
			}
			
			
			// Warning
			foreach($database->Select('payment' ,array('contract_id'=>$contract['contract_id']) ,0) as $payment) {
				$date = getdate($payment['pay_date']);
				$found = false;
				foreach($listType[$type['type_id']] as $list) {
					if($list==$monList[$date['mon']-1].' '.($date['year']+543)) {
						$found = true;
					}
				}
				if(!$found) {
					$listType[$type['type_id']][$date['mon'].'-'.$date['year']] = $monList[$date['mon']-1].' '.($date['year']+543);
				}
			}
		}
	}
}

$fullMonth = array(_January,_February,_March,_April,_Mays,_June,_July,_August,_September,_October,_November,_December);
?>
<br /><div align="left"><h1><?php echo _HEAD_SELECT_REPORT; ?></h1></div>
<table align="left" width="100%" border="0" cellspacing="0" cellpadding="0" style="border-top:#999 dashed 1px;">
  <tr>
    <td align="center">
    <?php //foreach($database->Select('object_type' ,0 ,0) as $type) : ?>
<!--      <table align="left" width="100%" border="0" cellspacing="0" cellpadding="3" id="list-user">
        <tr class="list-select">
          <td><a href="?doc=report1_<?php //echo $type['type_id']; ?>" class="report"><?php //echo _REPORT4_HEAD1.$type['type_name']; ?></a></td>
        </tr>
      </table>
-->    <?php //endforeach; ?>
    <?php foreach($database->Select('object_type' ,0 ,0) as $type) : ?>
      <table align="left" width="100%" border="0" cellspacing="0" cellpadding="3" id="list-user">
        <tr>
          <td><strong><?php echo _REPORT1_HEAD1.$type['type_name']; ?></strong></td>
        </tr>
        <tr>
          <td>
          <select name="select1" id="month_r2-<?php echo $type['type_id']; ?>">
            <?php foreach($fullMonth as $key=>$month) : ?>
            <option value="<?php echo ($key+1); ?>"><?php echo $month; ?></option>
            <?php endforeach; ?>
          </select>
          <?php
          $getDate = getdate(time());   		  
		  ?>    
          <select name="select2" id="year_r2-<?php echo $type['type_id']; ?>">
            <?php for($yloop=0;$yloop<=50;$yloop++) : ?>
            <option <?php if($getDate['year']==(2000+$yloop)) { echo 'selected="selected"';} ?> value="<?php echo (2000+$yloop); ?>"><?php echo (2000+$yloop+543); ?></option>
            <?php endfor; ?>
          </select>
          <input type="button" value="<?php echo _REPORT_FIND; ?>" class="report" id="r2-<?php echo $type['type_id']; ?>" title="<?php echo _IMAGE_TAG_PRINT; ?>" />
		  <script>
          $(document).ready(function(){
			  $('#r2-<?php echo $type['type_id']; ?>').click(function(){
				  window.open('?doc=report2_<?php echo $type['type_id'].'-'; ?>' + $('#month_r2-<?php echo $type['type_id']; ?>').val() + '-' + $('#year_r2-<?php echo $type['type_id']; ?>').val(),'name','height=800,width=750');
			  });
          });
          </script>          
          </td>
        </tr>
      </table>
    <?php endforeach; ?><hr />
    <?php foreach($database->Select('object_type' ,0 ,0) as $type) : ?>
      <table align="left" width="100%" border="0" cellspacing="0" cellpadding="3" id="list-user">
        <tr>
          <td><strong><?php echo _REPORT2_HEAD1.$type['type_name']; ?></strong></td>
        </tr>
        <tr>
          <td>
          <select name="select1" id="month_r3-<?php echo $type['type_id']; ?>">
            <?php foreach($fullMonth as $key=>$month) : ?>
            <option value="<?php echo ($key+1); ?>"><?php echo $month; ?></option>
            <?php endforeach; ?>
          </select>
          <?php
          $getDate = getdate(time());   		  
		  ?>    
          <select name="select2" id="year_r3-<?php echo $type['type_id']; ?>">
            <?php for($yloop=0;$yloop<=50;$yloop++) : ?>
            <option <?php if($getDate['year']==(2000+$yloop)) { echo 'selected="selected"';} ?> value="<?php echo (2000+$yloop); ?>"><?php echo (2000+$yloop+543); ?></option>
            <?php endfor; ?>
          </select>
          <input type="button" value="<?php echo _REPORT_FIND; ?>" class="report" id="r3-<?php echo $type['type_id']; ?>" title="<?php echo _IMAGE_TAG_PRINT; ?>" />
		  <script>
          $(document).ready(function(){
			  $('#r3-<?php echo $type['type_id']; ?>').click(function(){
				  window.open('?doc=report3_<?php echo $type['type_id'].'-'; ?>' + $('#month_r3-<?php echo $type['type_id']; ?>').val() + '-' + $('#year_r3-<?php echo $type['type_id']; ?>').val(),'name','height=800,width=750');
			  });
          });
          </script>          
          </td>
        </tr>
      </table>
    <?php endforeach; ?><hr />
    <?php foreach($database->Select('object_type' ,0 ,0) as $type) : ?>
      <table align="left" width="100%" border="0" cellspacing="0" cellpadding="3" id="list-user">
        <tr>
          <td><strong><?php echo _REPORT3_HEAD1.$type['type_name']._REPORT3_HEAD2; ?></strong></td>
        </tr>
        <tr>
          <td>
          <select name="select1" id="month_r4-<?php echo $type['type_id']; ?>">
            <?php foreach($fullMonth as $key=>$month) : ?>
            <option value="<?php echo ($key+1); ?>"><?php echo $month; ?></option>
            <?php endforeach; ?>
          </select>
          <?php
          $getDate = getdate(time());   		  
		  ?>    
          <select name="select2" id="year_r4-<?php echo $type['type_id']; ?>">
            <?php for($yloop=0;$yloop<=50;$yloop++) : ?>
            <option <?php if($getDate['year']==(2000+$yloop)) { echo 'selected="selected"';} ?> value="<?php echo (2000+$yloop); ?>"><?php echo (2000+$yloop+543); ?></option>
            <?php endfor; ?>
          </select>
          <input type="button" value="<?php echo _REPORT_FIND; ?>" class="report" id="r4-<?php echo $type['type_id']; ?>" title="<?php echo _IMAGE_TAG_PRINT; ?>" />
		  <script>
          $(document).ready(function(){
			  $('#r4-<?php echo $type['type_id']; ?>').click(function(){
				  window.open('?doc=report4_<?php echo $type['type_id'].'-'; ?>' + $('#month_r4-<?php echo $type['type_id']; ?>').val() + '-' + $('#year_r4-<?php echo $type['type_id']; ?>').val(),'name','height=800,width=750');
			  });
          });
          </script>          
          </td>
        </tr>
      </table>
    <?php endforeach; ?><hr />
    </td>
  </tr>
</table>
<?php
foreach($database->Select('object_type' ,0 ,0) as $type) {
	
	//	contract_id	cus_id	emp_id	object_id	cost	deposite	canceled	signup_date	cancel_date	expire_date
	$tableConteact = '<table align="left" width="100%" border="0" cellspacing="0" cellpadding="3" id="list-user"><tr>';
	$tableConteact .= '<td style="border-bottom:#333 solid 2px;"><strong>'._REGISTER_USERID.'</strong></td>';
	$tableConteact .= '<td style="border-bottom:#333 solid 2px;"><strong>'._REGISTER_FULLNAME.'</strong></td>';
	$tableConteact .= '<td style="border-bottom:#333 solid 2px;" align="center"><strong>'._INVOICE_CONTRACT_NUMBER.'</strong></td>';
	$tableConteact .= '<td style="border-bottom:#333 solid 2px;" align="center"><strong>'._CONTRACT_PRINT_OBJECT.$type['type_name'].'</strong></td>';
	$tableConteact .= '<td style="border-bottom:#333 solid 2px;"><strong>'._CONTRACT_SINGUP.'</strong></td>';
	$tableConteact .= '<td style="border-bottom:#333 solid 2px;"><strong>'._CONTRACT_EXPIRE.'</strong></td>';
	$tableConteact .= '</tr>';
	$number = 0;
	foreach($database->Select('object_rental', array('type_id'=>$type['type_id']), 0) as $object) {
		foreach($database->Select('contract', array('object_id'=>$object['object_id']), 0) as $contract) {
			$number++;
			$customer = $database->Value('customer', array('cus_id'=>$contract['cus_id']), 0);
			$idObject = $contract['object_id'];
			while(strlen($idObject)<3) { $idObject = '0'.$idObject; }
			$tableConteact .= '<tr><td>'.$number.'</td><td>'.$customer['fullname'].'</td>';
			$tableConteact .= '<td align="center">'.$contract['cus_id'].$contract['object_id'].$contract['emp_id'].'-'.$contract['contract_id'].'</td>';
			$tableConteact .= '<td align="center">'.$type['type_id'].$idObject.'</td>';
			$tableConteact .= '<td>'.ThaiDate::Mid($contract['signup_date']).'</td>';
			$tableConteact .= '<td>'.ThaiDate::Mid($contract['expire_date']).'</td>';
			$tableConteact .= '</tr>';
		}
	}
	$tableConteact .= '</table>';
	$data = array(
			'head'=>_CONTRACT_PRINT_HEAD,
			'date'=>_REPORT4_DATE.ThaiDate::Full(time()),
			'report_type'=>_REPORT4_HEAD1.$type['type_name'],
			'text'=>$tableConteact,
			'personal'=>_REPORT_SIGN,			
		);
		
	$printButton = '<div style="position:fixed;top:10px;right:10px;"><input type="button" name="print" value="Print" onClick="javascript:window.print()">
					<input type="button" name="close" value="Close" onClick="javascript:window.close()"></div>';		
	
	$content = site::Content('report1',$data);
	$targetDirectory = "document/";
	$fileName = 'report1_'.$type['type_id'].'.html';
	$isFile = fopen($targetDirectory.$fileName, 'w');
	
	fputs($isFile, $printButton);
	fputs($isFile, $content);
	fclose($isFile);
	
	//Report 2
	$number = 0;
	foreach($listSignup[$type['type_id']] as $key=>$date) {
		$tableConteact = '<table align="left" width="100%" border="0" cellspacing="0" cellpadding="3" id="list-user"><tr>';
		$tableConteact .= '<td style="border-bottom:#333 solid 2px;"><strong>'._REGISTER_USERID.'</strong></td>';
		$tableConteact .= '<td style="border-bottom:#333 solid 2px;"><strong>'._REGISTER_FULLNAME.'</strong></td>';
		$tableConteact .= '<td style="border-bottom:#333 solid 2px;" width="350"><strong>'._REGISTER_ADDRESS.'</strong></td>';
		$tableConteact .= '<td style="border-bottom:#333 solid 2px;"><strong>'._CONTRACT_PRINT_OBJECT.$type['type_name'].'</strong></td>';
		$tableConteact .= '<td style="border-bottom:#333 solid 2px;"><strong>'._PAYMENT_PAYRENT.'</strong></td>';
		$tableConteact .= '</tr>';
		foreach($database->Select('object_rental', array('type_id'=>$type['type_id']), 0) as $object) {
			foreach($database->Select('contract', array('object_id'=>$object['object_id']), 0) as $contract) {
				$selectDate = explode('-',$key);
				$getDate = getdate($contract['signup_date']);
				if($selectDate[0]==$getDate['mon'] && $selectDate[1]==$getDate['year'] && $contract['canceled']==0) {
					$number++;
					$customer = $database->Value('customer', array('cus_id'=>$contract['cus_id']), 0);
					$idObject = $contract['object_id'];
					while(strlen($idObject)<3) { $idObject = '0'.$idObject; }
					$tableConteact .= '<tr><td>'.$number.'</td><td>'.$customer['fullname'].'</td>';
					$tableConteact .= '<td>'.$customer['address'].'</td>';
					$tableConteact .= '<td align="center">'.$type['type_id'].$idObject.'</td>';
					$tableConteact .= '<td>'.number_format($type['rentalcost'],0).'</td>';
					$tableConteact .= '</tr>';
				}
			}
		}
		$tableConteact .= '</table>';
		$data = array(
				'head'=>_CONTRACT_PRINT_HEAD,
				'date'=>_REPORT4_DATE.ThaiDate::Full(time()),
				'report_type'=>_REPORT1_HEAD1.$type['type_name']._REPORT3_HEAD2.$date,
				'text'=>$tableConteact,
				'personal'=>_REPORT_SIGN,			
			);
		$content = site::Content('report1',$data);
		$targetDirectory = "document/";
		$fileName = 'report2_'.$object['type_id'].'-'.$key.'.html';
		$isFile = fopen($targetDirectory.$fileName, 'w');
		
		fputs($isFile, $printButton);
		fputs($isFile, $content);
		fclose($isFile);
	}
	
	
	//Report 3	
	foreach($listExpire[$type['type_id']] as $key=>$date) {
		
		$tableConteact = '<table align="left" width="100%" border="0" cellspacing="0" cellpadding="3" id="list-user"><tr>';
		$tableConteact .= '<td style="border-bottom:#333 solid 2px;"><strong>'._REGISTER_USERID.'</strong></td>';
		$tableConteact .= '<td style="border-bottom:#333 solid 2px;"><strong>'._REGISTER_FULLNAME.'</strong></td>';
		$tableConteact .= '<td style="border-bottom:#333 solid 2px;" align="center"><strong>'._INVOICE_CONTRACT_NUMBER.'</strong></td>';
		$tableConteact .= '<td style="border-bottom:#333 solid 2px;" align="center"><strong>'._CONTRACT_PRINT_OBJECT.$type['type_name'].'</strong></td>';
		$tableConteact .= '<td style="border-bottom:#333 solid 2px;"><strong>'._CONTRACT_SINGUP.'</strong></td>';
		$tableConteact .= '<td style="border-bottom:#333 solid 2px;"><strong>'._CONTRACT_EXPIRE.'</strong></td>';
		$tableConteact .= '</tr>';
		$number = 0;
		foreach($database->Select('object_rental', array('type_id'=>$type['type_id']), 0) as $object) {			
			foreach($database->Select('contract', array('object_id'=>$object['object_id']), 0) as $contract) {
				$selectDate = explode('-',$key);
				$getDate = getdate($contract['cancel_date']);				
				if($selectDate[0]==$getDate['mon'] && $selectDate[1]==$getDate['year'] && $contract['canceled']==1) {	
					$number++;				
					$customer = $database->Value('customer', array('cus_id'=>$contract['cus_id']), 0);
					$idObject = $contract['object_id'];
					while(strlen($idObject)<3) { $idObject = '0'.$idObject; }					
					$tableConteact .= '<tr><td>'.$number.'</td><td>'.$customer['fullname'].'</td>';
					$tableConteact .= '<td align="center">'.$contract['cus_id'].$contract['object_id'].$contract['emp_id'].'-'.$contract['contract_id'].'</td>';
					$tableConteact .= '<td align="center">'.$type['type_id'].$idObject.'</td>';
					$tableConteact .= '<td>'.ThaiDate::Mid($contract['signup_date']).'</td>';
					$tableConteact .= '<td>'.ThaiDate::Mid($contract['expire_date']).'</td>';
					$tableConteact .= '</tr>';
				}
			}
		}
		$tableConteact .= '</table>';
		$data = array(
				'head'=>_CONTRACT_PRINT_HEAD,
				'date'=>_REPORT4_DATE.ThaiDate::Full(time()),
				'report_type'=>_REPORT1_HEAD1.$type['type_name']._REPORT3_HEAD2.$date,
				'text'=>$tableConteact,
				'personal'=>_REPORT_SIGN,			
			);
		$content = site::Content('report1',$data);
		$targetDirectory = "document/";
		$fileName = 'report3_'.$type['type_id'].'-'.$key.'.html';
		$isFile = fopen($targetDirectory.$fileName, 'w');
		
		fputs($isFile, $printButton);
		fputs($isFile, $content);
		fclose($isFile);
	
	}
	
	// Report 4
	
	foreach($listType[$type['type_id']] as $key=>$date) {
		$number++;
		$tableConteact = '<table align="center" width="50%" border="0" cellspacing="0" cellpadding="3" id="list-user"><tr>';
		$tableConteact .= '<td width="30" style="border-bottom:#333 solid 2px;"><strong>'._REGISTER_USERID.'</strong></td>';
		$tableConteact .= '<td style="border-bottom:#333 solid 2px;"><strong>'._REPORT3_HEAD3.'</strong></td>';
		$tableConteact .= '<td style="border-bottom:#333 solid 2px;" width="80"><strong>'._REPORT3_HEAD4.'</strong></td>';
		$tableConteact .= '</tr>';
		$totalMoney = 0;
		$number = 0;
		foreach($database->Select('payment', 0, 0) as $payment) {
			$selectDate = explode('-',$key);
			$getDate = getdate($payment['pay_date']);
			if($selectDate[0]==$getDate['mon'] && $selectDate[1]==$getDate['year']) {
				$number ++;
				if($payment['amount']==1000 || $payment['amount']==2000) {
					$money = _PAYMENT_PAYRENT;
				} else if($payment['amount']==3000 || $payment['amount']==6000) {
					$money = _PAYMENT_DEPOSITE;
				}
				$totalMoney += $payment['amount'];
				$tableConteact .= '<tr><td>'.$number.'</td><td>'.$money.'</td>';
				$tableConteact .= '<td>'.number_format($payment['amount'],0).'</td>';
				$tableConteact .= '</tr>';
			}
		}
		$tableConteact .= '<tr><td align="right" style="border-top:#333 solid 2px;">&nbsp;</td><td align="right" style="border-top:#333 solid 2px;">'._PAYMENT_TOTAL.'</td>';
		$tableConteact .= '<td style="border-top:#333 solid 2px;">'.number_format($totalMoney,0)._CONTRACT_PRINT_BAHT.'</td>';
		$tableConteact .= '</tr>';
		$UnitMoney = array('',_MONEY_1,_MONEY_2,_MONEY_3,_MONEY_4,_MONEY_5,_MONEY_6,'',_MONEY_7);
		$ThaiMoney = array(_MONEY_ONE,_MONEY_TWO,_MONEY_TREE,_MONEY_FOUR,_MONEY_FIVE,_MONEY_SIX,_MONEY_SEVEN,_MONEY_EIGHT,_MONEY_NINE);
		$lenMoney = strlen($totalMoney);
		$stringMoney = NULL;
		for($iloop=0;$iloop<$lenMoney;$iloop++)
		{
			$tmp = substr(strrev($totalMoney), $iloop, 1);
			if($tmp!=0) {
				if($iloop==0) {
					$stringMoney = $ThaiMoney[$tmp-1].''.$stringMoney;
				} elseif($iloop==1) {
					$stringMoney = $UnitMoney[8].$UnitMoney[$iloop].$stringMoney;
				} else {
					$stringMoney = $ThaiMoney[$tmp-1].$UnitMoney[$iloop].$stringMoney;
				}
			}
		}
		
		$tableConteact .= '<tr><td align="right" colspan="2">'.$stringMoney._CONTRACT_PRINT_BAHT.'</td>';
		$tableConteact .= '</tr>';
		$tableConteact .= '</table>';
		$data = array(
				'head'=>_CONTRACT_PRINT_HEAD,
				'date'=>_REPORT4_DATE.ThaiDate::Full(time()),
				'report_type'=>_REPORT3_HEAD1.$type['type_name']._REPORT3_HEAD2.$date,
				'text'=>$tableConteact,
				'personal'=>_REPORT_SIGN,			
			);
		$content = site::Content('report1',$data);
		$targetDirectory = "document/";
		$fileName = 'report4_'.$type['type_id'].'-'.$key.'.html';
		$isFile = fopen($targetDirectory.$fileName, 'w');
		
		fputs($isFile, $printButton);
		fputs($isFile, $content);
		fclose($isFile);
	}
	
}
?>