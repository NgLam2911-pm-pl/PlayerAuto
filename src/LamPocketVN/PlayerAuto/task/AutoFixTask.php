<?php

namespace LamPocketVN\PlayerAuto\task;

use pocketmine\scheduler\Task;
use pocketmine\{Player, Server};
use pocketmine\item\{Item, Tool};

use LamPocketVN\PlayerAuto\PlayerAuto;

/**
 * Class AutoFixTask
 * @package LamPocketVN\PlayerAuto\task
 */
class AutoFixTask extends Task
{
    /**
     * @var $plugin
     */
    private $plugin;

    /**
     * AutoFixTask constructor.
     * @param PlayerAuto $plugin
     */
    public function __construct(PlayerAuto $plugin)
    {
        $this->plugin = $plugin;
    }

    /**
     * @param $currentick
     */
    public function onRun($currentick)
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