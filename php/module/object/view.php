<?php
$database = new SyncDatabase();
?>
<div align="right" id="event_main">
<input type="button" id="action_add" class="button" value=" " title="<?php echo _IMAGE_TAG_ADD; ?>" />
<input type="button" id="action_remove" class="button" value=" " title="<?php echo _IMAGE_TAG_REMOVE; ?>" />
</div>
<div align="right" id="event_del" style="display:none;">
<input type="button" id="action_del" class="button" value=" " title="<?php echo _IMAGE_TAG_DEL; ?>" disabled="disabled" />
<input type="button" id="action_back" class="button" value=" " title="<?php echo _IMAGE_TAG_BACK; ?>" />
</div>
<br /><div align="left"><h1><?php echo _HEAD_LIST_OBJECT; ?></h1></div>
<table align="left" width="100%" border="0" cellspacing="0" cellpadding="0" style="border-top:#999 dashed 1px;">
 <tr>
  <td valign="top" width="230" style="border-right:#666 solid 2px;">
	<?php
    $objectCount = $database->Count('object_rental', array('type_id'=>2),0);
    $objectRow =  floor($objectCount/3) + 1;
    
    $objectName = $database->Select('object_type', array('type_id'=>2),0);
    $objectName = $objectName[0]['type_name'];
    ?>
    <table width="235" border="0" cellspacing="1" cellpadding="3">
      <?php foreach($database->Select('object_rental', array('type_id'=>2),0) as $object): ?>
      <tr>
        <td>
          <a href="?object=edit&id=<?php echo $object['object_id']; ?>">
          <div <?php
		    if(isset($_GET['id']) && $_GET['id']==$object['object_id']) {
				echo 'id="object-block-select"'; 
			} else if($object['status_object']==1) {
				echo 'id="object-block-rent"'; 
			} else {
				echo 'id="object-block-empty"'; 
			} 
			?>; class="id-<?php echo $object['object_id']; ?>">
            <?php
            $typeName = $database->Select('object_type', array('type_id'=>$object['type_id']),0);
            $typeName = $typeName[0];
            ?>
            <div id="selected-id<?php echo $object['object_id']; ?>" style="position:absolute; display:none;">&nbsp;
            </div>
            <div id="object-name" class="name-<?php echo $object['object_id']; ?>">
              <?php 
              echo 'No. ';
              $idObject = $object['object_id'];
              while(strlen($idObject)<3) { $idObject = '0'.$idObject; }
              echo '2'.$idObject;
              ?>
            </div>
            <div id="object-detail">
              <?php
			  echo '<div style="margin-bottom:6px;font-size:12px;text-decoration:underline;"><strong>'.$typeName['type_name'].$object['detail'].'</strong></div>';
			  if($object['status_object']==1) {
				  $contract = $database->Value('contract', array('object_id'=>$object['object_id']),0);
				  $customer = $database->Value('customer', array('cus_id'=>$contract['cus_id']),0);
				  
				  echo '<div style="margin-bottom:3px;">'._OBJECT_RENT_BY.' <strong>'.$customer['fullname'].'</strong></div>';
				  echo '<div style="margin-bottom:3px;">'._OBJECT_RENT_DATE.ThaiDate::Full($contract['signup_date']).'</div>';
			  } else {
				  echo '<div>'._OBJECT_RENT_BYNONE.'</div>';
				  echo '<span id="object-empty" class="select-'.$object['object_id'].'">'._OBJECT_RENT_BLANK.'</span>';
			  }
              ?>
            </div>
          </div></a>
        </td>
      </tr>
        <?php endforeach; ?>
        <?php
		if($objectCount!=0) {
			while($objectCount<3) {
				echo '<td>&nbsp;</td>';
				$objectCount++;
			}
		} else {
			echo '<td align="center">None</td>';
		}
		?>
    </table>
  </td>
  <td valign="top" style="width:80px; background-color:#999;">&nbsp;
  </td>
  <td valign="top" style="border-left:#666 solid 2px;">
	<?php
    $objectCount = $database->Count('object_rental', array('type_id'=>1),0);
    $objectRow =  floor($objectCount/2) + 1;
    
    $objectName = $database->Select('object_type', array('type_id'=>1),0);
    $objectName = $objectName[0]['type_name'];
    ?>
    <table align="center" width="100%" border="0" cellspacing="1" cellpadding="3">
      <?php for($iRow=0;$iRow<$objectRow;$iRow++): ?>
      <tr>
        <?php foreach($database->Select('object_rental', array('type_id'=>1),array(0, 0, 'LIMIT '.($iRow*2).',2')) as $object): ?>
        <td width="230">
          <a href="?object=edit&id=<?php echo $object['object_id']; ?>">
          <div <?php
		    if(isset($_GET['id']) && $_GET['id']==$object['object_id']) {
				echo 'id="object-block-select"'; 
			} else if($object['status_object']==1) {
				echo 'id="object-block-rent"'; 
			} else {
				echo 'id="object-block-empty"'; 
			} 
			?>; class="id-<?php echo $object['object_id']; ?>">
            <?php
            $typeName = $database->Select('object_type', array('type_id'=>$object['type_id']),0);
            $typeName = $typeName[0];
            ?>
            <div id="selected-id<?php echo $object['object_id']; ?>" style="position:absolute; display:none;">&nbsp;
            </div>
            <div id="object-name" class="name-<?php echo $object['object_id']; ?>">
              <?php 
              echo 'No. ';
              $idObject = $object['object_id'];
              while(strlen($idObject)<3) { $idObject = '0'.$idObject; }
              echo '1'.$idObject;
              ?>
            </div>
            <div id="object-detail">
              <?php
			  echo '<div style="margin-bottom:6px;font-size:12px;text-decoration:underline;"><strong>'.$typeName['type_name'].$object['detail'].'</strong></div>';
			  if($object['status_object']==1) {
				  $contract = $database->Value('contract', array('object_id'=>$object['object_id']),0);
				  $customer = $database->Value('customer', array('cus_id'=>$contract['cus_id']),0);
				  
				  echo '<div style="margin-bottom:3px;">'._OBJECT_RENT_BY.' <strong>'.$customer['fullname'].'</strong></div>';
				  echo '<div style="margin-bottom:3px;">'._OBJECT_RENT_DATE.ThaiDate::Full($contract['signup_date']).'</div>';
			  } else {
				  echo '<div>'._OBJECT_RENT_BYNONE.'</div>';
				  echo '<span id="object-empty" class="select-'.$object['object_id'].'">'._OBJECT_RENT_BLANK.'</span>';
			  }
              ?>
            </div>
          </div></a>
        </td>
        <?php endforeach; ?>
        <?php
		if($objectCount!=0) {
			while($objectCount<3) {
				echo '<td>&nbsp;</td>';
				$objectCount++;
			}
		} else {
			echo '<td align="center">None</td>';
		}
		?>
      </tr>
      <?php endfor; ?>
    </table>
  </td>
 </tr>
