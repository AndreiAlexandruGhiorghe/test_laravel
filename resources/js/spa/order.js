function Order () {
    this.id = undefined
    this.renderOrder = function ( params) {
        var html=``;
        $.each(params.order.products, function (key, product) {
            html +=
                `<tr>
                <td>
                <img src="/storage/images/${product.image_path}" class="phoneImage">
                </td>
                <td>
                ${product.title}<br>
                ${product.description}<br>
                ${product.price} euro<br>
                ${product.pivot.quantity} ${translate('buc')}<br>
                </td>
                </tr>`
        });
        html +=
            `<tr><td>
            Created at: ${((params.order.created_at) ? params.order.created_at : '')}
            </td></tr>
            <tr><td>
            Name: ${((params.order.name) ? params.order.name : '')}
            </td></tr>
            <tr><td>
            Address: ${((params.order.address) ? params.order.address : '')}
            </td></tr>
            <tr><td>
            Comments: ${((params.order.comments) ? params.order.comments : '')}
            </td></tr>`

        return html
    }
    this.show = function () {
        $.ajax(route('order.show', [this.id]), {
            dataType: 'json',
            success: (response) => {
                $('.page.order').show()
                $('.page.order .list tbody').html(this.renderOrder(response.data))
            },
            error: () => {
                if (error.status === 401) {
                    setCookie('oldRoute', document.location.hash, 1)
                    window.location.hash = '#login'
                }
            }
        })
    }
    this.init = () => {
        // get the if from hash
        this.id = window.location.hash.slice(7)
        this.show()
    }
    this.destroy = () => {
        $('.page.order .list tbody').empty()
        delete router._order
    }
}
