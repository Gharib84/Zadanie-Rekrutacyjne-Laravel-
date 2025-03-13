<!doctype html>
<html>

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    @vite('resources/css/app.css')
</head>
<body>
</body>
<div class="container mx-auto w-full p-10 h-screen mt-16">
    <h1 class="text-3xl text-center w-full mx-auto">Zadanie Rekrutacyjne Laravel</h1>
    <div class="grid grid-cols-1 gap-4">
        <div class="overflow-x-auto">
            <table class="table border-solid border-2 border-slate-400 w-full mt-10">
                <!-- head -->
                <thead>
                    <tr>
                        <th></th>
                        <th class="text-green-500">Category</th>
                        <th class="text-green-500">Name</th>
                        <th class="text-green-500">PhotoUrls</th>
                        <th class="text-green-500">Tags</th>
                        <th class="text-green-500">Status</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- row 1 -->
                    <tr>
                        <th>1</th>
                        <td>Cy Ganderton</td>
                        <td>Quality Control Specialist</td>
                        <td>Blue</td>
                        <td>Lorem</td>
                        <td>Lorem.</td>
                    </tr>
                    <!-- row 2 -->
                    <tr>
                        <th>2</th>
                        <td>Hart Hagerty</td>
                        <td>Desktop Support Technician</td>
                        <td>Purple</td>
                        <td>Lorem.</td>
                        <td>Lorem</td>
                    </tr>
                    <!-- row 3 -->
                    <tr>
                        <th>3</th>
                        <td>Brice Swyre</td>
                        <td>Tax Accountant</td>
                        <td>Red</td>
                        <td>Lorem</td>
                        <td>Lorem</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>

</html>