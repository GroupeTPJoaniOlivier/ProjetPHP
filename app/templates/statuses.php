<!DOCTYPE html>

<html>
    <?php include 'header.php'; ?>
    <body>

    <div class="container">

        <div class="page-header">
            <h1 class="text-center">Twitty <small>only for pros</small></h1>
        </div>

        <?php include 'navbar.php'; ?>

        <div class="col-sm-6">
        <form action="/statuses" method="POST" class="form-horizontal">
            <div class="form-group">
                <label for="username" class="col-sm-2 control-label sr-only">Username:</label>
                <div class="col-sm-12">
                    <input type="text" class="form-control" id="username" placeholder="Your name" name="username">
                </div>
            </div>
            <div class="form-group">
                <label for="message" class="col-sm-2 control-label sr-only" >Message:</label>
                <div class="col-sm-12">
                    <textarea name="message" placeholder="Let's tweet!" rows="3" class="form-control"></textarea>
                </div>
            </div>
            <input type="submit" value="Tweet!" class="btn btn-primary">
        </form>
        </div>

        <div class="list-group col-sm-6">
        <?php foreach($parameters['array'] as $param) : ?>
            <a href="/statuses/<?= $param->getId() ?>" class="list-group-item">
                <h4 class="list-group-item-heading"><?= $param->getOwner()->get()['pseudo'] ?>  <small><?= date_format($param->getDate(), 'd/m/Y g:i A') ?></small></h4>
                <p class="list-group-item-text"><?= $param->getText() ?></p>
            </a>
        <?php endforeach; ?>
        </div>


    </div>
    </body>
</html>