<?php 
$database = new SyncDatabase();
$object = $database->Value('object_rental', array('object_id'=>$_GET['id']),0);

if(isset($_GET['action']) && isset($_POST['register_edit'])): 

$editObject = array(
			'detail'	=> $_REQUEST['regis_detail'],
			'type_id'	=> $_REQUEST['regis_type'],
			);
$database->Update('object_rental', $editObject, array('object_id'=>$_GET['id']));
?>
<table width="100%" cellpadding="5" cellspacing="0" border="0">
    <tr>
      <td width="180" align="center" valign="top" style="border-right:#CCC dashed 1px;">
       <input type="button" name="register_success" id="register_success" value=" " title="<?php echo _IMAGE_TAG_SUBMIT; ?>"  />
      </td>
      <td align="left" valign="top">
       <h4><?php echo _REGISTER_OBJECT_EDIT; ?></h4>
        <table border="0" cellspacing="0" cellpadding="3">
          <tr>
            <td align="right" valign="top">&nbsp;</td>
            <td align="left" valign="top">&nbsp;</td>
          </tr>
          <tr>
            <td align="right" valign="top"><strong><?php echo _REGISTER_TYPE; ?>:</strong></td>
            <td align="left" valign="top"><?php $typeName = $database->Value('object_type', array('type_id'=>$_REQUEST['regis_type']),0); echo $typeName['type_name']; ?></td>
          </tr>
          <tr>
            <td width="150" align="right" valign="top"><strong><?php echo _REGISTER_STATUS; ?>:</strong></td>
            <td width="150" align="left" valign="top"><?php if($object['status_object']=='0'){ echo _OBJECT_RENT_BLANK; } else { echo _OBJECT_RENT_NOBLANK; } ?></td>
          </tr>
          <tr>
            <td align="right" valign="top"><strong><?php echo _REGISTER_DETAIL; ?>:</strong></td>
            <td align="left"><?php echo $_REQUEST['regis_detail']; ?></td>
          </tr>
          <tr>
            <td align="right" valign="top">&nbsp;</td>
            <td align="left" valign="top">&nbsp;</td>
          </tr>
        </table>
      </td>
    </tr>
  </table>
<script>
$(document).ready(function(){
	$('#register_success').click(function(){
		$(this).href('object=view');
	});
});
</script>
<?php else: ?>
<?php if($object!=NULL): ?>
<form action="?object=edit&id=<?php echo $_GET['id']; ?>&action=success" method="POST" name="employee_register" id="employee_register">
  <table width="100%" cellpadding="5" cellspacing="0" border="0">
    <tr>
      <td width="180" align="center" valign="top" style="border-right:#CCC dashed 1px;">
       <input type="submit" name="register_edit" id="register_edit" value="" title="<?php echo _IMAGE_TAG_EDIT; ?>"  />
       <input type="button" name="register_cancel" id="register_cancel" value="" title="<?php echo _IMAGE_TAG_CANCEL; ?>"  /></td>
      <td align="left" valign="top">
        <h4><?php echo _REGISTER_USER_DATA; ?><span class="vaild_info2" id="form_comment">&nbsp;</span></h4>
        <table border="0" cellspacing="0" cellpadding="3">
          <?php if($object['status_object']=='1'): ?>
          <tr>
            <td align="right"><?php echo _REGISTER_TYPE; ?></td>
            <td align="left" style="font-size:12px; font-weight:bold;">
			<?php $typeName = $database->Value('object_type', array('type_id'=>$object['type_id']),0); echo $typeName['type_name']; ?>
            <input type="hidden" name="regis_type" id="regis_type" value="<?php echo $object['type_id']; ?>" />
            </td>
          </tr>
          <?php else: ?>
          <tr>
            <td align="right"><?php echo _REGISTER_TYPE; ?></td>
            <td align="left">
            <select name="regis_type" id="regis_type">
              <?php foreach($database->Select('object_type', 0, 0) as $type): ?>
              <option value="<?php echo $type['type_id']; ?>"<?php if($object['type_id']==$type['type_id']){ echo ' selected="selected"'; } ?>><?php echo $type['type_name']; ?></option>
              <?php endforeach; ?>
            </select>
          </tr>
          <?php endif; ?>
          <tr>
            <td align="right"><?php echo _REGISTER_STATUS; ?></td>
            <td align="left">
            <label style="vertical-align:top"><input name="regis_status" disabled="disabled" type="radio" value="0" <?php if($object['status_object']=='0'){ echo 'checked="checked"'; } ?> />
            <?php echo _OBJECT_RENT_BLANK; ?></label>
            <label style="vertical-align:top"><input name="regis_status" disabled="disabled" type="radio" value="1" <?php if($object['status_object']=='1'){ echo 'checked="checked"'; } ?> />
			<?php echo _OBJECT_RENT_NOBLANK; ?></label>
            </td>
          </tr>
          <tr>	
            <td width="200" align="right"><?php echo _REGISTER_DETAIL; ?></td>
            <td align="left"><input name="regis_detail" type="text" id="regis_detail" size="30" maxlength="40" value="<?php echo $object['detail']; ?>" /></td>
            <td rowspan="4" align="left" valign="top"><span class="vaild_data" id="form_comment"><?php echo _REGISTER_DATA_COMMENT; ?></span></td>
          </tr>
        </table>
      </td>
    </tr>
  </table>
</form>
<script>
$(document).ready(function(){
	var regisData = true;
	
	$('#register_cancel').click(function(){
		$(this).href('object=view');
	});


	//--> Other Data Text	
	$('#regis_type, #regis_detail').focusin(function(){
		if(!regisData) {
			$('.vaild_info2').fadeIn('fast');
			$('.vaild_info2').html('<?php echo _REGISTER_DATA_COMMENT; ?>');
		}
	});
	$('#regis_type, #regis_detail').focusout(function(){ $('.vaild_info2').fadeOut(0); });	
	$('#regis_type, #regis_detail').keyup(function(){
		if($('#regis_type').val()!='' && $('#regis_detail').val()!='') {
			regisData = true;
			$('.vaild_info2').fadeOut('fast');
		} else {
			regisData = false;
			$('.vaild_info2').fadeIn('fast');
		}
		formApplyVailds();
	});
	$('#regis_type, #regis_detail').keydown(function(){
		if($('#regis_type').val()!='' && $('#regis_detail').val()!='') {
			regisData = true;
			$('.vaild_info2').fadeOut('fast');
		} else {
			regisData = false;
			$('.vaild_info2').fadeIn('fast');
		}
		formApplyVailds();
	});
	
	function formApplyVailds(){
		if(regisData) {
			$('#register_edit').removeAttr('disabled','disabled');
		} else {
			$('#register_edit').attr('disabled','disabled');
		}
	}
});
</script>
<?php else: ?>
	<div id="exception"><?php echo _SITE_NONE_MODULE;?></div>
<?php endif; ?>
<?php endif; ?>