<?php
declare(strict_types=1);

namespace LamPocketVN\PlayerAuto\command;

use pocketmine\command\CommandSender;

use LamPocketVN\PlayerAuto\PlayerAuto;
use pocketmine\player\Player;

class AutoSellCommand extends BaseCommand
{
    private PlayerAuto $plugin;

    /**
     * AutoSellCommand constructor.
     * @param PlayerAuto $plugin
     */
    public function __construct(PlayerAuto $plugin)
    {
        parent::__construct("autosell");
        $this->setDescription('AutoSell Command');
        $this->setPermission("playerauto.autosell");
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
        if(!$sender->hasPermission("playerauto.autosell"))
        {
            $sender->sendMessage("You not have premission to use this command");
            return true;
        }
        if(!$sender instanceof Player)
        {
            $sender->sendMessage("Please use this in-game.");
            return true;
        }
        if ($this->plugin->isAutoSell($sender))
        {
            $this->plugin->setAutoSell($sender, "off");
            $sender->sendMessage("AutoSell Disabled !");
        }
        else
        {
            $this->plugin->setAutoSell($sender, "on");
            $sender->sendMessage("AutoSell Enabled !");
        }
        return true;
    }
}