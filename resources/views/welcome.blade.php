<!doctype html>
<html>

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    @vite('resources/css/app.css')
</head>

<body>
    <div class="container mx-auto w-full p-10 h-screen mt-16">
        <!--three items per row-->
        <div class="flex flex-col lg:flex-row justify-between items-center w-full mb-5 gap-y-4 lg:gap-y-0">
            <div class="filter w-full lg:w-auto">
                <select class="select select-success">
                    <option disabled selected>Pick a Runtime</option>
                    <option>available</option>
                    <option>pending</option>
                    <option>sold</option>
                </select>
            </div>
            <div class="header">
                <h1 class="text-3xl">Zadanie Rekrutacyjne Laravel</h1>
            </div>
            <div class="action">
                action
            </div>

        </div>
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
    <!--javascript-->
    <script> 
        document.addEventListener('DOMContentLoaded', () => {
            const select = document.querySelector('.select');
             select.addEventListener('change', () => {
                 const selectedValue = select.value;
                 console.log(selectedValue);
             })
        });
    </script>
</body>
</html>