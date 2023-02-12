<?php

declare(strict_types=1);

namespace EasyCorp\Bundle\EasyAdminBundle\Tests\Test\Trait;

use Doctrine\ORM\EntityManagerInterface;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Router\AdminUrlGenerator;
use EasyCorp\Bundle\EasyAdminBundle\Test\Trait\CrudTestAsserts;
use EasyCorp\Bundle\EasyAdminBundle\Test\Trait\CrudTestUrlGeneration;
use EasyCorp\Bundle\EasyAdminBundle\Tests\TestApplication\Controller\CategoryCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Tests\TestApplication\Controller\DashboardController;
use EasyCorp\Bundle\EasyAdminBundle\Tests\TestApplication\Entity\Category;
use PHPUnit\Framework\AssertionFailedError;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

final class CrudTestAssertsTraitTest extends WebTestCase
{
    use CrudTestAsserts;
    use CrudTestUrlGeneration;

    protected KernelBrowser $client;
    protected AdminUrlGenerator $adminUrlGenerator;
    protected EntityManagerInterface $entityManager;

    protected function setUp(): void
    {
        $this->client = static::createClient();
        $this->client->followRedirects();
        $this->client->setServerParameters(['PHP_AUTH_USER' => 'admin', 'PHP_AUTH_PW' => '1234']);

        $container = static::getContainer();
        $this->entityManager = $container->get(EntityManagerInterface::class);
        $this->adminUrlGenerator = $container->get(AdminUrlGenerator::class);
    }

    /**
     * @return string returns the tested Controller Fqcn
     */
    protected function getControllerFqcn(): string
    {
        return CategoryCrudController::class;
    }

    /**
     * @return string returns the tested Controller Fqcn
     */
    protected function getDashboardFqcn(): string
    {
        return DashboardController::class;
    }

    public function testAssertFullEntityIndexCount(): void
    {
        $this->client->request('GET', $this->generateIndexUrl());

        $allCategories = $this->entityManager->getRepository(Category::class)->findAll();
        self::assertIndexFullEntityCount(\count($allCategories));
    }

    public function testAssertIncorrectFullEntityIndexCountRaisesError(): void
    {
        $this->client->request('GET', $this->generateIndexUrl());

        $this->expectException(AssertionFailedError::class);

        $allCategories = $this->entityManager->getRepository(Category::class)->findAll();
        self::assertIndexFullEntityCount($this->count($allCategories) + 1);
    }

    public function testAssertZeroFullEntityIndexCountRaisesError(): void
    {
        $this->client->request('GET', $this->generateIndexUrl());

        $this->expectException(AssertionFailedError::class);
        self::assertIndexFullEntityCount(0);
    }

    public function testAssertNegativeFullEntityIndexCountRaisesError(): void
    {
        $this->client->request('GET', $this->generateIndexUrl());

        $this->expectException(\InvalidArgumentException::class);
        self::assertIndexFullEntityCount(-1);
    }

    public function testAssertIndexPageEntityCountIsCorrect(): void
    {
        $this->client->request('GET', $this->generateIndexUrl());
        $this->assertIndexPageEntityCount(20); // 20 items per page is the default for EasyAdmin
    }

    /**
     * @dataProvider pageEntityIncorrectCount
     */
    public function testAssertIndexPageEntityIncorrectCountRaisesError(int $incorrectCount, string $expectedException): void
    {
        $this->client->request('GET', $this->generateIndexUrl());

        $this->expectException($expectedException);
        $this->assertIndexPageEntityCount($incorrectCount);
    }

    public function pageEntityIncorrectCount(): \Generator
    {
        // 20 items per page is the default for EasyAdmin
        yield [0, AssertionFailedError::class];
        yield [-10, \InvalidArgumentException::class];
        yield [21, AssertionFailedError::class];
        yield [30, AssertionFailedError::class];
    }

    public function testAssertIndexPagesCountIsCorrect(): void
    {
        $this->client->request('GET', $this->generateIndexUrl());

        $allCategories = $this->entityManager->getRepository(Category::class)->findAll();
        self::assertIndexPagesCount((int) ceil(\count($allCategories) / 20)); // 20 items per page is the default for EasyAdmin
    }

    /**
     * @dataProvider pageIncorrectCount
     */
    public function testAssertIndexPagesIncorrectCountRaisesError(int $incorrectCount, string $expectedException): void
    {
        $this->client->request('GET', $this->generateIndexUrl());

        self::expectException($expectedException);
        self::assertIndexPagesCount($incorrectCount);
    }

    public function pageIncorrectCount(): \Generator
    {
        // 20 items per page is the default for EasyAdmin
        yield [0, \InvalidArgumentException::class];
        yield [-10, \InvalidArgumentException::class];
        yield [3, AssertionFailedError::class];
        yield [1, AssertionFailedError::class];
        yield [30, AssertionFailedError::class];
    }

    public function testAssertIndexEntityActionExistsForEntity(): void
    {
        $this->client->request('GET', $this->generateIndexUrl());
        $this->assertIndexEntityActionExistsForEntity(Action::EDIT, 1);
        $this->assertIndexEntityActionExistsForEntity(Action::DELETE, 1);
    }

    public function testAssertIndexEntityIncorrectActionExistsForEntityRaisesError(): void
    {
        $this->client->request('GET', $this->generateIndexUrl());
        self::expectException(AssertionFailedError::class);
        $this->assertIndexEntityActionExistsForEntity(Action::INDEX, 1);

        self::expectException(AssertionFailedError::class);
        $this->assertIndexEntityActionExistsForEntity('IncorrectAction', 1);
    }

    public function testAssertIndexIncorrectEntityActionExistsForEntityRaisesError(): void
    {
        $this->client->request('GET', $this->generateIndexUrl());

        self::expectException(AssertionFailedError::class);
        $this->assertIndexEntityActionExistsForEntity(Action::EDIT, 0);
    }

    public function testAssertNotIndexEntityActionExistsForEntity(): void
    {
        $this->client->request('GET', $this->generateIndexUrl());
        $this->assertNotIndexEntityActionExistsForEntity(Action::INDEX, 1);
        $this->assertNotIndexEntityActionExistsForEntity('IncorrectAction', 1);
    }

    public function testAssertNotIndexEntityIncorrectActionExistsForEntityRaisesError(): void
    {
        $this->client->request('GET', $this->generateIndexUrl());
        self::expectException(AssertionFailedError::class);
        $this->assertNotIndexEntityActionExistsForEntity(Action::EDIT, 1);

        self::expectException(AssertionFailedError::class);
        $this->assertNotIndexEntityActionExistsForEntity(Action::DELETE, 1);
    }

    public function testAssertNotIndexIncorrectEntityActionExistsForEntityRaisesError(): void
    {
        $this->client->request('GET', $this->generateIndexUrl());

        self::expectException(AssertionFailedError::class);
        $this->assertNotIndexEntityActionExistsForEntity(Action::INDEX, 0);
    }
}
