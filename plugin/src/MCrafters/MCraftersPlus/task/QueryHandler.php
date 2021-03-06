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
      $this->plugin->getLogger()->info($this->plugin->getCenteredString("\n------------------------\n§1M§9Crafters+ §5Auto Updater§f\nA new version of $name has been released! Do you want to update your current installed version " . $this->plugin->getServer()->getPluginManager()->getPlugin($name)->getDescription()->getVersion() . " to the new " . $parse["version"] . "?\n§7Update description:§f\n" . $parse["description"] . "\n(§ayes§f/§cno§f)"));
      if($this->plugin->getConfig()->get("force_auto_update")){
        $this->plugin->getLogger()->info("Force Auto Update enabled! Updating now...");
      }else{
        if(strtolower($this->plugin->getInput("no")) === "yes"){
          // continue
        }else{
          $this->plugin->getLogger()->info("Update cancelled!");
          return;
        }
      }
      $this->plugin->getLogger()->info("Disabling plugin...");
      $this->plugin->getServer()->getPluginManager()->disablePlugin($plugin);
      $this->plugin->getLogger()->info("Downloading plugin... Please wait...");
      $this->plugin->getServer()->getScheduler()->scheduleAsyncTask(new DownloadHandler($parse["download"], $this->plugin->getDataFolder() . "/" . $this->name . ".phar"));
      sleep($this->plugin->getConfig()->get("download_time"));
      if(file_exists($this->plugin->getDataFolder() . "/" . $this->name . ".phar")){
        $this->plugin->getLogger()->info($this->name . " downloaded. Restarting plugin now...");
        $this->plugin->getServer()->forceShutdown();
        sleep(1);
        $reflection = new \ReflectionClass("pocketmine\\plugin\\PluginBase");
        $file = $reflection->getProperty("file");
        $file->setAccessible(true);
        $this->plugin->force_delete($file->getValue($plugin));
        copy($this->plugin->getDataFolder() . "/" . $this->name . ".phar", $this->plugin->getServer()->getDataFolder() . "/plugins/" . $this->name . ".phar");
        $this->plugin->force_delete($this->plugin->getDataFolder() . "/" . $this->name . ".phar");
        shell_exec($this->plugin->getConfig()->get("start_exec"));
      }else{
        $this->plugin->getLogger()->warning("Something went wrong! The update couldn't be installed!");
      }
    }
  }
  
}
