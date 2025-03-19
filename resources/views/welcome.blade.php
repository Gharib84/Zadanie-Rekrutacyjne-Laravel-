<!doctype html>
<html>

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    @vite(['resources/css/app.css', 'resources/js/app.js', 'resources/js/pet.js'])
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>

<body>
    <div class="container mx-auto w-full p-10 h-screen mt-16">
        @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
        @endif

        @if (session('error'))
        <div class="alert alert-error">
            {{ session('error') }}
        </div>
        @endif

        <!--three items per row-->
        <div class="flex flex-col lg:flex-row justify-between items-center w-full mb-5 gap-y-4 lg:gap-y-0">
            <div class="filter w-full lg:w-auto">
                <form method="GET" action="{{ route('pets.index') }}">
                    <select name="status" class="select select-success" onchange="this.form.submit()">
                        <option disabled selected>Pick a Runtime</option>
                        <option value="available" {{ request('status') == 'available' ? 'selected' : '' }}>available</option>
                        <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>pending</option>
                        <option value="sold" {{ request('status') == 'sold' ? 'selected' : '' }}>sold</option>
                    </select>
                </form>
            </div>
            <div class="header">
                <h1 class="text-3xl">Zadanie Rekrutacyjne Laravel</h1>
            </div>
            <div class="action w-full  lg:w-auto">
                <button class="btn btn-active btn-warning w-full lg:w-auto text-blue-900 font-bold" onclick="add_new_pet.showModal()">dodaj</button>
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
                    <tbody id="pets-table-body">
                        @foreach ($pets as $pet)
                        <tr id="pet-row-{{ $pet['id'] }}">
                            <td>{{ $pet['id'] }}</td>
                            <td>{{ $pet['name'] }}</td>
                            <td>{{ $pet['category']['name'] ?? 'brak' }}</td>
                            <td>
                                <a href="{{ $photoUrl ?? 'brak' }}" class="text-yellow-500 font-bold">{{ $photoUrl ?? 'brak' }}</a>
                            </td>
                            <td>
                                @foreach ($pet['tags'] as $tag)
                                {{ $tag['name'] ?? 'brak' }}<br>
                                @endforeach
                            </td>
                            <td>{{ $pet['status'] ?? 'brak' }}</td>
                            <td class="flex gap-2">
                                <button class="btn btn-soft btn-info text-white" onclick="openEditModal(`{{ $pet['id'] }}`)">Edytuj</button>

                                <button class="btn btn-soft btn-error text-white delete-pet-button" data-pet-id="{{ $pet['id'] }}" onclick="deletePet( `{{$pet['id']}}`)">Usuń</button>
                            </td>
                        </tr>
                        <!-- Global Edit Modal -->
                        <!--edit modal for pet-->
                        <dialog id="edit_pet_{{$pet['id']}}" class="modal modal-bottom sm:modal-middle edit-pet-form">
                            <div class="modal-box">
                                <h3 class="text-lg font-bold text-yellow-500">Edytuj peta: {{ $pet['name'] }}</h3>
                                <p class="py-4">
                                <form id="edit-pet-form-{{$pet['id']}}" method="POST">
                                    @csrf
                                    @method('PUT')
                                    <input type="hidden" name="id" value="{{ $pet['id'] }}" id="edit-pet-id">
                                    <fieldset class="fieldset">
                                        <legend class="fieldset-legend">Pet szczegóły</legend>
                                        <input type="text" name="name" id="edit-pet-name" class="input w-full" placeholder="Name" required />
                                        <select name="status" id="edit-pet-status" class="select select-success w-full mt-2" required>
                                            <option value="available">available</option>
                                            <option value="pending">pending</option>
                                            <option value="sold">sold</option>
                                        </select>
                                    </fieldset>
                                    <div class="modal-action">
                                        <button type="button" class="btn btn-primary" onclick="editPet(`{{ $pet['id'] }}`)">Edytuj</button>
                                        <button type="button" class="btn" onclick="document.getElementById(`edit_pet_{{$pet['id']}}`).close()">Close</button>
                                    </div>
                                </form>
                                </p>
                            </div>
                        </dialog>
                        @endforeach
                    </tbody>
                </table>
                <div class="mt-4">
                    {{ $pets->appends(['status' => request('status')])->links() }}
                </div>
            </div>
        </div>
    </div>
    <!-- Open the modal using ID.showModal() method -->
    <dialog id="add_new_pet" class="modal modal-bottom sm:modal-middle">
        <div class="modal-box">
            <h3 class="text-lg font-bold text-yellow-500">Stworz nowego peta</h3>
            <p class="py-4">
            <form id="create-pet-form" method="POST">
                @csrf
                <fieldset class="fieldset">
                    <legend class="fieldset-legend">Pet szczegóły</legend>
                    <input type="text" name="name" class="input w-full" placeholder="Name" required />
                    <input type="text" name="category" class="input w-full mt-2" placeholder="Category" required />
                    <input type="text" name="photoUrls" class="input w-full mt-2" placeholder="Photo URLs (comma separated)" required />
                    <input type="text" name="tags" class="input w-full mt-2" placeholder="Tags (comma separated)" required />
                    <select name="status" class="select select-success w-full mt-2" required>
                        <option value="available">available</option>
                        <option value="pending">pending</option>
                        <option value="sold">sold</option>
                    </select>
                </fieldset>
                <div class="modal-action">
                    <button type="button" class="btn btn-primary" onclick="submitPetForm()">Save</button>
                    <button type="button" class="btn" onclick="add_new_pet.close()">Close</button>
                </div>
            </form>
            </p>
        </div>
    </dialog>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const form = document.getElementById('create-pet-form');
            form.addEventListener('submit', async (event) => {
                event.preventDefault();
                await submitPetForm();
            });

            const editForm = document.querySelectorAll('.edit-pet-form');
            editForm.forEach(form => {
                form.addEventListener('submit', async (event) => {
                    event.preventDefault();
                    await editPetForm(form);
                });
            })

            loadPetsFromSessionStorage();
        });

        async function submitPetForm() {
            const form = document.getElementById('create-pet-form');
            const formData = new FormData(form);
            const petData = {
                name: formData.get('name'),
                category: formData.get('category'),
                photoUrls: formData.get('photoUrls'),
                tags: formData.get('tags'),
                status: formData.get('status'),
            };

            try {
                const response = await fetch('http://127.0.0.1:8000/store', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    },
                    body: JSON.stringify(petData),
                });

                const contentType = response.headers.get('content-type');
                if (!contentType || !contentType.includes('application/json')) {
                    throw new TypeError('The server did not return a valid JSON response.');
                }
                const data = await response.json();
                console.log(data);

                if (!response.ok) {
                    if (data.errors) {
                        document.querySelectorAll('.error-message').forEach(el => el.textContent = '');
                        for (const [field, errors] of Object.entries(data.errors)) {
                            const errorElement = document.getElementById(`${field}-error`);
                            if (errorElement) {
                                errorElement.textContent = errors[0];
                            }
                        }
                    } else {
                        alert(data.message || 'Failed to create pet');
                    }
                } else {
                    alert(data.message || 'Pet created successfully');
                    form.reset();
                    addPetToTable(data.data);
                    savePetToSessionStorage(data.data);
                    add_new_pet.close();
                }

            } catch (error) {
                console.error('Error:', error);
                alert('An unexpected error occurred. Please try again.');
            }
        }

        function addPetToTable(pet) {
            const petsTableBody = document.getElementById('pets-table-body');
            const row = document.createElement('tr');
            row.id = `pet-row-${pet.id}`;
            row.innerHTML = `
        <td>${pet.id}</td>
        <td>${pet.name}</td>
        <td>${pet.category.name ?? 'brak'}</td>
        <td>${pet.photoUrls.map(url => `<a href="${url}" class="text-yellow-500 font-bold">${url}</a>`).join('<br>')}</td>
        <td>${pet.tags.map(tag => `${tag.name ?? 'brak'}`).join('<br>')}</td>
        <td>${pet.status ?? 'brak'}</td>
        <td class="flex gap-2">
            <a href="" class="btn btn-soft btn-info text-white">Edytuj</a>
            <button class="btn btn-soft btn-error text-white delete-pet-button" data-pet-id="${pet.id}" onclick="deletePet(${pet.id})">Usuń</button>
        </td>
    `;
            petsTableBody.appendChild(row);
        }

        function openEditModal(id) {
            const row = document.getElementById(`pet-row-${id}`);
            const petName = row.querySelector('td:nth-child(2)').textContent.trim();
            const petStatus = row.querySelector('td:nth-child(6)').textContent.trim();

            // Populate the modal form fields
            document.getElementById('edit-pet-id').value = id;
            document.getElementById('edit-pet-name').value = petName;
            document.getElementById('edit-pet-status').value = petStatus;
            const editModal = document.getElementById(`edit_pet_${id}`);
            editModal.showModal();
        }
        async function editPet(id) {
            const form = document.getElementById(`edit-pet-form-${id}`);
            const formData = new FormData(form);
            const petData = {
                id: formData.get('id'),
                name: formData.get('name'),
                status: formData.get('status'),
            };

            try {
                const response = await fetch(`http://127.0.0.1:8000/edit/${petData.id}`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    },
                    body: JSON.stringify(petData),
                });

                const contentType = response.headers.get('content-type');
                if (!contentType || !contentType.includes('application/json')) {
                    throw new TypeError('The server did not return a valid JSON response.');
                }

                const data = await response.json();
                console.log(data);
                if (!response.ok) {
                    if (data.errors) {
                        document.querySelectorAll('.error-message').forEach(el => el.textContent = '');
                        for (const [field, errors] of Object.entries(data.errors)) {
                            const errorElement = document.getElementById(`${field}-error`);
                            if (errorElement) {
                                errorElement.textContent = errors[0];
                            }
                        }
                    } else {
                        alert(data.message || 'Failed to create pet');
                    }
                } else {
                    alert(data.message || 'Pet created successfully');
                    editForm.reset();
                    addPetToTable(data.data);
                    savePetToSessionStorage(data.data);
                    edit_pet_`${id}`.close();
                    const row = document.getElementById(`pet-row-${data.data.id}`);
                    row.querySelector('td:nth-child(2)').textContent = data.data.name;
                    row.querySelector('td:nth-child(6)').textContent = data.data.status ?? 'brak';
                    document.getElementById(`edit_pet_${id}`).close();
                }
            } catch (error) {
                console.log('Error:', error);
                alert('An unexpected error occurred. Please try again.');
            }
        }

        async function deletePet(id) {
            try {
                const response = await fetch(`http://127.0.0.1:8000/destroy/${id}`, {
                    method: 'DELETE',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    },
                });

                const data = await response.json();
                if (response.ok) {
                    alert(data.message || 'Pet deleted successfully');
                    document.getElementById(`pet-row-${id}`).remove();
                    removePetFromSessionStorage(`pet-row-${id}`);
                } else {
                    alert(data.message || 'Failed to delete pet');
                }
            } catch (error) {
                console.error('Error:', error);
                alert('An unexpected error occurred. Please try again.');
            }
        }

        function savePetToSessionStorage(pet) {
            let pets = JSON.parse(sessionStorage.getItem('pets')) || [];
            pets.push(pet);
            sessionStorage.setItem('pets', JSON.stringify(pets));
        }

        function loadPetsFromSessionStorage() {
            const pets = JSON.parse(sessionStorage.getItem('pets')) || [];
            pets.forEach(pet => addPetToTable(pet));
        }

        function removePetFromSessionStorage(id) {
            let pets = JSON.parse(sessionStorage.getItem('pets')) || [];
            pets = pets.filter(pet => pet.id !== id);
            sessionStorage.setItem('pets', JSON.stringify(pets));
        }
    </script>
</body>

</html>