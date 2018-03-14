<?php
namespace LevelMain;
use pocketmine\command\CommandSender;
use pocketmine\command\PluginCommand;
use LevelMain\Main;
use pocketmine\Server;
use pocketmine\utils\Config;
use pocketmine\utils\TextFormat as TF;
use pocketmine\Player;
class LevelCommand extends PluginCommand
{
    private $main;
    public function __construct(Main $main, $name)
    {
        parent::__construct($name, $main);
        $this->main = $main;
    }
    public function execute(CommandSender $sender, $currentAlias, array $args)
    {
        $config = new Config($this->main->getDataFolder()."lp/".strtolower($sender->getName()).".yml", Config::YAML);
        $sender->sendMessage('§e===================');
        $sender->sendMessage('§bLevel:§7 '.$config->get('level'));
        $sender->sendMessage('§bXP:§7 '.$config->get('xp').'/50');
        $sender->sendMessage('§e===================');
    }
}