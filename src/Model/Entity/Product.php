<?php

declare(strict_types = 1);

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
     * @param int $id
     * @param string $name
     * @param float $price
     * @param string $desc
     */
    public function __construct(int $id, string $name, float $price, string $desc = '')
    {
        $this->id = $id;
        $this->name = $name;
        $this->price = $price;
        $this->desc = $desc;
    }

    /**
     * @return int
     */
    public function getId(): int
    {
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
     * @return float
     */
    public function getPrice(): float
    {
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
     * @return array
     */
    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'price' => $this->price,
            'desc' => $this->desc,
        ];
    }
}
