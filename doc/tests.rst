Tests
======

As EasyAdmin is part, functionally testing the admin pages can leverage the
`Symfony functional testing workflow`_ extending the `WebTestCase` class.

As EasyAdmin provides already defined ways of displaying the data in its Crud pages,
a specific custom function test class has been provided : `AbstractCrudTestCase`.

.. TODO : description of the intent and objectives

.. TODO : list

Functional Test Case Example
------------------------

Suppose you have a `Dashboard`_ named :code:`App\\Controller\\Admin\\AppDashboardController` and
a `Category Controller`_ named :code:`App\\Controller\\Admin\\CategoryCrudController`. Here's an
example of a function test class for that Controller

.. code-block:: php

    # tests/Admin/Controller/CategoryCrudControllerTest.php
    namespace App\Tests\Admin\Controller;

    use App\Controller\Admin\CategoryCrudController;
    use App\Controller\Admin\AppDashboardController
    use EasyCorp\Bundle\EasyAdminBundle\Test\AbstractCrudTestCase;

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
            // no use of security here, up to you to ensure the login in your test in case it's necessary
            $this->client->request("GET", $this->generateIndexUrl());
            static::assertResponseIsSuccessful();
        }
    }


Url Generation
------------------------

.. TODO : Describe the url generation trait and its functions


Asserts
------------------------

.. TODO : Describe the asserts trait and its functions


Actions
------------------------

.. TODO : Describe the actions trait and its functions


.. _`Symfony functional testing workflow`: https://symfony.com/doc/current/testing.html#application-tests
.. _Dashboard: https://symfony.com/bundles/EasyAdminBundle/4.x/dashboards.html
.. _Category Controller: https://symfony.com/bundles/EasyAdminBundle/4.x/crud.html