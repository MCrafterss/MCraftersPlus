<?php

/*
 * __  __  ____            __ _                        
 *|  \/  |/ ___|_ __ __ _ / _| |_ ___ _ __ ___     _   
 *| |\/| | |   | '__/ _` | |_| __/ _ \ '__/ __|  _| |_ 
 *| |  | | |___| | | (_| |  _| ||  __/ |  \__ \ |_   _|
 *|_|  |_|\____|_|  \__,_|_|  \__\___|_|  |___/   |_|  
 *
*/

namespace MCrafters\MCraftersPlus;

use pocketmine\plugin\PluginBase;

class Main extends PluginBase{
  
  public function onEnable(){
    $this->getLogger()->info("Enabling MCraftersPlus...");
  }
  
  public function onDisable(){
    $this->getLogger()->info("Disabling MCraftersPlus...");
  }
  
  public function getInput($default = ""){
		$input = \trim(\fgets(STDIN));
		return $input === "" ? $default : $input;
	}
  
}
