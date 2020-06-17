<?php

class Robot
{
	
	public const batteryLife=60; // In seconds
	public const batteryChargingTime=30; // In seconds
	public $batteryflag=1; // battery status
	public $cleanedfloorCnt=0;
	function clean(string $floor,int $area){
		
		switch ($floor) {
			case "hard":
						$currentStateSeconds=1;
						$this->test($area,$currentStateSeconds);
					
			  break;
			case "carpet":
						$currentStateSeconds=2;
						$this->test($area,$currentStateSeconds);
						
			  break;
			default:
			  echo "Please provide the valid state.";
		  }

	}

	public function test(int $area,int $currentStateSeconds){
		ob_implicit_flush(true);
		@ob_end_flush();
		
		echo 'Floor is getting clean'."\n";
		
		for($cnt=$currentStateSeconds;$cnt<=self::batteryLife;$cnt+=$currentStateSeconds){
			 
			if($this->cleanedfloorCnt<=$area){
			sleep($currentStateSeconds);  // time taking to clean 1 m2
			$this->cleanedfloorCnt=$this->cleanedfloorCnt+1;
			
			if($cnt>=self::batteryLife){
				echo 'Floor cleaned count is - '.$this->cleanedfloorCnt."\n";
				$this->batteryflag=0;  // battery getting discharged
				
			}else{
				$this->batteryflag=1;  //  battery is charged
				
			}

			
			if($this->batteryflag==0){  // after battery discharged functionality
				echo 'Now batterry is getting charged'."\n";
				sleep(self::batteryChargingTime);
				$this->batteryflag=1;
				if($this->cleanedfloorCnt<$area){
				$this->test($area,$currentStateSeconds);
				}
			}
		
		}
			if($this->cleanedfloorCnt==$area){
				echo 'Floor cleaned count is - '.$this->cleanedfloorCnt."\n";
				exit;
			}
			
	}
}


}

$robo=new Robot();
//$robo->clean('carpet',95);
$my_args = array();
for ($i = 1; $i < count($argv); $i++) {  // for parsing function argument 
    if (preg_match('/^--([^=]+)=(.*)/', $argv[$i], $match)) {
        $my_args[$match[1]] = $match[2];
    }
}
$fun=$argv[1];
if (!is_numeric($my_args['area'])) { // type hinting exception handle with custom message
	echo $my_args['area'] ." must be a number";
	exit;
}
$robo->$fun($my_args['floor'],$my_args['area']); // call methods with param from command line




?>
