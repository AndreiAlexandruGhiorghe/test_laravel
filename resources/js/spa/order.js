function Order () {
    this.id = undefined
    this.renderOrder = function ( params) {
        var html='';
        $.each(params.order.products, function (key, product) {
            html += [
                '<tr>',
                '<td>',
                '<img src="/storage/images/' + product.image_path + '" class="phoneImage">',
                '</td>',
                '<td>',
                product.title + '<br>',
                product.description + '<br>',
                product.price + 'euro<br>',
                product.pivot.quantity + ' buc<br>',
                '</td>',
                '</tr>',
            ].join('');
        });
        html += [
            '<tr><td>',
            'Created at: ' + ((params.order.created_at) ? params.order.created_at : ''),
            '</td></tr>',
            '<tr><td>',
            'Name: ' + ((params.order.name) ? params.order.name : ''),
            '</td></tr>',
            '<tr><td>',
            'Address: ' + ((params.order.address) ? params.order.address : ''),
            '</td></tr>',
            '<tr><td>',
            'Comments: ' + ((params.order.comments) ? params.order.comments : ''),
            '</td></tr>'
        ]

        return html
    }
    this.show = function () {
        $.ajax('/order/' + this.id, {
            dataType: 'json',
            success: (response) => {
                $('.page.order').show()
                $('.page.order .list tbody').html(this.renderOrder(response))
            }
        })
    }
    this.init = () => {
        // get the if from hash
        this.id = window.location.hash.slice(7)
        this.show()
    }
}
