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

    return '';
}

function setCookie(cname, cvalue, exdays) {
    var d = new Date();
    d.setTime(d.getTime() + (exdays*24*60*60*1000));
    var expires = "expires="+ d.toUTCString();
    document.cookie = cname + "=" + cvalue + ";" + expires + ";path=/";
}

function deleteCookie(cname) {
    document.cookie = `${cname}=; expires=Thu, 01 Jan 1970 00:00:00 UTC; path=/;`;
}

function changeLabel () {
    // this function serves to change the name of the label over the file input
    var asta = $('#inputFileId')[0].value;
    var aux = asta.split('\\')[asta.split('\\').length - 1];
    $('#labelId').html(aux)
}

function logout () {
    $.ajax(route('login.destroy'), {
        datatype: 'json',
        type: 'DELETE',
        headers: {
            'X-CSRF-Token': $('meta[name="_token"]').attr('content')
        },
        success: (response) => {
            window.onhashchange()
        }
    })
}

const routes = {
    product: {
        index: '/product',
        edit: '/product/{product}/edit',
        store: '/product',
        update: '/product/{product}',
        destroy: '/product/{product}',
    },
    index: {
        index: '/index',
        update: '/index/{product}'
    },
    cart: {
        index: '/cart',
        destroy: '/cart/{product}',
        store: '/cart'
    },
    order: {
        index: '/order',
        show: '/order/{order}'
    },
    login: {
        show: '/login',
        store: '/login',
        destroy: '/login/signout'
    }
}

// it returns the full path of he route
function route (routeName, params = []) {
    var urlBuilder = routes
    var finalUrl = ''
    $.each(routeName.split('.') ? routeName.split('.'): [], function(key,pieceOfUrl){
        urlBuilder = urlBuilder[pieceOfUrl]
        if (urlBuilder === undefined) {
            console.log(`%c error: There is no ${routeName} route`, 'color: red;')
            return
        }
    })
    if (urlBuilder === undefined) {
        return `error: There is no ${routeName} route`
    }
    var indexParams = 0;
    $.each(urlBuilder.split('/') ? urlBuilder.split('/'): [], function (key, piece) {
        if (key === 0) {
            // do nothing the first element will be '' (empty string) every time
        } else if (piece.match('{[a-zA-z]*}')) {
            if (indexParams < params.length) {
                finalUrl += `/${params[indexParams++]}`
            } else {
                console.log(`%c Error: wrong number of params at ${routeName} route`,'color: red;')
            }
        } else {
            finalUrl += `/${piece}`
        }
    })

    return finalUrl
}
