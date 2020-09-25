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
                    $('.login .list [name="loginButton"]').after('<span class="errorSpan">'
                        + response.message
                        + '</span>');
                } else {
                    window.location.hash = response.redirect;
                }
            },
            error: function (request) {
                $('.login .list span').remove();
                if (request.responseJSON.errors.usernameField !== undefined) {
                    $('.login .list [name="usernameField"]')
                        .after(`<span class="errorSpan">${request.responseJSON.errors.usernameField}</span>`);
                }
                if (request.responseJSON.errors.passwordField !== undefined) {
                    $('.login .list [name="passwordField"]')
                        .after(`<span class="errorSpan">${request.responseJSON.errors.passwordField}</span>`);
                }
            }
        });
    }
    this.renderLogin = function () {
        html = [
            `<tr>`,
            `<td>`,
            `<input type="text" name="usernameField" placeholder="username">`,
            `</td>`,
            `</tr>`,
            `<tr>`,
            `<td>`,
            `<input type="password" name="passwordField" placeholder="password">`,
            `</td>`,
            `</tr>`,
            `<tr>`,
            `<td>`,
            `<button `,
            `name="loginButton" `,
            `onclick="router._login.loginFunction()">${translate('Login')}</button>`,
            `</td>`,
            `</tr>`
        ].join(``)
        return html
    }
    this.init = function () {
        // Show the login page
        $('.login').show();
        $('.login .list').empty().html(this.renderLogin());
    }
}
