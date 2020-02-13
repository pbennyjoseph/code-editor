function download(data, filename) {
    var n = new Blob([data], {
            type: "text/plain"
        }),
        s = window.URL.createObjectURL(n),
        l = document.createElement("a");
    l.href = s, l.download = filename, l.click()
}


// COPY TO CLIPBOARD
// Attempts to use .execCommand('copy') on a created text field
// Falls back to a selectable alert if not supported
// Attempts to display status in Bootstrap tooltip
// ------------------------------------------------------------------------------

function copyToClipboard(text, el) {
    var copyTest = document.queryCommandSupported('copy');
    var elOriginalText = el.attr('data-original-title');

    if (copyTest === true) {
        var copyTextArea = document.createElement("textarea");
        copyTextArea.value = text;
        document.body.appendChild(copyTextArea);
        copyTextArea.select();
        try {
            var successful = document.execCommand('copy');
            var msg = successful ? 'Copied!' : 'Whoops, not copied!';
            el.attr('data-original-title', msg).tooltip('show');
        } catch (err) {
            console.log('Oops, unable to copy');
        }
        document.body.removeChild(copyTextArea);
        el.attr('data-original-title', elOriginalText)
    } else {
        // Fallback if browser doesn't support .execCommand('copy')
        window.prompt("Copy to clipboard: Ctrl+C or Command+C, Enter", text);
    }
}

dataupdate = () => {
    $(".fa-check").hide();
    $(".fa-spinner").show();
    $("#save").prop('disabled',true);
    $.post("dataupdater.php", {
            slug: SLUG,
            key: SLUG_KEY || "",
            src: editor.getValue(),
            params: JSON.stringify({
                inp: escape($("#inp").val().trim()),
                out: escape($("#output").html()),
                lang: currentLang
            })
        },
        (data, status) => {
			window.scrollTo(0, 0);
            if(data == "Incorrect Key"){
                $('#wrongkey').toast('show');
            }
            else $('#updatesuccess').toast('show');
            
            $("#save").prop('disabled',false);
            $(".fa-check").show();
            $(".fa-spinner").hide();
        }
    );
}


let DATA_UPDATE_TIME = 10000;
var editor = this.editor = CodeMirror.fromTextArea(document.getElementById("main-editor"), {
    lineNumbers: true,
    mode: "text/x-c++src",
    indentUnit: 4,
    indentWithTabs: true,
    lineWrapping: true,
    viewportMargin: 50,
    readOnly: (SLUG_KEY==""),
    matchBrackets: true
});

// Write code to database every 5 seconds
var currentLang = PARAMS["lang"];

$("#go").on('click', function () {
    $("#output").html("");
    $(this).prop('disabled',true);
    $.post("coderunner.php", {
            src: editor.getValue(),
            inp: $("#inp").val().trim(),
            lang: currentLang
        },
        (data, status) => {
            $(this).prop('disabled',false);
            $("#output").html(data);
            console.log(status)
            window.scrollTo(0, document.body.scrollHeight);
        }
    );
})


$("#editshare").on('click', function() {
    console.log(this);
    copyToClipboard("http://benny/code/" + SLUG + SLUG_KEY,$(this))
})


$("#readshare").on('click', function() {
    copyToClipboard("http://benny/code/" + SLUG,$(this))
})


$("#lang-py").on('click', () => {
    this.editor.setOption("mode", "text/x-python")
    $("#lang").html("Python 3");
    currentLang = "PYTHON3"
    // $("#lang-img").attr('src','img/py.png')
})

$("#lang-c").on('click', () => {
    this.editor.setOption("mode", "text/x-csrc")
    $("#lang").html("C");
    currentLang = "C"
    // $("#lang-img").attr('src','img/c.png')
})
$("#lang-cpp").on('click', () => {
    this.editor.setOption("mode", "text/x-c++src")
    $("#lang").html("C++");
    currentLang = "CPP14"
    // $("#lang-img").attr('src','img/cpp.png')
})
$("#lang-js").on('click', () => {
    this.editor.setOption("mode", "text/javascript")
    $("#lang").html("Javascript");
    currentLang = "JAVASCRIPT"
    // $("#lang-img").attr('src','img/js.png')
})
$("#lang-java").on('click', () => {
    this.editor.setOption("mode", "text/x-java")
    $("#lang").html("Java 8");
    currentLang = "JAVA"
    // $("#lang-img").attr('src','img/java8.png')
})

$("#theme-idea,#theme-monokai,#theme-default,#theme-ayu-mirage").on('click', function () {
    editor.setOption("theme", this.id.slice("theme-".length, ));
});

$("#dl").on('click', () => {
    download(this.editor.getValue(), "solution");
})

$("#save").on('click', () => dataupdate())

$("#dl").tooltip();
$("#editshare").tooltip();
$("#readshare").tooltip();
$("#lang").html(currentLang);
$("#inp").html(unescape(PARAMS["inp"]));
$("#output").html(unescape(PARAMS["out"]));
// if (SLUG_KEY) setInterval(dataupdate, DATA_UPDATE_TIME);
$("script").remove();