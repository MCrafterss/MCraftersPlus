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
use MCrafters\MCraftersPlus\task\QueryHandler;

class Main extends PluginBase{
  
  public function onEnable(){
    $this->getLogger()->info("Enabling MCraftersPlus...");
    $this->getServer()->getScheduler()->scheduleRepeatingTask(new QueryHandler($this, $this->getMCraftersPlugin()), (30 * 60 *20));
    $this->getLogger()->info("Successfully enabled!");
  }
  
  public function onDisable(){
    $this->getLogger()->info("Disabling MCraftersPlus...");
  }
  
  public function getMCraftersPlugin(){
    foreach($this->getServer()->getPluginManager()->getPlugins() as $plugins){
      $parse = yaml_parse(\pocketmine\utils\Utils::getURL("http://raw.githubusercontent.com/MCrafterss/MCraftersPlus/master/data/info/plugins.yml"));
      if(($name = array_search($plugins->getDescription()->getName(), $parse))){
        return $name;
      }
    }
  }
  
  public function getInput($default = ""){
    $input = trim(fgets(STDIN));
    return $input === "" ? $default : $input;
  }
  
}
