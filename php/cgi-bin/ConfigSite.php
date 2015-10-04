<?php
// Author: Kenanek Thongkam
class ini
{
	public static function SettingArray($path)
	{
		$tmpConfig = NULL;
		$loadConfig = parse_ini_file($path, true);
		foreach($loadConfig as $isGroupConfig)
		{
			foreach($isGroupConfig as $name=>$value)
			{
				$tmpConfig[$name] = $value;
			}
		}
		return $tmpConfig;
	}	
}

class alert
{
	public static function Warning($text)
	{
		$tmpString = '<center><div class="alert-warning">';
		$tmpString .= $text.'</div></center>';
		return $tmpString;
	}	
	public static function Info($text)
	{
		$tmpString = '<center><div class="alert-info">';
		$tmpString .= $text.'</div></center>';
		return $tmpString;
	}	
}

class site
{
	public static function Module($folder, $name)
	{
		if(file_exists('module/'.$folder.'/'.$name.'.php')) {
			include_once('module/'.$folder.'/'.$name.'.php');
			return true;
		} else {
			include_once('plugins/default.php');
			return false;
		}
	}
	
	public static function Content($file, $value = array())
	{
		$urlInfo = pathinfo($_SERVER['REQUEST_URI']);
		$urlfile = 'http://'.$_SERVER['SERVER_NAME'].'/'.$urlInfo['dirname'].'/index.php/?html='.$file;
		$getContent = file_get_contents($urlfile);
		$data = array();
		if(ereg('\[', $getContent)) {
			$contents = explode('[',$getContent);
			$tmpString = $contents[0];
			for($loop=1;$loop<count($contents);$loop++) {
				if(ereg('\]', $contents[$loop])) {
					$vars = explode(']', $contents[$loop]);
					$found = false;
					foreach($value as $key=>$val) {
						if($vars[0]==$key) {
							$found = true;
							$tmpString .= $value[$vars[0]];					 
						}
					}
					if(!$found) { $tmpString .= '<strong>['.$vars[0].']</strong>'; }
					$tmpString .= $vars[1];
				} else {
					$tmpString .= $contents[$loop];
				}
			}
		} else {
			$tmpString = $data;
		}
		return $tmpString;
	}
}

class ThaiDate
{
	public static function TimeStamp($isDay, $isMonth, $isYear)
	{
		return mktime(7, 0, 0, $isMonth, $isDay, $isYear);
	}
	
	public static function Full($timestamp)
	{
		$midMonth = array('Jan'=>_Jan,'Feb'=>_Feb,'Mar'=>_Mar,'Apr'=>_Apr,'May'=>_May,'Jun'=>_Jun,'Jul'=>_Jul,'Aug'=>_Aug,'Oct'=>_Oct,'Nov'=>_Nov,'Dec'=>_Dec);
		$fullMonth = array('January'=>_January,'February'=>_February,'March'=>_March,'April'=>_April,'May'=>_Mays,'June'=>_June,'July'=>_July,
						   'August'=>_August,'September'=>_September,'October'=>_October,'November'=>_November,'December'=>_December);
		$isDay = date('d',$timestamp);
		$isMonth = date('F',$timestamp);
		$isYear = date('Y',$timestamp);
		
		return _DATE_DAY.$isDay.' '.$fullMonth[$isMonth]._DATE_PS.($isYear+543);
	}	
	
	public static function Mid($timestamp)
	{
		$midMonth = array('Jan'=>_Jan,'Feb'=>_Feb,'Mar'=>_Mar,'Apr'=>_Apr,'May'=>_May,'Jun'=>_Jun,'Jul'=>_Jul,'Aug'=>_Aug,'Oct'=>_Oct,'Nov'=>_Nov,'Dec'=>_Dec);
		$fullMonth = array('January'=>_January,'February'=>_February,'March'=>_March,'April'=>_April,'May'=>_Mays,'June'=>_June,'July'=>_July,
						   'August'=>_August,'September'=>_September,'October'=>_October,'November'=>_November,'December'=>_December);
		$isDay = date('d',$timestamp);
		$isMonth = date('F',$timestamp);
		$isYear = date('Y',$timestamp);
		
		return $isDay.' '.$fullMonth[$isMonth].' '.($isYear+543);
	}	
}

?>
