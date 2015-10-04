<?php
$database = new SyncDatabase();
switch($_GET['form'])
{
	case 'username':
		if($database->Select('employee',array('username'=>$_POST['user_vaild']),0))
		{
			echo json_encode(array('error'=>'<img src="images/fail.gif" width="16" height="16" border="0" align="absmiddle" />','vaild'=>0));
		} else {
			echo json_encode(array('error'=>'<img src="images/done.gif" width="16" height="16" border="0" align="absmiddle" />','vaild'=>1));
		}
	break;
	case 'tmp_name':
			$isFile = pathinfo($_POST['name']);
			$isName = md5($isFile['filename']).'.'.$isFile['extension'];
			$isPath = 'images/tmpuser/'.$isName;		

			echo json_encode(array(
						'filename'=>md5($isFile['filename']).'.'.$isFile['extension'],
						'filepath'=>$isPath,
						));
	break;
	case 'picture':
		if(!isset($_FILES['regis_picture_tmp'])) {
			echo '<style type="text/css">body { padding:0px;margin:0px; }</style>';
			echo '<div class="preview"><img src="images/browse_pic.jpg" width="240" height="280" border="0" /></div>';
		} else {
			$isFile = pathinfo($_FILES['regis_picture_tmp']['name']);
			list($isWidth, $isHeight) = getimagesize($_FILES['regis_picture_tmp']['tmp_name']);
			list($isX, $isY) = array(120 - ($isWidth / 2), 140 - ($isHeight / 2));
			echo '<style type="text/css">body { padding:'.$isY.'px 0 0 '.$isX.'px;margin:0px;font-size:11px;color:#444444; }</style>';
			$target_path = 'images/tmpuser/'.md5($isFile['filename']).'.'.$isFile['extension'];
			if($isFile['extension']=='jpg' || $isFile['extension']=='gif' || $isFile['extension']=='png')
			{
				if($isWidth<=240 && $isHeight<=280 && $_FILES['regis_picture_tmp']['size']<=1048576)
				{
					move_uploaded_file($_FILES['regis_picture_tmp']['tmp_name'], $target_path);
					echo '<div class="preview"><img src="'.$target_path.'" border="0" /></div>';
				} else {
					echo '<div class="preview"><img src="images/bigsize_pic.jpg" width="240" height="280" border="0" /></div>';
				}
			} else {
				echo '<div class="preview"><img src="images/noimage_pic.jpg" width="240" height="280" border="0" /></div>';
			}
		}
	break;
	case 'view_picture':
		$isFile = pathinfo('images/employee/'.$_GET['image']);
		list($isWidth, $isHeight) = getimagesize('images/employee/'.$_GET['image']);
		list($isX, $isY) = array(120 - ($isWidth / 2), 140 - ($isHeight / 2));
		echo '<style type="text/css">body { padding:'.$isY.'px 0 0 '.$isX.'px;margin:0px;font-size:11px;color:#444444; }</style>';
		echo '<div class="preview"><img src="images/employee/'.$_GET['image'].'" border="0" /></div>';
	break;
}
?>
