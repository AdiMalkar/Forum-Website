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
    $id = $_GET['catid'];
    $sql = "SELECT * FROM `categories` WHERE category_id = $id";
    $result = mysqli_query($conn, $sql);
    while ($row = mysqli_fetch_assoc($result)) {
        $catname = $row['category_name'];
        $catdesc = $row['category_description'];
    }
    ?>
    <?php
    $method = $_SERVER['REQUEST_METHOD'];
    $showAlert = false;
    if ($method=='POST') {
        // Insert Record Into DB
        $th_title = $_POST['title'];
        $th_desc = $_POST['desc']; 
        $sno = $_POST['sno'];
        $sql = "INSERT INTO `threads` (`thread_title`, `thread_desc`, `thread_cat_id`, `thread_user_id`, `timestamp`) VALUES ( '$th_title', '$th_desc', '$id', '$sno', current_timestamp())";
        $result = mysqli_query($conn, $sql);
        $showAlert = true;
        if ($showAlert) {
            echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
                        <strong>Success! </strong> Your question has been added successfully. Please for community to responds.
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
            <h1 class="display-4">Welcome to <?php echo $catname;?> Forum</h1>
            <p class="lead"><?php echo $catdesc;?></p>
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
            <a class="btn btn-success btn-lg" href="#" role="button">Learn more</a>
        </div>
    </div>
    <div class="container">
    <h1 class="py-2">Start a Discussion</h1>
    </div>
    <?php
    if (isset($_SESSION['loggedin']) && $_SESSION['loggedin']==true) {
        echo '<div class="container">
        <form action="'.$_SERVER["REQUEST_URI"].'" method="post">
    <div class="form-group">
        <label for="exampleInputEmail1">Problem Title</label>
        <input type="text" class="form-control" id="title" name="title" aria-describedby="emailHelp">
        <small id="emailHelp" class="form-text text-muted">Keep your title as short as possible.</small>
    </div>
    <input type="hidden" name="sno" value="'.$_SESSION['sno'].'">
    <div class="form-group">
        <label for="exampleFormControlTextarea1">Elaborate your concern here</label>
        <textarea class="form-control" id="desc" name="desc" rows="3"></textarea>
    </div>
    <button type="submit" class="btn btn-success">Submit</button>
    </form>
    </div>';
    }
    else{
    echo '<div class="alert alert-primary" role="alert">
    <p class="lead my-0">You are not logged in. Login First to post your query/concern in the forum.</p>
  </div>';
    }

    ?>
    <div class="container" id="ques">
        <h1 class="py-2">Browse Questions</h1>
        <?php
        $id = $_GET['catid'];
        $sql = "SELECT * FROM `threads` WHERE thread_cat_id= $id";
        $result = mysqli_query($conn, $sql);
        $noResult = true;
        while ($row = mysqli_fetch_assoc($result)) {
            $noResult = false;
            $id = $row['thread_id'];
            $title = $row['thread_title'];
            $desc = $row['thread_desc'];
            $thread_time = $row['timestamp'];
            $thread_user_id = $row['thread_user_id'];
            $sql2 = "SELECT user_email FROM `users`WHERE sno = '$thread_user_id'";
            $result2 = mysqli_query($conn, $sql2);
            $row2 = mysqli_fetch_assoc($result2);
            
            echo '<div class="media my-3">
            <img src="images/ud.png" width="34px" class="mr-3" alt="...">
            <div class="media-body py-2">'.
                '<h5 class="mt-0"><a class="text-dark" href="thread.php?threadid='.$id.'">'. $title .'</a></h5>
                <p>'. $desc .'</p> </div>'.'<p class = "font-weight-bold my-0">Posted By: '.$row2['user_email'].' at '.$thread_time.'</p>'.
            '</div>';
        }
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