<?php 
$database = new SyncDatabase();
$employee = $database->Value('employee',array('username'=>$_GET['username']),0);

if(isset($_GET['action']) && isset($_POST['register_edit'])):
	$isFile = pathinfo($_REQUEST['regis_picture']);
	list($isWidth, $isHeight, $i, $isAttrImage) = getimagesize($_REQUEST['regis_picture']);
	if($isFile['basename']!==$employee['picture']) {
		if(file_exists($_REQUEST['regis_picture'])) {
			$folder_taget = 'images/employee/'.$isFile['basename'];
			copy($_REQUEST['regis_picture'], $folder_taget);				
			foreach (glob("images/tmpuser/*.*") as $filename) { unlink($filename); }
			$imageVailds = true;
		}
	}
	
	$editUser = array(
				'emp_name'	=> $_REQUEST['regis_fullname'],
				'address'	=> $_REQUEST['regis_address'],
				'telephone'	=> $_REQUEST['regis_telephone'],
				);
	if($isFile['basename']!==$employee['picture']) {
		$editUser['picture'] = $isFile['basename'];
	}
	if($_REQUEST['regis_password']!==$employee['password'] && $_REQUEST['regis_password']!=='') {
		$editUser['password'] = $_REQUEST['regis_password'];
	}
				
	$database->Update('employee', $editUser, array('username'=>$_GET['username']));
?>
	<table width="100%" cellpadding="5" cellspacing="0" border="0">
    <tr>
      <td width="180" align="center" valign="top" style="border-right:#CCC dashed 1px;">
       <input type="button" name="register_success" id="register_success" value=" " title="<?php echo _IMAGE_TAG_SUBMIT; ?>" />
      </td>
      <td align="left" valign="top">
       <h4><?php echo _REGISTER_USER_EDIT; ?></h4>
        <table border="0" cellspacing="0" cellpadding="3">
          <tr>
            <td width="220" rowspan="6" align="center"><div style="border:#999 solid 1px; padding:1px; display:inline-block;">
            <?php echo '<img src="images/employee/'.$isFile['basename'].'" '.$isAttrImage.' border="0" />'; ?>
            </div></td>
            <td align="right" valign="top">&nbsp;</td>
            <td align="left" valign="top">&nbsp;</td>
          </tr>
          <tr>
            <td width="100" align="right" valign="top"><strong><?php echo _REGISTER_USERNAME; ?>:</strong></td>
            <td width="150" align="left" valign="top"><?php echo $_REQUEST['regis_username']; ?></td>
          </tr>
          <tr>
            <td align="right" valign="top">&nbsp;</td>
            <td align="left" valign="top">&nbsp;</td>
          </tr>
          <tr>
            <td align="right" valign="top"><strong><?php echo _REGISTER_FULLNAME; ?>:</strong></td>
            <td align="left" valign="top"><?php echo $_REQUEST['regis_fullname']; ?></td>
          </tr>
          <tr>
            <td align="right" valign="top"><strong><?php echo _REGISTER_ADDRESS; ?>:</strong></td>
            <td align="left"><?php echo $_REQUEST['regis_address']; ?></td>
          </tr>
          <tr>
            <td align="right" valign="top"><strong><?php echo _REGISTER_TELEPHONE; ?>:</strong></td>
            <td align="left" valign="top"><?php echo $_REQUEST['regis_telephone']; ?></td>
          </tr>
          <tr>
            <td align="right">&nbsp;</td>
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
		$(this).href('employee=view');				
	});
});
</script>

