<?php
declare(strict_types=1);

namespace LamPocketVN\PlayerAuto\command;

use pocketmine\command\CommandSender;

use LamPocketVN\PlayerAuto\PlayerAuto;
use pocketmine\player\Player;


class AutoFixCommand extends BaseCommand
{
    private PlayerAuto $plugin;

    /**
     * AutoFixCommand constructor.
     * @param PlayerAuto $plugin
     */
    public function __construct(PlayerAuto $plugin)
    {
        parent::__construct("autofix");
        $this->setDescription('AutoFix Command');
        $this->setPermission("playerauto.autofix");
        $this->plugin = $plugin;
    }

    /**
     * @param CommandSender $sender
     * @param string $commandLabel
     * @param array $args
     */
    public function execute(CommandSender $sender, string $commandLabel, array $args): void
    {
        if(!$sender->hasPermission("playerauto.autofix"))
        {
            $sender->sendMessage("You not have premission to use this command");
            return;
        }
        if(!$sender instanceof Player)
        {
            $sender->sendMessage("Please use this in-game.");
            return;
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
    }
}