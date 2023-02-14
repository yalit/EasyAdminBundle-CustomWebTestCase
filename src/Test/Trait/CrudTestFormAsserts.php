<?php

declare(strict_types=1);

namespace EasyCorp\Bundle\EasyAdminBundle\Test\Trait;

trait CrudTestFormAsserts
{
    protected function assertFormFieldExists(string $fieldName, string $message = ''): void
    {
        $message = '' === $message ? sprintf('The field %s is not existing in the form', $fieldName) : $message;

        self::assertSelectorExists($this->getFormFieldSelector($fieldName), $message);
    }

    protected function assertFormFieldNotExists(string $fieldName, string $message = ''): void
    {
        $message = '' === $message ? sprintf('The field %s is existing in the form', $fieldName) : $message;

        self::assertSelectorNotExists($this->getFormFieldSelector($fieldName), $message);
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

    protected function getFormEntity(): string
    {
        $form = $this->client->getCrawler()->filter('form[method="post"]');

        return $form->attr('name');
    }

    protected function getFormFieldSelector(string $fieldName): string
    {
        return sprintf('form[method="post"] #%s_%s', $this->getFormEntity(), $fieldName);
    }
}
