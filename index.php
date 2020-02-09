<!DOCTYPE HTML>
<html>

<head>
    <title>Code Editor</title>
    <link rel="shortcut icon" href="favicon.ico" />

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css"
        integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <link rel="stylesheet" href="codemirror-5.51.0/lib/codemirror.css">
    <link rel="stylesheet" href="codemirror-5.51.0/theme/monokai.css">
    <link rel="stylesheet" href="codemirror-5.51.0/theme/idea.css">
    <link rel="stylesheet" href="codemirror-5.51.0/theme/ayu-mirage.css">
    <link rel="stylesheet" href="css/styles.css">
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
                <!-- <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button"
                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Dropdown
                    </a>
                    <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                        <a class="dropdown-item" href="#">Action</a>
                        <a class="dropdown-item" href="#">Another action</a>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="#">Something else here</a>
                    </div>
                </li> -->
            </ul>
            <!-- <form class="form-inline my-2 my-lg-0">
                <input class="form-control mr-sm-2" type="search" placeholder="Search" aria-label="Search">
                <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>
            </form> -->
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
                </div>
                <div class="card-body" id="txtcard">
                    <textarea style="display: none" id="main-editor"></textarea>
                    <button id="go" class="mx-1 my-2 float-right btn btn-primary" >Compile and Run</button>
                </div>
                <!-- <center><text class="">Ready.</text></center> -->

            </div>
        </div>
        <div class="col-sm-3">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Special title treatment</h5>
                    <p class="card-text">With supporting text below as a natural lead-in to additional content.</p>
                    <a href="#" class="btn btn-primary">Go somewhere</a>
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
    <script src="codemirror-5.51.0/lib/codemirror.js"></script>
    <script src="codemirror-5.51.0/mode/clike/clike.js"></script>
    <script src="codemirror-5.51.0/mode/python/python.js"></script>
    <script src="codemirror-5.51.0/mode/javascript/javascript.js"></script>
    <script src="codemirror-5.51.0/addon/edit/matchbrackets.js"></script>
    <script src="codemirror-5.51.0/addon/comment/comment.js"></script>

    <script src="js/main.js"></script>
</body>

</html>