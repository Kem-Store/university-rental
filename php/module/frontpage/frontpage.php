<?php
$database = new SyncDatabase();
$user = $database->Select('employee',0,0);
?>
<table align="center" width="100%" border="0" cellspacing="0" cellpadding="10">
  <tr>
    <td>
      <table align="center" width="400" border="0" cellspacing="0" cellpadding="5">
        <tr>
          <td align="center">
            <div id="wizard-menu"><a href="?customer=register" class="register">
             <img id="icon-menu" src="images/IconRegister.png" width="128" height="128" border="0" />
             <div id="wizard-text"><?php echo _WIZARD_REGISTER; ?></div></a>
            </div>
          </td>
          <td align="center">
            <div id="wizard-menu"><a href="?contract=register" class="rent">
             <img id="icon-menu" src="images/IconRent.png" width="128" height="128" border="0" />
             <div id="wizard-text"><?php echo _WIZARD_RENT; ?></div></a>
            </div>
          </td>
        </tr>
        <tr>
          <td align="center">
            <div id="wizard-menu"><a href="?pay=ment" class="pay">
             <img id="icon-menu" src="images/IconPay.png" width="128" height="128" border="0" />
             <div id="wizard-text"><?php echo _WIZARD_PAY; ?></div></a>
            </div>
          </td>
          <td align="center">
          	<!--
            <div id="wizard-menu"><a href="?report=view" class="report">
             <img id="icon-menu" src="images/IconReport.png" width="128" height="128" border="0" />
             <div id="wizard-text"><?php echo _WIZARD_REPORT; ?></div></a>
            </div>
            -->
          </td>
        </tr>
      </table>
    </td>
    <td width="220" style="border-left:#CCC dashed 1px;" valign="top">
     <h4><?php echo _STATUS_SAMMARY; ?></h4>
     <div style="padding:0 0 5px 15px; background-color:#F99">
     <?php 
	 foreach($database->Select('object_type',0,0) as $rental) {
		 echo '<strong>'.$rental['type_name'].'</strong> ';
		 echo $database->Count('object_rental',array('type_id'=>$rental['type_id'], 'status_object'=>'0'),0);
		 echo '('.$database->Count('object_rental',array('type_id'=>$rental['type_id']),0).')';
		 echo '<br />';	
	 }
	 echo '<strong>'._STATUS_CUSTOMER_TOTAL.'</strong> ';
	 echo $database->Count('customer',0,0)._STATUS_UNIT;
	 echo '<br />';
	 echo '<strong>'._STATUS_CUSTOMER_PAY.'</strong> ';
	 $paidCount = 0;
	 foreach($database->Select('customer',0,0) as $customer) {
		 foreach($database->Select('contract', array('cus_id'=>$customer['cus_id']),0) as $contract) {
			 if($database->Count('payment', array('contract_id'=>$contract['contract_id'],'paid'=>0),0)!=0) {
				 $paidCount++;
			 }
		 }
	 }
	 echo $paidCount._STATUS_UNIT;
	 echo '<br />';
	 ?> 
     </div>
     <h4>Other</h4>
    </td>
  </tr>
</table>
