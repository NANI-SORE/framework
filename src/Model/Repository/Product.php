<?php

declare(strict_types=1);

namespace Model\Repository;

use Model\Entity;

class Product
{
    /**
     * Поиск продуктов по массиву id
     *
     * @param int[] $ids
     * @return Entity\Product[]
     */
    public function search(array $ids = []): array
    {
        if (!count($ids)) {
            return [];
        }

        $productList = [];
        $product = new Entity\Product(0, '', 0, '');
        foreach ($this->getDataFromSource(['id' => $ids]) as $item) {
            $product->setId($item['id']);
            $product->setPrice($item['price']);
            $product->setName($item['name']);
            $product->setDesc($item['desc']);
            // $product->setDiscount($item['discount']);
            $productList[] = clone $product;
            // $productList[] = new Entity\Product($item['id'], $item['name'], $item['price'], $item['desc']);
        }

        return $productList;
    }

    /**
     * Найти продукт по Id
     *
     * @param int $id
     * @return Entity\Product[]
     */
    public function fetchById(int $id): array
    {
        // wrap $id in array and search
        return $this->search(compact($id));
    }

    /**
     * Получаем все продукты
     *
     * @return Entity\Product[]
     */
    public function fetchAll(): array
    {
        $productList = [];
        $product = new Entity\Product(0, '', 0, '');
        foreach ($this->getDataFromSource() as $item) {
            $product->setId($item['id']);
            $product->setPrice($item['price']);
            $product->setName($item['name']);
            $product->setDesc($item['desc']);
            // $product->setDiscount($item['discount']);
            $productList[] = clone $product;
            // $productList[] = new Entity\Product($item['id'], $item['name'], $item['price'], $item['desc']);
        }

        return $productList;
    }

    /**
     * Получаем продукты из источника данных
     *
     * @param array $search
     *
     * @return array
     */
    private function getDataFromSource(array $search = [])
    {
        $dataSource = [
            [
                'id' => 1,
                'name' => 'PHP',
                'price' => 15300,
                'desc' => 'desc PHP',
            ],
            [
                'id' => 2,
                'name' => 'Python',
                'price' => 20400,
                'desc' => 'desc Python',
            ],
            [
                'id' => 3,
                'name' => 'C#',
                'price' => 30100,
                'desc' => 'desc C#',
            ],
            [
                'id' => 4,
                'name' => 'Java',
                'price' => 30600,
                'desc' => 'desc Java',
            ],
            [
                'id' => 5,
                'name' => 'Ruby',
                'price' => 18600,
                'desc' => 'desc Ruby',
            ],
            [
                'id' => 8,
                'name' => 'Delphi',
                'price' => 8400,
                'desc' => 'desc Delphi',
            ],
            [
                'id' => 9,
                'name' => 'C++',
                'price' => 19300,
                'desc' => 'desc C++',
            ],
            [
                'id' => 10,
                'name' => 'C',
                'price' => 12800,
                'desc' => 'desc C',
            ],
            [
                'id' => 11,
                'name' => 'Lua',
                'price' => 5000,
                'desc' => 'desc Lua',
            ],
            [
                'id' => 12,
                'name' => 'Rust',
                'price' => 13337,
                'desc' => 'desc Rust',
            ],
        ];

        if (!count($search)) {
            return $dataSource;
        }

        $productFilter = function (array $dataSource) use ($search): bool {
            return in_array($dataSource[key($search)], current($search), true);
        };

        return array_filter($dataSource, $productFilter);
    }
}
