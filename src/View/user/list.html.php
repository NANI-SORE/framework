<?php

/** @var \Model\Entity\User[] $userList */
$body = function () use ($userList) {
    ?>
    <hr>
    <?php
    foreach ($userList as $key => $user) {
        ?>
        <p>Пользователь: <?= $user->getName() ?></p>
        <ol>
            <li>Логин: <?= $user->getLogin() ?></li>
            <li>Имя: <?= $user->getName() ?></li>
            <li>День Рождения: <?= date("d.m.Y", $user-> getBirthday()) ?></li>
            <li>Роль: <?= $user->getRole()->getTitle() ?></li>
            <li>Тип роли: <?= $user->getRole()->getType() ?></li>
        </ol>
        <hr>
<?php
    }
};

$renderLayout(
    'main_template.html.php',
    [
        'title' => 'Все пользователи',
        'body' => $body,
    ]
);
