<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <title>Index Page</title>
    <link rel="stylesheet" href="{{ mix('css/app.css') }}">
</head>
<body>
    <table>
        <tbody>
                @foreach ($productsList as $product)
                    <tr>
                        <td>
                            <img src="{{ $product['image_path'] }}" alt="{{ __('The image could not be loaded') }}"><br>
                        </td>
                        <td>
                            {{ $product['title'] }}<br>
                            {{ $product['description'] }}<br>
                            {{ $product['price'] }} {{ __('euro') }}<br>
                            {{ $product['inventory'] - ((isset($myCart[$product['id']]))
                                ? $myCart[$product['id']]
                                : 0) }} {{ __('left') }}<br>
                        </td>
                        <td>
                            <form method="post"
                                  action="{{ route('index.update',[$product['id']]) }}"
                            >
                                @csrf
                                @method('PUT')
                                <button type="submit" class="linkButton"> {{ __('Add') }} </button>
                            </form>
                        </td>
                    </tr>
                @endforeach
                <tr>
                    <td>
                        <a href="{{ route('cart.index') }}"> {{ __('Go to cart') }} </a>
                    </td>
                </tr>
        </tbody>
    </table>
</body>
</html>
