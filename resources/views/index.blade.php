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
                @for ($i = 0; $i < count($productsList); $i++)
                    <tr>
                        <td>
                            <img src="{{ $productsList[$i]['image_path'] }}" alt="{{ __('The image could not be loaded') }}"><br>
                        </td>
                        <td>
                            {{ $productsList[$i]['title'] }}<br>
                            {{ $productsList[$i]['description'] }}<br>
                            {{ $productsList[$i]['price'] }} {{ __('euro') }}<br>
                            {{ $productsList[$i]['inventory'] - ((isset($myCart[$productsList[$i]['id']]))
                                ? $myCart[$productsList[$i]['id']]
                                : 0) }} {{ __('left') }}<br>
                        </td>
                        <td>
                            <form method="post" action="{{ route('index') }}">
                                @csrf
                                <input type="hidden" name="idProduct" value="{{ $productsList[$i]['id'] }}">
                                <button type="submit" class="linkButton"> {{ __('Add') }} </button>
                            </form>
                        </td>
                    </tr>
                @endfor
                <tr>
                    <td>
                        <a href="{{ route('cart.index') }}"> {{ __('Go to cart') }} </a>
                    </td>
                </tr>
        </tbody>
    </table>
</body>
</html>
