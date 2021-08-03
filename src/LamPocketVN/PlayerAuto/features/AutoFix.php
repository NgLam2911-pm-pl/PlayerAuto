<?php
declare(strict_types=1);

namespace LamPocketVN\PlayerAuto\features;

use pocketmine\event\Listener;
use pocketmine\event\block\BlockBreakEvent;
use pocketmine\item\Tool;
use LamPocketVN\PlayerAuto\PlayerAuto;

class AutoFix implements Listener
{
    private PlayerAuto $plugin;

    /**
     * AutoFix constructor.
     * @param PlayerAuto $plugin
     */
    public function __construct(PlayerAuto $plugin)
    {
        $this->plugin = $plugin;
    }

    /**
     * @param BlockBreakEvent $event
	 * @priority HIGHEST
	 * 2@handleCancelled FALSE
     */
    public function onBreak(BlockBreakEvent $event)
    {
        $player = $event->getPlayer();
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