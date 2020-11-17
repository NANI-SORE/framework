<?php


namespace Service\Order;

use Service\User\ISecurity;
use Service\Billing\IBilling;
use Service\Discount\IDiscount;
use Service\Communication\ICommunication;

class BasketBuilder
{
    /**
     * @var float
     */
    private $orderPrice;

    /**
     * @var IDiscount
     */
    private $discount;

    /**
     * @var ISecurity
     */
    private $security;

    /**
     * @var IBilling
     */
    private $billing;

    /**
     * @var ICommunication
     */
    private $communication;

    /**
     * @return float
     */
    public function getOrderPrice(): float
    {
        return $this->orderPrice;
    }

    /**
     * @param float $orderPrice
     * @return BasketBuilder
     */
    public function setOrderPrice(float $orderPrice): BasketBuilder
    {
        $this->orderPrice = $orderPrice;
        return $this;
    }

    /**
     * @return IDiscount
     */
    public function getDiscount(): IDiscount
    {
        return $this->discount;
    }

    /**
     * @param IDiscount $discount
     * @return BasketBuilder
     */
    public function setDiscount(IDiscount $discount): BasketBuilder
    {
        $this->discount = $discount;
        return $this;
    }

    /**
     * @return ISecurity
     */
    public function getSecurity(): ISecurity
    {
        return $this->security;
    }

    /**
     * @param ISecurity $security
     * @return BasketBuilder
     */
    public function setSecurity(ISecurity $security): BasketBuilder
    {
        $this->security = $security;
        return $this;
    }

    /**
     * @return IBilling
     */
    public function getBilling(): IBilling
    {
        return $this->billing;
    }

    /**
     * @param IBilling $billing
     * @return BasketBuilder
     */
    public function setBilling(IBilling $billing): BasketBuilder
    {
        $this->billing = $billing;
        return $this;
    }

    /**
     * @return ICommunication
     */
    public function getCommunication(): ICommunication
    {
        return $this->communication;
    }

    /**
     * @param ICommunication $communication
     * @return BasketBuilder
     */
    public function setCommunication(ICommunication $communication): BasketBuilder
    {
        $this->communication = $communication;
        return $this;
    }

    public function build(): CheckoutProcess
    {
        return new CheckoutProcess($this);
    }
}
