<?php if(isset($_GET['action']) && isset($_POST['register_apply'])): ?>
<?php
$database = new SyncDatabase();
if(!$database->Select('customer',array('idcard'=>$_REQUEST['regis_idcard']),0)) {
	$newCustomer = array(
				'regis_date'=> $_SERVER['REQUEST_TIME'],
				'fullname'	=> $_REQUEST['regis_fullname'],
				'address'	=> $_REQUEST['regis_address'],
				'idcard'	=> $_REQUEST['regis_idcard'],
				'telephone'	=> $_REQUEST['regis_telephone'],
				'job'		=> $_REQUEST['regis_job'],
				);
	$database->Insert('customer', $newCustomer);
}
?>
<table width="100%" cellpadding="5" cellspacing="0" border="0">
    <tr>
      <td width="180" align="center" valign="top" style="border-right:#CCC dashed 1px;">
       <input type="button" name="register_edit" id="register_edit" value=" " title="<?php echo _IMAGE_TAG_EDIT; ?>"  />
       <input type="button" name="register_success" id="register_success" value=" " title="<?php echo _IMAGE_TAG_SUBMIT; ?>" />
      </td>
      <td align="left" valign="top">
       <h4><?php echo _REGISTER_CUSTOMER_ADD; ?></h4>
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
            <td width="100" align="right" valign="top"><strong><?php echo _REGISTER_IDCARD; ?>:</strong></td>
            <td width="150" align="left" valign="top"><?php echo $_REQUEST['regis_idcard']; ?></td>
          </tr>
          <tr>
            <td align="right" valign="top"><strong><?php echo _REGISTER_ADDRESS; ?>:</strong></td>
            <td align="left"><?php echo $_REQUEST['regis_address']; ?></td>
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
 <?php
 $idNewCustomer = $database->Value('customer',array('idcard'=>$_REQUEST['regis_idcard']),0);
 ?>
<script>
$(document).ready(function(){
	$('#register_edit').click(function(){
		$(this).href('customer=edit&id=<?php echo $idNewCustomer['cus_id']; ?>');
	});
	
	$('#register_success').click(function(){
		$(this).href('customer=view');
	});
});
</script>
<?php else: ?>
<form action="?customer=register&action=success" method="POST" name="employee_register" id="employee_register">
  <table width="100%" cellpadding="5" cellspacing="0" border="0">
    <tr>
      <td width="180" align="center" valign="top" style="border-right:#CCC dashed 1px;">
       <input type="submit" name="register_apply" id="register_apply" value="" title="<?php echo _IMAGE_TAG_SAVE; ?>" disabled="disabled" />
       <input type="reset" name="register_reset" id="register_reset" value="" title="<?php echo _IMAGE_TAG_BACK; ?>" /></td>
      <td align="left" valign="top">
        <h4><?php echo _REGISTER_USER_DATA; ?></h4>
        <input type="hidden" name="regis_picture" id="regis_picture" value="" />
        <table border="0" cellspacing="0" cellpadding="3">
          <tr>
            <td width="150" align="right">1.<?php echo _REGISTER_FULLNAME; ?></td>
            <td align="left"><input name="regis_fullname" type="text" id="regis_fullname" value="" size="20" maxlength="40" />
            <span class="vaild_fullname" id="form_comment">&nbsp;</span></td>
            <td rowspan="4" align="left" valign="top"><span class="vaild_data" id="form_comment">&nbsp;</span></td>
          </tr>
          <tr>
            <td align="right">2.<?php echo _REGISTER_IDCARD; ?></td>
            <td align="left"><input name="regis_idcard" type="text" id="regis_idcard" size="20" maxlength="13" />
            <span class="vaild_idcard" id="form_comment">&nbsp;</span></td>
          </tr>
          <tr>
            <td align="right">3.<?php echo _REGISTER_ADDRESS; ?></td>
            <td align="left"><textarea name="regis_address" cols="35" rows="5" id="regis_address"></textarea></td>
          </tr>
          <tr>
            <td align="right">4.<?php echo _REGISTER_JOB; ?></td>
            <td align="left"><input name="regis_job" type="text" id="regis_job" size="20" maxlength="10" />
            <span class="vaild_job" id="form_comment">&nbsp;</span></td>
          </tr>
          <tr>
            <td align="right">5.<?php echo _REGISTER_TELEPHONE; ?></td>
            <td align="left"><input name="regis_telephone" type="text" id="regis_telephone" size="20" maxlength="10" />
            <span class="vaild_telephone" id="form_comment">&nbsp;</span></td>
          </tr>
        </table>
      </td>
    </tr>
  </table>
