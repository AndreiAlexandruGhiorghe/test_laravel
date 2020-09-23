@extends ('layouts.html')

@section ('bodyContent')
    <table>
        <tbody>
            @foreach ($productsList as $product)
                <tr>
                    <td>
                        <img
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
                        <td>
                            @foreach ($product->comments as $comment)
                                @if ($comment->state == true)
                                    <table>
                                        <tbody>
                                            <tr>
                                                <td>
                                                    {{ $comment->username }}
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    {{ $comment->content }}
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                @endif
                            @endforeach
                        </td>
                    <td>
                        <form method="POST" action="{{ route('comment.store') }}">
                            @csrf
                            <input type="hidden" name="product_id" value="{{ $product->id }}">
                            <table>
                                <tbody>
                                    <tr>
                                        <td>
                                            <input
                                                class="inputType"
                                                type="text"
                                                name="username"
                                                placeholder="{{ __('username') }}"
                                                value="{{ (old('id') != $product->id) ? '': old('username') }}"
                                            >
                                            @if(old('id') == $product->id)
                                                @error('username')
                                                    <span class="error">
                                                        {{ $errors->first('username') }}
                                                    </span>
                                                @enderror
                                            @endif
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <textarea
                                                class="inputType"
                                                type="text"
                                                name="content"
                                                placeholder="{{ (old('id') != $product->id) ? '' : old('content') }}"
                                            >
                                            </textarea>
                                            @if(old('id') == $product->id)
                                                @error('content')
                                                    <span class="error">
                                                        {{ $errors->first('content') }}
                                                    </span>
                                                @enderror
                                            @endif
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <input type="submit" name="submitComment" value="Comment">
                                        </td>
                                    </tr>
                                </tbody>
                            </table>

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
