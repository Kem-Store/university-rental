<?php
$database = new SyncDatabase();
$vaildLogin = 0;
$imageUser = '<img id="image_user" src="images/employee/user_none.jpg" width="110" height="128" border="0" />';
if($database->Select('employee',array('username'=>$_POST['user_vaild']),0)) {
	if($database->Select('employee',array('username'=>$_POST['user_vaild'], 'password'=>$_POST['pass_vaild']),0)) {
		$vaildLogin = 1;
		$error = '<strong>MD5: </strong>'.md5($_POST['user_vaild']);
	} else {
		$vaildLogin = 2;
		$error = _SUBMIT_FAIL_PASS;
	}
	foreach($database->Select('employee',array('username'=>$_POST['user_vaild']),0) as $user) {
		if ($user['picture']!=NULL)
			$imageUser = '<img id="image_user" src="images/employee/'.$user['picture'].'" width="110" height="128" border="0" />';
	}
} else {
	$vaildLogin = 0;
	$error = _SUBMIT_FAIL_USER;
}

echo json_encode(array(
				'error' => $error,
				'vaild' => $vaildLogin,
				'image' => $imageUser,
				));
?>