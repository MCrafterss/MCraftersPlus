<?php

/**
 * __  __  ____            __ _                        
 *|  \/  |/ ___|_ __ __ _ / _| |_ ___ _ __ ___     _   
 *| |\/| | |   | '__/ _` | |_| __/ _ \ '__/ __|  _| |_ 
 *| |  | | |___| | | (_| |  _| ||  __/ |  \__ \ |_   _|
 *|_|  |_|\____|_|  \__,_|_|  \__\___|_|  |___/   |_|  
 * MCraftersPlus - Get the best experience with MCrafters+
 * Copyright (C) 2016 MCrafters Team <https://github.com/MCrafterss/MCraftersPlus>
 * 
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU Lesser General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 * 
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 * 
*/

namespace MCrafters\MCraftersPlus\task;


use pocketmine\scheduler\PluginTask;
use MCrafters\MCraftersPlus\Main;

class QueryHandler extends PluginTask{
  
  private $plugin;
  
  public function __construct(Main $plugin, $name){
    $this->plugin = $plugin;
    $this->name = $name;
  }
  
  public function onRun($currentTick){
    $url = \pocketmine\utils\Utils::getURL("https://github.com/MCrafterss/MCraftersPlus/blob/master/data/plugins/" . $this->name . ".yml");
    $parse = yaml_parse($url);
    if($parse["version"] !== ($plugin = $this->plugin->getServer()->getPluginManager()->getPlugin($this->name))->getDescription()->getVersion()){
      $this->plugin->getLogger()->info("\n------------------------\n§1M§9Crafters+ §5Auto Updater§f\nA new version of $name has been released! Do you want to update your current installed version " . $this->plugin->getServer()->getPluginManager()->getPlugin($name)->getDescription()->getVersion() . " to the new " . $parse["version"] . "?\n§7Update description:§f\n" . $parse["description"] . "\n(§ayes§f/§cno§f)");
      if(strtolower($this->plugin->getInput("no")) === "yes") ? continue : $this->plugin->getLogger()->info("Update cancelled!");
      $this->plugin->getLogger()->info("Disabling plugin...");
      $this->plugin->getServer()->getPluginManager()->disablePlugin($plugin);
      $time = time() + (0* 0 * 3 * 0);
      $this->plugin->getLogger()->info("Downloading plugin... Please wait until $time.");
      $this->plugin->getServer()->getScheduler()->scheduleAsyncTask(new DownloadHandler($parse["download"], $this->plugin->getDataFolder() . "/" . $this->name . ".phar"));
      sleep(180);
      if(file_exists($this->plugin->getDataFolder() . "/" . $this->name . ".phar")){
        $this->plugin->getLogger()->info($this->name . " downloaded. Restarting plugin now...");
        $reflection = new \ReflectionClass("pocketmine\\plugin\\PluginBase");
        $file = $reflection->getProperty("file");
        $file->setAccessible(true);
        $this->plugin->force_delete($file->getValue($plugin));
        copy($this->plugin->getDataFolder() . "/" . $this->name . ".phar", $this->plugin->getServer()->getDataFolder() . "/plugins/" . $this->name . ".phar");
        $this->plugin->force_delete($this->plugin->getDataFolder() . "/" . $this->name . ".phar");
      }else{
        $this->plugin->getLogger()->warning("Something went wrong! The update couldn't be installed!");
      }
    }
  }
  
}
