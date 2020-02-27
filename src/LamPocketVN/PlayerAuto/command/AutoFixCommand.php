<?php

namespace LamPocketVN\PlayerAuto\command;

use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\command\PluginCommand;
use pocketmine\Player;

use LamPocketVN\PlayerAuto\PlayerAuto;


class AutoFixCommand extends PluginCommand
{
    /**
     * @var $plugin
     */
    private $plugin;

    /**
     * AutoFixCommand constructor.
     * @param PlayerAuto $plugin
     */
    public function __construct(PlayerAuto $plugin)
    {
        parent::__construct("autofix", $plugin);
        $this->setDescription('AutoFix Command');
        $this->setPermission("playerauto.autofix");
        $this->plugin = $plugin;
    }

    /**
     * @param CommandSender $sender
     * @param string $commandLabel
     * @param array $args
     * @return bool
     */
    public function execute(CommandSender $sender, string $commandLabel, array $args): bool
    {
        if(!$sender->hasPermission("playerauto.autofix"))
        {
            $sender->sendMessage("You not have premission to use this command");
            return true;
        }
        if(!$sender instanceof Player)
        {
            $sender->sendMessage("Please use this in-game.");
            return true;
        }
        if ($this->plugin->isAutoFix($sender))
        {
            $this->plugin->setAutoFix($sender, "off");
            $sender->sendMessage("AutoFix Disabled !");
        }
        else
        {
            $this->plugin->setAutoFix($sender, "on");
            $sender->sendMessage("AutoFix Enabled !");
        }
        return true;
    }
}