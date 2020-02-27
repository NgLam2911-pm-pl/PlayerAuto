<?php

namespace LamPocketVN\PlayerAuto;

use pocketmine\plugin\PluginBase;
use pocketmine\utils\Config;
use pocketmine\Player;
use pocketmine\item\Item;

use LamPocketVN\PlayerAuto\command\AutoSellCommand;
use LamPocketVN\PlayerAuto\command\AutoFixCommand;
use LamPocketVN\PlayerAuto\command\AutoFeedCommand;
use LamPocketVN\PlayerAuto\features\AutoSell;
use LamPocketVN\PlayerAuto\features\AutoFix;
use LamPocketVN\PlayerAuto\features\AutoFeed;
use LamPocketVN\PlayerAuto\features\CreatePlayer;
use LamPocketVN\PlayerAuto\task\AutoFixTask;

/**
 * Class PlayerAuto
 * @package LamPocketVN\PlayerAuto
 */
class PlayerAuto extends PluginBase
{
    /**
     * @var $config
     */
    public $config;
    /**
     * @var $ase
     * @var $afi
     * @var $afe
     */

    public $ase, $afi, $afe = [];

    /**
     * @return mixed
     */
    public function getSetting()
    {
        return $this->cfg;
    }

    public function onEnable()
    {
        $this->saveResource("config.yml");
        $this->config = new Config($this->getDataFolder() . "config.yml", Config::YAML);
        $this->cfg = $this->config->getAll();
        $this->CreateFeatures();
    }

    public function CreateFeatures()
    {
        $this->getServer()->getPluginManager()->registerEvents(new CreatePlayer($this), $this);
        if ($this->getSetting()['features']['autosell'] === true)
        {
            $this->getServer()->getPluginManager()->registerEvents(new AutoSell($this), $this);
            $this->getServer()->getCommandMap()->register("autosell", new AutoSellCommand($this));
        }
        if ($this->getSetting()['features']['autofix'] === "event")
        {
            $this->getServer()->getPluginManager()->registerEvents(new AutoFix($this), $this);
            $this->getServer()->getCommandMap()->register("autofix", new AutoFixCommand($this));
        }
        elseif ($this->getSetting()['features']['autofix'] === "task")
        {
            $this->getServer()->getCommandMap()->register("autofix", new AutoFixCommand($this));
            $task = new AutoFixTask($this);
            $this->getScheduler()->scheduleRepeatingTask($task, 100);
        }
        if ($this->getSetting()['features']['autofeed'] === true)
        {
            $this->getServer()->getPluginManager()->registerEvents(new AutoFeed($this), $this);
            $this->getServer()->getCommandMap()->register("autosell", new AutoFeedCommand($this));
        }
    }

    /**
     * @param Player $player
     * @return bool
     */
    public function isAutoSell($player)
    {
        if ($this->ase[$player->getName()] === "on") {
            return true;
        } else {
            return false;
        }
    }

    /**
     * @param Player $player
     * @param $mode
     */
    public function setAutoSell($player, $mode)
    {
        $this->ase[$player->getName()] = $mode;
    }

    public function isAutoFeed($player)
    {
        if (isset($this->afe[$player->getName()]))
        {
            if ($this->afe[$player->getName()] === "on") {
                return true;
            } else {
                return false;
            }
        }
        else
            return false;
    }

    public function setAutoFeed($player, $mode)
    {
        $this->afe[$player->getName()] = $mode;
    }

    public function isAutoFix ($player)
    {
        if ($this->afi[$player->getName()] === "on") {
            return true;
        } else {
            return false;
        }
    }

    public function setAutoFix($player, $mode)
    {
        $this->afi[$player->getName()] = $mode;
    }
}
