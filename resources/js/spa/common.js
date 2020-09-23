var translation = {
    "example of text" : "the real text",
    "Add" : "add",
    "add" : "Add"
}
function translate (string) {
    return (translation[string] === undefined) ? string : translation[string];
}

function getCookie (cname) {
    // source: "https://www.w3schools.com/js/js_cookies.asp"
    var name = cname + "=";
    var ca = document.cookie.split(';');
    for(var i = 0; i < ca.length; i++) {
        var c = ca[i];
        while (c.charAt(0) == ' ') {
            c = c.substring(1);
        }
        if (c.indexOf(name) == 0) {
            return c.substring(name.length, c.length);
        }
    }
    return "";
}

function changeLabel () {
    // this function serves to change the name of the label over the file input
    var asta = $('#inputFileId')[0].value;
    var aux = asta.split('\\')[asta.split('\\').length - 1];
    $('#labelId').html(aux)
}
