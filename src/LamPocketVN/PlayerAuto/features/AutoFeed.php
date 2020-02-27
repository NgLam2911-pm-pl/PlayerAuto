<?php

namespace LamPocketVN\PlayerAuto\features;

use pocketmine\event\Listener;
use pocketmine\event\player\PlayerExhaustEvent;

use LamPocketVN\PlayerAuto\PlayerAuto;

class AutoFeed implements Listener
{
    /**
     * @var $plugin
     */
    private $plugin;

    /**
     * AutoFeed constructor.
     * @param PlayerAuto $plugin
     */
    public function __construct(PlayerAuto $plugin)
    {
        $this->plugin = $plugin;
    }

    /**
     * @param PlayerExhaustEvent $event
     */
    public function onExhaust(PlayerExhaustEvent $event)
    {
        $player = $event->getPlayer();
        if ($this->plugin->isAutoFeed($player))
        {
            $player->setFood(20);
        }
    }
}