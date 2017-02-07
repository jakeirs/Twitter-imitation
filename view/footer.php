<footer class="footer">
    <div class="container">
    <p>&copy;Szymon Wojciechowski <small>2016</small></p>

    </div>
</footer>






<!-- jQuery first, then Tether, then Bootstrap JS. -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js" integrity="sha384-3ceskX3iaEnIogmQchP8opvBy3Mi7Ce34nWjpBIwVTHfGYWQS9jwHDVRnpKKHJg7" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/tether/1.3.7/js/tether.min.js" integrity="sha384-XTs3FgkjiBgo8qjEjBk0tGmf3wPrWtA6coPfQDfFEY8AnYJwjalXCiosYRBIBZX8" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.5/js/bootstrap.min.js" integrity="sha384-BLiI7JTZm+JWlgKa0M0kGRpJbF2J8q+qreVrKBC47e3K6BW78kGLrCkeRX6I9RoK" crossorigin="anonymous"></script>
    
<!-- Modal -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
        <h4 class="modal-title" id="modalLoginTitle">Login</h4>
      </div>
      <div class="modal-body">
          <div class="alert alert-danger" id="loginAlert">
          </div>
          
        <form method="post">
            <input type="hidden" id="loginActive" name="loginActive" value="1">
  <div class="form-group">
    <label for="email">Email</label>
    <input type="email" class="form-control" id="email" placeholder="Email Address" required>
  </div>
  <div class="form-group">
    <label for="password">Password</label>
    <input type="password" class="form-control" id="password" placeholder="Password" required>
  </div>
</form>
          
      </div>
      <div class="modal-footer">
          <a id="toggleLogin" href="#">Sign up</a>
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary" id="loginSignupButton">Login</button>
      </div>
    </div>
  </div>
</div>

<script>

    $("#toggleLogin").click(function() {
        if ($("#loginActive").val() == 1) {
            
           $("#loginActive").val("0");
           $("#modalLoginTitle").html("Sign Up");
           $("#loginSignupButton").html("Sign Up");
           $("#toggleLogin").html("Login");
      } else {
            $("#loginActive").val("1");
           $("#modalLoginTitle").html("Login");
           $("#loginSignupButton").html("Login");
           $("#toggleLogin").html("Sign Up");
        }
        })
    
    $("#loginSignupButton").click(function() {
        $.ajax({
            type: "POST",
            url: "action.php?action=loginSignup",
            data: "email=" + $("#email").val() + "&password=" + $("#password").val()
             + "&loginActive=" + $("#loginActive").val(),
            success: function(result) {
                if (result == "success") {
                    window.location.assign("http://79.170.40.40/meerfi.com/12-twitter/");
                } else {
                    $("#loginAlert").html(result).css("display", "block");
                    
                }
                
            }
        })
    })
       
    $(".toggleFollow").click(function() {
        
        var idOfUser = $(this).attr("data-userid");
        
        $.ajax({  // metodą POST przenoszę wartość userId, czyli id użytkowników, do których należą posty
            type: "POST",
            url: "action.php?action=toggleFollow",
            data: "userId=" + idOfUser,
            success: function(result) {
                
                if (result == "unfollowed") {
                    
                    $("a[data-userId='"+ idOfUser + "']").html("Follow");
                } else if (result == "followed") {
                    
                    $("a[data-userId='" + idOfUser + "']").html("Unfollow");
                }
                }
            })
    })
    
    $("#postTweetButton").click(function() {
        
         $.ajax({  // metodą POST przenoszę wartość userId, czyli id użytkowników, do których należą posty
            type: "POST",
            url: "action.php?action=postTweet",
            data: "tweetContent=" + $("#tweetContent").val(),
            success: function(result) {
                
               if (result == "posted") {
                   $("#tweetPostedFailed").hide();
                   $("#tweetPostedSuccess").show();
                   
               } else if (result != "") {
                   
                   $("#tweetPostedSuccess").hide(); $("#tweetPostedFailed").html(result).show();
               }
            }
      })  
    })

</script>


  </body>
</html>