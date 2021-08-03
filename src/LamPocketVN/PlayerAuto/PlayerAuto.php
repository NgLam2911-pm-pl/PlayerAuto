<?php
declare(strict_types=1);

namespace LamPocketVN\PlayerAuto;

use pocketmine\player\Player;
use pocketmine\plugin\PluginBase;
use pocketmine\utils\Config;
use LamPocketVN\PlayerAuto\command\AutoSellCommand;
use LamPocketVN\PlayerAuto\command\AutoFixCommand;
use LamPocketVN\PlayerAuto\command\AutoFeedCommand;
use LamPocketVN\PlayerAuto\features\AutoSell;
use LamPocketVN\PlayerAuto\features\AutoFix;
use LamPocketVN\PlayerAuto\features\AutoFeed;
use LamPocketVN\PlayerAuto\features\CreatePlayer;
use LamPocketVN\PlayerAuto\task\AutoFixTask;

class PlayerAuto extends PluginBase
{
    public Config $config;

    public array $ase, $afi, $afe = [];

    public array $cfg;

    public function getSetting(): array
    {
        return $this->cfg;
    }

    public function onEnable(): void
    {
        $this->saveResource("config.yml");
        $this->config = new Config($this->getDataFolder() . "config.yml", Config::YAML);
        $this->cfg = $this->config->getAll();
        $this->CreateFeatures();
    }

    public function CreateFeatures(): void
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

    public function isAutoSell(Player $player): bool
    {
        if ($this->ase[$player->getName()] === "on") {
            return true;
        } else {
            return false;
        }
    }

    public function setAutoSell(Player $player, $mode): void
    {
        $this->ase[$player->getName()] = $mode;
    }

    public function isAutoFeed(Player $player): bool
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

    public function setAutoFeed(Player $player, $mode): void
    {
        $this->afe[$player->getName()] = $mode;
    }

    public function isAutoFix (Player $player): bool
    {
        if ($this->afi[$player->getName()] === "on") {
            return true;
        } else {
            return false;
        }
    }

    public function setAutoFix($player, $mode): void
    {
        $this->afi[$player->getName()] = $mode;
    }
}