<?php else: ?>
<?php if($employee!=NULL): ?>
<form action="?employee=edit&username=<?php echo $_GET['username']; ?>&action=success" method="POST" name="employee_register" id="employee_register">
  <table width="100%" cellpadding="5" cellspacing="0" border="0">
    <tr>
      <td width="180" align="center" valign="top" style="border-right:#CCC dashed 1px;">
       <input type="submit" name="register_edit" id="register_edit" value="" title="<?php echo _IMAGE_TAG_EDIT; ?>" />
       <input type="button" name="register_cancel" id="register_cancel" value="" title="<?php echo _IMAGE_TAG_CANCEL; ?>" /></td>
      <td align="left" valign="top">
      <h4><?php echo _REGISTER_USER_ACCESS; ?><span class="vaild_info" id="form_comment">&nbsp;</span></h4>
        <table border="0" cellspacing="0" cellpadding="3">
          <tr>
            <td width="200" align="right"><?php echo _REGISTER_USERNAME; ?></td>
            <td align="left"><input name="regis_username" type="text" id="regis_username" value="<?php echo $employee['username']; ?>" size="25" readonly="readonly" />
            <span class="vaild_username">&nbsp;</span>
           </td>
          </tr>
          <tr>
            <td align="right"><?php echo _REGISTER_PASSWORD; ?></td>
            <td align="left"><input name="regis_password" type="password" id="regis_password" value="" size="15" />
            <span class="vaild_password">&nbsp;</span></td>
          </tr>
          <tr>
            <td align="right"><?php echo _REGISTER_REPASSWORD; ?></td>
            <td align="left"><input name="regis_repassword" type="password" id="regis_repassword" value="" size="15" />
            <span class="vaild_repassword">&nbsp;</span></td>
          </tr>
        </table>
        <h4><?php echo _REGISTER_USER_DATA; ?><span class="vaild_info2" id="form_comment">&nbsp;</span></h4>
        <input type="hidden" name="regis_picture" id="regis_picture" value="<?php echo 'images/employee/'.$employee['picture']; ?>" />
        <table border="0" cellspacing="0" cellpadding="3">
          <tr>
            <td width="200" align="right"><?php echo _REGISTER_FULLNAME; ?></td>
            <td align="left"><input name="regis_fullname" type="text" id="regis_fullname" value="<?php echo $employee['emp_name']; ?>" size="30" maxlength="40" /></td>
            <td rowspan="4" align="left" valign="top"><span class="vaild_data" id="form_comment"><?php echo _REGISTER_DATA_COMMENT; ?></span></td>
          </tr>
          <tr>
            <td align="right"><?php echo _REGISTER_ADDRESS; ?></td>
            <td align="left"><textarea name="regis_address" cols="35" rows="5" id="regis_address"><?php echo $employee['address']; ?></textarea></td>
          </tr>
          <tr>
            <td align="right"><?php echo _REGISTER_TELEPHONE; ?></td>
            <td align="left"><input name="regis_telephone" type="text" id="regis_telephone" size="20" maxlength="10" value="<?php echo $employee['telephone']; ?>" /></td>
          </tr>
        </table>
      </td>
    </tr>
  </table>
</form>
<form action="?ajax=employee_register&form=picture" method="POST" enctype="multipart/form-data" name="register_upload" target="picture_target" id="register_upload" >
  <table width="100%" cellpadding="5" cellspacing="0" border="0">
    <tr>
      <td width="180" align="center" valign="top" style="border-right:#CCC dashed 1px;">&nbsp;</td>
      <td align="left" valign="top">
        <h4><?php echo _REGISTER_USER_IMAGE; ?></h4>
        <table border="0" cellspacing="0" cellpadding="3">
          <tr>
              <td align="right"></td>
            <td align="left">
              <input name="regis_picture_name" type="text" readonly="readonly" id="regis_picture_name" size="50" value="<?php echo $employee['picture']; ?>" /></td>
          </tr>
          <tr>
            <td width="200" align="right" valign="top"><?php echo _REGISTER_PICTURE; ?></td>
            <td align="left"><input type="file" name="regis_picture_tmp" id="regis_picture_tmp" />
            <iframe name="picture_target" id="picture_target2" width="240" height="280" scrolling="no" frameborder="1"
              style="border:#999 solid 1px; padding:1px; margin:2px;" src="?ajax=employee_register&form=view_picture&image=<?php echo $employee['picture']; ?>"></iframe></td>
          </tr>
          <tr>
            <td align="right"></td>
            <td align="left"><input type="submit" name="submit_upload" id="submit_upload" value=" " disabled="disabled" /></td>
          </tr>
        </table>      
      </td>
    </tr>
  </table>
