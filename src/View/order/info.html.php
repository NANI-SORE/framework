<?php

/** @var \Model\Entity\Product[] $productList */
/** @var bool $isLogged */
/** @var \Closure $path */
/** @var float $orderPrice */
/** @var float $orderDiscount */
/** @var array $itemDiscounts */
$body = function () use ($productList, $isLogged, $path, $orderPrice, $orderDiscount, $itemDiscounts) {
?>
    <form method="post">
        <table cellpadding="10">
            <tr>
                <td colspan="3" align="center">Корзина</td>
            </tr>
            <?php
            $n = 1;
            foreach ($productList as $product) {
            ?>
                <tr>
                    <td><?= $n++ ?>.</td>
                    <td><?= $product->getName() ?></td>
                    <td><?= $product->getPrice() ?> руб.</td>
                    <?php 
                    $isDiscounted = array_search($product->getId(), array_column($itemDiscounts, 'productId'));
                    if ($isDiscounted !== FALSE && $itemDiscounts[$isDiscounted]['itemDiscount']) {
                        $_itemPrice = $itemDiscounts[$isDiscounted]['discountedPrice'];
                        $_itemDiscount = $itemDiscounts[$isDiscounted]['itemDiscount'];
                    ?>
                        <td><?= $_itemDiscount ?>% - скидка на товар</td>
                        <td><?= $_itemPrice ?> руб. со скидкой</td>
                    <?php
                    }
                    ?>
                    <td>
                        <form method="post">
                            <input name="removeProduct" type="hidden" value="<?= $product->getId() ?>" />
                            <input type="submit" value="Удалить" />
                        </form>
                    </td>
                </tr>
            <?php
                $totalWithDiscount = $orderPrice * (1 - ($orderDiscount / 100));
            } ?>
            <tr>
                <td colspan="3" align="right">Итого: <?= $orderPrice ?> руб. Скидка <?= $orderDiscount ?>% => <?= $totalWithDiscount ?> руб.</td>
            </tr>
            <?php if ($orderPrice > 0) {
                if ($isLogged) {
            ?>
                    <tr>
                        <td colspan="3" align="center">
                            <form method="post">
                                <input type="submit" value="Оформить заказ" />
                            </form>
                        </td>
                    </tr>
                <?php
                } else {
                ?>
                    <tr>
                        <td colspan="4" align="center">Для оформления заказа, <a href="<?= $path('user_authentication') ?>">авторизуйтесь</a></td>
                    </tr>
            <?php
                }
            } ?>
        </table>
    </form>
<?php
};

$renderLayout(
    'main_template.html.php',
    [
        'title' => 'Корзина',
        'body' => $body,
    ]
);
