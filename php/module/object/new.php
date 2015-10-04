<?php 
$database = new SyncDatabase();
if(isset($_GET['action']) && isset($_POST['register_apply'])): 
$newObject = array(
			'detail'	=> $_REQUEST['regis_detail'],
			'type_id'	=> $_REQUEST['regis_type'],
			);
$database->Insert('object_rental', $newObject);
?>
<table width="100%" cellpadding="5" cellspacing="0" border="0">
    <tr>
      <td width="180" align="center" valign="top" style="border-right:#CCC dashed 1px;">
       <input type="button" name="register_success" id="register_success" value=" " title="<?php echo _IMAGE_TAG_SUBMIT; ?>" />
      </td>
      <td align="left" valign="top">
       <h4><?php echo _REGISTER_OBJECT_ADD; ?></h4>
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
            <td width="150" align="left" valign="top"><?php echo _OBJECT_RENT_BLANK; ?></td>
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
<form action="?object=new&action=success" method="POST" name="employee_register" id="employee_register">
  <table width="100%" cellpadding="5" cellspacing="0" border="0">
    <tr>
      <td width="180" align="center" valign="top" style="border-right:#CCC dashed 1px;">
       <input type="submit" name="register_apply" id="register_apply" value="" title="<?php echo _IMAGE_TAG_SAVE; ?>" disabled="disabled" />
       <input type="reset" name="register_reset" id="register_reset" value="" title="<?php echo _IMAGE_TAG_BACK; ?>" /></td>
      <td align="left" valign="top">
        <h4><?php echo _REGISTER_USER_DATA; ?><span class="vaild_info2" id="form_comment">&nbsp;</span></h4>
        <table border="0" cellspacing="0" cellpadding="3">
          <tr>
            <td align="right"><?php echo _REGISTER_TYPE; ?></td>
            <td align="left">
            <select name="regis_type" id="regis_type">
              <?php foreach($database->Select('object_type', 0, 0) as $type): ?>
              <option value="<?php echo $type['type_id']; ?>"><?php echo $type['type_name']; ?></option>
              <?php endforeach; ?>
            </select>
          </tr>
          <tr>	
            <td width="150" align="right"><?php echo _REGISTER_DETAIL; ?></td>
            <td align="left"><input name="regis_detail" type="text" id="regis_detail" size="30" maxlength="40" value="" />
            <span class="vaild_data" id="form_comment">&nbsp;</span>
            </td>
            <td rowspan="4" align="left" valign="top">&nbsp;</td>
          </tr>
        </table>
      </td>
    </tr>
  </table>
</form>
<script>
$(document).ready(function(){
	var regisData = false;
	
	$('#register_reset').click(function(){
		$(this).href('object=view');
	});
	
	
	//--> FullName Text
	$('#regis_detail').bind({
		focusin: function() {
			if(!regisData) {
				$('.vaild_data').fadeIn(0);
				$('.vaild_data').css('color','#900');
				$('.vaild_data').html('<img src="images/fail.gif" width="16" height="16" border="0" align="absmiddle" /> <?php echo _REGISTER_DETAIL_COMMENT; ?>');
			}
		},
		keyup: function() {
			if($(this).val()!='') {
				regisData = true;
				$('.vaild_data').css('color','#090');
				$('.vaild_data').html('<img src="images/done.gif" width="16" height="16" border="0" align="absmiddle" /> <?php echo _REGISTER_DETAIL_PASSED; ?>');
			} else {
				regisData = false;
				$('.vaild_data').css('color','#900');
				$('.vaild_data').html('<img src="images/fail.gif" width="16" height="16" border="0" align="absmiddle" /> <?php echo _REGISTER_DETAIL_COMMENT; ?>');
			}
			formApplyVailds();
		},
		keydown: function() {
			if($(this).val()!='') {
				regisData = true;
				$('.vaild_data').html('<img src="images/done.gif" width="16" height="16" border="0" align="absmiddle" /> <?php echo _REGISTER_DETAIL_PASSED; ?>');
			} else {
				regisData = false;
				$('.vaild_data').html('<img src="images/fail.gif" width="16" height="16" border="0" align="absmiddle" /> <?php echo _REGISTER_DETAIL_COMMENT; ?>');
			}
			formApplyVailds();
		},
	});	




	function formApplyVailds(){
		if(regisData) {
			$('#register_apply').removeAttr('disabled','disabled');
		} else {
			$('#register_apply').attr('disabled','disabled');
		}
	}
});
</script>
<?php endif; ?>