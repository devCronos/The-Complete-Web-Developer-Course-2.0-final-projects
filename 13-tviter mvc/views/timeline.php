<div class="container mainContainer">
    <div class="row">
        <div class="col col-md-8">
            <h2>Tweets for you</h2>

            <?php displayTweets('isFollowing'); ?>
        </div>

        <div class="col-6 col-md-4">
            <?php dispalySearch(); ?>
            <hr>
            <?php dispalyTweetBox(); ?>
        </div>
    </div>
</div>