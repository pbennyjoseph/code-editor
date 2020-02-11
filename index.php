<?php
    session_start();
    $_SESSION['message'] = "secret";
    require_once('shared/config.php');
    require_once('shared/utils.php');
    $connection = new mysqli(DB_HOST,DB_USER,DB_PASSWD,DB_DATABASE);
    $jsslug = "undefined";
    $jskey = "undefined";
    $src = "";
    $ccodesrc = "#include <stdio.h>\n\nint main(){\n\t\n\treturn 0;\n}";
    // Check connection
    if ($connection -> connect_errno) {
        echo "Failed to connect to MySQL: " . $connection -> connect_error;
        exit();
    }
    if(isset($_GET['url'])){
        $slug = substr($_GET['url'],0,6);
        $key = substr($_GET['url'],6);
        $query = "SELECT * from mapping where slug='$slug'";
        $readonly = false;
        if($key == "")
            $readonly = true;
        if(!($result  = $connection->query($query))){
            die ('There was an error running query[' . $connection->error . ']');
        }
        if($result->num_rows > 0){
           while($row = $result->fetch_assoc()){
            //    var_dump($row);
               $src = $row["src"];
               $jsslug = $row["slug"];
               $jskey = $row["editkey"];
               $jsparams = $row["params"];
               $readonly = ($row['editkey']!=$key);
           }
        }
        else{
            die("404 Not Found");
        }
    }
    else {
        do{
            $string = generate_string(SLUG_CHARSET,6);
            $query = "SELECT * from mapping where `slug` LIKE '%$string%'";
            if(!($result  = $connection->query($query))){
                die ('There was an error running query[' . $connection->error . ']');
            }
        } while($result->num_rows > 0);
        $editkey = generate_string(SLUG_CHARSET,32);
        $query = "INSERT INTO mapping (src,params,slug,editkey) VALUES('$ccodesrc','{\"lang\": \"C\",\"inp\": \"\", \"out\" : \"\"}','$string','$editkey');";
        if(!($result  = $connection->query($query))){
            die ('There was an error running query[' . $connection->error . ']');
        }
        header("Location: /code/$string$editkey");
        exit();
    }
    $connection->close();
    // exit();
?>
<!DOCTYPE HTML>
<html>

