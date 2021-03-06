@extends ('layouts.html')

@section ('bodyContent')
    <table id="contentTable">
        <tbody>
            @foreach ($products as $product)
                <tr>
                    <td>
                        <img class="phoneImage" src="{{ asset('/storage/images/' . $product['image_path']) }}">
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
                    <a href="{{ route('product.add') }}" class="linkButton">
                        {{ __('Add') }}
                    </a>
                </td>
                <td>
                    <form action="{{ route('logout') }}" method="post">
                        @csrf
                        <button type="submit" class="linkButton">
                            {{ __('Logout') }}
                        </button>
                    </form>
                </td>
            </tr>
        </tbody>
    </table>
@endsection
