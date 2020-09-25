function Orders () {
    this.renderOrdersList = function (response) {
        var html = ``
        $.each(response, function(nrOrder, order) {
            html += [
                `<tr><td>`,
                order,
                `</td></tr>`,
                `<tr><td>`,
                `<a href="#order/${nrOrder}">${translate('see Order')}</a>`,
                `</td></tr>`
            ].join(``)
        })

        return html
    }
    this.init = function () {
        $('.page.orders').show();
        // Load the orders from the server
        $.ajax('/order', {
            dataType: 'json',
            success: (response) => {
                if (response.redirect === '#login') {
                    window.location.hash = '#login'
                } else {
                    // Render the products in the order's list
                    $('.page.orders .list tbody').html(this.renderOrdersList(response));
                }
            }
        });
    }
}
