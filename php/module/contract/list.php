<?php
$control = new Session();
$database = new SyncDatabase();
$money = ini::SettingArray('default.ini');
$_SERVER['REQUEST_TIME'];
$control->Value('USER_RENTAL');
$idContract = date('y', $_SERVER['REQUEST_TIME']);
?>
<div align="right" id="event_main">
<input type="button" id="action_regis" class="button" title="<?php echo _IMAGE_TAG_REGIS; ?>" value=" " />
</div>
<br /><div align="left"><h1><?php echo _HEAD_LIST_CONTRACT; ?></h1></div>
<table align="left" width="100%" border="0" cellspacing="0" cellpadding="0" style="border-top:#999 dashed 1px;">
  <tr>
    <td align="center"><div>&nbsp;</div>
      <table align="left" width="100%" border="0" cellspacing="0" cellpadding="3" id="list-user">
        <tr style="background-color:#666;color:#FFF;">
          <td width="100" align="center" id="head-text"><strong><?php echo _CONTRACT_NUMBER; ?></strong></td>
          <td width="140" align="center"><strong><?php echo _CONTRACT_FULLNAME; ?></strong></td>
          <td width="50" align="center"><strong><?php echo _CONTRACT_TYPE; ?></strong></td>
          <td width="80" align="right"><strong><?php echo _CONTRACT_COST; ?></strong></td>
          <td width="80" align="right"><strong><?php echo _CONTRACT_CHARGE; ?></strong></td>
          <td width="120" align="center"><strong><?php echo _CONTRACT_SINGUP; ?></strong></td>
          <td width="120" align="center"><strong><?php echo _CONTRACT_EXPIRE; ?></strong></td>
          <td width="32" align="center">&nbsp;</td>
        </tr>
      </table>
      <?php
	  $colorRow = 1;
      foreach($database->Select('contract',0,0) as $contract)
      {
		  $idContract = $contract['cus_id'].$contract['object_id'].$contract['emp_id'].'-'.$contract['contract_id'];
		  $customer = $database->Value('customer', array('cus_id'=>$contract['cus_id']), 0);
		  $object = $database->Value('object_rental', array('object_id'=>$contract['object_id']), 0);
		  $objectType = $database->Value('object_type', array('type_id'=>$object['type_id']), 0);
		  $costCharge = 0;
		  foreach($database->Select('payment', array('contract_id'=>$contract['contract_id'], 'paid'=>0), 0) as $cost) {
			  $costCharge += $cost['amount']+$cost['charge'];
		  }
		  if($colorRow%2==0) { $style = 'style="background-color:#F7F7F7;"'; } else { $style = ''; }
		  echo '<a href="?contract=edit&id='.$contract['contract_id'].'">';
		  echo '<table align="right" width="100%" border="0" cellspacing="0" cellpadding="3" id="list-user" '.$style.'>';
          echo '<tr style="height:30px" class="list-select">';
          echo '<td align="right"><div style="width:100px;"><strong>'.$idContract.'</strong></div></td>';
          echo '<td align="center"><div style="width:140px;">'.$customer['fullname'].'</div></td>';
          echo '<td align="center"><div style="width:50px;">'.$objectType['type_name'].'</div></td>';
          echo '<td align="right"><div style="width:80px;">'.number_format($contract['cost'], 2).'</div></td>';
          echo '<td align="right"><div style="width:80px;">'.number_format($costCharge, 2).'</div></td>';
          echo '<td align="right"><div style="width:120px;">'.ThaiDate::Mid($contract['signup_date']).'</div></td>';
          echo '<td align="right"><div style="width:120px;">'.ThaiDate::Mid($contract['expire_date']).'</div></td>';
          echo '<td align="center"><div style="width:20px;"><a href="?object=view&id='.$contract['object_id'].'">';
		  if($contract['canceled']!=1) {
		  	echo '<img src="images/thumbnail_large.gif" width="14" height="14" border="0" align="absmiddle" />';
		  }
		  echo '</a></div></td></tr></table></a>';
		  $colorRow++;
      }
	  if($database->Count('contract',0,0)==0) {
          echo '<table align="right" width="100%" border="0" cellspacing="0" cellpadding="3" id="list-user"><tr style="height:30px"><td align="center" align="center" colspan="8">';
          echo '<strong>'._REGISTER_NONE.'</strong>';
		  echo '</td></tr></table>';
	  }
      ?>
    </td>
  </tr>
</table>
<script>
$(document).ready(function(){
	$('#event_main').show(0);
	$('#action_regis').click(function(){
		$(this).href('contract=register');
	});
	var cus_id = [<?php foreach($database->Select('customer',0,0) as $user) { echo '"'.$user['cus_id'].'",'; } ?>];
	var checkboxValue = [];
	if(cus_id.length==0) { $('#action_remove').attr('disabled','disabled'); }
	$('#action_remove').click(function(){
		$('#event_main').hide(0);
		$('#event_del').show(0);
		$('#head-text').html('<strong style="margin:0 2px 0 2px;"><?php echo _REGISTER_SELECT; ?></strong>');
		jQuery.each(cus_id, function() {
			$('#id' + this).html('<input type="checkbox" name="cus_id[]" id="selected_emp" value="'+this+'" />');
			$('#img_' + this).html('<img src="/images/unselect.gif" width="16" height="16" border="0" />');			
		});
	});
	
	$('#action_del').click(function(){
		if(checkboxValue) {
			$.ajax({ url: 'index.php?ajax=list_delete&table=customer',
				data: ({ list_id : checkboxValue }),
				error: function (data){
					$('#error_ajax').html('Error');
				},
				success: function (data){				
					window.location = "http://<?php echo $_SERVER['SERVER_NAME']; ?>?customer=view";
				},
			});
		} else {
			window.location = "http://<?php echo $_SERVER['SERVER_NAME']; ?>?customer=view";
		}		
	});
	
	$('#action_back').click(function(){
		$('#action_del').attr('disabled','disabled');
		$('#event_main').show(0);
		$('#event_del').hide(0);
		$('#head-text').html('<strong><?php echo _REGISTER_USERID; ?></strong>');
		var loop = 0;
		jQuery.each(cus_id, function() {
			$('#img_'+this).html(loop+1);
			$('#id'+this).html('');
			if((loop+1)%2==0){
				$('#user_'+this).css('background-color','#F7F7F7');
			} else {
				$('#user_'+this).css('background-color','#FFFFFF');
			}
			loop++;
		});
	});
	// #empid
	$("#selected_emp").live('change', function() {
		checkboxValue = $("#selected_emp:checked").multiVal();
		jQuery.each(cus_id, function() {
			if(this%2==0){
				$('#user_'+this).css('background-color','#F7F7F7');
			} else {
				$('#user_'+this).css('background-color','#FFFFFF');
			}
			$('#img_'+this).html('<img src="/images/unselect.gif" width="16" height="16" border="0" />');	
		});
		
		jQuery.each(checkboxValue, function() {
			$('#user_'+this).css('background-color','#f6846c');
			$('#img_'+this).html('<img src="/images/select.gif" width="16" height="16" border="0" />');	
		});
		if(checkboxValue!='') {
			$('#action_del').removeAttr('disabled','disabled');
		} else {
			$('#action_del').attr('disabled','disabled');
		}
    });	
	
});
</script>