</table>
<script>
$(document).ready(function(){
	var rentObject = [ <?php foreach($database->Select('object_rental', array('status_object'=>'1'), 0) as $object) { echo '"'.$object['object_id'].'",'; } ?> ];
	var emptyObject = [ <?php foreach($database->Select('object_rental', array('status_object'=>'0'), 0) as $object) { echo '"'.$object['object_id'].'",'; } ?> ];
	var checkboxValue = [];
	$('#action_add').click(function(){
		$(this).href('object=new');
	});
	
	if(rentObject.length==0 && emptyObject.length==0) { $('#action_remove').attr('disabled','disabled'); }
	
	$('#action_remove').click(function(){
		$('#event_main').hide(0);
		$('#event_del').show(0);
		jQuery.each(rentObject, function() {
			$('#selected-id' + this).show(0);
			$('#selected-id' + this).html('<input type="checkbox" name="object_id[]" id="selected_object" value="'+this+'" disabled="disabled" />');
			$(".id-" + this).css({
				'background': '#EEE',
				'color': '#999',
				'border': '#EEE solid 1px',
				'cursor': 'default',
			});
			$(".name-" + this).css({
				'background': '#EEE',
				'color': '#999',
			});
		});		
		jQuery.each(emptyObject, function() {
			$('#selected-id' + this).show(0);
			$('#selected-id' + this).html('<input type="checkbox" name="object_id[]" id="selected_object" value="'+this+'" />');
			$(".id-" + this).css({
				'background': '#F7F7F7',
			});
			$(".select-" + this).hide();
		});		
	});
	
	$('#action_back').click(function(){
		$('#action_del').attr('disabled','disabled');
		$('#event_main').show(0);
		$('#event_del').hide(0);
		jQuery.each(rentObject, function() {
			$('#selected-id' + this).hide(0);
			$('#selected-id' + this).empty();
			$(".id-" + this).css({
				'background': 'url(images/bg_rent.png) 0px 0px no-repeat',
				'color': '#000',
				'border': '#D3D3D3 solid 1px',
				'cursor': 'pointer',
			});
			$(".name-" + this).css({
				'background': '#333',
				'color': '#FFF',
			});
		});		
		jQuery.each(emptyObject, function() {
			$('#selected-id' + this).hide(0);
			$('#selected-id' + this).empty();
			$(".id-" + this).css({
				'background': '#F7F7F7',
				'border': '#D3D3D3 solid 1px',
			});
			$('.name-'+this).css({
				'background':'#333',
			});
			$(".select-" + this).show();
		});		
	});
	
	$('#action_del').click(function(){
		if(checkboxValue) {
			$.ajax({ url: 'index.php?ajax=list_delete&table=object_rental',
				data: ({ list_id : checkboxValue }),
				error: function (data){
					$('#error_ajax').html('Error');
				},
				success: function (data){	
					$(this).href('object=view');
				},
			});
		} else {
			$(this).href('object=view');
		}		
	});
	
	
	$("#selected_object").live('change', function() {
		checkboxValue = $("#selected_object:checked").multiVal();
		jQuery.each(emptyObject, function() {
			$('.id-'+this).css({
				'background':'#F7F7F7',
				'border': '#D3D3D3 solid 1px',
			});
			$('.name-'+this).css({
				'background':'#333',
			});
		});
		
		jQuery.each(checkboxValue, function() {
			$('.name-'+this).css({
				'background':'#d72b29',
			});
			$('.id-'+this).css({
				'background': 'url(images/bg_rent.png) 0px -100px no-repeat',
				'border': '#d72b29 solid 1px',
			});
		});
		if(checkboxValue!='') {
			$('#action_del').removeAttr('disabled','disabled');
		} else {
			$('#action_del').attr('disabled','disabled');
		}
    });	

	
});
</script>
