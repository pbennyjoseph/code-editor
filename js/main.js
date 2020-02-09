
var editor = this.editor = CodeMirror.fromTextArea(document.getElementById("main-editor"), {
    lineNumbers: true,
    mode: "text/x-c++src",
    indentUnit: 4,
    indentWithTabs: true,
    lineWrapping: true,
    viewportMargin: 50,
    matchBrackets: true
});

var currentLang = "C"

$("#go").on('click', function () {
    $("#output").html("");
    $(this).hide();
    $.post("coderunner.php",
        {
            src: editor.getValue(),
            inp: $("#inp").val(),
            lang: currentLang
        },
       (data, status) => {
            $(this).show();
            $("#output").html(data);
            console.log(status)
        }
    );
})
$("#lang-py").on('click', () => {
    this.editor.setOption("mode", "text/x-python")
    $("#lang").html("Python 3");
    currentLang = "PYTHON"
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
$("script").remove();