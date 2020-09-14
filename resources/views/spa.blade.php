@extends('layouts.html')

@section('headContent')
    <!-- Load the jQuery JS library -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>

    <script src="http://127.0.0.1:8000/functions.js"></script>

    <!-- Custom JS script -->
    <script type="text/javascript">
        var myCart = [];
        function loginFunction() {
            var username = $('[name="usernameField"]')[0].value;
            var password = $('[name="passwordField"]')[0].value;

            $.ajax('/login', {
                dataType: 'json',
                type: 'POST',
                data: {
                    '_token': '{{ csrf_token() }}',
                    'usernameField': username,
                    'passwordField': password,
                },
                success: function (response) {

                    window.location.hash = '#product';
                },
                error: function (request) {
                    $('.login .list span').remove();
                    console.log(request);
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
        function submitOrder() {
            let name = $('.cart [name="nameField"]')[0].value;
            let address = $('.cart [name="addressField"]')[0].value;
            let comments = $('.cart [name="commentsField"]')[0].value;
            $.ajax('/cart',{
                dataType: 'json',
                type: 'POST',
                data: {
                    '_token': '{{ csrf_token() }}',
                    'nameField': name,
                    'addressField': address,
                    'commentsField': comments,
                },
                success: function (response) {
                    window.location.hash = '#';
                },
                error: function (request) {
                    $('.cart .list span').remove();
                    if (request.responseJSON.errors.nameField !== undefined) {
                        $('.cart .list [name="nameField"]').after('<span style="color: red">'
                            + request.responseJSON.errors.nameField
                            + '</span>');
                    }
                    if (request.responseJSON.errors.addressField) {
                        $('.cart .list [name="addressField"]').after('<span style="color: red">'
                            + request.responseJSON.errors.nameField
                            + '</span>');
                    }
                }
            });
        }
        function addFunction(idProduct) {
            $.ajax('/index/' + idProduct, {
                dataType: 'json',
                type: 'PUT',
                data: {
                    "_token": "{{ csrf_token() }}",
                },
                success: function (response) {
                    // Render the products in the cart list
                    $('.index .list').html(renderIndexList(response));
                }
            });
        }
        function addProductToDB(idProduct) {
            $.ajax('/product', {
                dataType: 'json',
                type: 'POST',
                data: {
                    "_token": "{{ csrf_token() }}",
                },
                success: function (response) {
                    // Render the products in the cart list
                    $('.index .list').html(renderIndexList(response));
                }
            });
        }
        function removeFunction(idProduct) {
            $.ajax('/cart/' + idProduct, {
                dataType: 'json',
                type: 'DELETE',
                data: {
                    "_token": "{{ csrf_token() }}",
                },
                success: function (response) {
                    $('.cart .list').empty()
                    // Render the products in the cart list
                    $('.cart .list').html(renderCartList(response));
                }
            });
        }
        function renderIndexList(params) {
            var html='';
            $.each(params['products'], function (key, product) {
                if (product.inventory - (params['myCart'].hasOwnProperty(product.id)
                    ? params['myCart'][product.id]
                    : 0) > 0) {
                    html += [
                        '<tr>',
                        '<td>',
                        '<img src="/storage/images/' + product.image_path + '" class="phoneImage">',
                        '</td>',
                        '<td>',
                        product.title + '<br>',
                        product.description + '<br>',
                        product.price + ' {{ __('euro') }}<br>',
                        product.inventory - (params['myCart'].hasOwnProperty(product.id)
                            ? params['myCart'][product.id]
                            : 0) + ' {{ __('left') }}<br>',
                        '<td>' +
                        '<button onclick="addFunction('+ product.id +')">{{ __('Add') }}</button>'+
                        '</td>',
                        '</tr>'
                    ].join('');
                }
            });

            return html;
        }
        function renderCartList(params) {
            var html='';
            $.each(params['products'], function (key, product) {
                html += [
                    '<tr>',
                    '<td>',
                    '<img src="/storage/images/' + product.image_path + '" class="phoneImage">',
                    '</td>',
                    '<td>',
                    product.title + '<br>',
                    product.description + '<br>',
                    product.price + ' {{ __('euro') }}<br>',
                    (params['myCart'].hasOwnProperty(product.id)
                        ? params['myCart'][product.id]
                        : 0) + ' {{ __('in cart') }}<br>',
                    '<td>' +
                    '<button onclick="removeFunction('+ product.id +')">{{ __('Remove') }}</button>'+
                    '</td>',
                    '</tr>'
                ].join('');
            });

            html += [
                '<tr><td>Name:',
                '<input type="text" name="nameField" value="{{ old('nameField') }}">',
                '</td></tr>',
                '<tr><td>Address:',
                '<input type="text" name="addressField" value="{{ old('addressField') }}"',
                '</td></tr>',
                '<tr><td>Comments:',
                '<textarea type="text" name="commentsField" value="{{ old('commentsField') }}"></textarea>',
                '</td></tr>',
            ].join('');

            return html;
        }
        function renderLogin() {
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
                '                    <button name="loginButton" onclick="loginFunction()">{{ __('Login') }}</button>\n' +
                '                </td>\n' +
                '            </tr>';
            return html;
        }
        function renderProductList(params) {
            var html='';

            $.each(params['products'], function (key, product) {
                html += [
                    '<tr>',
                    '<td>',
                    '<img src="/storage/images/' + product.image_path + '" class="phoneImage">',
                    '</td>',
                    '<td>',
                    product.title + '<br>',
                    product.description + '<br>',
                    product.price + ' {{ __('euro') }}<br>',
                    product.inventory + ' {{ __('left') }}<br>',
                    '<td>' +
                    '<button onclick="addFunction('+ product.id +')">{{ __('Edit') }}</button>'+
                    '</td>',
                    '<td>' +
                    '<button onclick="addFunction('+ product.id +')">{{ __('Delete') }}</button>'+
                    '</td>',
                    '</tr>'
                ].join('');
            });
            console.log(html)
            return html;
        }
        function renderProductForm(params = []) {
            var addPage = (params === [])
            var html = '';
            html = [
                '<table><tbody>' +
                '<form ' +
                (addPage) ?  + '{{ route('product.add') }}': 'http://127.0.0.1:8000/product/' + params.id + '/edit'  +
                '>' +
                '' +
                '</form>' +
                '</tbody></table>'
            ].join('')
        }
        function addProductPage() {
            $('.page.product .product').hide()
            $('.page.product .productForm').show().html(renderProductForm())
        }

        $(document).ready(function () {
            /**
             * URL hash change handler
             */
            window.onhashchange = function () {
                // First hide all the pages
                $('.page').hide();

                switch(window.location.hash) {
                    case '#login':
                        // Show the login page
                        $('.login').show();
                        $('.login .list').empty().html(renderLogin());
                        break;
                    case '#cart':
                        // Show the cart page
                        $('.cart').show();
                        // Load the cart products from the server
                        $.ajax('/cart', {
                            dataType: 'json',
                            success: function (response) {
                                // Render the products in the cart list
                                $('.cart .list').html(renderCartList(response));

                                // add the checkout button
                                $('.cart [name="submitOrder"]')
                                    .attr('onclick', 'submitOrder()')
                                    .text('{{ __('Checkout') }}');
                            }
                        });
                        break;
                    case '#product':
                        // Show the cart page
                        $('.product').show();
                        // Load the cart products from the server
                        $.ajax('/product', {
                            dataType: 'json',
                            success: function (response) {
                                console.log(response)
                                // Render the products in the cart list
                                $('.product .list').html(renderProductList(response));
                            },
                            error: function (error) {
                                console.log(error)
                            }
                        });
                        break;
                    // case '#product/':
                    //     // Show the cart page
                    //     $('.product').show();
                    //     // Load the cart products from the server
                    //     $.ajax('/product', {
                    //         dataType: 'json',
                    //         success: function (response) {
                    //             console.log(response)
                    //             // Render the products in the cart list
                    //             $('.product .list').html(renderProductList(response));
                    //         }
                    //     });
                    default:
                        // If all else fails, always default to index
                        // Show the index page
                        $('.index').show();
                        // Load the index products from the server
                        $.ajax('/index', {
                            dataType: 'json',
                            success: function (response) {
                                // Render the products in the index list
                                $('.index .list tbody').html(renderIndexList(response));
                                // update the local cart
                                myCart = response['myCart'];
                            }
                        });
                        break;
                }
            }

            window.onhashchange();
        });
    </script>
@endsection

@section('bodyContent')
    <!-- The index page -->
    <div class="page index">
        <!-- The index element where the products list is rendered -->
        <table class="list"><tbody></tbody></table>

        <!-- A link to go to the cart by changing the hash -->
        <a href="#cart" class="button">Go to cart</a>
    </div>

    <!-- The cart page -->
    <div class="page cart">
        <!-- The cart element where the products list is rendered -->
        <table class="list"></table>

        <!-- A link to go to the index by changing the hash -->
        <a href="#" class="button">Go to index</a>

        <button name="submitOrder">Checkout</button>
    </div>

{{--    The prduct page--}}
    <div class="page product">
        <div class="product">
            {{--        Show the products list--}}
            <table class="list"></table>

            {{--        Add new product--}}
            <button name="addProductToDB" onclick="addProductPage()">Add</button>

            <a href="#" class="button">Go to index</a>
        </div>
        <div class="productForm">
            Product Form
        </div>
    </div>

{{--    The login page--}}
    <div class="page login">
        <table class="list"></table>
    </div>

{{--    The order page--}}
    <div class="page order">
{{--        Show the orders--}}
        <div class="ordersList"></div>

{{--        Show one order--}}
        <div class="orderDetails"></div>
    </div>

@endsection
