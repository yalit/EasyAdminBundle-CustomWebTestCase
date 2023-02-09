Tests
======

As EasyAdmin is part, functionally testing the admin pages can leverage the
`Symfony functional testing workflow`_ extending the `WebTestCase` class.

As EasyAdmin provides already defined ways of displaying the data in its Crud pages,
a specific custom function test class has been provided : `AbstractCrudTestCase`.

.. TODO : description of the intent and objectives

Functional Test Case Example
------------------------

Suppose you have a `Dashboard`_ named `App\\Controller\\Admin\\AppDashboardController` and
an `Category Controller`_ named `App\\Controller\\Admin\\CategoryCrudController`. Here's an
example of a function test class for that Controller

.. code-block:: php

    # tests/Admin/Controller/CategoryCrudControllerTest.php
    namespace App\Tests\Admin\Controller;

    use App\Controller\Admin\CategoryCrudController;
    use App\Controller\Admin\AppDashboardController
    use EasyCorp\Bundle\EasyAdminBundle\Test\Test\AbstractCrudTestCase;

    final class CategoryCrudControllerTest extends AbstractCrudTestCase
    {
        protected function getControllerFqcn(): string
        {
            return CategoryCrudController::class;
        }

        protected function getDashboardFqcn(): string
        {
            return AppDashboardController::class;
        }

        public function testIndexPage(): void
        {
            // no use of security here, up to you to ensure the login in your test
            // in case it's necessary
            $this->client->request("GET", $this->generateIndexUrl());
            static::assertResponseIsSuccessful();
        }
    }

.. _`Symfony functional testing workflow`: https://symfony.com/doc/current/testing.html#application-tests