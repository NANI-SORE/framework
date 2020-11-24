<?php
declare(strict_types=1);

namespace Service\Order;

use Service\Billing\Card;
use Service\Communication\Email;
use Service\User\Security;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class FacadeCheckout
{
    /**
     * @var SessionInterface
     */
    private $session;

    /**
     * FacadeCheckout constructor.
     * @param SessionInterface $session
     */
    public function __construct(SessionInterface $session)
    {
        $this->session = $session;
    }

    /**
     * @param BasketBuilder $basketBuilder
     */
    public function checkoutProcess(BasketBuilder $basketBuilder): array
    {
        return $basketBuilder->build()->checkoutProcess($this->getBasket()->getProductsInfo());
    }


    /**
     * Оформление заказа
     *
     * @return array
     */
    public function checkout(): array
    {
        list('orderDiscount' => $orderDiscount, 'orderPrice' => $orderPrice) = $this->getBasket()->getOrderPrice();

        $basketBuilder = new BasketBuilder();
        $basketBuilder->setOrderPrice($orderPrice)
            ->setDiscount($orderDiscount)
            ->setSecurity(new Security($this->session))
            ->setBilling(new Card())
            ->setCommunication(new Email());

        return $this->checkoutProcess($basketBuilder);
    }

    /**
     * Фабричный метод для Basket
     *
     * @return Basket
     */
    protected function getBasket(): Basket
    {
        return new Basket($this->session);
    }
}
