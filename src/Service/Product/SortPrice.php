<?php


namespace Service\Product;

class SortPrice implements ISort
{
    /**
     * @param \Model\Entity\Product[] $product
     * @param string $direction
     * @return \Model\Entity\Product[]
     */
    public function sort(array $product, string $direction): array
    {
        usort($product, function (\Model\Entity\Product $a, \Model\Entity\Product $b) use ($direction) {
            $result = $a->getPrice() > $b->getPrice();
            $result = $direction == 'desc' ? (-1 * $result) : $result;
            return $result;
        });

        return $product;
    }
}
