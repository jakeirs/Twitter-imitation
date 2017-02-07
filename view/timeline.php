<div class="container mainContainer">
    <div class="row">
        <div class="col-md-8">
        
            <h1>Tweets you are following</h1>
            
            <?php displayTweets('isFollowing'); ?>
        
        </div>
        <div class="col-md-4">
        
           <?php displaySearch(); ?>
            
            <hr>
            
           <?php displayTweetBox(); ?>
        
        
        </div>
    </div>
</div>