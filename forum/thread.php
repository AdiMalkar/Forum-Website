<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/css/bootstrap.min.css"
        integrity="sha384-zCbKRCUGaJDkqS1kPbPd7TveP5iyJE0EjAuZQTgFLD2ylzuqKfdKlfG/eSrtxUkn" crossorigin="anonymous">
    <style>
    #ques {
        min-height: 433px;
    }
    </style>
    <title>Welcome to iDiscuss - Coding Forum</title>
</head>

<body>
    <?php include 'partials/_dbconnect.php'; ?>
    <?php include 'partials/_header.php'; ?>
    <?php include 'partials/_loginModal.php'; ?>
    <?php include 'partials/_signupModal.php'; ?>
    <?php
    $id = $_GET['threadid'];
    $sql = "SELECT * FROM threads WHERE thread_id = $id";
    $result = mysqli_query($conn, $sql);
    while ($row = mysqli_fetch_assoc($result)) {
        $title = $row['thread_title'];
        $desc = $row['thread_desc'];
    }
    ?>

    <?php
    $method = $_SERVER['REQUEST_METHOD'];
    $showAlert = false;
    if ($method=='POST') {
        // Insert Record Into comment DB
        $comment = $_POST['comment']; 
        $sno = $_POST['sno'];
        $sql = "INSERT INTO `comments` ( `comment_content`, `thread_id`, `comment_by`, `comment_time`) VALUES ('$comment', '$id', '$sno', current_timestamp())";
        $result = mysqli_query($conn, $sql);
        $showAlert = true;
        if ($showAlert) {
            echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
                        <strong>Success! </strong> Your comment has been added successfully!
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                     </div>';
        }
    } 
    ?>

    <!-- Category starts here  -->
    <div class="container my-2">
        <div class="jumbotron">
            <h1 class="display-4"><?php echo $title;?></h1>
            <p class="lead"><?php echo $desc;?></p>
            <p><b>Posted By: </b></p>
            <hr class="my-4">
            <p>This forum is for sharing knowledge with everyone.
            <ol>
                <li>No Spam / Advertising / Self-promote in the forums. ... </li>
                <li>Do not post copyright-infringing material. ... </li>
                <li>Do not post “offensive” posts, links or images. ... </li>
                <li>Do not cross post questions. ... </li>
                <li>Remain respectful of other members at all times. </li>
            </ol>
            </p>
        </div>
    </div>
    <div class="container">
    <h1 class="py-2">Post a Comment</h1>
    </div>
    <?php
    if (isset($_SESSION['loggedin']) && $_SESSION['loggedin']==true) {
        echo '<div class="container">
        <form action="'.$_SERVER["REQUEST_URI"].'" method="post">
            <div class="form-group">
                <label for="exampleFormControlTextarea1">Type your comment</label>
                <textarea class="form-control" id="comment" name="comment" rows="3"></textarea>
                <input type="hidden" name="sno" value="'.$_SESSION['sno'].'">
            </div>
            <button type="submit" class="btn btn-success">Post Comment</button>
        </form>
    </div>';
    }
    else {
        echo '<div class="alert alert-primary" role="alert">
        <p class="lead my-0">You are not logged in. Login First to reply to this post.</p>
      </div>';
    }
    
    ?>
    <div class="container" id="ques">
        <h1 class="py-2">Discussion</h1>
        <?php
        $id = $_GET['threadid'];
        $sql = "SELECT * FROM `comments` WHERE thread_id= $id";
        $result = mysqli_query($conn, $sql);
        $noResult = true;
        while ($row = mysqli_fetch_assoc($result)) {
            $noResult = false;
            $id = $row['comment_id'];
            $content = $row['comment_content'];
            $comment_time = $row['comment_time'];
            $thread_user_id = $row['comment_by'];
            $sql2 = "SELECT user_email FROM `users`WHERE sno = '$thread_user_id'";
            $result2 = mysqli_query($conn, $sql2);
            $row2 = mysqli_fetch_assoc($result2);
            
            echo '<div class="media my-3">
            <img src="images/ud.png" width="54px" class="mr-3" alt="...">
            <div class="media-body py-2">
                <p class = "font-weight-bold my-0">Posted By: '.$thread_user_id.' at '.$comment_time.'</p>
                <p>'. $content .'</p>
            </div>
            </div>';
        }
        // Check if there are any results in the database
        if ($noResult) {
            echo '<div class="jumbotron jumbotron-fluid">
                <div class="container">
                <p class="display-5">No Threads Found.</p>
                <p class="lead">Be the first person to ask a question.</p>
                </div>
            </div>';
        }
        ?>
        <!-- <div class="media my-3">
            <img src="images/ud.png" width="34px" class="mr-3" alt="...">
            <div class="media-body py-2">
                <h5 class="mt-0">Installation error of pyaudio in windows</h5>
                <p>Standing on the frontline when the bombs start to fall. Heaven is jealous of our love, angels are
                    crying from up above. Can't replace you with a million rings. Boy, when you're with me I'll give you
                    a taste. There's no going back. Before you met me I was alright but things were kinda heavy. Heavy
                    is the head that wears the crown.</p>
            </div>
        </div> -->
    </div>

    <?php include 'partials/_footer.php'; ?>

    <!-- Optional JavaScript; choose one of the two! -->

    <!-- Option 1: jQuery and Bootstrap Bundle (includes Popper) -->
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.slim.min.js"
        integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-fQybjgWLrvvRgtW6bFlB7jaZrFsaBXjsOMm/tB9LTS58ONXgqbR9W8oWht/amnpF" crossorigin="anonymous">
    </script>

    <!-- Option 2: Separate Popper and Bootstrap JS -->
    <!--
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/js/bootstrap.min.js" integrity="sha384-VHvPCCyXqtD5DqJeNxl2dtTyhF78xXNXdkwX1CZeRusQfRKp+tA7hAShOK/B/fQ2" crossorigin="anonymous"></script>
    -->
</body>

</html>