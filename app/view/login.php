<div id="guest_wrap">
    <form class="form-sign" method="POST" action="<?php echo URL_ROOT; ?>/user/login">

        <a href="<?php echo $_SERVER["REQUEST_URI"]; ?>">
            <img class="mb-4 padding-top-login" src="<?php echo URL_ROOT; ?>/assets/images/friendbook-front-logo.png" alt="friend book front logo">
        </a>
        <h1 class="h3 mb-3 font-weight-normal">Please sign-in</h1>

        <label for="email" class="sr-only">Email address</label>
        <input type="email" id="email" name="email" class="form-control" placeholder="Email address">

        <label for="inputPassword" class="sr-only">Password</label>
        <input type="password" id="password" name="password" class="form-control" placeholder="Password">

        <input type="submit" id="login_btn" name="login" class="btn btn-lg btn-success btn-block" value="Sign in">
        <a href="<?php echo URL_ROOT; ?>/index/register" class="btn text-success">You don't have account?</a>
        <p class="mt-5 mb-3 text-muted">
            www.FriendBook.bg &copy; 2018 <br> All Rights Reserved <br> Version 3.0
        </p>
    </form>
</div>