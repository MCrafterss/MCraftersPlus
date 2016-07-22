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

use pocketmine\scheduler\AsyncTask;
use MCrafters\MCraftersPlus\Main;

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
