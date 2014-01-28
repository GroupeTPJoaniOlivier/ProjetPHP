<?php
    $item = $parameters['item'];
?>
<!DOCTYPE html>
<html>
    <?php include 'header.php' ?>



    <body>



    <div class="container">
        <div class="page-header">
            <h1 class="text-center">Reading</h1>
        </div>

        <h1>You are reading article <?=  $item->getId() ?> </h1>
        <p>
            <p>It has been writen by <?= $item->getOwner() ?></p>
            <p>It has been published on the <?= date_format($item->getDate(), 'd/m/Y g:i A') ?></p>
            <blockquote><?= $item->getText() ?></blockquote>
        </p>

        <form action="/statuses/<?= $item->getId() ?>" method="POST">
            <input type="hidden" name="_method" value="DELETE">
            <input type="submit" value="Delete">
        </form>
    </div>


    </body>
</html>