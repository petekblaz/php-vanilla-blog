<?php
include(realpath($_SERVER['DOCUMENT_ROOT'] . '/../app/bootstrap.php'));

// If session variable userId is set, redirect to admin panel
if (isset($_SESSION['userId']) && !empty($_SESSION['userId'])) {
    header('location: /admin');
}

// If POST request, try to login with submitted data
if ($_SERVER['REQUEST_METHOD'] == 'POST' && !empty($_POST['username']) && !empty($_POST['password'])) {
    $user->login($_POST['username'], $_POST['password']);
}


include(TEMPLATES_PATH . '/_header.php')
?>

<div class="container container-admin-login">

    <div class="row">
        <div class="col-md-4 col-md-offset-4">
            <h1>Login to admin area</h1>
            <hr />
            <form class="login-form" action="" method="post">
                <!-- <p>Username:</p> -->
                <input type="text" class="form-control" name="username" placeholder="Username">
                <input type="password" class="form-control" name="password" placeholder="Password">
                <button type="submit" class="btn btn-success btn-block" name="submit">Login</button>
            </form>

        </div>
    </div>

</div>


<?php include(TEMPLATES_PATH . '/_footer.php'); ?>