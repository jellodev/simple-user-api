<h2><?= esc($title); ?></h2>

<?php if (! empty($users) && is_array($users)) : ?>

    <?php foreach ($users as $user): ?>
        <h3><?= esc($user['name']); ?></h3>
    <?php endforeach; ?>

<?php else : ?>

    <h3>No found anyone</h3>
    <p>can not find anything</p>

<?php endif ?>