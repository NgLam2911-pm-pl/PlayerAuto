<?php
declare(strict_types=1);

namespace LamPocketVN\PlayerAuto\task;

use pocketmine\item\Tool;
use pocketmine\scheduler\Task;
use LamPocketVN\PlayerAuto\PlayerAuto;

class AutoFixTask extends Task
{
    private PlayerAuto $plugin;

    public function __construct(PlayerAuto $plugin)
    {
        $this->plugin = $plugin;
    }

    public function onRun(): void
    {
        foreach ($this->plugin->getServer()->getOnlinePlayers() as $player)
        {
            if ($this->plugin->isAutoFix($player))
            {
                $item = $player->getInventory()->getItemInHand();
                if ($item instanceof Tool)
                {
                    if ($item->getDamage() >= $this->plugin->getSetting()['setting']['damage'])
                    {
                        $item->setDamage(0);
                        $player->getInventory()->setItemInHand($item);
                        $player->sendMessage($this->plugin->getSetting()['msg']['auto-fix']);
                    }
                }
            }
        }
    }
}