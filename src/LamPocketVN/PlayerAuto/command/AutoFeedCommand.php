<?php
declare(strict_types=1);

namespace LamPocketVN\PlayerAuto\command;

use pocketmine\command\CommandSender;

use LamPocketVN\PlayerAuto\PlayerAuto;
use pocketmine\player\Player;


class AutoFeedCommand extends BaseCommand
{
    private PlayerAuto $plugin;

    /**
     * AutoFeedCommand constructor.
     * @param PlayerAuto $plugin
     */
    public function __construct(PlayerAuto $plugin)
    {
        parent::__construct("autofeed");
        $this->setDescription('AutoFeed Command');
        $this->setPermission("playerauto.autofeed");
        $this->plugin = $plugin;
    }

    /**
     * @param CommandSender $sender
     * @param string $commandLabel
     * @param array $args
     */
    public function execute(CommandSender $sender, string $commandLabel, array $args): void
    {
        if(!$sender->hasPermission("playerauto.autofeed"))
        {
            $sender->sendMessage("You not have premission to use this command");
            return;
        }
        if(!$sender instanceof Player)
        {
            $sender->sendMessage("Please use this in-game.");
            return;
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
    }
}