<?php

declare(strict_types=1);

namespace EasyCorp\Bundle\EasyAdminBundle\Test\Trait;

// TODO : implement TODOs
use function PHPUnit\Framework\assertCount;

trait CrudTestAsserts
{
    use CrudTestHelpersTrait;

    protected static function assertIndexFullEntityCount(int $expectedIndexFullEntityCount, string $message = ''): void
    {
        if (0 > $expectedIndexFullEntityCount) {
            throw new \InvalidArgumentException();
        }

        if (0 === $expectedIndexFullEntityCount) {
            $message = '' !== $message ? $message : 'There should be no results found in the index table';
            static::assertSelectorTextSame('.no-results', 'No results found.', $message);
        } else {
            $message = '' !== $message ? $message : sprintf('There should be a total of %d results found in the index table', $expectedIndexFullEntityCount);
            static::assertSelectorNotExists('.no-results');
            static::assertSelectorTextSame('.list-pagination-counter strong', (string) $expectedIndexFullEntityCount, $message);
        }
    }

    protected function assertIndexPageEntityCount(int $expectedIndexPageEntityCount, string $message = ''): void
    {
        if (0 > $expectedIndexPageEntityCount) {
            throw new \InvalidArgumentException();
        }

        if (0 === $expectedIndexPageEntityCount) {
            $message = '' !== $message ? $message : 'There should be no results found in the index table';
            static::assertSelectorExists('tr.no-results', $message);
        } else {
            $message = '' !== $message ? $message : sprintf('There should be %d results found in the current index page', $expectedIndexPageEntityCount);
            static::assertSelectorNotExists('tr.no-results', );
            static::assertSelectorExists('tbody tr');
            $indexPageEntityRows = $this->client->getCrawler()->filter('tbody tr');
            static::assertEquals($expectedIndexPageEntityCount, $indexPageEntityRows->count(), $message);
        }
    }

    protected function assertIndexPagesCount(int $expectedIndexPagesCount, string $message = ''): void
    {
        if (0 >= $expectedIndexPagesCount) {
            throw new \InvalidArgumentException();
        }

        $crawler = $this->client->getCrawler();
        $message = '' !== $message ? $message : sprintf('There should be a total of %d pages in the index page', $expectedIndexPagesCount);

        $pageItemsSelector = '.list-pagination-paginator ul.pagination li.page-item';
        static::assertSelectorExists($pageItemsSelector);

        $pageItems = $crawler->filter($pageItemsSelector);
        $lastNumberedPageItem = $pageItems->slice($pageItems->count() - 2, 1);
        static::assertEquals((string) $expectedIndexPagesCount, $lastNumberedPageItem->filter('a')->text(), $message);
    }

    protected function assertIndexEntityActionExists(string $action, string|int $entityId, string $message = ''): void
    {
        $message = '' === $message ? sprintf('The action %s has not been found for entity id %s', $action, (string) $entityId) : $message;

        $entityRow = $this->client->getCrawler()->filter($this->getIndexEntityRowSelector($entityId));
        self::assertCount(1, $entityRow, sprintf('The entity %s is not existing in the table', (string) $entityId));

        $action = $entityRow->first()->filter($this->getActionSelector($action));
        assertCount(1, $action, $message);
    }

    protected function assertNotIndexEntityActionExists(string $action, string|int $entityId, string $message = ''): void
    {
        $message = '' === $message ? sprintf('The action %s has been found for entity id %s', $action, (string) $entityId) : $message;

        $entityRow = $this->client->getCrawler()->filter($this->getIndexEntityRowSelector($entityId));
        self::assertCount(1, $entityRow, sprintf('The entity %s is not existing in the table', (string) $entityId));

        $action = $entityRow->first()->filter($this->getActionSelector($action));
        assertCount(0, $action, $message);
    }

    protected function assertIndexEntityActionTextSame(string $action, string $actionDisplay, string|int $entityId, string $message = ''): void
    {
        $this->assertIndexEntityActionExists($action, $entityId);

        $message = '' === $message ? sprintf('The action %s is not labelled with the following text : %s', $action, $actionDisplay) : $message;
        self::assertSelectorTextSame($this->getIndexEntityActionSelector($action, $entityId), $actionDisplay, $message);
    }

    protected function assertIndexEntityActionNotTextSame(string $action, string $actionDisplay, string|int $entityId, string $message = ''): void
    {
        $this->assertIndexEntityActionExists($action, $entityId);

        $message = '' === $message ? sprintf('The action %s is labelled with the following text : %s', $action, $actionDisplay) : $message;
        self::assertSelectorTextNotContains($this->getIndexEntityActionSelector($action, $entityId), $actionDisplay, $message);
    }

    // TODO : add messages to the 4 below functions
    protected function assertGlobalActionExists(string $action): void
    {
        self::assertSelectorExists($this->getGlobalActionSelector($action));
    }

    protected function assertGlobalActionNotExists(string $action): void
    {
        self::assertSelectorNotExists($this->getGlobalActionSelector($action));
    }

    protected function assertGlobalActionDisplays(string $action, string $actionDisplay): void
    {
        self::assertSelectorTextSame($this->getGlobalActionSelector($action), $actionDisplay);
    }

    protected function assertGlobalActionNotDisplays(string $action, string $actionDisplay): void
    {
        self::assertSelectorTextNotContains($this->getGlobalActionSelector($action), $actionDisplay);
    }

    protected function assertIndexColumnExists(string $columnName, string $message = ''): void
    {
        $message = '' === $message ? sprintf('The column %s is not existing', $columnName) : $message;
        self::assertSelectorExists($this->getIndexHeaderColumnSelector($columnName));
    }

    protected function assertIndexColumnNotExists(string $columnName, string $message = ''): void
    {
        $message = '' === $message ? sprintf('The column %s is existing', $columnName) : $message;
        self::assertSelectorNotExists($this->getIndexHeaderColumnSelector($columnName));
    }

    protected function assertColumnHeaderContains(string $columnName, string $columnHeaderValue, string $message = ''): void
    {
        $message = '' === $message ? sprintf('The column %s does not contain %s', $columnName, $columnHeaderValue) : $message;
        self::assertSelectorTextSame($this->getIndexHeaderColumnSelector($columnName), $columnHeaderValue);
    }

    protected function assertNotColumnHeaderContains(string $columnName, string $columnHeaderValue): void
    {
        // TODO : to implement
    }

    protected function assertFormFieldExists(string $fieldName): void
    {
        // TODO : to implement
    }

    protected function assertFormFieldNotExists(string $fieldName): void
    {
        // TODO : to implement
    }

    protected function assertFormFieldHasLabel(string $fieldName, string $label): void
    {
        // TODO : to implement
    }

    protected function assertFormFieldNotHasLabel(string $fieldName, string $label): void
    {
        // TODO : to implement
    }

    protected function assertFormFieldHasValue(string $fieldName, string|int|bool $value): void
    {
        // TODO : to implement
    }

    protected function assertFormFieldNotHasValue(string $fieldName, string|int|bool $value): void
    {
        // TODO : to implement
    }

    protected function assertFormFieldIsDisplayed(string $fieldName): void
    {
        // TODO : to implement
    }

    protected function assertFormFieldIsHidden(string $fieldName): void
    {
        // TODO : to implement
    }
}
