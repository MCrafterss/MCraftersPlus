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

namespace MCrafters\MCraftersPlus;

use pocketmine\plugin\PluginBase;
use pocketmine\utils\Utils;
use MCrafters\MCraftersPlus\task\QueryHandler;

class Main extends PluginBase{
  
  public function onEnable(){
    $this->getLogger()->info("Enabling MCraftersPlus...");
    if(!is_dir($this->getDataFolder())) @mkdir($this->getDataFolder());
    if($this->connectionTest() === true){
      $this->getServer()->getScheduler()->scheduleRepeatingTask(new QueryHandler($this, $this->getMCraftersPlugin()), (30 * 60 *20));
      $this->getLogger()->info("Successfully connected to the server.");
    }else{
      $this->getLogger()->error("§cCould not connect to the server! Are you connected to the internet?");
      $this->getServer()->getPluginManager()->disablePlugin($this);
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
      $parse = json_decode(Utils::getURL("http://raw.githubusercontent.com/MCrafterss/MCraftersPlus/master/data/info/plugins.json", true));
      if($name = array_search($plugins->getDescription()->getName(), $parse)){
        return $parse[$name];
      }
    }
  }
  
  public function getInput($default = ""){
    $input = trim(fgets(STDIN));
    return $input === "" ? $default : $input;
  }
  
  /**
   * I made this to get centered text
   * Looks awesome
  */
  public function getCenteredString($string){
    $lines = explode("\n", $string);
    $length = max(array_map("mb_strlen", $lines));
    foreach($lines as &$line){
      $line = str_pad($line, $length, " ", STR_PAD_BOTH);
    }
    $centeredLine = implode("\n", $lines);
    return $centeredLine;
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
