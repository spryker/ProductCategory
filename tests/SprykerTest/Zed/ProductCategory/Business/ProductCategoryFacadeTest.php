<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerTest\Zed\ProductCategory\Business;

use Codeception\Test\Unit;
use Spryker\Zed\ProductCategory\Business\ProductCategoryFacadeInterface;

/**
 * Auto-generated group annotations
 *
 * @group SprykerTest
 * @group Zed
 * @group ProductCategory
 * @group Business
 * @group Facade
 * @group ProductCategoryFacadeTest
 * Add your own group annotations below this line
 */
class ProductCategoryFacadeTest extends Unit
{
    /**
     * @var \SprykerTest\Zed\ProductCategory\ProductCategoryBusinessTester
     */
    protected $tester;

    /**
     * @return void
     */
    public function testGetProductConcreteIdsByCategoryIdsReturnArrayOfIdsOfAssignedConcretes(): void
    {
        // Arrange
        $categoryTransfer = $this->tester->haveCategory();
        $productTransfer = $this->tester->haveProduct();

        $this->tester->assignProductToCategory($categoryTransfer->getIdCategory(), $productTransfer->getFkProductAbstract());

        // Act
        $productConcreteIds = $this->getProductCategoryFacade()
            ->getProductConcreteIdsByCategoryIds([$categoryTransfer->getIdCategory()]);

        // Assert
        $this->assertIsArray($productConcreteIds);
        $this->assertEquals([$productTransfer->getIdProductConcrete()], $productConcreteIds);
    }

    /**
     * @return void
     */
    public function testGetProductConcreteIdsByCategoryIdsReturnsEmptyArrayWhenNoProductsAssignedToCategory(): void
    {
        // Arrange
        $categoryTransfer = $this->tester->haveCategory();

        // Act
        $productConcreteIds = $this->getProductCategoryFacade()
            ->getProductConcreteIdsByCategoryIds([$categoryTransfer->getIdCategory()]);

        // Assert
        $this->assertIsArray($productConcreteIds);
        $this->assertEmpty($productConcreteIds);
    }

    /**
     * @return void
     */
    public function testGetLocalizedProductAbstractNamesByCategoryWillReturnLocalizedProductsNamesByCategory(): void
    {
        // Arrange
        $categoryTransfer = $this->tester->haveCategory();
        $productTransfer = $this->tester->haveFullProduct();
        $localeTransfer = $this->tester->getCurrentLocale();

        $expectedProductName = sprintf(
            '%s (%s)',
            $productTransfer->getLocalizedAttributes()[0]->getName(),
            $productTransfer->getAbstractSku()
        );

        $this->tester->assignProductToCategory($categoryTransfer->getIdCategory(), $productTransfer->getFkProductAbstract());

        // Act
        $productNames = $this->getProductCategoryFacade()
            ->getLocalizedProductAbstractNamesByCategory($categoryTransfer, $localeTransfer);

        // Arrange
        $this->assertTrue(in_array($expectedProductName, $productNames), 'Localized product name should be found.');
    }

    /**
     * @return \Spryker\Zed\ProductCategory\Business\ProductCategoryFacadeInterface
     */
    public function getProductCategoryFacade(): ProductCategoryFacadeInterface
    {
        return $this->tester->getLocator()->productCategory()->facade();
    }
}
