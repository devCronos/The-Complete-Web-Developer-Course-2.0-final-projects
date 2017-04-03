<div class="container mainContainer">
    <div class="row">
        <div class="col col-md-8">
            <?php if(isset($_GET['userid'])){ ?>
                <?php displayTweets($_GET['userid'])  ?>
            <?php }else { ?>
            <h2>Active Users</h2>

            <?php displayUsers(); ?>
            <?php } ?>
        </div>

        <div class="col-6 col-md-4">
            <?php dispalySearch(); ?>
            <hr>
            <?php dispalyTweetBox(); ?>
        </div>
    </div>
</div>