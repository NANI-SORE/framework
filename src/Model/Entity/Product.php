<?php

declare(strict_types=1);

namespace Model\Entity;

class Product
{
    /**
     * @var int
     */
    private $id;

    /**
     * @var string
     */
    private $name;

    /**
     * @var float
     */
    private $price;

    /**
     * @var string
     */
    private $desc;

    /**
     * @var float
     */
    private $discount;

    /**
     * @param int $id
     * @param string $name
     * @param float $price
     * @param string $desc
     */
    public function __construct(int $id, string $name, float $price, string $desc = '', float $discount = 0)
    {
        $this->id = $id;
        $this->name = $name;
        $this->price = $price;
        $this->desc = $desc;
        $this->discount = $discount;
    }



    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId(int $id): int
    {
        $this->id = $id;
        return $this->id;
    }



    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName(string $name): string
    {
        $this->name = $name;
        return $this->name;
    }



    /**
     * @return float
     */
    public function getPrice(): float
    {
        return $this->price;
    }

    /**
     * @param float $price
     */
    public function setPrice(float $price): float
    {
        $this->price = $price;
        return $this->price;
    }



    /**
     * @return string
     */
    public function getDesc(): string
    {
        return $this->desc;
    }

    /**
     * @param string $desc
     */
    public function setDesc(string $desc): string
    {
        $this->desc = $desc;
        return $this->desc;
    }

    /**
     * @return float
     */
    public function getDiscount(): float
    {
        return $this->discount;
    }

    /**
     * @param string $discount
     */
    public function setDiscount(float $discount): float
    {
        $this->discount = $discount;
        return $this->discount;
    }



    /**
     * @return array
     */
    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'price' => $this->price,
            'desc' => $this->desc,
            'discount' => $this->discount,
        ];
    }
}
