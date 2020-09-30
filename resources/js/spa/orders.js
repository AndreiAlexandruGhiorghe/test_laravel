function Orders () {
    this.renderOrdersList = function (response) {
        var html = ``
        $.each(response, function(nrOrder, order) {
            html +=
                `<tr><td>
                ${order}
                </td></tr>
                <tr><td>
                <a href="#order/${nrOrder}">${translate('see Order')}</a>
                </td></tr>`
        })

        return html
    }
    this.init = function () {
        $('.page.orders').show();
        // Load the orders from the server
        $.ajax(route('order.index'), {
            dataType: 'json',
            success: (response) => {
                // Render the products in the order's list
                $('.page.orders .list tbody').html(this.renderOrdersList(response.data));
            },
            error: (error) => {
                if (error.status === 401) {
                    setCookie('oldRoute', document.location.hash, 1)
                    window.location.hash = '#login'
                }
            }
        });
    }
    this.destroy = () => {
        $('.page.orders .list tbody').empty()
        delete router._orders
    }
}
