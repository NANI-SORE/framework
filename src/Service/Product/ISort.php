<?php
declare(strict_types=1);

namespace Service\Product;

interface ISort
{
    /**
     * @param \Model\Entity\Product[] $product
     * @param string $direction
     * @return \Model\Entity\Product[]
     */
    public function sort(array $product, string $direction): array;
}
