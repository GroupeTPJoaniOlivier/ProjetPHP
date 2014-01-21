
<h1>Statuses</h1>
<h3>Number of statuses : <?= count($parameters['array']) ?></h3>

<ul>
<?php foreach($parameters['array'] as $param) : ?>
<li>[<?= date_format($param->getDate(), 'd/m/Y g:i A') ?>] <?= $param->getText() ?> - by <?= $param->getOwner() ?></li>
<?php endforeach; ?>
</ul>