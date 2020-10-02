function Login() {
    this.loginFunction = function () {
        var username = $('[name="usernameField"]')[0].value;
        var password = $('[name="passwordField"]')[0].value;

        $.ajax(route('login.store'), {
            dataType: 'json',
            type: 'POST',
            headers: {
                'X-CSRF-Token': $('meta[name="_token"]').attr('content')
            },
            data: {
                'usernameField': username,
                'passwordField': password,
            },
            success: function (response) {
                var oldRoute = getCookie('oldRoute')
                deleteCookie('oldRoute')
                if (oldRoute === '#login') {
                    window.location.hash = '#products';
                } else {
                    window.location.hash = oldRoute
                }
            },
            error: function (request) {
                $('.login .list span').remove();
                if (request.status === 422) {
                    if (request.responseJSON.errors.usernameField !== undefined) {
                        $('.login .list [name="usernameField"]')
                            .after(`<span class="errorSpan">${request.responseJSON.errors.usernameField}</span>`);
                    }
                    if (request.responseJSON.errors.passwordField !== undefined) {
                        $('.login .list [name="passwordField"]')
                            .after(`<span class="errorSpan">${request.responseJSON.errors.passwordField}</span>`);
                    }
                } else {
                    // 401 wrong username or password
                    $('.login .list [name="loginButton"]')
                        .after(`<span class="errorSpan">${translate('Wrong username or passwrod')}</span>`);
                }

            }
        });
    }
    this.renderLogin = function () {
        html = `<tr>
                <td>
                    <input type="text" name="usernameField" placeholder="username">
                </td>
            </tr>
            <tr>
                <td>
                    <input type="password" name="passwordField" placeholder="password">
                </td>
            </tr>
            <tr>
                <td>
                    <button
                    name="loginButton"
                    onclick="router._login.loginFunction()"
                    >
                        ${translate('Login')}
                    </button>
                </td>
            </tr>`
        return html
    }
    this.init = function () {
        // Show the login page
        $('.login').show();
        $('.login .list').empty().html(this.renderLogin());
    }
    this.destroy = () => {
        $('.login .list').empty()
        delete router._login
    }
}
