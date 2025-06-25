<script setup lang="ts">
import { Head, Link, router } from '@inertiajs/vue3';
import AppLayout from '@/layouts/AppLayout.vue';
defineProps({ products: Array });


const deleteProduct = (id) => {
  if (confirm('Are you sure you want to delete this product?')) {
    router.delete(`/products/${id}`, {
      preserveState: false, // this tells Inertia: "Don't reuse current props, ask backend for fresh ones"
      onSuccess: () => {
        console.log('Deleted and reloaded');
      },
    });
  }
};
</script>

<template>
  <Head title="Products" />
  <AppLayout>
    <div class="p-6">
      <h1 class="text-2xl font-bold mb-4">Product List</h1>
      <table class="w-full border">
        <thead class="bg-gray-100">
          <tr>
            <th class="p-2">Name</th>
            <th class="p-2">Price</th>
            <th class="p-2">Image</th>
            <th class="p-2">Actions</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="product in products" :key="product.id" class="border-t">
            <td class="p-2">{{ product.name }}</td>
            <td class="p-2">${{ product.price }}</td>
            <td class="p-2">
              <img v-if="product.image" :src="`/storage/${product.image}`" alt="" class="h-12" />
            </td>
            <td class="p-2">
              <Link :href="`/products/${product.id}/edit`" class="text-blue-600 hover:underline">Edit</Link>
              <button @click="deleteProduct(product.id)" class="text-red-600 hover:underline ml-2">
                Delete
              </button>
            </td>
          </tr>
        </tbody>
      </table>
    </div>
  </AppLayout>
</template>