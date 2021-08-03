<?php
declare(strict_types=1);

namespace LamPocketVN\PlayerAuto\features;

use pocketmine\event\Listener;
use pocketmine\event\player\PlayerJoinEvent;

use LamPocketVN\PlayerAuto\PlayerAuto;

class CreatePlayer implements Listener
{
    private PlayerAuto $plugin;
    /**
     * CreatePlayer constructor.
     * @param PlayerAuto $plugin
     */
    public function __construct(PlayerAuto $plugin)
    {
        $this->plugin = $plugin;
    }
    /**
     * Create data went player join :3
     * @param PlayerJoinEvent $event
     */
    public function onJoin (PlayerJoinEvent $event)
    {
        $player = $event->getPlayer();
        $this->plugin->setAutoSell($player, "off");
        $this->plugin->setAutoFeed($player, "off");
        $this->plugin->setAutoFix($player, "off");
    }
}