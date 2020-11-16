<?php

declare(strict_types=1);

namespace Service\Order;

use Model;
use Service\Billing\Card;
use Service\Billing\IBilling;
use Service\Discount\OrderDiscount;
use Service\Discount\UserDiscount;
use Service\Discount\ItemDiscount;
use Service\Communication\Email;
use Service\Communication\ICommunication;
use Service\Discount\IDiscount;
use Service\User\ISecurity;
use Service\User\Security;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class Basket
{
    /**
     * Сессионный ключ списка всех продуктов корзины
     */
    private const BASKET_DATA_KEY = 'basket';

    /**
     * @var SessionInterface
     */
    private $session;

    /**
     * @param SessionInterface $session
     */
    public function __construct(SessionInterface $session)
    {
        $this->session = $session;
    }

    /**
     * Добавляем товар в заказ
     *
     * @param int $product
     *
     * @return void
     */
    public function addProduct(int $product): void
    {
        $basket = $this->session->get(static::BASKET_DATA_KEY, []);
        if (!in_array($product, $basket, true)) {
            $basket[] = $product;
            $this->session->set(static::BASKET_DATA_KEY, $basket);
        }
    }

    /**
     * Убираем товар из заказа
     *
     * @param int $product
     *
     * @return void
     */
    public function removeProduct(int $product): void
    {
        $basket = $this->session->get(static::BASKET_DATA_KEY, []);
        $key = array_search($product, $basket, true);
        if ($key !== false) {
            unset($basket[$key]);
            $this->session->set(static::BASKET_DATA_KEY, $basket);
        }
    }

    /**
     * Очистить корзину
     *
     * @return void
     */
    public function clear(): void
    {
        $basket = $this->session->get(static::BASKET_DATA_KEY, []);
        if ($basket) {
            $this->session->set(static::BASKET_DATA_KEY, []);
        }
    }

    /**
     * Проверяем, лежит ли продукт в корзине или нет
     *
     * @param int $productId
     *
     * @return bool
     */
    public function isProductInBasket(int $productId): bool
    {
        return in_array($productId, $this->getProductIds(), true);
    }

    /**
     * Получаем информацию по всем продуктам в корзине
     *
     * @return Model\Entity\Product[]
     */
    public function getProductsInfo(): array
    {
        $productIds = $this->getProductIds();

        $products = $this->getProductRepository()->search($productIds);
        return $products;
    }

    /**
     * Получаем информацию о скидках
     *
     * @return array
     */
    public function getOrderPrice(): array
    {
        $security = new Security($this->session);

        $discounts = [];

        $discounts[] = new UserDiscount($security->getUser());

        $orderPrice = 0;
        foreach ($this->getProductsInfo() as $product) {
            $itemDisc = new ItemDiscount($product->getId());
            $discountedItemPrice = $product->getPrice() * (1 - ($itemDisc->getDiscount() / 100));

            $itemDiscounts[] = [
                'productId' => $product->getId(),
                'itemDiscount' => $itemDisc->getDiscount(),
                'discountedPrice' => $discountedItemPrice
            ];

            $orderPrice += $discountedItemPrice;
        }

        $orderDiscount = new OrderDiscount($orderPrice);
        $discounts[] = $orderDiscount;

        $biggestDiscount = $orderDiscount;
        foreach ($discounts as $_discount) {
            if ($_discount->getDiscount() > $biggestDiscount->getDiscount()) {
                $biggestDiscount = $_discount;
            }
        }

        return ['orderDiscount' => $biggestDiscount->getDiscount(), 'itemDiscounts' => $itemDiscounts, 'orderPrice' => $orderPrice];
    }

    /**
     * Оформление заказа
     *
     * @return array
     */
    public function checkout(): array
    {
        $security = new Security($this->session);

        // Здесь должна быть некоторая логика выбора способа платежа
        $billing = new Card();

        // Здесь должна быть некоторая логика получения способа уведомления пользователя о покупке
        $communication = new Email();

        list('orderDiscount' => $orderDiscount, 'orderPrice' => $orderPrice) = $this->getOrderPrice();

        return $this->checkoutProcess($orderDiscount, $orderPrice, $billing, $security, $communication);
    }

    /**
     * Проведение всех этапов заказа
     *
     * @param IDiscount $discount,
     * @param float $totalPrice
     * @param IBilling $billing,
     * @param ISecurity $security,
     * @param ICommunication $communication
     * @return array order info
     */
    public function checkoutProcess(
        float $discount,
        float $orderPrice,
        IBilling $billing,
        ISecurity $security,
        ICommunication $communication
    ): array {
        $products = $this->getProductsInfo();

        $percentLeft = 1 - ($discount / 100);
        $orderPrice = $orderPrice * $percentLeft;

        $billing->pay($orderPrice);

        $user = $security->getUser();
        $communication->process($user, 'checkout_template');
        return ['productList' => $products, 'discount' => $discount, 'orderPrice' => $orderPrice];
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

    /**
     * Получаем список id товаров корзины
     *
     * @return array
     */
    private function getProductIds(): array
    {
        return $this->session->get(static::BASKET_DATA_KEY, []);
    }
}
