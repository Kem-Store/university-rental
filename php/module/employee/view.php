<div align="right" id="event_main" style="display:none;">
<input type="button" id="action_add" class="button" value=" " title="<?php echo _IMAGE_TAG_ADD; ?>" />
<input type="button" id="action_remove" class="button" value=" " title="<?php echo _IMAGE_TAG_REMOVE; ?>" />
</div>
<div align="right" id="event_del" style="display:none;">
<input type="button" id="action_del" class="button" value=" " title="<?php echo _IMAGE_TAG_DEL; ?>" disabled="disabled" />
<input type="button" id="action_back" class="button" value=" " title="<?php echo _IMAGE_TAG_BACK; ?>" />
</div>
<br /><div align="left"><h1><?php echo _HEAD_LIST_EMPLOYEE; ?></h1></div>
<table align="left" width="100%" border="0" cellspacing="0" cellpadding="0" style="border-top:#999 dashed 1px;">
  <tr>
    <td align="center"><div>&nbsp;</div>
      <table align="left" width="100%" border="0" cellspacing="0" cellpadding="3" id="list-user">
        <tr style="background-color:#666;color:#FFF;">
          <td width="35" align="center"id="head-text"><strong><?php echo _REGISTER_USERID; ?></strong></td>
          <td width="5" align="center">&nbsp;</td>
          <td width="90" align="left"><strong><?php echo _REGISTER_USERNAME; ?></strong></td>
          <td width="120" align="left"><strong><?php echo _REGISTER_FULLNAME; ?></strong></td>
          <td width="350" align="left"><strong><?php echo _REGISTER_ADDRESS; ?></strong></td>
          <td width="85" align="left"><strong><?php echo _REGISTER_TELEPHONE; ?></strong></td>
          <td width="20" align="center">&nbsp;</td>
        </tr>
      </table>
      <?php
      $database = new SyncDatabase();
	  $colorRow = 1;
      foreach($database->Select('employee',0,0) as $user)
      {
		  if($colorRow%2==0) { $style = 'style="background-color:#F7F7F7"'; } else { $style = ''; }
		  echo '<a href="?employee=edit&username='.$user['username'].'">';
          echo '<table align="left" width="100%" border="0" cellspacing="0" cellpadding="3" id="user_'.$user['emp_id'].'" '.$style.'>';
		  echo '<tr style="height:30px" class="list-select">';
          echo '<td align="center"><div style="width:35px;" id="img_'.$user['emp_id'].'">'.$colorRow.'</div></td>';
		  echo '<td align="center"><div style="width:5px;" id="id'.$user['emp_id'].'"></div></td>';
          echo '<td align="left"><div style="width:90px;">'.$user['username'].'</div></td>';
          echo '<td align="left"><div style="width:120px;"><strong>'.$user['emp_name'].'</strong></div></td>';
          echo '<td align="left"><div style="width:350px;word-wrap:break-word;">'.$user['address'].'</div></td>';
          echo '<td align="left"><div style="width:85px;">'.$user['telephone'].'</div></td>';
          echo '<td align="center"><div style="width:20px;">';
		  if($user['picture']!='user_none.jpg') {
			  echo '<img src="images/thumbnail_large.gif" width="14" height="14" border="0" align="absmiddle" />';
		  }
		  echo '</div></td></tr></table></a>';
		  $colorRow++;
      }
	  if($database->Count('employee',0,0)==0) {
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
	$('#action_add').click(function(){
		$(this).href('employee=add');				
	});
	var emp_id = [<?php foreach($database->Select('employee',0,0) as $user) { echo '"'.$user['emp_id'].'",'; } ?>];
	var checkboxValue = [];

	$('#action_remove').click(function(){
		$('#event_main').hide(0);
		$('#event_del').show(0);
		$('#head-text').html('<strong style="margin:0 2px 0 2px;"><?php echo _REGISTER_SELECT; ?></strong>');
		jQuery.each(emp_id, function() {
			var admin = '';
			if(this==1) { admin = ' '; }
			$('#user_' + this + ' tr').removeClass('list-select');
			$('#id' + this).html('<input type="checkbox" name="emp_id[]" id="selected_emp"'+admin+' value="' + this + '" />');
			$('#img_' + this).html('<img src="images/unselect.gif" width="16" height="16" border="0" />');			
		});	
		$('#id1').html('<input type="checkbox" name="emp_id1" id="selected_emp" disabled="disabled" value="0" />');
		$('#img_1').html('<img src="images/unselect_dis.gif" width="16" height="16" border="0" />');			
	});
	
	$('#action_del').click(function(){
		if(checkboxValue) {
			$.ajax({ url: 'index.php?ajax=list_delete&table=employee',
				data: ({ list_id : checkboxValue }),
				error: function (data){
					$('#error_ajax').html('Error');
				},
				success: function (data){				
					$(this).href('employee=view');				
				},
			});
		} else {
			$(this).href('employee=view');				
		}		
	});
	
	$('#action_back').click(function(){
		$('#action_del').attr('disabled','disabled');
		$('#event_main').show(0);
		$('#event_del').hide(0);
		$('#head-text').html('<strong><?php echo _REGISTER_USERID; ?></strong>');
		var loop = 1;
		jQuery.each(emp_id, function() {
			$('#user_' + this + ' tr').addClass('list-select');
			$('#img_'+this).html(loop);
			$('#id'+this).html('');
			if(this%2==0) {
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
		jQuery.each(emp_id, function() {
			if(loop%2==0) {
				$('#user_'+this).css('background-color','#F7F7F7');
			} else {
				$('#user_'+this).css('background-color','#FFFFFF');
			}
			$('#img_'+this).html('<img src="images/unselect.gif" width="16" height="16" border="0" />');	
			loop++;
		});
		$('#img_1').html('<img src="images/unselect_dis.gif" width="16" height="16" border="0" />');	
				
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
