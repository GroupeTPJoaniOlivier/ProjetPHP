<?php


    $item = $parameters['item'];
    $user = $parameters['user'];

?>
<!DOCTYPE html>
<html>
    <?php include 'header.php' ?>

    <body>

    <div class="container">
        <div class="page-header">
            <h1 class="text-center">Reading</h1>
        </div>

        <?php include 'navbar.php'; ?>

        <div class="col-sm-12">
        <h1>You are reading article <?=  $item->getId() ?> </h1>
        <p>

            <?php if($user === null) : ?>
                <p>It has been writen by an anonym</p>
            <?php else : ?>
                <p>It has been writen by <a href="/profile/<?= $user->getId()?>"><?= $user->getUsername(); ?></a></p>
            <?php endif; ?>
            <p>It has been published on the <?= date_format($item->getDate(), 'd/m/Y g:i A') ?></p>
            <blockquote><?= $item->getText() ?></blockquote>
        </p>

            <?php if($_SESSION['userId'] === $item->getOwner()) :?>
                <form action="/statuses/<?= $item->getId() ?>" method="POST">
                    <input type="hidden" name="_method" value="DELETE">
                    <input type="submit" value="Delete">
                </form>
            <?php endif; ?>

        </div>
    </div>


    </body>
</html>