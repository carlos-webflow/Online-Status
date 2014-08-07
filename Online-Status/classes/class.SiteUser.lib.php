<?php
/**
 * WORKING WITH CLASSES
 */
	class SiteUser
	{
		public $data = array();
        public $dir = './onlineusers/';
		public function __construct()
		{
			return ( '{' . __METHOD__ . '}' );
		}
		public function login($user,$id)
		{
			$this->data['name'] = $user;
            $this->data['id'] = $id;
		}
		public function online($user,$status)
		{
			$this->data['status'] = $status;
            if(!is_dir($this->dir)){ mkdir($this->dir, 0777); }
			$fp = fopen($this->dir.$user,'wb'); fwrite($fp,$status); fclose($fp);
			$onlineNow = array();
			$awayNow = array();
			$usersonline = scandir($this->dir);
			foreach($usersonline as $useronline){
				if(time() > filemtime($this->dir.$useronline)+300 && ($useronline!='.' || $useronline!='..')){
					unlink($this->dir.$useronline);
				}else{
					if($useronline!='.' || $useronline!='..'){
						$status = file_get_contents($this->dir.$useronline);
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