<?php

	ini_set('display_errors', '1');
    ini_set('error_reporting', E_ALL);

    require_once "./sdk/index.php";

    //Setting up the Hackerearth API
    $hackerearth = Array(
		'client_secret' => 'fdf490fb4652f76a7da15c4c2bf5ea33f3028b68', //(REQUIRED) Obtain this by registering your app at http://www.hackerearth.com/api/register/
        'time_limit' => '1',   //(OPTIONAL) Time Limit (MAX = 5 seconds )
        'memory_limit' => '26214444'  //(OPTIONAL) Memory Limit (MAX = 262144 [256 MB])
    );

    if(isset($_POST['src'])){
        $code = $_POST['src'];
        $config = Array();
        $config['time']='1';	 	//(OPTIONAL) Your time limit in integer and in unit seconds
        $config['memory']='26214444'; //(OPTIONAL) Your memory limit in integer and in unit kb
        $config['source']=$code;    	//(REQUIRED) Your source code for which you want to use hackerEarth api
        $config['input']=$_POST['inp'];     	//(OPTIONAL) Input against which you have to test your source code
        $config['language']=$_POST['lang'];   	//(REQUIRED) Choose any one of them 
                            // C, CPP, CPP11, CLOJURE, CSHARP, JAVA, JAVASCRIPT, HASKELL, PERL, PHP, PYTHON, RUBY
        $responseOfRun = run($hackerearth,$config);
        $r = $responseOfRun["run_status"];
        if ($r["status"] == "CE"){
           echo "<text class='bg-warning'>" . $responseOfRun["compile_status"] . "</text>";
           exit(2);
        }
        echo '<div class="output hidden" id="output" style="border: 1px dashed rgb(204, 204, 204); padding: 20px;">
        <div class="content-heading-bold" replacedata="false" style="color: rgb(37, 44, 51); font-size: 14px; font-weight: 600;">Output</div>
        <div class="less-margin" style="margin: 5px 0px 0px;">
           <pre class="word-spacing-0" style="overflow-x: auto; word-spacing: 0px;">'.$r["output_html"].'
     </pre>
        </div>
        <div class="content-heading-bold medium-margin" style="margin: 20px 0px 0px; color: rgb(37, 44, 51); font-size: 14px; font-weight: 600;">Input</div>
        <div class="less-margin" style="margin: 5px 0px 0px;">
           <pre class="light" style="overflow-x: auto; color: rgb(0, 0, 0);">'.$config['input'].'</pre>
        </div>
        <div class="float-left col" style="float: left; width: 110.688px; margin: 20px 30px 0px 0px;">
           <div class="content-heading-bold" style="color: rgb(37, 44, 51); font-size: 14px; font-weight: 600;">Time (sec)</div>
           <div class="less-margin body-font dark" style="color: rgb(70, 83, 94); margin: 5px 0px 0px;">'.$r["time_used"].'</div>
        </div>
        <div class="float-left col" style="float: left; width: 110.688px; margin: 20px 30px 0px 0px;">
           <div class="content-heading-bold" style="color: rgb(37, 44, 51); font-size: 14px; font-weight: 600;">Memory (KB)</div>
           <div class="less-margin body-font dark" style="color: rgb(70, 83, 94); margin: 5px 0px 0px;">'.$r["memory_used"].'</div>
        </div>
        <div class="float-left col" style="float: left; width: 110.688px; margin: 20px 30px 0px 0px;">
           <div class="content-heading-bold" style="color: rgb(37, 44, 51); font-size: 14px; font-weight: 600;">Status</div>
           <div class="less-margin body-font dark" style="color: rgb(70, 83, 94); margin: 5px 0px 0px;">'.$r["status"].'</div>
        </div>
        <div class="float-left col" style="float: left; width: 110.688px; margin: 20px 30px 0px 0px;">
           <div class="content-heading-bold" style="color: rgb(37, 44, 51); font-size: 14px; font-weight: 600;">Status Detail</div>
           <div class="less-margin body-font dark" style="color: rgb(70, 83, 94); margin: 5px 0px 0px;">'.$r["status_detail"].'</div>
        </div>
        <div class="clear" style="clear: both;"></div>
     </div>';
    }
?>