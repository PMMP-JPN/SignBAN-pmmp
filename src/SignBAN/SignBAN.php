<?php
namespace SignBAN;
use pocketmine\Server;
use pocketmine\event\Listener;
use pocketmine\Player;
use pocketmine\plugin\PluginBase;
use pocketmine\IPlayer;
use pocketmine\block\Block;
use pocketmine\tile\Sign;
use pocketmine\event\block\SignChangeEvent;
use pocketmine\event\player\PlayerInteractEvent;
use pocketmine\scheduler\PluginTask;
use pocketmine\event\player\PlayerKickEvent;

class SignBAN extends PluginBase implements Listener{	
    private $players = array();
    public function onEnable(){
		$this->getServer()->getPluginManager()->registerEvents($this, $this);
	} 
    public function onDisable(){
    }
	
	public function playerBlockTouch(PlayerInteractEvent $event){
		$player = $event->getPlayer();
        	if($event->getBlock()->getID() == 323 || $event->getBlock()->getID() == 63 || $event->getBlock()->getID() == 68){
            	$sign = $event->getPlayer()->getLevel()->getTile($event->getBlock());
					if(!($sign instanceof Sign)){
                		return;
           			}
            		$sign = $sign->getText();
					if($player->isOp()){
						$player->sendMessage("You are OP!");
					}else{
            			if($sign[0]=='[SB]'){
							$this->ban($player);
						}elseif($sign[0]=='[SIGNBAN]')  {
							$this->ban($player);
						}elseif($sign[0]=='[JAILBREAK]')  {
							$this->ban($player);	
						}elseif($sign[0]=='[GOOUT]')  {
							$this->ban($player);
						}
				}
			}
	}

	public function ban(Player $player){
        	$reason = "You tappped SignBAN";
			$ip = $player->getAddress();
			$name = $player->getName();
			$this->getServer()->broadcastMessage("[SignBAN]Banned IP Address ".$ip);
			$player->getServer()->getIPBans()->addBan($ip,$reason, null, "SignBAN");
			$player->getServer()->getNameBans()->addBan($name,$reason, null,"SignBAN");
			$player->kick("You tapped SignBAN");
    	}
}