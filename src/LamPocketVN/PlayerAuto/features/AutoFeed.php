<?php
declare(strict_types=1);

namespace LamPocketVN\PlayerAuto\features;

use pocketmine\event\Listener;
use pocketmine\event\player\PlayerExhaustEvent;

use LamPocketVN\PlayerAuto\PlayerAuto;
use pocketmine\player\Player;

class AutoFeed implements Listener
{
    private PlayerAuto $plugin;

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
	 * @priority HIGHEST
	 * @handleCancelled FALSE
     */
    public function onExhaust(PlayerExhaustEvent $event): void
    {
        $player = $event->getPlayer();
        if (!$player instanceof Player)
		{
			return;
		}
        if ($this->plugin->isAutoFeed($player))
        {
            $player->getHungerManager()->setFood(20);
        }
    }
}