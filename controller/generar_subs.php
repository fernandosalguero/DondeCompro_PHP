<?php 
    session_start();

    if(isset($_SESSION["subs"])){

        $_SESSION["subs_2"] = array();

        for($i = 0; $i < 4; $i++){

            $_SESSION["subs_2"][$i] = (rand(0, 555)); 
            $_SESSION["subs"][$i] = $_SESSION["subs_2"][$i];
    
        }

        echo 1;


    }else{

        echo 0;

    }

?> 