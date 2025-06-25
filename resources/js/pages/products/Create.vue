<script setup lang="ts">
import { useForm, Head } from '@inertiajs/vue3';
import AppLayout from '@/layouts/AppLayout.vue';
import { type BreadcrumbItem } from '@/types';
import { usePage } from '@inertiajs/vue3';

const page = usePage();
const breadcrumbs: BreadcrumbItem[] = [
    { title: 'Dashboard', href: '/dashboard' },
    { title: 'Create Product', href: '/products/create' },
];

const form = useForm({
    name: '',
    price: '',
    description: '',
    stock: '',
    image: null, // Add image field
});

function handleImageChange(e: Event) {
    const file = (e.target as HTMLInputElement).files?.[0];
    if (file) {
        form.image = file;
    }
}

function submit() {
    form.post('/products', {
        forceFormData: true, // IMPORTANT for file uploads
    });
}
</script>

<template>
    <Head title="Create Product" />
    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="max-w-2xl mx-auto px-6 py-8 bg-white rounded shadow space-y-6">
            <h1 class="text-3xl font-bold text-gray-800">Create Product</h1>

            <div v-if="page.props.flash?.success" class="bg-green-100 border border-green-300 text-green-800 px-4 py-2 rounded">
                {{ page.props.flash.success }}
            </div>

            <form @submit.prevent="submit" class="space-y-6">
                <!-- Name -->
                <div>
                    <label class="block text-sm font-medium text-gray-700">Name</label>
                    <input
                        v-model="form.name"
                        type="text"
                        class="w-full mt-1 border-gray-300 rounded-md shadow-sm focus:ring focus:ring-blue-200 focus:outline-none px-4 py-2"
                    />
                    <p v-if="form.errors.name" class="text-red-500 text-sm mt-1">{{ form.errors.name }}</p>
                </div>

                <!-- Price -->
                <div>
                    <label class="block text-sm font-medium text-gray-700">Price ($)</label>
                    <input
                        v-model="form.price"
                        type="number"
                        step="0.01"
                        class="w-full mt-1 border-gray-300 rounded-md shadow-sm focus:ring focus:ring-blue-200 focus:outline-none px-4 py-2"
                    />
                    <p v-if="form.errors.price" class="text-red-500 text-sm mt-1">{{ form.errors.price }}</p>
                </div>

                <!-- Description -->
                <div>
                    <label class="block text-sm font-medium text-gray-700">Description</label>
                    <textarea
                        v-model="form.description"
                        class="w-full mt-1 border-gray-300 rounded-md shadow-sm focus:ring focus:ring-blue-200 focus:outline-none px-4 py-2"
                        rows="4"
                    ></textarea>
                    <p v-if="form.errors.description" class="text-red-500 text-sm mt-1">{{ form.errors.description }}</p>
                </div>

                <!-- Stock -->
                <div>
                    <label class="block text-sm font-medium text-gray-700">Stock</label>
                    <input
                        v-model="form.stock"
                        type="number"
                        step="1"
                        class="w-full mt-1 border-gray-300 rounded-md shadow-sm focus:ring focus:ring-blue-200 focus:outline-none px-4 py-2"
                    />
                    <p v-if="form.errors.stock" class="text-red-500 text-sm mt-1">{{ form.errors.stock }}</p>
                </div>

                <!-- Image Upload -->
                <div>
                    <label class="block text-sm font-medium text-gray-700">Image</label>
                    <input type="file" @change="handleImageChange" class="mt-1 block w-full text-sm file:border file:border-gray-300 file:rounded file:px-3 file:py-1 file:bg-white file:text-gray-700 hover:file:bg-gray-50" />
                    <p v-if="form.errors.image" class="text-red-500 text-sm mt-1">{{ form.errors.image }}</p>

                    <!-- Image Preview -->
                    <div v-if="form.image" class="mt-4">
                        <p class="text-sm text-gray-500 mb-1">Preview:</p>
                        <img :src="previewUrl" alt="Image preview" class="h-32 w-auto border rounded shadow" />
                    </div>
                </div>

                <!-- Submit Button -->
                <div class="pt-4">
                    <button
                        type="submit"
                        :disabled="form.processing"
                        class="w-full bg-blue-600 text-white px-4 py-2 rounded-md font-semibold hover:bg-blue-700 transition disabled:opacity-50"
                    >
                        {{ form.processing ? 'Saving...' : 'Save Product' }}
                    </button>
                </div>
            </form>
        </div>
    </AppLayout>
</template>