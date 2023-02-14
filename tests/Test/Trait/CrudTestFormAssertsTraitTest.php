<?php

declare(strict_types=1);

namespace EasyCorp\Bundle\EasyAdminBundle\Tests\Test\Trait;

use Doctrine\ORM\EntityManagerInterface;
use EasyCorp\Bundle\EasyAdminBundle\Router\AdminUrlGenerator;
use EasyCorp\Bundle\EasyAdminBundle\Test\Trait\CrudTestFormAsserts;
use EasyCorp\Bundle\EasyAdminBundle\Test\Trait\CrudTestUrlGeneration;
use EasyCorp\Bundle\EasyAdminBundle\Tests\TestApplication\Controller\CategoryCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Tests\TestApplication\Controller\SecureDashboardController;
use PHPUnit\Framework\AssertionFailedError;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

final class CrudTestFormAssertsTraitTest extends WebTestCase
{
    use CrudTestFormAsserts;
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
        return SecureDashboardController::class;
    }

    /**
     * @dataProvider newFormFields
     */
    public function testAssertFormFieldExists(string $fieldName): void
    {
        $this->client->request('GET', self::generateNewFormUrl());

        self::assertFormFieldExists($fieldName);
    }

    /**
     * @dataProvider newFormUnknownFields
     */
    public function testAssertFormFieldExistsWithNonExistingFieldRaisesError(string $fieldName): void
    {
        $this->client->request('GET', self::generateNewFormUrl());

        self::expectException(AssertionFailedError::class);
        self::assertFormFieldExists($fieldName);
    }

    /**
     * @dataProvider newFormUnknownFields
     */
    public function testAssertFormFieldNotExists(string $fieldName): void
    {
        $this->client->request('GET', self::generateNewFormUrl());

        self::assertFormFieldNotExists($fieldName);
    }

    /**
     * @dataProvider newFormFields
     */
    public function testAssertFormFieldNotExistsWithExistingFieldsRaisesError(string $fieldName): void
    {
        $this->client->request('GET', self::generateNewFormUrl());

        self::expectException(AssertionFailedError::class);
        self::assertFormFieldNotExists($fieldName);
    }

    public function newFormFields(): \Generator
    {
        yield ['name'];
        yield ['slug'];
        yield ['active'];
    }

    public function newFormUnknownFields(): \Generator
    {
        yield ['id'];
        yield ['Technician'];
        yield ['unknown_field'];
    }
}
