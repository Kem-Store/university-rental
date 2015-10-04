<?php if(isset($_GET['action']) && isset($_POST['register_apply'])): ?>
<?php
$database = new SyncDatabase();
$imageVailds = false;

if($_REQUEST['regis_picture']!='') {
	$isFile = pathinfo($_REQUEST['regis_picture']);
	if(file_exists($_REQUEST['regis_picture'])) {
		list($isWidth, $isHeight, $i, $isAttrImage) = getimagesize($_REQUEST['regis_picture']);
		$folder_taget = 'images/employee/'.$isFile['basename'];
		copy($_REQUEST['regis_picture'], $folder_taget);				
		foreach (glob("images/tmpuser/*.*") as $filename) { unlink($filename); }
		$imageVailds = true;
	} else {
		$imageVailds = false;
		$isFile['basename'] = 'user_none.jpg';
		$isAttrImage = 'width="110" height="128"';
	}
} else {
	$imageVailds = false;
	$isFile['basename'] = 'user_none.jpg';
	$isAttrImage = 'width="110" height="128"';
}
if(!$database->Select('employee',array('username'=>$_REQUEST['regis_username']),0)) {
	$newUser = array(
				'emp_name'	=> $_REQUEST['regis_fullname'],
				'address'	=> $_REQUEST['regis_address'],
				'telephone'	=> $_REQUEST['regis_telephone'],
				'picture'	=> $isFile['basename'],
				'username'	=> $_REQUEST['regis_username'],
				'password'	=> $_REQUEST['regis_password'],
				);
	$database->Insert('employee', $newUser);
}
?>
<table width="100%" cellpadding="5" cellspacing="0" border="0">
    <tr>
      <td width="180" align="center" valign="top" style="border-right:#CCC dashed 1px;">
       <input type="button" name="register_edit" id="register_edit" value=" " title="<?php echo _IMAGE_TAG_EDIT; ?>" />
       <input type="button" name="register_success" id="register_success" value=" " title="<?php echo _IMAGE_TAG_SUBMIT; ?>" />
      </td>
      <td align="left" valign="top">
       <h4><?php echo _REGISTER_USER_ADD; ?></h4>
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
	$('#register_edit').click(function(){
		$(this).href('employee=edit&username=<?php echo $_REQUEST['regis_username']; ?>');				
	});
	
	$('#register_success').click(function(){
		$(this).href('employee=view');				
	});
});
</script>
<?php else: ?>
<form action="?employee=add&action=success" method="POST" name="employee_register" id="employee_register">
  <table width="100%" cellpadding="5" cellspacing="0" border="0">
    <tr>
      <td width="180" align="center" valign="top" style="border-right:#CCC dashed 1px;">
       <input type="submit" name="register_apply" id="register_apply" value="" title="<?php echo _IMAGE_TAG_SAVE; ?>" disabled="disabled" />
       <input type="reset" name="register_reset" id="register_reset" value="" title="<?php echo _IMAGE_TAG_BACK; ?>" /></td>
      <td align="left" valign="top">
      <h4><?php echo _REGISTER_USER_ACCESS; ?></h4>
        <table border="0" cellspacing="0" cellpadding="3">
          <tr>
            <td width="120" align="right">1.<?php echo _REGISTER_USERNAME; ?></td>
            <td align="left"><input name="regis_username" type="text" id="regis_username" value="" size="25" maxlength="16" />
            <span class="vaild_username" id="form_comment">&nbsp;</span>
           </td>
          </tr>
          <tr>
            <td align="right">2.<?php echo _REGISTER_PASSWORD; ?></td>
            <td align="left"><input name="regis_password" type="password" id="regis_password" value="" size="15" />
            <span class="vaild_password" id="form_comment">&nbsp;</span></td>
          </tr>
          <tr>
            <td align="right">3.<?php echo _REGISTER_REPASSWORD; ?></td>
            <td align="left"><input name="regis_repassword" type="password" id="regis_repassword" value="" size="15" />
            <span class="vaild_repassword" id="form_comment">&nbsp;</span></td>
          </tr>
        </table>
        <h4><?php echo _REGISTER_USER_DATA; ?></h4>
        <input type="hidden" name="regis_picture" id="regis_picture" value="" />
        <table border="0" cellspacing="0" cellpadding="3">
          <tr>
            <td width="120" align="right">4.<?php echo _REGISTER_FULLNAME; ?></td>
            <td align="left"><input name="regis_fullname" type="text" id="regis_fullname" value="" size="30" maxlength="40" />
            <span class="vaild_fullname" id="form_comment">&nbsp;</span>
            </td>
            <td rowspan="4" align="left" valign="top"><span class="vaild_data" id="form_comment"><?php echo _REGISTER_DATA_COMMENT; ?></span></td>
          </tr>
          <tr>
            <td align="right">5.<?php echo _REGISTER_ADDRESS; ?></td>
            <td align="left"><textarea name="regis_address" cols="35" rows="5" id="regis_address"></textarea></td>
          </tr>
          <tr>
            <td align="right">6.<?php echo _REGISTER_TELEPHONE; ?></td>
            <td align="left"><input name="regis_telephone" type="text" id="regis_telephone" size="20" maxlength="10" />
            <span class="vaild_telephone" id="form_comment">&nbsp;</span>
            </td>
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
              <input name="regis_picture_name" type="text" readonly="readonly" id="regis_picture_name" size="50" /></td>
          </tr>
          <tr>
            <td width="120" align="right" valign="top">7.<?php echo _REGISTER_PICTURE; ?></td>
            <td align="left"><input type="file" name="regis_picture_tmp" id="regis_picture_tmp" />
            <iframe name="picture_target" id="picture_target2" width="240" height="280" scrolling="no" frameborder="1"
              style="border:#999 solid 1px; padding:1px; margin:2px;" src="?ajax=employee_register&form=picture"></iframe></td>
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
	var regisUsername = false;
	var regisPassword = false;
	var regisRePassword = false;
	var regisfullname = false;
	var registelephone = false;
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

	$('#register_reset').click(function(){
		$(this).href('employee=view');				
	});
	
	//--> Username Text
	$('#regis_username').bind({
		focusin: function() {
			if(!regisUsername) {
				$('.vaild_username').fadeIn(0);
				$('.vaild_username').css('color','#900');
				$('.vaild_username').html('<img src="images/fail.gif" width="16" height="16" border="0" align="absmiddle" /> <?php echo _REGISTER_USERNAME_COMMENT; ?>');
			}
		},
		keyup: function() {
			formUsernameAvalible();
		},
		keydown: function() {
			formUsernameAvalible();
		},
	});		
	
	function formUsernameAvalible()
	{
		if($('#regis_username').val()!='') {
			if($('#regis_username').val().length>=5) {
				$.ajax({ url: 'index.php?ajax=employee_register&form=username',
					data: ({ user_vaild : $('#regis_username').val() }),
					error: function (data){
						$('.vaild_username').html('Error');
					},
					success: function (data){
						$('.vaild_username').css('color','#090');
						$('.vaild_username').html(data.error + ' <?php echo _REGISTER_USERNAME_PASSED; ?>');
						if(data.vaild==1) {
							regisUsername = true;
						} else {
							regisUsername = false;
						}
						formApplyVailds();
					},
				});
			} else {
				$('.vaild_username').css('color','#900');
				$('.vaild_username').html('<img src="images/fail.gif" width="16" height="16" border="0" align="absmiddle" /> <?php echo _REGISTER_USERNAME_COMMENT; ?>');
				regisUsername = false;
				formApplyVailds();
			}
		} else {
			$('.vaild_username').css('color','#900');
			$('.vaild_username').html('<img src="images/fail.gif" width="16" height="16" border="0" align="absmiddle" /> <?php echo _REGISTER_USERNAME_COMMENT; ?>');
			regisUsername = false;
			formApplyVailds();
		}
	}

	//--> Password Text
	$('#regis_password').bind({
		focusin: function() {
			if(!regisPassword) {
				$('.vaild_password').fadeIn(0);
				$('.vaild_password').css('color','#900');
				$('.vaild_password').html('<img src="images/fail.gif" width="16" height="16" border="0" align="absmiddle" /> <?php echo _REGISTER_PASSWORD_COMMENT; ?>');
			}
		},
		keyup: function() {
			if($(this).val()!='' && $(this).val().length>=6) {
				regisPassword = true;
				$('.vaild_password').css('color','#090');
				$('.vaild_password').html('<img src="images/done.gif" width="16" height="16" border="0" align="absmiddle" /> <?php echo _REGISTER_PASSWORD_PASSED; ?>');
			} else {
				regisPassword = false;
				$('.vaild_password').css('color','#900');
				$('.vaild_password').html('<img src="images/fail.gif" width="16" height="16" border="0" align="absmiddle" /> <?php echo _REGISTER_PASSWORD_COMMENT; ?>');
			}
			formApplyVailds();
		},
		keydown: function() {
			if($(this).val()!='' && $(this).val().length>=6) {
				regisPassword = true;
				$('.vaild_password').html('<img src="images/done.gif" width="16" height="16" border="0" align="absmiddle" /> <?php echo _REGISTER_PASSWORD_PASSED; ?>');
			} else {
				regisPassword = false;
				$('.vaild_password').html('<img src="images/fail.gif" width="16" height="16" border="0" align="absmiddle" /> <?php echo _REGISTER_PASSWORD_COMMENT; ?>');
			}
			formApplyVailds();
		},
	});	
	
	//--> RePassword Text
	$('#regis_repassword').bind({
		focusin: function() {
			if(!regisRePassword) {
				$('.vaild_repassword').fadeIn(0);
				$('.vaild_repassword').css('color','#900');
				$('.vaild_repassword').html('<img src="images/fail.gif" width="16" height="16" border="0" align="absmiddle" /> <?php echo _REGISTER_REPASSWORD_COMMENT; ?>');
			}
		},
		keyup: function() {
			if($(this).val()!='' && $(this).val().length>=6 && $('#regis_password').val()==$(this).val()) {
				regisRePassword = true;
				$('.vaild_repassword').css('color','#090');
				$('.vaild_repassword').html('<img src="images/done.gif" width="16" height="16" border="0" align="absmiddle" /> <?php echo _REGISTER_REPASSWORD_PASSED; ?>');
			} else {
				regisRePassword = false;
				$('.vaild_repassword').css('color','#900');
				$('.vaild_repassword').html('<img src="images/fail.gif" width="16" height="16" border="0" align="absmiddle" /> <?php echo _REGISTER_REPASSWORD_COMMENT; ?>');
			}
			formApplyVailds();
		},
		keydown: function() {
			if($(this).val()!='' && $(this).val().length>=6 && $('#regis_password').val()==$(this).val()) {
				regisRePassword = true;
				$('.vaild_repassword').html('<img src="images/done.gif" width="16" height="16" border="0" align="absmiddle" /> <?php echo _REGISTER_REPASSWORD_PASSED; ?>');
			} else {
				regisRePassword = false;
				$('.vaild_repassword').html('<img src="images/fail.gif" width="16" height="16" border="0" align="absmiddle" /> <?php echo _REGISTER_REPASSWORD_COMMENT; ?>');
			}
			formApplyVailds();
		},
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

	//--> Telephone Text
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
		if(regisUsername && regisPassword && regisRePassword && regisfullname && registelephone && regisPicture) {
			$('#register_apply').removeAttr('disabled','disabled');
		} else {
			$('#register_apply').attr('disabled','disabled');
		}
	}
});
</script>
<?php endif; ?>