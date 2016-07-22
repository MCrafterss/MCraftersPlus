<?php

/*
 * __  __  ____            __ _                        
 *|  \/  |/ ___|_ __ __ _ / _| |_ ___ _ __ ___     _   
 *| |\/| | |   | '__/ _` | |_| __/ _ \ '__/ __|  _| |_ 
 *| |  | | |___| | | (_| |  _| ||  __/ |  \__ \ |_   _|
 *|_|  |_|\____|_|  \__,_|_|  \__\___|_|  |___/   |_|  
 *
*/

namespace MCrafters\MCraftersPlus\task;


use pocketmine\scheduler\PluginTask;

class QueryHandler extends PluginTask{
  
  private $plugin;
  
  public function __construct(Main $plugin, $name){
    parent::__construct($plugin);
    $this->plugin = $plugin;
  }
  
  public function onRun($currentTick){
    $url = \pocketmine\utils\Utils::getURL("https://github.com/MCrafterss/MCraftersPlus/blob/master/data/plugins/$name.yml");
    $parse = yaml_parse($url);
    if($parse["version"] !== $this->plugin->getServer()->getPluginManager()->getPlugin($name)->getDescription()->getVersion()){
      $this->plugin->getLogger()->info("\n------------------------\n§1M§9Crafters+ §5Auto Updater§f\nA new version of $name has been released! Do you want to update your current installed version " . $this->plugin->getServer()->getPluginManager()->getPlugin($name)->getDescription()->getVersion() . " to the new " . $parse["version"] . "?\n§7Update description:§f\n" . $parse["description"] . "\n(§ayes§f/§cno§f)");
      if(strtolower($this->plugin->getInput("no")) === "yes") continue;
      $this->plugin->getLogger()->info("Updating plugin...");
      $this->plugin->getServer()->getScheduler()->scheduleAsyncTask(new DownloadHandler($parse["download"], $this->plugin->getDataFolder() . "/" . $filename));
    }
  }
  
}
