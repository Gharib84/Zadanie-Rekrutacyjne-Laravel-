<!doctype html>
<html>

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    @vite('resources/css/app.css')
</head>

<body>
<div class="container mx-auto w-full p-10 h-screen mt-16">
    <h1 class="text-3xl text-center w-full mx-auto">Zadanie Rekrutacyjne Laravel</h1>
    <div class="grid grid-cols-1 gap-4">
        <div class="overflow-x-auto">
            <table class="table border-solid border-2 border-slate-400 w-full mt-10">
                <!-- head -->
                <thead>
                    <tr>
                        <th class="text-green-500">id</th>
                        <th class="text-green-500">name</th>
                        <th class="text-green-500">Category</th>
                        <th class="text-green-500">PhotoUrls</th>
                        <th class="text-green-500">Tags</th>
                        <th class="text-green-500">Status</th>
                        <td class="text-green-500">przycisk akcji</td>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($pets as $pet)
                    <tr>
                        <td>{{ $pet['id'] }}</td>
                        <td>{{ $pet['name'] }}</td>
                        <td>{{ $pet['category']['name'] ?? 'brak' }}</td>
                        <td>
                            @foreach ($pet['photoUrls'] as $photoUrl)
                            <a href="{{ $photoUrl ?? 'brak' }}" class="text-yellow-500 font-bold">{{ $photoUrl ?? 'brak' }}</a>
                            @endforeach
                        </td>
                        <td>
                            @foreach ($pet['tags'] as $tag)
                            {{ $tag['name'] ?? 'brak' }}<br>
                            @endforeach
                        </td>
                        <td>{{ $pet['status'] ?? 'brak' }}</td>
                        <td class="flex gap-2">
                            <a href="" class="btn btn-soft btn-info text-white">Edytuj</a>
                            <form method="post">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-soft btn-error text-white">Usuń</button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            <div class="mt-4">
                {{ $pets->links() }}
            </div>
        </div>
    </div>
</div>
</body>

</html>