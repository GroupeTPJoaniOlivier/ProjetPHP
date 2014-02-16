
<div class="col-sm-12">
<nav class="navbar navbar-default" role="navigation">
    <div class="container-fluid">
        <!-- Brand and toggle get grouped for better mobile display -->
        <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="/">Twitty</a>
            <!-- Right -->

        </div>
        <div>
            <?php if($_SESSION['is_authenticated']) : ?>
                <p class="navbar-text navbar-right" ><a href="/logout" class="navbar-link">Logout</a></p>
                <p class="navbar-text navbar-right" style="margin-right:20px;">Logged in as <a href="#" class="navbar-link"><?= ucfirst($_SESSION['username']) ?></a></p>
            <?php else : ?>
                <p class="navbar-text navbar-right" style="margin-right:20px;"><a href="/signIn" class="navbar-link">Sign in</p>
                <p class="navbar-text navbar-right" style="margin-right:20px;"><a href="/login" class="navbar-link">Login</p>
            <?php endif; ?>
        </div>

    </div>
</nav>
</div>