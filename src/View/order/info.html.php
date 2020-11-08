<?php

/** @var \Model\Entity\Product[] $productList */
/** @var bool $isLogged */
/** @var \Closure $path */
/** @var float $orderPrice */
/** @var float $discount */
$body = function () use ($productList, $isLogged, $path, $orderPrice, $discount) {
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
                    <?php if ($product->getDiscount() > 0) {
                        $itemDiscounted = $product->getPrice() * (1 - ($product->getDiscount() / 100));
                    ?>
                        <td><?= $product->getDiscount() ?>% - скидка на товар</td>
                        <td><?= $itemDiscounted ?> руб. со скидкой</td>
                    <?php
                    }
                    ?>
                    <td>
                        <form method="post">
                            <input name="removeProduct" type="hidden" value="<?= $product->getId() ?>" />';
                            <input type="submit" value="Удалить" />
                        </form>
                    </td>
                </tr>
            <?php
                $totalWithDiscount = $orderPrice * (1 - ($discount / 100));
            } ?>
            <tr>
                <td colspan="3" align="right">Итого: <?= $orderPrice ?> руб. Скидка <?= $discount ?>% => <?= $totalWithDiscount ?> руб.</td>
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
