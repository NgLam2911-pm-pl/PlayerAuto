<?php

namespace LamPocketVN\PlayerAuto\command;

use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\command\PluginCommand;
use pocketmine\Player;

use LamPocketVN\PlayerAuto\PlayerAuto;


class AutoFeedCommand extends PluginCommand
{
    /**
     * @var $plugin
     */
    private $plugin;

    /**
     * AutoFeedCommand constructor.
     * @param PlayerAuto $plugin
     */
    public function __construct(PlayerAuto $plugin)
    {
        parent::__construct("autofeed", $plugin);
        $this->setDescription('AutoFeed Command');
        $this->setPermission("playerauto.autofeed");
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
        if(!$sender->hasPermission("playerauto.autofeed"))
        {
            $sender->sendMessage("You not have premission to use this command");
            return true;
        }
        if(!$sender instanceof Player)
        {
            $sender->sendMessage("Please use this in-game.");
            return true;
        }
        if ($this->plugin->isAutoFeed($sender))
        {
            $this->plugin->setAutoFeed($sender, "off");
            $sender->sendMessage("AutoFeed Disabled !");
        }
        else
        {
            $this->plugin->setAutoFeed($sender, "on");
            $sender->sendMessage("AutoFeed Enabled !");
        }
        return true;
    }
}