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
                    <img src="{{ $message->embed('storage/images/' . $productsList[$i]['image_path']) }}" alt="{{ __('The image could not be loaded') }}"><br>
                </td>
                <td>
                    {{ $productsList[$i]['title'] }}<br>
                    {{ $productsList[$i]['description'] }}<br>
                    {{ $productsList[$i]['price'] }} {{ __('euro') }}<br>
                    {{ ((isset($myCart[$productsList[$i]['id']]))
                        ? $myCart[$productsList[$i]['id']]
                        : 0) }} {{ __('in cart') }}<br>
                </td>
            </tr>
        @endfor
        <tr>
            <td>
                <p>
                    Name: {{ $orderDetails['nameField'] }}
                </p>
            </td>
        </tr>
        <tr>
            <td>
                <p>
                    Address: {{ $orderDetails['addressField'] }}
                </p>
            </td>
        </tr>
        <tr>
            <td>
                <p>
                    Comments: {{ $orderDetails['commentsField'] }}
                </p>
            </td>
        </tr>
    </tbody>
</table>
</body>
</html>
