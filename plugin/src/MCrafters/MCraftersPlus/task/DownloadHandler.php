<?php

namespace MCrafters\MCraftersPlus\task;

use pocketmine\scheduler\AsyncTask;
use MCrafters\MCraftersPlus\Main;

class DownloadHandler extends AsyncTask{
  
  private $plugin;
  
  public function __construct(Main $plugin){
    $this->plugin = $plugin;
  }
  
  public function onRun(){
    //download
  }
  
}
