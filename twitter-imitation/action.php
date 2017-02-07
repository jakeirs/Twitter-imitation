<?php
// BACK-END
    include("functions.php");

    if ($_GET['action'] == "loginSignup") {
        
        $error = "";
        $email = mysqli_real_escape_string($link, $_POST['email']);
        
        $password = mysqli_real_escape_string($link, $_POST['password']);
        
                
        if (! $_POST['email']) {
            
            $error = "Adres email wymagany.";
            
        } else if (! $_POST['password']) {
            $error = "Hasło wymagane.";
            
        } else if (filter_var($_POST['email'], 
                    FILTER_VALIDATE_EMAIL) === false) {
  
          $error = "Proszę wpisać poprawny adres email";
        }
        
        if ($error != "") {
             
            echo  $error;
            exit();
            
        }
        
        if ($_POST['loginActive'] == 0) {
            
            $query = "SELECT * FROM users WHERE email = '$email' ";
            
            $result =  mysqli_query($link, $query);
            
            if (mysqli_num_rows($result) > 0) {
                
                $error = "Podany adres email jest zajęty";
            } else {
                
                $query = "INSERT INTO users (email, password) VALUES('$email', '$password')";
                                
                if (mysqli_query($link, $query)) {
                    
                    $hashedPassword = hashPass(mysqli_insert_id($link), $password);
                    
                   $_SESSION['id'] = mysqli_insert_id($link);
                    
                                                                               
                    $query = "UPDATE users SET password = '$hashedPassword' WHERE email = '$email' LIMIT 1 ";
                    
                    mysqli_query($link, $query);
                    
                    echo "success";
                    
                } else {
                    $error = "Nie udało się utworzyć konta. Spróbuj później.";
                }
            }
            
        } else if ($_POST['loginActive'] == 1) {
            
            $query = "SELECT * FROM users WHERE email = '$email' ";
            $result = mysqli_query($link, $query);
            
            $row = mysqli_fetch_assoc($result);
                                    
             if ( hashPass($row['id'], $password) == $row['password']) {
                 
                 echo "success";
                 
                 $_SESSION['id'] = $row['id'];
                                  
             } else {
                 $error = "Nie prawidłowa kombinacja email/hasło. Proszę spróbować ponownie.";
             }
            
        }
        
        if ($error != "") {
             
            echo  $error;
            exit();
            
        }
    }

    if ($_GET['action'] == "toggleFollow") {
        
                
         $query = "SELECT * FROM isFollowing WHERE follower = ".$_SESSION['id']." AND isFollowing = ".$_POST['userId']." LIMIT 1 ";
        
        $result = mysqli_query($link, $query);
        
        if (mysqli_num_rows($result) > 0) {
            
            $row = mysqli_fetch_assoc($result);
            
            mysqli_query($link, "DELETE FROM isFollowing WHERE id =".$row['id']." LIMIT 1 ");
            
            echo "unfollowed";
        } else {
            
             mysqli_query($link, "INSERT INTO isFollowing (follower, isFollowing) 
                VALUES (".$_SESSION['id'].", ".$_POST['userId']." ) ");
            
            $row = mysqli_fetch_assoc($result);
            
            print_r($row);
            
            echo "followed";
            
        }
    }

    if ($_GET['action'] == "postTweet") {
        
         if (! $_POST['tweetContent']) {
                  
             echo "Proszę wpisz cokolwiek";
         } else if (strlen($_POST['tweetContent']) > 140) {
             
             echo "Twój tweet jest za długi. Max. 140 znaków.";
         } else {
             
             $query = "INSERT INTO tweets (tweet, userid, datetime) VALUES ('".mysqli_real_escape_string($link, $_POST['tweetContent'])."', ".$_SESSION['id'].", NOW()  ) ";
             
             mysqli_query($link, $query);
             
             echo "posted";
         }
        
    }


?>