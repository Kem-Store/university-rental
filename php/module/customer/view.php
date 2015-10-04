<div align="right" id="event_main" style="display:none;">
<input type="button" id="action_regis" class="button" value=" " title="<?php echo _IMAGE_TAG_REGIS; ?>" />
<input type="button" id="action_remove" class="button" value=" " title="<?php echo _IMAGE_TAG_REMOVE; ?>" />
</div>
<div align="right" id="event_del" style="display:none;">
<input type="button" id="action_del" class="button" value=" " title="<?php echo _IMAGE_TAG_DEL; ?>" disabled="disabled" />
<input type="button" id="action_back" class="button" value=" " title="<?php echo _IMAGE_TAG_BACK; ?>" />
</div>
<br /><div align="left"><h1><?php echo _HEAD_LIST_CUSTOMER; ?></h1></div>
<table align="left" width="100%" border="0" cellspacing="0" cellpadding="0" style="border-top:#999 dashed 1px;">
  <tr>
    <td align="center"><div>&nbsp;</div>
      <table align="left" width="100%" border="0" cellspacing="0" cellpadding="3" id="list-user">
        <tr style="background-color:#666;color:#FFF;">
          <td width="35" align="center" id="head-text"><strong><?php echo _REGISTER_USERID; ?></strong></td>
          <td width="5" align="center">&nbsp;</td>
          <td width="120" align="left"><strong><?php echo _REGISTER_FULLNAME; ?></strong></td>
          <td width="140" align="left"><strong><?php echo _REGISTER_IDCARD; ?></strong></td>
          <td width="340" align="left"><strong><?php echo _REGISTER_ADDRESS; ?></strong></td>
          <td width="85" align="right"><strong><?php echo _REGISTER_TELEPHONE; ?></strong></td>
        </tr>
      </table>
      <?php
      $database = new SyncDatabase();
	  $colorRow = 1;
      foreach($database->Select('customer',0,0) as $customer)
      {
		  if($colorRow%2==0) { $style = 'style="background-color:#F7F7F7;"'; } else { $style = ''; }
		  echo '<a href="?customer=edit&id='.$customer['cus_id'].'">';
		  echo '<table align="left" width="100%" border="0" cellspacing="0" cellpadding="3" class="list-space" id="user_'.$customer['cus_id'].'" '.$style.'>';
          echo '<tr style="height:30px" class="list-select">';
          echo '<td align="center"><div style="width:35px;" id="img_'.$customer['cus_id'].'">'.$colorRow.'</div></td>';
		  echo '<td align="center"><div style="width:5px;" id="id'.$customer['cus_id'].'"></div></td>';
          echo '<td align="left"><div style="width:120px;word-wrap:break-word;"><strong>'.$customer['fullname'].'</strong></div></td>';
          echo '<td align="left"><div style="width:140px;">'.$customer['idcard'].'</div></td>';
          echo '<td align="left"><div style="width:345px;word-wrap:break-word;">'.$customer['address'].'</div></td>';
          echo '<td align="right"><div style="width:85px;">'.$customer['telephone'].'</div></td>';
		  echo '</tr></table></a>';
		  $colorRow++;
      }
	  if($database->Count('customer',0,0)==0) {
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
		$(this).href('customer=register');
	});
	var cus_id = [<?php foreach($database->Select('customer',0,0) as $user) { echo '"'.$user['cus_id'].'",'; } ?>];
	var checkboxValue = [];
	if(cus_id.length==0) { $('#action_remove').attr('disabled','disabled'); }
	$('#action_remove').click(function(){
		$('#event_main').hide(0);
		$('#event_del').show(0);
		$('#head-text').html('<strong style="margin:0 2px 0 2px;"><?php echo _REGISTER_SELECT; ?></strong>');
		jQuery.each(cus_id, function() {
			$('#user_' + this + ' tr').removeClass('list-select');
			$('#id' + this).html('<input type="checkbox" name="cus_id[]" id="selected_emp" value="'+this+'" />');
			$('#img_' + this).html('<img src="images/unselect.gif" width="16" height="16" border="0" />');			
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
					$(this).href('customer=view');				
				},
			});
		} else {
			$(this).href('customer=view');				
		}		
	});
	
	$('#action_back').click(function(){
		$('#action_del').attr('disabled','disabled');
		$('#event_main').show(0);
		$('#event_del').hide(0);
		$('#head-text').html('<strong><?php echo _REGISTER_USERID; ?></strong>');
		var loop = 1;
		jQuery.each(cus_id, function() {
			$('#img_'+this).html(loop);
			$('#id'+this).html('');
			$('#user_' + this + ' tr').addClass('list-select');
			if(loop%2==0){
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
		var loop = 1;
		jQuery.each(cus_id, function() {
			if(loop%2==0){
				$('#user_'+this).css('background-color','#F7F7F7');
			} else {
				$('#user_'+this).css('background-color','#FFFFFF');
			}
			$('#img_'+this).html('<img src="images/unselect.gif" width="16" height="16" border="0" />');
			loop++;	
		});
		
		jQuery.each(checkboxValue, function() {
			$('#user_'+this).css('background-color','#f6846c');
			$('#img_'+this).html('<img src="images/select.gif" width="16" height="16" border="0" />');	
		});
		if(checkboxValue!='') {
			$('#action_del').removeAttr('disabled','disabled');
		} else {
			$('#action_del').attr('disabled','disabled');
		}
    });	
	
});
</script>
