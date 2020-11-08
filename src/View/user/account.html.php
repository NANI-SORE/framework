<?php

/** @var \Model\Entity\User $user */
/**@var float $lastOrder */
$body = function () use ($user, $lastOrder) {
?>
    <hr>
    <p>Личный кабинет пользователя: <?= $user->getName() ?></p>
    <ol>
        <li>Логин: <?= $user->getLogin() ?></li>
        <li>Имя: <?= $user->getName() ?></li>
        <li>День Рождения: <?= date("d.m.Y", $user->getBirthday()) ?></li>
        <li>Роль: <?= $user->getRole()->getTitle() ?></li>
        <li>Тип роли: <?= $user->getRole()->getType() ?></li>
        <?php 
        if($lastOrder) {
            ?>
            <li>Последний заказ: <?= $lastOrder ?></li>
            <?php
        }
        ?>
    </ol>
    <hr>
<?php
};

$renderLayout(
    'main_template.html.php',
    [
        'title' => 'Личный кабинет',
        'body' => $body,
    ]
);
