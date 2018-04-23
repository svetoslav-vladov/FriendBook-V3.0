<div class="container text-center">
<?php
    if(isset($array)){
        $error = $array;
    }

     //this handles error.php check htaccess file for more info

    if(isset($error) && $error == 403){
        echo "<div class=\"row\">";
        echo "<div class=\"col-sm-12\"\">";
        require_once "./error_403.php";
        echo '</div>';
        echo '</div>';
    }
    elseif(isset($error) && $error == 404){
        echo "<div class=\"row\">";
        echo "<div class=\"col-sm-12\"\">";
        require_once "./error_404.php";
        echo '</div>';
        echo '</div>';
    }
    elseif(isset($error) && $error == 401){
        echo "<div class=\"row\"\">";
        echo "<div class=\"col-sm-12\"\">";
        require_once  "./error_401.php";
        echo '</div>';
        echo '</div>';
    }
    elseif(isset($error['pdoexception'])){
       $err = htmlentities($error['PDOException']);
        echo '<div class="row"><div class="col-sm-12">' . $err . '</div></div>';
    }
    elseif(isset($error['exception'])){
        $err = htmlentities($error['PDOException']);
        echo '<div class="row"><div class="col-sm-12">' . $err . '</div></div>';
    }
    else{
        echo '<div class="row"><div class="col-sm-12">' . $error[0] . '</div></div>';
    }
    //testing
    //var_dump($error);

?>
    <div class="row">
        <div class="col-sm-12">

            <a href="<?php echo URL_ROOT; ?>" class="btn btn-success mt-5 text-white">Main Page</a>

        </div>
    </div>
</div>


