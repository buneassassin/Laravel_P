<!-- resources/views/rickandmorty/characters.blade.php -->
<!DOCTYPE html>
<html>
<head>
    <title>Rick and Morty Characters</title>
</head>
<body>
    <h1>Rick and Morty Characters</h1>
    <ul>
        @foreach ($characters as $character)
            <li>
                <strong>{{ $character->name }}</strong><br>
                <img src="{{ $character->image }}" alt="{{ $character->name }}" style="width:100px;">
                <p>Status: {{ $character->status }}</p>
                <p>Species: {{ $character->species }}</p>
            </li>
        @endforeach
    </ul>
</body>
</html>