</form>
<script>
$(document).ready(function(){
	var regisfullname = false;
	var regisidcard = false;
	var regisjob = false;
	var registelephone = false;
	
	$('#register_reset').click(function(){
		$(this).href('customer=view');
	});
	
	//--> FullName Text
	$('#regis_fullname').bind({
		focusin: function() {
			if(!regisfullname) {
				$('.vaild_fullname').fadeIn(0);
				$('.vaild_fullname').css('color','#900');
				$('.vaild_fullname').html('<img src="images/fail.gif" width="16" height="16" border="0" align="absmiddle" /> <?php echo _REGISTER_FULLNAME_COMMENT; ?>');
			}
		},
		keyup: function() {
			if($(this).val()!='') {
				regisfullname = true;
				$('.vaild_fullname').css('color','#090');
				$('.vaild_fullname').html('<img src="images/done.gif" width="16" height="16" border="0" align="absmiddle" /> <?php echo _REGISTER_FULLNAME_PASSED; ?>');
			} else {
				regisfullname = false;
				$('.vaild_fullname').css('color','#900');
				$('.vaild_fullname').html('<img src="images/fail.gif" width="16" height="16" border="0" align="absmiddle" /> <?php echo _REGISTER_FULLNAME_COMMENT; ?>');
			}
			formApplyVailds();
		},
		keydown: function() {
			if($(this).val()!='') {
				regisfullname = true;
				$('.vaild_fullname').html('<img src="images/done.gif" width="16" height="16" border="0" align="absmiddle" /> <?php echo _REGISTER_FULLNAME_PASSED; ?>');
			} else {
				regisfullname = false;
				$('.vaild_fullname').html('<img src="images/fail.gif" width="16" height="16" border="0" align="absmiddle" /> <?php echo _REGISTER_FULLNAME_COMMENT; ?>');
			}
			formApplyVailds();
		},
	});	

	//--> ID Card Text
	$('#regis_idcard').bind({
		focusin: function() {
			if(!regisidcard) {
				$('.vaild_idcard').fadeIn(0);
				$('.vaild_idcard').css('color','#900');
				$('.vaild_idcard').html('<img src="images/fail.gif" width="16" height="16" border="0" align="absmiddle" /> <?php echo _REGISTER_IDCARD_COMMENT; ?>');
			}
		},
		keyup: function() {
			if($(this).val()!='' && $(this).val().length==13) {
				regisidcard = true;
				$('.vaild_idcard').css('color','#090');
				$('.vaild_idcard').html('<img src="images/done.gif" width="16" height="16" border="0" align="absmiddle" /> <?php echo _REGISTER_IDCARD_PASSED; ?>');
			} else {
				regisidcard = false;
				$('.vaild_idcard').css('color','#900');
				$('.vaild_idcard').html('<img src="images/fail.gif" width="16" height="16" border="0" align="absmiddle" /> <?php echo _REGISTER_IDCARD_COMMENT; ?>');
			}
			formApplyVailds();
		},
		keydown: function() {

			if($(this).val()!='' && $(this).val().length==13) {
				regisidcard = true;
				$('.vaild_idcard').html('<img src="images/done.gif" width="16" height="16" border="0" align="absmiddle" /> <?php echo _REGISTER_IDCARD_PASSED; ?>');
			} else {
				regisidcard = false;
				$('.vaild_idcard').html('<img src="images/fail.gif" width="16" height="16" border="0" align="absmiddle" /> <?php echo _REGISTER_IDCARD_COMMENT; ?>');
			}
			formApplyVailds();
		},
	});	

	//--> FullName Text
	$('#regis_job').bind({
		focusin: function() {
			if(!regisjob) {
				$('.vaild_job').fadeIn(0);
				$('.vaild_job').css('color','#900');
				$('.vaild_job').html('<img src="images/fail.gif" width="16" height="16" border="0" align="absmiddle" /> <?php echo _REGISTER_JOB_COMMENT; ?>');
			}
		},
		keyup: function() {
			if($(this).val()!='') {
				regisjob = true;
				$('.vaild_job').css('color','#090');
				$('.vaild_job').html('<img src="images/done.gif" width="16" height="16" border="0" align="absmiddle" /> <?php echo _REGISTER_JOB_PASSED; ?>');
			} else {
				regisjob = false;
				$('.vaild_job').css('color','#900');
				$('.vaild_job').html('<img src="images/fail.gif" width="16" height="16" border="0" align="absmiddle" /> <?php echo _REGISTER_JOB_COMMENT; ?>');
			}
			formApplyVailds();
		},
		keydown: function() {
			if($(this).val()!='') {
				regisjob = true;
				$('.vaild_job').html('<img src="images/done.gif" width="16" height="16" border="0" align="absmiddle" /> <?php echo _REGISTER_JOB_PASSED; ?>');
			} else {
				regisjob = false;
				$('.vaild_job').html('<img src="images/fail.gif" width="16" height="16" border="0" align="absmiddle" /> <?php echo _REGISTER_JOB_COMMENT; ?>');
			}
			formApplyVailds();
		},
	});	

	//--> FullName Text
	$('#regis_telephone').bind({
		focusin: function() {
			if(!registelephone) {
				$('.vaild_telephone').fadeIn(0);
				$('.vaild_telephone').css('color','#900');
				$('.vaild_telephone').html('<img src="images/fail.gif" width="16" height="16" border="0" align="absmiddle" /> <?php echo _REGISTER_TELEPHONE_COMMENT; ?>');
			}
		},
		keyup: function() {
			if($(this).val()!='' && $(this).val().length==10) {
				registelephone = true;
				$('.vaild_telephone').css('color','#090');
				$('.vaild_telephone').html('<img src="images/done.gif" width="16" height="16" border="0" align="absmiddle" /> <?php echo _REGISTER_TELEPHONE_PASSED; ?>');
			} else {
				registelephone = false;
				$('.vaild_telephone').css('color','#900');
				$('.vaild_telephone').html('<img src="images/fail.gif" width="16" height="16" border="0" align="absmiddle" /> <?php echo _REGISTER_TELEPHONE_COMMENT; ?>');
			}
			formApplyVailds();
		},
		keydown: function() {
			if($(this).val()!='' && $(this).val().length==10) {
				registelephone = true;
				$('.vaild_telephone').html('<img src="images/done.gif" width="16" height="16" border="0" align="absmiddle" /> <?php echo _REGISTER_TELEPHONE_PASSED; ?>');
			} else {
				registelephone = false;
				$('.vaild_telephone').html('<img src="images/fail.gif" width="16" height="16" border="0" align="absmiddle" /> <?php echo _REGISTER_TELEPHONE_COMMENT; ?>');
			}
			formApplyVailds();
		},
	});	

	function formApplyVailds(){
		if(regisfullname && regisidcard && regisjob && registelephone) {
			$('#register_apply').removeAttr('disabled','disabled');
		} else {
			$('#register_apply').attr('disabled','disabled');
		}
	}
});
</script>
<?php endif; ?>