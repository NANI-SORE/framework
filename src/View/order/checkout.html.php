<?php

/** @var \Model\Entity\Product[] $productList */
/** @var float $discount */
/** @var float $orderPrice */
$body = function () use ($productList, $discount, $orderPrice) {
?>
    <form method="post">
        <table cellpadding="10">
            <tr>
                <td colspan="3" align="center">Покупка успешно совершена</td>
                <td colspan="3" align="center">Ваша скидка <?= (string)$discount ?>%</td>
            </tr>
            <tr>
                <td colspan="3" align="center">Покупка <?= (string)count($productList) ?> товаров на сумму <?= (string)$orderPrice ?> руб. успешно совершена</td>
            </tr>
        </table>
    </form>
<?php
};

$renderLayout(
    'main_template.html.php',
    [
        'title' => 'Покупка',
        'body' => $body,
    ]
);
