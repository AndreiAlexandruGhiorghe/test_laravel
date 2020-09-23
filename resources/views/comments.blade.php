@extends ('layouts.html')

@section ('bodyContent')
    <table>
        <tbody>
            @foreach ($comments as $comment)
                <tr>
                    <td>
                        {{ $comment->id }}<br>
                        {{ $comment->username }}<br>
                        {{ $comment->content }}
                    </td>
                    <td>
                        <form method="POST" action="{{ route('comment.update', [$comment->id]) }}">
                            @csrf
                            @method('PUT')
                            <input type="submit" name="submitAccept" value="{{ __('Accept') }}">
                        </form>
                    </td>
                    <td>
                        <form method="POST" action="{{ route('comment.destroy', [$comment->id]) }}">
                            @csrf
                            @method('DELETE')
                            <input type="submit" name="submitReject" value="{{ __('Reject') }}">
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection
