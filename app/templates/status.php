<?php
    $item = $parameters['item'];
?>

<h1>You are reading article <?=  $item->getId() ?> </h1>
<p>
    <p>It has been writen by <?= $item->getOwner() ?></p>
    <p>It has been published on the <?= date_format($item->getDate(), 'd/m/Y g:i A') ?></p>
    <blockquote><?= $item->getText() ?></blockquote>
</p>