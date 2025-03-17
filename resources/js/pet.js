"use strict";

async function submitPetForm() {
    const form = document.getElementById('create-pet-form');
    const formData = new FormData(form);
    const petData = {
        name: formData.get('name'),
        category: { name: formData.get('category') },
        photoUrls: formData.get('photoUrls').split(',').map(url => url.trim()),
        tags: formData.get('tags').split(',').map(tag => ({ name: tag.trim() })),
        status: formData.get('status')
    };

    try {
        const response = await fetch('https://petstore.swagger.io/v2/pet', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify(petData)
        });

        const data = await response.json();
        console.log('Success:', data);
        add_new_pet.close();
    } catch (error) {
        console.error('Error:', error);
    }
}