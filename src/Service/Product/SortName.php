<?php


namespace Service\Product;

class SortName implements ISort
{

    /**
     * @param \Model\Entity\Product[] $product
     * @param string $direction
     * @return \Model\Entity\Product[]
     */
    public function sort(array $product, string $direction):array
    {
        usort($product, function (\Model\Entity\Product $a, \Model\Entity\Product $b) use ($direction) {
            $result = $a->getName() <=> $b->getName();
            $result = $direction == 'desc' ? (-1 * $result) : $result;
            return $result;
        });
        return $product;
    }
}
