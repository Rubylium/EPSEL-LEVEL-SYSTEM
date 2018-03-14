<?php
namespace LevelMain;

use pocketmine\event\player\PlayerMoveEvent;
use pocketmine\plugin\PluginBase;
use pocketmine\event\player\PlayerJoinEvent;
use pocketmine\Server;
use pocketmine\utils\Config;
use pocketmine\Player;
use pocketmine\event\Listener;


class Main extends PluginBase implements Listener {


    public function onEnable() {
        @mkdir($this->getDataFolder());
        @mkdir($this->getDataFolder()."lp/");
        $this->getLogger()->info("§eESPEL Level System : §aON !");
        $this->getServer()->getCommandMap()->register("level", new LevelCommand($this, "level"));
        $this->getServer()->getPluginManager()->registerEvents($this,$this);
    }

    public function onJoin(PlayerJoinEvent $event){
        $config = new Config($this->getDataFolder()."lp/".strtolower($event->getPlayer()->getName()).".yml", Config::YAML);
        $config->save();
        if($config->get('xp') > 0){

        } else {
            Server::GetInstance()->broadcastMessage('§7§l=[ §r§bESPEL §7§l]=§r '.$event->getPlayer()->getName().'§aNous rejoins pour la première fois, bienvenue !');
            $config->set('xp',10);
            $config->set('level',1);
            $config->save();
            $event->getPlayer()->sendMessage("§7=[§r§eXXXXXXXXXXXXXXXXXXX§7]=");
            $event->getPlayer()->sendMessage("");
            $event->getPlayer()->sendMessage("§bBienvenue sur le serveur.");
            $event->getPlayer()->sendMessage("10exp sont offer pour ta première connection !");
            $event->getPlayer()->sendMessage("Bon jeux à vous !");
            $event->getPlayer()->sendMessage("");
            $event->getPlayer()->sendMessage("§7=[§r§eXXXXXXXXXXXXXXXXXXX§7]=");
        }
        $event->getPlayer()->setDisplayName('§7[§bl§e'. $config->get('level').'§7][§eP'. $config->get('prestige').'§7] '.$event->getPlayer()->getName());
    }

    public function onMove(PlayerMoveEvent $event){
        $config = new Config($this->getDataFolder()."lp/".strtolower($event->getPlayer()->getName()).".yml", Config::YAML);
        $p = $event->getPlayer();
        $n = $p->getName();
       if($config->get('level') <= 99){
           if($config->get('xp') < 100 ){
               $config->set('xp',$config->get('xp')+0.1);
               $config->save();
           } else {
               $config->set('xp',0);
               $config->set('level',$config->get('level') + 1);
               Server::GetInstance()->broadcastMessage('§7§l=[ §r§bESPEL §7§l]=§r §bWoow, §e'.$n.'§b Just went to level §e'.$config->get('level'));
               $event->getPlayer()->setDisplayName('§7[§bl§e'. $config->get('level').'§7][§eP'. $config->get('prestige').'§7] '.$event->getPlayer()->getName());
               $config->save();
           }
       }


    }

    public function onMovePrestige(PlayerMoveEvent $event){
        $config = new Config($this->getDataFolder()."lp/".strtolower($event->getPlayer()->getName()).".yml", Config::YAML);
        $p = $event->getPlayer();
        $n = $p->getName();
       if($config->get('level') >= 99){
           if($config->get('xp') < 100 ){
               $config->set('xp',$config->get('xp')+0.0);
               $config->save();
           } else {
               $config->set('level',0);
               $config->set('prestige',$config->get('level') + 1);
               Server::GetInstance()->broadcastMessage('§7§l=[ §r§bESPELeague §7§l]=§r §bWoow, §e'.$n.'§b Just went to §ePrestige §e'.$config->get('prestige'));
               $event->getPlayer()->setDisplayName('§7[§bl§e'. $config->get('level').'§7][§eP'. $config->get('prestige').'§7] '.$event->getPlayer()->getName());
               $config->save();
           }
       }


    }

}