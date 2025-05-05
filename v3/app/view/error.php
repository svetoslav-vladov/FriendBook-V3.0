<div class="container text-center">
<?php
    if(isset($data)){
        $error = $data;
    }

     //this handles error.php check htaccess file for more info
    echo "<div class=\"row\">";
    echo "<div class=\"col-sm-12\"\">";
    if(isset($error) && $error == 403){
        require_once "./error_403.php";
    }
    elseif(isset($error) && $error == 404){
        require_once "./error_404.php";
    }
    elseif(isset($error) && $error == 401){
        require_once  "./error_401.php";
    }
    elseif(isset($error['pdoexception'])){
       $err = htmlentities($error['PDOException']);
        echo $err;
    }
    elseif(isset($error['exception'])){
        $err = htmlentities($error['PDOException']);
        echo $err;
    }
    else{
        echo $error[0];
    }
    echo '</div>';
    echo '</div>';
    //testing
    //var_dump($error);

?>
    <div class="row">
        <div class="col-sm-12">

            <a href="<?php echo URL_ROOT; ?>" class="btn btn-success mt-5 text-white">Main Page</a>

        </div>
    </div>
</div>


