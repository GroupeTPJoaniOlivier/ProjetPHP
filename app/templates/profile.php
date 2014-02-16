<?php
    $user = $parameters['user'];
    $statuses = $parameters['array'];
?>

<!DOCTYPE html>

<html>
<?php include 'header.php'; ?>
<body>

<div class="container">

    <div class="page-header">
        <h1 class="text-center"><?= $user->getUsername() ?></h1>
    </div>

    <?php include 'navbar.php'; ?>

    <div class="container">
    <ul class="list-group col-sm-12">
        <?php foreach($statuses as $status) : ?>
            <div class="panel panel-default">
                <div class="panel-heading"><a href="/profile/<?= $user->getId() ?>"><?= $user->getUsername() ?></a> - <small> <?= date_format($status->getDate(), 'd/m/Y g:i A') ?> </small></div>
                <div class="panel-body">
                    <a style="display: block; text-decoration: none;" href="/statuses/<?= $status->getId() ?>">
                        <?= $status->getText() ?>
                    </a>
                </div>
            </div>
        <?php endforeach; ?>
    </ul>
    </div>

</body>
</html>