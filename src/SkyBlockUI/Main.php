<?php
  
namespace SkyBlockUI;

use pocketmine\Server;
use pocketmine\Player;
use pocketmine\plugin\PluginBase;
use jojoe77777\FormAPI\CustomForm;
use jojoe77777\FormAPI\ModalForm;
use jojoe77777\FormAPI\SimpleForm;
use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\command\ConsoleCommandSender;
use pocketmine\event\Listener;
use pocketmine\event\server\ServerCommandEvent;

class Main extends PluginBase implements Listener{

    public function onLoad(): void{
        $this->getLogger()->info("SkblockUI Loading...");
    } 
  
    public function onEnable(): void{
        $this->getServer()->getPluginManager()->registerEvents(($this), $this);
        $this->getLogger()->info("SkblockUI Enabling...");
    }

    public function onDisable(): void{
        $this->getLogger()->info("SkblockUI Disabling...");
    }

    public function checkDepends(): void{
        $this->formapi = $this->getServer()->getPluginManager()->getPlugin("FormAPI");
        if(is_null($this->formapi)){
            $this->getLogger()->error("FormAPI Not Found");
            $this->getPluginLoader()->disablePlugin($this);
        }
        $this->sb = $this->getServer()->getPluginManager()->getPlugin("SkyBlock");
        if(is_null($this->sb)){
            $this->getLogger()->error("Skblock Plugin Not Found");
            $this->getPluginLoader()->disablePlugin($this);
        }
    }

    public function onCommand(CommandSender $sender, Command $cmd, string $label, array $args):bool{
        if($cmd->getName() == "is"){
            if(!($sender instanceof Player)){
                $sender->sendMessage("Opening UI...", false);
                return true;
            }
            $api = $this->getServer()->getPluginManager()->getPlugin("FormAPI");
            $form = $api->createSimpleForm(function (Player $player, $data){
                $result = $data;
                if ($result == null) {
                }
                switch ($result) {
                    case 0:
                        break;
                    case 1:
                        $this->createForm($player);
                        break;
                    case 2:
                        $this->getServer()->getCommandMap()->dispatch($player, "is go");
                        break;
                    case 3:
                        $this->getServer()->getCommandMap()->dispatch($player, "is category");
                        break;
                    case 4:
                        $this->getServer()->getCommandMap()->dispatch($player, "is blocks");
                        break;
                    case 5:
                        $this->getServer()->getCommandMap()->dispatch($player, "is disband");
                        break;
                }
            });
            $form->setTitle($this->getConfig()->get("title"));
            $form->setContent($this->getConfig()->get("content"));
			$form->addButton($this->getConfig()->get("exit-button"));
            $form->addButton($this->getConfig()->get("create-island"));
			$form->addButton($this->getConfig()->get("join-island"));
			$form->addButton($this->getConfig()->get("see-category"));
			$form->addButton($this->getConfig()->get("see-blocks"));
			$form->addButton($this->getConfig()->get("disband-island"));
			$form->sendToPlayer($sender);
        }
        return true;
    }

    public function createForm(CommandSender $sender):bool{
        if(!($sender instanceof Player)){
                $sender->sendMessage("Opening UI...", false);
                return true;
            }
        $api = $this->getServer()->getPluginManager()->getPlugin("FormAPI");
            $form = $api->createSimpleForm(function (Player $player, $data){
                $result = $data;
                if ($result == null) {
                }
                switch ($result) {
                    case 0:
                        break;
                    case 1:
                        $this->getServer()->getCommandMap()->dispatch($player, "is create basic");
                        break;
                }
            });
            $form->setTitle($this->getConfig()->get("title"));
            $form->setContent($this->getConfig()->get("create-content"));
            $form->addButton($this->getConfig()->get("exit-button"));
            $form->addButton($this->getConfig()->get("basic"), 0, "textures/blocks/grass_side_carried");
            $form->sendToPlayer($sender);
            return true;
    }
}
