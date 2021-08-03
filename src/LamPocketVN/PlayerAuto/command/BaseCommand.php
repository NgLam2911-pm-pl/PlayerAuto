<?php
declare(strict_types=1);

namespace LamPocketVN\PlayerAuto\command;

use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\plugin\PluginOwned;
use pocketmine\plugin\PluginOwnedTrait;

abstract class BaseCommand extends Command implements PluginOwned
{
	use PluginOwnedTrait;

	public function __construct(string $name, string $description = "", ?string $usageMessage = null, array $aliases = [])
	{
		parent::__construct($name, $description, $usageMessage, $aliases);
	}

	public function execute(CommandSender $sender, string $commandLabel, array $args)
	{
	}
}