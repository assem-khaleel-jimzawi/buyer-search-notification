<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Search Results</title>
</head>
<body>
    <h1>Search Results for "{{ $query }}"</h1>

    @if($matches->isEmpty())
        <p>No parts matched your search.</p>
    @else
        <ul>
            @foreach($matches as $part)
                <li>{{ $part->name }}</li>
            @endforeach
        </ul>
    @endif

    <p>Thank you for using our search service.</p>
</body>
</html>
