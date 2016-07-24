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
use pocketmine\utils\Utils;
use MCrafters\MCraftersPlus\task\QueryHandler;

class Main extends PluginBase{
  
  public function onEnable(){
    $this->getLogger()->info("Enabling MCraftersPlus...");
    if($this->connectionTest() === true){
      $this->getServer()->getScheduler()->scheduleRepeatingTask(new QueryHandler($this, $this->getMCraftersPlugin()), (30 * 60 *20));
      $this->getLogger()->info("Successfully connected to the server.");
    }else{
      $this->getLogger()->info("§cCould not connect to the server! Are you connected to the internet?");
    }
  }
  
  public function onDisable(){
    $this->getLogger()->info("Disabling MCraftersPlus...");
  }
  
  public function connectionTest(){
    if(Utils::getURL("http://raw.githubusercontent.com/MCrafterss/MCraftersPlus/master/data/info/connection.txt", 10) === \false){
      return false;
    }else{
      return true;
    }
  }
  
  public function getMCraftersPlugin(){
    foreach($this->getServer()->getPluginManager()->getPlugins() as $plugins){
      $parse = yaml_parse(Utils::getURL("http://raw.githubusercontent.com/MCrafterss/MCraftersPlus/master/data/info/plugins.yml"));
      if(($name = array_search($plugins->getDescription()->getName(), $parse))){
        return $name;
      }
    }
  }
  
  public function getInput($default = ""){
    $input = trim(fgets(STDIN));
    return $input === "" ? $default : $input;
  }
  
  /**
   * This function will delete file(s) and/or directories.
   * This will even delete sub-directories,
   * so use it carefully.
   */
  protected function force_delete($target){
    if(is_dir($target)){
      $files = glob($target . '*', GLOB_MARK );
      foreach($files as $file){
        $this->force_delete($file);
      }
      rmdir($target);
    }elseif(is_file($target)){
      unlink($target);  
    }else{
      return false;
    }
  }
  
}
