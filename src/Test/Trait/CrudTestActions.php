<?php

declare(strict_types=1);

namespace EasyCorp\Bundle\EasyAdminBundle\Test\Trait;

use function PHPUnit\Framework\assertCount;

trait CrudTestActions
{
    protected function clickOnIndexGlobalAction(string $globalAction): void
    {
        $crawler = $this->client->getCrawler();
        $action = $crawler->filter(sprintf('.global-actions .action-%s', $globalAction));

        assertCount(1, $action, sprintf('There is no action %s in the page', $globalAction));

        $this->client->click($action->link());
    }

	protected function clickOnIndexEntityAction(string|int $entityId, string $action): void
	{
		// TODO : to implement only if extending PantherTestCase
	}

	protected function selectAllRecordOnPage(): void
	{
		// TODO : to implement only if extending PantherTestCase
	}

	/**
	 * @param array<array-key, int|string> $recordsId
	 */
	protected function selectRecordsOnPage(array $recordsId): void
	{
		// TODO : to implement only if extending PantherTestCase
	}

    /**
     * @param array<array-key, string> $entityIds
     */
    protected function clickOnIndexBatchAction(string $batchAction, array $entityIds = []): void
    {
        // TODO : to implement only if extending PantherTestCase
    }

    protected function goToNextIndexPage(): void
    {
        // TODO : to implement only if extending PantherTestCase
    }

    protected function goToPreviousIndexPage(): void
    {
        // TODO : to implement only if extending PantherTestCase
    }

    protected function clickOnMenuItem(string $menuDisplayName): void
    {
        // TODO : to implement only if extending PantherTestCase
    }
}
