function Login() {
    this.loginFunction = function () {
        var username = $('[name="usernameField"]')[0].value;
        var password = $('[name="passwordField"]')[0].value;

        $.ajax('/login', {
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
                $('.login .list span').remove();
                if (response.redirect == '#login') {
                    $('.login .list [name="loginButton"]').after('<span style="color: red">'
                        + response.message
                        + '</span>');
                } else {
                    window.location.hash = response.redirect;
                }
            },
            error: function (request) {
                $('.login .list span').remove();
                if (request.responseJSON.errors.usernameField !== undefined) {
                    $('.login .list [name="usernameField"]').after('<span style="color: red">'
                        + request.responseJSON.errors.usernameField
                        + '</span>');
                }
                if (request.responseJSON.errors.passwordField !== undefined) {
                    $('.login .list [name="passwordField"]').after('<span style="color: red">'
                        + request.responseJSON.errors.passwordField
                        + '</span>');
                }
            }
        });
    }
    this.renderLogin = function () {
        html= '<tr>\n' +
            '                <td>\n' +
            '                    <input type="text" name="usernameField" placeholder="username">\n' +
            '                </td>\n' +
            '            </tr>\n' +
            '            <tr>\n' +
            '                <td>\n' +
            '                    <input type="password" name="passwordField" placeholder="password">\n' +
            '                </td>\n' +
            '            </tr>\n' +
            '            <tr>\n' +
            '                <td>\n' +
            '                    <button ' +
            'name="loginButton" ' +
            'onclick="new Login().loginFunction()">'+ translate('Login')+'</button>\n' +
        '                </td>\n' +
        '            </tr>'
        return html
    }
    this.init = function () {
        // Show the login page
        $('.login').show();
        $('.login .list').empty().html(this.renderLogin());
    }
}
