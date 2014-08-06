<?php
/**
 * WORKING WITH CLASSES
 */
	class SiteUser
	{
		public $data = array();
		public function __construct()
		{
			return ( '{' . __METHOD__ . '}' );
		}
		public function login($user)
		{
			$this->data['name'] = $user;
		}
		public function online($user,$status)
		{
			$this->data['status'] = $status;
			$fp = fopen('./onlineusers/'.$user,'wb'); fwrite($fp,$status); fclose($fp);
			$onlineNow = array();
			$awayNow = array();
			$usersonline = scandir('./onlineusers/');
			foreach($usersonline as $useronline){
				if(time() > filemtime('./onlineusers/'.$useronline)+300 && ($useronline!='.' || $useronline!='..')){
					unlink('./onlineusers/'.$useronline);
				}else{
					if($useronline!='.' || $useronline!='..'){
						$status = file_get_contents('./onlineusers/'.$useronline);
						if($status=='online'){	array_push($onlineNow, $useronline); }
						if($status=='away'){	array_push($awayNow, $useronline); }
					}
				}
			}
			$statusNow = array('onlineNow'=>$onlineNow, 'awayNow'=>$awayNow);
			return($statusNow);
		}
	}
?>