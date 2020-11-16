<?php

declare(strict_types=1);

namespace Service\Discount;

use Model;

class ItemDiscount implements IDiscount
{
    public const PRODUCT_ID = 8;
    public const DISCOUNT_AMOUNT = 8;

    /**
     * @var int
     */
    private $productId;

    /**
     * @param int $productId
     */
    public function __construct(int $productId)
    {
        $this->productId = $productId;
    }



    /**
     * @inheritdoc
     */
    public function getDiscount(): float
    {
        $discount = 0;
        if ($this->productId == self::PRODUCT_ID) {
            $discount = self::DISCOUNT_AMOUNT;
        } else {
            $discount = 0;
        }
        return $discount;
    }
}
