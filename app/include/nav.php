<nav class="navbar navbar-expand-md navbar-light fixed-top bg-success">
    <div class="container">
        <a class="navbar-brand" href="#">FriendBook</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarsExampleDefault" aria-controls="navbarsExampleDefault" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarsExampleDefault">
            <form class="form-inline mr-auto">
                <input class="form-control mr-sm-2" type="text" placeholder="Search" aria-label="Search">
                <button class="btn btn-outline-light my-2 my-sm-0" type="submit">Search</button>
            </form>
            <ul class="navbar-nav my-2 my-lg-0">
                <li class="nav-item active profile_btn_top">
                    <a class="nav-link" href="<?php echo URL_ROOT; ?>/index/profile">
                        <img class="img-fluid user_profile_pic" src="<?php echo URL_ROOT . $_SESSION['logged']['profile_pic'] ?>"
                                                       alt="<?php echo $_SESSION['logged']['full_name'];?> profile picture">
                        <?php echo $_SESSION['logged']['first_name'];?></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="<?php echo URL_ROOT; ?>/index/main">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#"><i class="fa fa-users"></i></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#"><i class="fa fa-envelope"></i></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#"><i class="fa fa-bell"></i></a>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="http://example.com" id="dropdown01"
                       data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fa fa-cogs"></i></a>
                    <div class="dropdown-menu" aria-labelledby="dropdown01">
                        <a class="dropdown-item" href="#"><i class="fa fa-cog"></i> Settings</a>
                        <a class="dropdown-item" href="<?php echo URL_ROOT; ?>/user/logout"><i class="fa fa-sign-out-alt"></i> logout</a>
                    </div>
                </li>
            </ul>

        </div>
    </div>
</nav>