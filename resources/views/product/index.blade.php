<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Products Page</title>
    <link rel="stylesheet" href="{{ mix('css/app.css') }}">
</head>
<body>
<table id="contentTable">
    <tbody>
        @foreach ($products as $product)
            <tr>
                <td>
                    <img class="phoneImage" src="<?= $product['image_path'] ?>">
                </td>
                <td>
                    {{ $product['title'] }}<br>
                    {{ $product['description'] }}<br>
                    {{ $product['price'] }} {{ __('lei') }}<br>
                    {{ $product['inventory'] }} {{ __('products') }}<br>
                </td>
                <td>
                    <a href="{{ route('product.edit', [$product['id']]) }}">
                        {{ __('Edit') }}
                    </a>
                </td>
                <td>
                    <form method="POST" action="{{ route('product.destroy', [$product['id']]) }}">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="linkButton" name="deleteItem">
                            {{ __('Delete') }}
                        </button>
                    </form>
                </td>
            </tr>
            <br>
        @endforeach
        <tr>
            <td>
                <a href="{{ route('product.edit', [0]) }}" class="linkButton">
                    {{ __('Add') }}
                </a>
            </td>
            {{--<td>--}}
                {{--<form method="post" action="">--}}
                    {{--<button type="submit" class="linkButton" name="logoutButton">--}}
                        {{--<?= translate('Logout') ?>--}}
                    {{--</button>--}}
                {{--</form>--}}
            {{--</td>--}}
        </tr>
    </tbody>
</table>
</body>
</html>
