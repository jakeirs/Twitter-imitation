<?php

    session_start();

    $link = mysqli_connect("localhost", "cl11-twitter", "banana", "cl11-twitter");

    if (mysqli_connect_errno()) {
        
        print_r(mysqli_connect_errno());
       
    } 

    function hashPass($id, $password) {
        $hashedPassword = "";
        $hashedPassword = md5(md5($id).$password);
        return($hashedPassword);
    }

if ($_GET['function'] == "logout" ) {
    
    session_unset();
}


function time_since($since) {
    $chunks = array(
        array(60 * 60 * 24 * 365 , 'rok'),
        array(60 * 60 * 24 * 30 , 'miesiąc'),
        array(60 * 60 * 24 * 7, 'tyg.'),
        array(60 * 60 * 24 , 'dzień'),
        array(60 * 60 , 'godz.'),
        array(60 , 'min.'),
        array(1 , 's')
    );

    for ($i = 0, $j = count($chunks); $i < $j; $i++) {
        $seconds = $chunks[$i][0];
        $name = $chunks[$i][1];
        if (($count = floor($since / $seconds)) != 0) {
            break;
        }
    }

    $print = ($count == 1) ? '1 '.$name : "$count {$name}";
    return $print;
}

    function displayTweets($type) {
        
        global $link;
        
        if ($type == 'public') {
            
            $whereClause = "";
        } else if ($type == 'isFollowing') {
            
            $whereClause = "";
            
            $query = "SELECT * FROM isFollowing WHERE follower =".$_SESSION['id'];
            
            $result = mysqli_query($link, $query);
            
            while ($row = mysqli_fetch_assoc($result)) {
                
                if ($whereClause == "") $whereClause = "WHERE";
                else $whereClause.= " OR ";
                $whereClause.=" userid = ".$row['isFollowing'];
                
            }
        } else if ($type == "yourtweets") {
            
            $whereClause = "WHERE userid= ".$_SESSION['id']; 
            
        } else if ($type == 'search') {
            
            echo '<p>Pokaż tweety dla wyszukania: "'.mysqli_real_escape_string($link, $_GET['q']).'":</p>';
                        
            $whereClause = "WHERE tweet LIKE '%".mysqli_real_escape_string($link, $_GET['q'])."%' ";
        } else if (is_numeric($type)) { // dla pod Strony PublicProfiles --> $type to userid
            
            $userQuery = "SELECT * FROM users WHERE id = ".$type." LIMIT 1 ";
                
                $userQueryResult = mysqli_query($link, $userQuery);
                $user = mysqli_fetch_assoc($userQueryResult);
            
                echo "<h2>Tweety ".$user['email'].":</h2>";
            
            $whereClause = "WHERE userid = ".mysqli_real_escape_string($link, $type);
        }
          
          
     $query = "SELECT * FROM tweets ".$whereClause." ORDER BY datetime DESC LIMIT 10";
        
        $result = mysqli_query($link, $query);
        
        if (mysqli_num_rows($result) == 0) {
            
            echo "There are no tweets to display";
        } else {
             
            while ( $row = mysqli_fetch_assoc($result) ) {
                
                $userQuery = "SELECT * FROM users WHERE id = ".$row['userid']." LIMIT 1 ";
                
                $userQueryResult = mysqli_query($link, $userQuery);
                $user = mysqli_fetch_assoc($userQueryResult);
                
                echo "<div class='tweet'><p><a href='?page=publicprofiles&userid=".$user['id']."'>".$user['email']."</a> <span class='time'>".time_since(time() - strtotime($row['datetime']))." temu</span></p>";
                
                echo $row['tweet'];
                
                echo "<p><a id='followOrNot' class='toggleFollow' 
                    data-userId='".$row['userid']."'>"; // napis Follow czy Unfollow pod postem
                
                $isFollowingQuery = "SELECT * FROM isFollowing WHERE
                follower = ".$_SESSION['id']." AND isFollowing = ".$row['userid']." LIMIT 1 ";
                
                $isFollowingQueryResult = mysqli_query($link, $isFollowingQuery);
                
                if (mysqli_num_rows($isFollowingQueryResult) > 0) {                
                    echo "Unfollow";
                } else {
                    echo "Follow";
                }
                    
                 echo "</a></p></div>";
                
            }
            } 
        }

   function displaySearch() {
       
       echo '<form class="form-inline">
  <div class="form-group">
    
    <input type="hidden" name="page" value="search">
    
    <input type="text" name="q" class="form-control" id="search" placeholder="Wyszukaj">
  </div>
  
  <button type="submit" class="btn btn-primary">'."Znajdź tweet'a".'</button>
</form>';
       
   }

    function displayTweetBox() {

        if ($_SESSION['id'] > 0) {

                echo '<div id="tweetPostedSuccess" class="alert alert-success">Twój tweet został wysłany poprawnie.</div>
                
                <div id="tweetPostedFailed" class="alert alert-danger">Twój tweet nie został wysłany.</div>
                
                <div class="form">
      <div class="form-group">

        <textarea class="form-control" id="tweetContent"></textarea>
        </div>
        
      <button id="postTweetButton"  class="btn btn-primary">'."Wytweetuj".'</button>
        </div>';


        }
    }

function displayUsers() {
    
    global $link;
    
     $query = "SELECT * FROM users LIMIT 10";
        
     $result = mysqli_query($link, $query);
                 
      while ( $row = mysqli_fetch_assoc($result) ) {
    
        echo "<p><a href='?page=publicprofiles&userid=".$row['id']."'>".$row['email']."</a></p>";
    
      }
}
    


?>