Tests
======

As EasyAdmin is part, functionally testing the admin pages can leverage the
`Symfony functional testing workflow`_ extending the `WebTestCase` class.

As EasyAdmin provides already defined ways of displaying the data in its Crud pages,
a specific custom function test class has been provided : `AbstractCrudTestCase`. The
class is based on specific traits which defines specific asserts and specific selector helpers.


1. `Functional Test Case Example`_
2. `Url Generation`_
3. `Asserts`_
4. `Actions`_
5. `Selector Helpers`_


Functional Test Case Example
-------------------------------------------

Suppose you have a `Dashboard`_ named :code:`App\\Controller\\Admin\\AppDashboardController` and
a `Category Controller`_ named :code:`App\\Controller\\Admin\\CategoryCrudController`. Here's an
example of a function test class for that Controller.

First, your test class need to extend the class `AbstractCrudTestCase`.  

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
Used by the `AbstractCrudTestCase`, is an url generation trait which helps to generate the specific of
the EasyAdmin urls.

.. tip:: 

    The trait can, of course, be used on its own but in that case, the class that is using it need or:

    - to define the 2 functions :code:`getControllerFqcn` and :code:`getDashboardFqcn`
    - to add the DashboardControllerFqcn and ControllerFQcn as input to the url generation functions

Here is the list of the url generation functions that are all providing url based on provided Dashboard 
& Controller class names:

- `getCrudUrl` : is the main function that allows for a complete generation with all possible options.
- `generateIndexUrl` : generates the url for the index page (based on the Dashboard and Controller defined)
- `generateNewFormUrl` : generates the url for the New form page (based on the Dashboard and Controller defined)
- `generateEditFormUrl` : generates the url for the Edit form page of a specific entity (based on the Dashboard and Controller defined and the entity Id)
- `generateDetailUrl` : generates the url for the Detail page of a specific entity (based on the Dashboard and Controller defined and the entity Id)
- `generateFilterRenderUrl` : generates the url to get the rendering of the filters (based on the Dashboard and Controller defined)


Asserts
------------------------

.. TODO : Describe the asserts trait and its functions


Actions
------------------------

.. TODO : Describe the actions trait and its functions


Selector Helpers
------------------------

.. _`Symfony functional testing workflow`: https://symfony.com/doc/current/testing.html#application-tests
.. _Dashboard: https://symfony.com/bundles/EasyAdminBundle/4.x/dashboards.html
.. _Category Controller: https://symfony.com/bundles/EasyAdminBundle/4.x/crud.html