<div class="container mainContainer">
    <div class="row">
        <div class="col-md-8">
        
            <h1>Twoje tweety</h1>
            
            <?php displayTweets('yourtweets'); ?>
        
        </div>
        <div class="col-md-4">
        
           <?php displaySearch(); ?>
            
            <hr>
            
           <?php displayTweetBox(); ?>
        
        
        </div>
    </div>
</div>