<?php

declare(strict_types=1);

namespace EasyCorp\Bundle\EasyAdminBundle\Test\Trait;

trait CrudTestHelpersTrait
{
	protected function getIndexEntityActionSelector(string $action, string|int $entityId): string
	{
		return $this->getIndexEntityRowSelector($entityId) . " " . $this->getActionSelector($action);
	}

	protected function getIndexEntityRowSelector(string|int $entityId): string
	{
		return sprintf('tbody tr[data-id=%s]', (string)$entityId);
	}

	protected function getActionSelector(string $action): string
	{
		return sprintf('.action-%s', $action);
	}

	protected function getGlobalActionSelector(string $action): string
	{
		return '.global-actions '.$this->getActionSelector($action);
	}
}