</form>
<script>
$(document).ready(function(){
	$('#register_cancel').click(function(){
		$(this).href('employee=view');				
	});

	var regisPassword = true;
	var regisPicture = true;
	
	$('#regis_picture_tmp').change(function(){
		regisPicture = false;
		$.ajax({ url: 'index.php?ajax=employee_register&form=tmp_name',
			data: ({ name : $('#regis_picture_tmp').val() }),
			success: function (data){
				$('#regis_picture').val(data.filepath);
				$('#regis_picture_name').val(data.filename);
			},
		});
		$('#submit_upload').removeAttr('disabled','disabled');
		$('div.preview').html('');
		formApplyVailds();
	});
	
	$('#register_upload').submit(function(){
		regisPicture = true;
		$('#picture_target').css('background','url("images/ajax-loader.gif") 112px 132px no-repeat')
		$('#submit_upload').attr('disabled','disabled');
		formApplyVailds();
	});


	//--> Password Textbox
	$('#regis_password').focusin(function(){ 
		$('.vaild_info').fadeIn('fast'); 
		$('.vaild_info').html('<?php echo _REGISTER_PASSWORD_COMMENT; ?>');
	});
	$('#regis_password').focusout(function(){ $('.vaild_info').fadeOut(0); });	
	$('#regis_password').keyup(function(){
		if($('#regis_password').val()!='') {
			if($('#regis_password').val().length>=6) {
				regisPassword = false;
				$('.vaild_password').html('<img src="images/done.gif" width="16" height="16" border="0" align="absmiddle" />');
			} else {
				regisPassword = false;
				$('.vaild_password').html('<img src="images/fail.gif" width="16" height="16" border="0" align="absmiddle" />');
			}
		} else {
			regisPassword = true;
			$('.vaild_password').html('');
		}
		formApplyVailds();
	});
	$('#regis_password').keydown(function(){
		if($('#regis_password').val()!='') {
			if($('#regis_password').val().length>=6) {
				regisPassword = false;
				$('.vaild_password').html('<img src="images/done.gif" width="16" height="16" border="0" align="absmiddle" />');
			} else {
				regisPassword = false;
				$('.vaild_password').html('<img src="images/fail.gif" width="16" height="16" border="0" align="absmiddle" />');
			}
		} else {
			regisPassword = true;
			$('.vaild_password').html('');
		}
		formApplyVailds();
	});	
	
	
	
	//--> Retry Password Textbox
	$('#regis_repassword').focusin(function(){
		$('.vaild_info').fadeIn('fast');
		$('.vaild_info').html('<?php echo _REGISTER_REPASSWORD_COMMENT; ?>');
	});
	$('#regis_repassword').focusout(function(){ $('.vaild_info').fadeOut(0); });
	$('#regis_repassword').keyup(function(){
		if($('#regis_repassword').val()!='') {
			if($('#regis_repassword').val().length>=6) {
				if($('#regis_password').val()==$('#regis_repassword').val()) {
					regisPassword = true;
					$('.vaild_repassword').html('<img src="images/done.gif" width="16" height="16" border="0" align="absmiddle" />');
				} else {
					regisPassword = false;
					$('.vaild_repassword').html('<img src="images/fail.gif" width="16" height="16" border="0" align="absmiddle" />');
				}
			} else {
				regisPassword = false;
				$('.vaild_repassword').html('<img src="images/fail.gif" width="16" height="16" border="0" align="absmiddle" />');
			}
		} else {
			regisPassword = false;
			$('.vaild_repassword').html('');
		}
		formApplyVailds();
	});
	$('#regis_repassword').keydown(function(){
		if($('#regis_repassword').val()!='') {
			if($('#regis_repassword').val().length>=6) {
				if($('#regis_password').val()==$('#regis_repassword').val()) {
					regisPassword = true;
					$('.vaild_repassword').html('<img src="images/done.gif" width="16" height="16" border="0" align="absmiddle" />');
				} else {
					regisPassword = false;
					$('.vaild_repassword').html('<img src="images/fail.gif" width="16" height="16" border="0" align="absmiddle" />');
				}
			} else {
				regisPassword = false;
				$('.vaild_repassword').html('<img src="images/fail.gif" width="16" height="16" border="0" align="absmiddle" />');
			}
		} else {
			regisPassword = false;
			$('.vaild_repassword').html('');
		}
		formApplyVailds();
	});
	
	function formApplyVailds(){
		if(regisPassword && regisPicture) {
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
