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

            <?php if($_SESSION['is_authenticated']) : ?>
                <div class="form-group">
                    <label for="username" class="col-sm-4 control-label">Tweeting as <?= $_SESSION['username'] ?></label>
                    <div class="col-sm-12">
                        <input type="hidden" id="userId" name="userId" class="form-control" value="<?= $_SESSION['userId'] ?>">
                    </div>
                </div>
            <?php else : ?>
                <div class="form-group">
                    <label for="username" class="col-sm-2 control-label sr-only">Username:</label>
                    <div class="col-sm-12">
                        <input type="text" class="form-control" id="username" placeholder="Your name" name="username">
                    </div>
                </div>
            <?php endif; ?>

            <div class="form-group">
                <label for="message" class="col-sm-2 control-label sr-only" >Message:</label>
                <div class="col-sm-12">
                    <textarea name="message" placeholder="Let's tweet!" rows="3" class="form-control"></textarea>
                </div>
            </div>
            <input type="submit" value="Tweet!" class="btn btn-primary">
        </form>
        </div>

        <ul class="list-group col-sm-6">
        <?php
            $user_finder = $parameters['user_finder'];
        ?>
        <?php foreach($parameters['array'] as $param) : ?>
            <?php $user = $user_finder->findOneById($param->getOwner()); ?>
            <div class="panel panel-default">
                <div class="panel-heading"><a href="/profile/<?= $user->getId() ?>"><?= $user->getUsername() ?></a> - <small> <?= date_format($param->getDate(), 'd/m/Y g:i A') ?> </small></div>
                <div class="panel-body">
                    <a style="display: block; text-decoration: none;" href="/statuses/<?= $param->getId() ?>">
                    <?= $param->getText() ?>
                    </a>
                </div>
            </div>
        <?php endforeach; ?>
        </ul>


    </div>
    </body>
</html>