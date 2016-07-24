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

use pocketmine\scheduler\AsyncTask;

class DownloadHandler extends AsyncTask{
  
  public function __construct($url, $folder){
    $this->url = $url;
    $this->folder = $folder;
  }
  
  public function onRun(){
    if(is_string(($download = \pocketmine\utils\Utils::getURL($this->url)))){
      file_put_contents($this->folder, $download);
    }
  }
  
}
