<?php

declare(strict_types=1);

namespace Service\Discount;

use Model;

class UserDiscount implements IDiscount
{
    public const DAYS_AMOUNT = 5;
    public const DISCOUNT_AMOUNT = 5;

    /**
     * @var string
     */
    private $user;

    /**
     * @param Model\Entity\User $user
     */
    public function __construct(Model\Entity\User $user)
    {
        $this->user = $user;
    }

    /**
     * @inheritdoc
     */
    public function getDiscount(): float
    {
        $birthday = $this->user->getBirthday();
        return $this->getDiscountBirthday($birthday);
    }

    public function getDiscountBirthday($birthday): float
    {
        #$birthday = '20.11.2010';
        $now = date('d.m.Y');

        $birthdayString = date('d.m.Y', $birthday);

        $beforeDiscount = date('d.m.Y', strtotime('today 00:00:00 +' . self::DAYS_AMOUNT . ' days'));
        $afterDiscount = date('d.m.Y', strtotime('today 00:00:00 -' . self::DAYS_AMOUNT . ' days'));

        if (($beforeDiscount >= $birthdayString) && ($birthdayString >= $afterDiscount)) {
            $discount = self::DISCOUNT_AMOUNT;
        } else {
            $discount = 0;
        }
        return $discount;
    }
}
