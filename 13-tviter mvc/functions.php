<?php
    session_start();

    $link = mysqli_connect("127.0.0.1","root","","twitter");
    if(mysqli_connect_errno()){
        print_r(mysqli_connect_error());
        exit();
    }
    if (isset($_GET['function']) && $_GET['function'] == "logout") {
        session_unset();
    }

function time_since($since) {
    $chunks = array(
        array(60 * 60 * 24 * 365 , 'year'),
        array(60 * 60 * 24 * 30 , 'month'),
        array(60 * 60 * 24 * 7, 'week'),
        array(60 * 60 * 24 , 'day'),
        array(60 * 60 , 'hour'),
        array(60 , 'min'),
        array(1 , 'second')
    );

    for ($i = 0, $j = count($chunks); $i < $j; $i++) {
        $seconds = $chunks[$i][0];
        $name = $chunks[$i][1];
        if (($count = floor($since / $seconds)) != 0) {
            break;
        }
    }

    $print = ($count == 1) ? '1 '.$name : "$count {$name}s";
    return $print;
}

    function displayTweets($type){
        global $link;
        $whereClause = "";
        if($type == 'public'){
            $whereClause = "";
        }else if($type == 'isFollowing'){
            if(isset($_SESSION['id'])) {
                $query = "SELECT * FROM isfollowing WHERE follower = " . mysqli_real_escape_string($link, $_SESSION['id']);
                $result = mysqli_query($link, $query);


                while ($row = mysqli_fetch_assoc($result)) {
                    if ($whereClause == "") $whereClause = "WHERE";
                    else $whereClause .= " OR";
                    $whereClause .= "`userid`=" . $row['following'];
                }
            }
        }else if($type == 'yourtweets'){
            if (isset($_SESSION['id'])) {
                $whereClause = " WHERE `userid` =" . mysqli_real_escape_string($link, $_SESSION['id']);
            }
        }else if($type == 'search'){
            echo "<p>Showing results for '".mysqli_real_escape_string($link,$_GET['q'])."'</p>" ;
            $whereClause = " WHERE `tweet` LIKE '%".mysqli_real_escape_string($link,$_GET['q'])."%'";
        }else if(is_numeric($type)){
            $userQuery = "SELECT * FROM users WHERE id = ".mysqli_real_escape_string($link,$type)." LIMIT 1";
            $userQueryResult = mysqli_query($link,$userQuery);
            $user = mysqli_fetch_assoc($userQueryResult);
            echo "<h2>".mysqli_real_escape_string($link,$user['email'])."'s Tweets</h2>";
            $whereClause = "WHERE `userid`=".mysqli_real_escape_string($link,$type);
        }
        $query = "SELECT * FROM tweets ".$whereClause." ORDER BY `datetime` DESC LIMIT 10 ";
        $results = mysqli_query($link,$query);
        if(mysqli_num_rows($results) == 0) {
            echo "There are no tweets to display";
        }else{
            while($row = mysqli_fetch_assoc($results)){
                $userQuery = "SELECT * FROM users WHERE id = ".mysqli_real_escape_string($link,$row['userid'])." LIMIT 1";
                $userQueryResult = mysqli_query($link,$userQuery);
                $user = mysqli_fetch_assoc($userQueryResult);
//                echo time();
//                echo " ";
//                echo strtotime($row['datetime']);
                echo "<div class='tweet'><p><a href='?page=publicprofiles&userid=".$user['id']."'>".$user['id']."'>".$user['email']."</a><span class='time'> ".time_since(time() - strtotime($row['datetime'])+3600)." ago </span></p>";
                echo "<p>".$row['tweet']."</p>";
                echo "<hr>";
                echo "<p><a class='toggleFollow' data-userId='".$row['userid']."' role=\"button\" style='color:#3366BB;'>";

                if(isset($_SESSION['id'])) {
                    $isFollowingQuery = "SELECT * FROM `twitter`.`isfollowing` WHERE `follower` = " . mysqli_real_escape_string($link, $_SESSION['id']) . "  AND `following` = " . mysqli_real_escape_string($link, $row['userid']) . " LIMIT 1 ";
                    $isFollowingQueryResult = mysqli_query($link, $isFollowingQuery);
                    if (mysqli_num_rows($isFollowingQueryResult) > 0) {
                        echo "Unfollow";
                    } else {
                        echo "Follow";
                    }
                }
                echo "</a></p></div>";
            }
        }
    }

    function dispalySearch(){
        echo "<form class='form-inline'>
                  <div class='form-group'>
                        <input type='hidden' name='page' value='search'> 
                        <input type='text' name='q' class='form-control' id='search' placeholder='search'>
                  </div>
                  <button type='submit' class='btn btn-primary'>Search</button>
              </form>";
    }
    function dispalyTweetBox() {
        if(isset($_SESSION['id'])){
            echo "<div id='tweetSuccess' class='alert alert-success'>Your tweet was posted successfully.</div>
                    <div id='tweetFail' class='alert alert-danger'></div>
            <div class='form'>
                  <div class='form-group'>
                        <div class=\"form-group\">
                            <textarea class=\"form-control\" id=\"tweetContent\" rows=\"5\" placeholder=\"Write your tweets here.\"></textarea>
                        </div>
                  </div>
                  <button type='submit' class='btn btn-primary' id='postTweetButton'> Post tweet </button>
            </div>";
        }
    }
    function displayUsers(){
        global $link;
        $query = "SELECT * FROM users LIMIT 10 ";
        $results = mysqli_query($link,$query);
        while($row = mysqli_fetch_assoc($results)){
            echo "<p><a href='?page=publicprofiles&userid=".$row['id']."'>".$row['email']."</a></p>";
        }
    }
?>