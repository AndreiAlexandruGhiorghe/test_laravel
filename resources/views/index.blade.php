@extends ('layouts.html')

@section ('bodyContent')
    <table>
        <tbody>
                @foreach ($productsList as $product)
                    <tr>
                        <td>
                            <img
                                class="phoneImage"
                                src="{{ asset('/storage/images/' . $product['image_path']) }}"
                                alt="{{ __('The image could not be loaded') }}"
                            ><br>
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
@endsection
