<!DOCTYPE html>

<html>
    <?php include 'header.php'; ?>
    <body>
        <div class="container">
            <div class="page-header">
                <h1 class="text-center">Login</h1>
            </div>

            <div class="content col-sm-12">
                <form action="/login" method="POST" class="form-horizontal">
                    <div class="form-group">
                        <!-- <label for="username" class="col-sm-2 control-label sr-only">Username</label> -->
                        <div class="col-sm-6 col-sm-offset-3">
                            <input type="text" class="form-control" id="username" placeholder="Username" name="username" />
                        </div>
                    </div>
                    <div class="form-group">
                        <!-- <label for="message" class="col-sm-2 control-label sr-only" >Password</label> -->
                        <div class="col-sm-6 col-sm-offset-3">
                            <input type="password" name="password" placeholder="Password" class="form-control" />
                        </div>
                    </div>
                    <div class="centered">
                        <input type="submit" value="Login" class="btn btn-primary col-sm-2 col-sm-offset-5">
                    </div>
                </form>
            </div>

        </div>
    </body>
</html>
