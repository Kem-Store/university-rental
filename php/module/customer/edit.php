<?php 
$database = new SyncDatabase();
$customer = $database->Value('customer', array('cus_id'=>$_GET['id']),0);

if(isset($_GET['action']) && isset($_POST['register_edit'])): 

$editCustomer = array(
			'fullname'	=> $_REQUEST['regis_fullname'],
			'address'	=> $_REQUEST['regis_address'],
			'idcard'	=> $_REQUEST['regis_idcard'],
			'telephone'	=> $_REQUEST['regis_telephone'],
			'job'		=> $_REQUEST['regis_job'],
			);
$database->Update('customer', $editCustomer, array('cus_id'=>$_GET['id']));
?>
<table width="100%" cellpadding="5" cellspacing="0" border="0">
    <tr>
      <td width="180" align="center" valign="top" style="border-right:#CCC dashed 1px;">
       <input type="button" name="register_success" id="register_success" value=" " title="<?php echo _IMAGE_TAG_SUBMIT; ?>" />
      </td>
      <td align="left" valign="top">
       <h4><?php echo _REGISTER_CUSTOMER_EDIT; ?></h4>
        <table border="0" cellspacing="0" cellpadding="3">
          <tr>
            <td align="right" valign="top">&nbsp;</td>
            <td align="left" valign="top">&nbsp;</td>
          </tr>
          <tr>
            <td align="right" valign="top"><strong><?php echo _REGISTER_FULLNAME; ?>:</strong></td>
            <td align="left" valign="top"><?php echo $_REQUEST['regis_fullname']; ?></td>
          </tr>
          <tr>
            <td width="150" align="right" valign="top"><strong><?php echo _REGISTER_IDCARD; ?>:</strong></td>
            <td width="150" align="left" valign="top"><?php echo $_REQUEST['regis_idcard']; ?></td>
          </tr>
          <tr>
            <td align="right" valign="top"><strong><?php echo _REGISTER_ADDRESS; ?>:</strong></td>
            <td align="left"><div style="word-wrap:break-word; width:350px;"><?php echo $_REQUEST['regis_address']; ?></div></td>
          </tr>
          <tr>
            <td align="right" valign="top"><strong><?php echo _REGISTER_JOB; ?>:</strong></td>
            <td align="left" valign="top"><?php echo $_REQUEST['regis_job']; ?></td>
          </tr>
          <tr>
            <td align="right" valign="top"><strong><?php echo _REGISTER_TELEPHONE; ?>:</strong></td>
            <td align="left" valign="top"><?php echo $_REQUEST['regis_telephone']; ?></td>
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
	$('#register_edit').click(function(){
		$(this).href('customer=edit&idcard=<?php echo $_REQUEST['regis_idcard']; ?>');
	});
	
	$('#register_success').click(function(){
		$(this).href('customer=view');
	});
});
</script>
<?php else: ?>
<?php if($customer!=NULL): ?>
<form action="?customer=edit&id=<?php echo $_GET['id']; ?>&action=success" method="POST" name="employee_register" id="employee_register">
  <table width="100%" cellpadding="5" cellspacing="0" border="0">
    <tr>
      <td width="180" align="center" valign="top" style="border-right:#CCC dashed 1px;">
       <input type="submit" name="register_edit" id="register_edit" value="" title="<?php echo _IMAGE_TAG_EDIT; ?>" />
       <input type="button" name="register_cancel" id="register_cancel" value="" title="<?php echo _IMAGE_TAG_CANCEL; ?>" /></td>
      <td align="left" valign="top">
        <h4><?php echo _REGISTER_USER_DATA; ?><span class="vaild_info2" id="form_comment">&nbsp;</span></h4>
        <table border="0" cellspacing="0" cellpadding="3">
          <tr>
            <td width="200" align="right"><?php echo _REGISTER_FULLNAME; ?></td>
            <td align="left"><input name="regis_fullname" type="text" id="regis_fullname" size="30" maxlength="40" value="<?php echo $customer['fullname']; ?>" /></td>
            <td rowspan="4" align="left" valign="top"><span class="vaild_data" id="form_comment"><?php echo _REGISTER_DATA_COMMENT; ?></span></td>
          </tr>
          <tr>
            <td align="right"><?php echo _REGISTER_IDCARD; ?></td>
            <td align="left"><input name="regis_idcard" type="text" id="regis_idcard" size="20" maxlength="13" value="<?php echo $customer['idcard']; ?>" /></td>
          </tr>
          <tr>
            <td align="right"><?php echo _REGISTER_ADDRESS; ?></td>
            <td align="left"><textarea name="regis_address" cols="35" rows="5" id="regis_address"><?php echo $customer['address']; ?></textarea></td>
          </tr>
          <tr>
            <td align="right"><?php echo _REGISTER_JOB; ?></td>
            <td align="left"><input name="regis_job" type="text" id="regis_job" size="20" maxlength="10" value="<?php echo $customer['job']; ?>" /></td>
          </tr>
          <tr>
            <td align="right"><?php echo _REGISTER_TELEPHONE; ?></td>
            <td align="left"><input name="regis_telephone" type="text" id="regis_telephone" size="20" maxlength="10" value="<?php echo $customer['telephone']; ?>" /></td>
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
		$(this).href('customer=view');
	});
	
		
	
	//--> Other Data Text	
	$('#regis_fullname, #regis_idcard, #regis_address, #regis_job, #regis_telephone').focusin(function(){
		if(!regisData) {
			$('.vaild_info2').fadeIn('fast');
			$('.vaild_info2').html('<?php echo _REGISTER_DATA_COMMENT; ?>');
		}
	});
	$('#regis_fullname, #regis_idcard, #regis_address, #regis_job, #regis_telephone').focusout(function(){ $('.vaild_info2').fadeOut(0); });	
	$('#regis_fullname, #regis_idcard, #regis_address, #regis_job, #regis_telephone').keyup(function(){
		if($('#regis_fullname').val()!='' && $('#regis_idcard').val()!='' && $('#regis_address').val()!='' && $('#regis_telephone').val()!='') {
			regisData = true;
			$('.vaild_info2').fadeOut('fast');
		} else {
			regisData = false;
		}
		formApplyVailds();
	});
	$('#regis_fullname, #regis_idcard, #regis_address, #regis_job, #regis_telephone').keydown(function(){
		if($('#regis_fullname').val()!='' && $('#regis_idcard').val()!='' && $('#regis_address').val()!='' && $('#regis_telephone').val()!='') {
			regisData = true;
			$('.vaild_info2').fadeOut('fast');
		} else {
			regisData = false;
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