<html>

<head>
    <script src="https://code.jquery.com/jquery-3.3.1.min.js" crossorigin="anonymous"></script>
    <link href="https://fonts.googleapis.com/css?family=Roboto+Slab|Ubuntu&display=swap" rel="stylesheet">
    <style>
    body{
        font-family: 'Roboto Slab', serif;
    }
    </style>
</head>

<body>

    <a href="https://codeforces.com/profile/bennyjoseph" style="text-decoration:none" target="_blank">&copy;
        bennyjoseph</a>
    <div>A College ID card has 0 on one side and 1 on the other.</div>There are N students with these ID cards.
    <div>They are numbered from <b>1</b> to <b>N</b> (Roll Numbers)</div>
    <div>Initially all of them wear ID card so that the '0' is visible</div>
    <div>You are given <b>Q</b> Queries of type 'R' , 'F', or 'T'</div>
    <div><b><br></b></div>
    <div><b>Type</b>&nbsp;'R' Query</div>
    <div><b>R a b</b></div>
    <div>Only the students with roll number <b>a</b> &lt;=<b> x</b> &lt;= <b>b</b> flip their ID card (Not their
        friends)</div>
    <div>
        <br>
    </div>
    <div><b>Type </b>'F' Query</div>
    <div><b>F a b</b></div>
    <div>The student a is friends with student b.</div>
    <div>
        <br>
    </div>
    <div><b>Type </b>'T' Query</div>
    <div><b>T</b> <b>x</b></div>
    <div>The student <b>x</b> flips his id card. All of his friends also flip their ID card</div>
    <div>
        <br>
    </div>
    <div><b>Finally print the number of students with id card showing '1'</b></div>
    <div>
        <br>
    </div>


    <div><b>Definitions:</b></div>
    <div>"<b>Flip the ID card</b>" a card facing '0' is made to face '1' and vice versa</div>
    <div>"<b>Friendship</b>" is transitive, i.e if <b>a</b> is friends with <b>b</b> and <b>b</b> is friends</div>
    <div>&nbsp;with <b>c</b> then <b>a</b> is friends with <b>c</b></div>
    <div>
        <br>
    </div>
    <div><b>Constraints:</b></div>
    <div>
        <font color="#4a4a4a"
            face="Segoe UI, Helvetica Neue, Helvetica, Lucida Grande, Arial, Ubuntu, Cantarell, Fira Sans, sans-serif">
            <span style="font-size: 17px; white-space: pre-wrap; background-color: rgb(230, 230, 230);"><b>1 &lt;= N &lt;= 10^5</b></span></font>
    </div>
    <div>
        <font color="#4a4a4a"
            face="Segoe UI, Helvetica Neue, Helvetica, Lucida Grande, Arial, Ubuntu, Cantarell, Fira Sans, sans-serif">
            <span style="font-size: 17px; white-space: pre-wrap; background-color: rgb(230, 230, 230);"><b>1 &lt;= a &lt;= b &lt;= N</b></span></font>
    </div>
    <div>
        <font color="#4a4a4a"
            face="Segoe UI, Helvetica Neue, Helvetica, Lucida Grande, Arial, Ubuntu, Cantarell, Fira Sans, sans-serif">
            <span style="font-size: 17px; white-space: pre-wrap; background-color: rgb(230, 230, 230);"><b>1 &lt;= x &lt;= N</b></span></font>
    </div>
    <div>
        <font color="#4a4a4a"
            face="Segoe UI, Helvetica Neue, Helvetica, Lucida Grande, Arial, Ubuntu, Cantarell, Fira Sans, sans-serif">
            <span style="font-size: 17px; white-space: pre-wrap; background-color: rgb(230, 230, 230);"><b>1 &lt;= Q &lt;= 10^6</b></span></font>
    </div>
    <br>
    <b>Input format:</b>
    <div>First line contains two integers <b>N</b> and <b>Q</b><br></div>
    <div>next <b>Q</b>&nbsp;lines contain the queries which are space-separated</div>
    <div><br></div>
    <div><b>Sample Input:</b></div>
    <div>3 3</div>
    <div>R 1 3</div>
    <div>R 1 2</div>
    <div>F 1 2</div>
    <div><br></div>
    <div><b>Sample Output:</b></div>
    <div>1</div>
    <div><br></div>
    <b>Explanation:</b>
    <div>Initially all three are zero</div>
    <div>0 0 0</div>
    <div>after the first query</div>
    <div>1 1 1</div>
    <div>after second query</div>
    <div>0 0 1</div>
    <div>after third query</div>
    <div>0 0 1</div>
    <div><br></div>
    <div>Hence the total number of ones is 1</div>
    <div>
        <div><br>
            <div><br></div>
        </div>
    </div>
    <div><b><br></b></div>
    <div><b><br></b></div>
    <div>
        <p id="response"> </p>
        <textarea id="inp" id="" cols="30" rows="10" maxlength="512" placeholder="Enter custom input here">
3 3
R 1 3
R 1 2
F 1 2
        </textarea>
        <button id="sub">See expected output</button>
        <br>
    </div>
    


</body>

<script>
    $('#sub').prop('disabled', true);

    $(function () {
        $('#inp').keyup(function () {
            if ($(this).val() == '') {
                $('#sub').prop('disabled', true);
            } else {
                $('#sub').prop('disabled', false);
            }
        });
    });

    var btn = $("#sub");
    $("#sub").click(function () {
        var txt = $("#inp").val();
        $('#sub').prop('disabled', true);
        $("#response").html("Loading....");
        $.post("coderunner.php", {
            inp: txt
        }, function (result) {
            $("#response").html(result);
            $('#sub').prop('disabled', false);
        });
    });
</script>

</html>