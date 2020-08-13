@extends ('layouts.html')

@section ('bodyContent')
    <table>
        <tbody>
            <form action="{{ route('login.store') }}" method="post">
                @csrf
                <tr>
                    <td>
                        <input
                            type="text"
                            name="usernameField"
                            placeholder="username"
                            value="{{ old('usernameField') }}"
                        >
                        <span style="color: red;">
                            @error('usernameField')
                            {{ $errors->first('usernameField') }}
                            @enderror
                        </span>
                    </td>
                </tr>
                <tr>
                    <td>
                        <input
                            type="password"
                            name="passwordField"
                            placeholder="password"
                            value="{{ old('passwordField') }}"
                        >
                        <span style="color: red;">
                            @error('passwordField')
                            {{ $errors->first('passwordField') }}
                            @enderror
                        </span>
                    </td>
                </tr>
                <tr>
                    <td>
                        <input type="submit" name="submitButton">
                    </td>
                </tr>
            </form>
        </tbody>
    </table>
@endsection