<head>
    <title>Code Editor</title>
    <link rel="shortcut icon" href="favicon.ico" />

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css"
        integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.12.1/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.51.0/codemirror.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.51.0/theme/monokai.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.51.0/theme/idea.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.51.0/theme/ayu-mirage.css">
    <link rel="stylesheet" href="css/styles.css">
    <script type="text/javascript">
        <?php
        if ($readonly) echo "var SLUG_KEY = undefined;";
        else echo "var SLUG_KEY = '$jskey';";
        echo "var SLUG = '$jsslug';";
        echo "var PARAMS = JSON.parse('$jsparams');"; 
        ?>
    </script>
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <a class="navbar-brand" href="#">
            <img src="favicon.ico" width="30" height="30" class="d-inline-block align-top" alt="">
            CodeEditor
        </a>
        <!-- <a class="navbar-brand" href="#">CodeEditor</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
            aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button> -->

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item active">
                    <a class="nav-link" href="#">Home <span class="sr-only">(current)</span></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">About</a>
                </li>
            </ul>
        </div>
    </nav>

    <div class="row my-3 mx-2">
        <div class="col-sm-9">
            <div class="card">
                <div class="card-header" id="main-header">
                    <text>Language : </text><text id="lang">C</text>
                    <!-- <img id="lang-img" width="48px" height="48px" class="rounded" src="img/cpp.png" /> -->
                    <a href="#" id="lang-py" class="mx-1 float-right badge badge-warning">Python 3.6</a>
                    <a href="#" id="lang-js" class="mx-1 float-right badge badge-danger">Javascript</a>
                    <a href="#" id="lang-java" class="mx-1 float-right badge badge-success">Java 8</a>
                    <a href="#" id="lang-cpp" class="mx-1 float-right badge badge-dark">CPP 14</a>
                    <a href="#" id="lang-c" class="mx-1 float-right badge badge-primary">C</a>
                    <br>
                    <a href="#" id="theme-monokai" class="mx-1 float-right badge badge-dark">Monokai</a>
                    <a href="#" id="theme-idea" class="mx-1 float-right badge badge-light">Idea</a>
                    <a href="#" id="theme-ayu-mirage" class="mx-1 float-right badge badge-dark">ayu mirage</a>
                    <a href="#" id="theme-default" class="mx-1 float-right badge badge-default">default</a>
                    <i style="color:green" class="fas fa-check"></i><i class="fas fa-spinner fa-pulse"
                        style="display: none;"></i>
                </div>
                <div class="card-body" id="txtcard">

                    <textarea style="display: none" id="main-editor"><?php echo $src ?></textarea>
                    <button id="go" class="mx-1 my-2 float-right btn btn-primary">Compile and Run</button>

                    <button id="dl" type="button" class="float-right mx-1 my-2 btn btn-secondary" data-toggle="tooltip"
                        data-placement="bottom" title="Download this code">
                        <i class="fas fa-download"></i>
                    </button>

                    <button id="save" type="button" class="mx-1 my-2 btn btn-warning">
                        <i class="fas fa-save"></i>
                    </button>
                </div>
                <!-- <center><text class="">Ready.</text></center> -->

            </div>
        </div>
        <div class="col-sm-3">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Share</h5>
                    <p class="card-text"></p>
                    <p>
                        <button class="btn btn-primary" id="editshare" data-toggle="tooltip" data-placement="bottom"
                            title="Copy editable link">
                            <i class="fas fa-share-alt"></i> + <i class="fas fa-edit"></i>
                        </button>
                        <button class="btn btn-primary" id="readshare" data-toggle="tooltip" data-placement="bottom"
                            title="Copy Readonly Link">
                            <i class="fas fa-share-alt"></i>
                        </button>
                    </p>
                </div>

                <div id="wrongkey" class="mx-2 my-2 toast fade hide" role="alert" aria-live="assertive" data-delay="5000"
                aria-atomic="true">
                <div class="toast-header">
                    <strong class="mr-auto"><i class="fas fa-exclamation-triangle"></i></strong>
                    <small>from DataUpdater</small>
                    <button type="button" class="ml-2 mb-1 close" data-dismiss="toast" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="toast-body">
                    Oops! That was an incorrect key! Maybe this is a Read-Only Code
                </div>
            </div>

            <div id="updatesuccess" class="mx-2 my-2 toast fade hide" role="alert" aria-live="assertive" data-delay="3000"
                aria-atomic="true">
                <div class="toast-header">
                    <strong class="mr-auto"><i style="color:green" class="fas fa-check"></i></strong>
                    <small>from DataUpdater</small>
                    <button type="button" class="ml-2 mb-1 close" data-dismiss="toast" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="toast-body">
                    Updated in Database!
                </div>
            </div>

            </div>
        </div>
    </div>

    <div class="card col-sm-8 mx-4 my-2">
        <div class="card-body">
            <h5 class="card-title">Standard Input</h5>
            <textarea id="inp" class="form-control" style="min-width: 100%"></textarea>
        </div>
    </div>

    <div class="card col-sm-8 mx-4 my-2">
        <div class="card-body">
            <h5 class="card-title">Output</h5>
            <div id="output"></div>
        </div>
    </div>

    <!-- 
    <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js"
        integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous">
    </script> -->
    <script src="https://code.jquery.com/jquery-3.4.1.js"
        integrity="sha256-WpOohJOqMqqyKL9FccASB9O0KwACQJpFTUBLTYOVvVU=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"
        integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous">
    </script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"
        integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous">
    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.51.0/codemirror.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.51.0/mode/clike/clike.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.51.0/mode/python/python.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.51.0/mode/javascript/javascript.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.51.0/addon/edit/matchbrackets.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.51.0/addon/comment/comment.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.12.1/js/all.min.js"></script>


    <script src="js/main.js"></script>
</body>

</html>