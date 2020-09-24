function Orders () {
    this.renderOrdersList = function (response) {
        var html = ''
        $.each(response, function(nrOrder, order) {
            html += [
                '<tr><td>',
                order,
                '</td></tr>',
                '<tr><td>',
                '<button onclick="router.order(' + nrOrder +')">' + translate('see Order') + '</button>',
                '</td></tr>'
            ].join('')
        })

        return html
    }

    this.init = function () {
        // If all else fails, always default to index
        $('.page.orders').show();
        // Load the index products from the server
        $.ajax('/order', {
            dataType: 'json',
            success: (response) => {
                if (response.redirect === '#login') {
                    window.location.hash = '#login'
                } else {
                    // Render the products in the index list
                    $('.page.orders .list tbody').html(this.renderOrdersList(response));
                }
            }
        });
    }
}
