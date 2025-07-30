    <form method="POST" action="{{ route('search.handle') }}">
        @csrf
        <input type="text" name="query" placeholder="Search parts..." required>
        <button type="submit">Search</button>
    </form>

    @if(session('status'))
        <p>{{ session('status') }}</p>
    @endif

    @error('query')
        <p style="color: red">{{ $message }}</p>
    @enderror
