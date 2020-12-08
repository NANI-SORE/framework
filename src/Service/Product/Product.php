<?php

declare(strict_types = 1);

namespace Service\Product;

use Model;

class Product
{
    /**
     * Получаем информацию по конкретному продукту
     *
     * @param int $id
     * @return Model\Entity\Product|null
     */
    public function getInfo(int $id): ?Model\Entity\Product
    {
        $product = $this->getProductRepository()->search([$id]);
        return count($product) ? $product[0] : null;
    }

    /**
     * Получаем все продукты
     *
     * @param string $sortType
     * @param string $sortDir
     *
     * @return Model\Entity\Product[]
     */
    public function getAll(string $sortType=null, string $sortDir='asc'): array
    {
        $productList = $this->getProductRepository()->fetchAll();

        switch ($sortType) {
            case 'name':
                $sort = new SortName();
                $productList = $sort->sort($productList, $sortDir);
                break;
            case 'price':
                $sort = new Sortprice();
                $productList = $sort->sort($productList, $sortDir);
                break;
            default:
                break;
        }

        return $productList;
    }

    /**
     * Фабричный метод для репозитория Product
     *
     * @return Model\Repository\Product
     */
    protected function getProductRepository(): Model\Repository\Product
    {
        return new Model\Repository\Product();
    }
}
