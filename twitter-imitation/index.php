<?php

    include("functions.php");

    include("view/header.php");

    if ($_GET['page'] == 'timeline') {
        
        include("view/timeline.php");
        
    } else if ($_GET['page'] == 'search') {
        
        include("view/search.php");
        
    } else if ($_GET['page'] == 'yourtweets') {
        
        include("view/yourtweets.php");
        
    } else if ($_GET['page'] == 'publicprofiles') {
         include("view/publicprofiles.php");
        
    } else {

        include("view/home.php");
        
    }

    include("view/footer.php");

?>