<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue'
import { type BreadcrumbItem } from '@/types'
import { Head, Link, usePage, router } from '@inertiajs/vue3'
import { computed } from 'vue'

// Breadcrumbs
const breadcrumbs: BreadcrumbItem[] = [
  {
    title: 'Dashboard',
    href: '/dashboard',
  },
]

// Get props passed from Inertia
const { props } = usePage()
const products = computed(() => props.products)

// Stats
const totalProducts = computed(() => products.value.total || 0)
const inStock = computed(() => products.value.data.filter((p: any) => p.stock > 0).length)
const lowStock = computed(() => products.value.data.filter((p: any) => p.stock > 0 && p.stock <= 5).length)
const bestSeller = computed(() =>
  products.value.data.reduce((prev: any, curr: any) => (prev.stock > curr.stock ? prev : curr), {})?.name || 'N/A'
)

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
  <Head title="Dashboard" />

  <AppLayout :breadcrumbs="breadcrumbs">
    <div class="flex h-full flex-1 flex-col gap-4 rounded-xl p-4">
      <!-- Stats Cards -->
      <div class="grid auto-rows-min gap-4 md:grid-cols-4">
        <div class="p-4 bg-white shadow rounded-lg">
          <div class="text-sm text-gray-500">Total Products</div>
          <div class="text-xl font-bold">{{ totalProducts }}</div>
        </div>
        <div class="p-4 bg-white shadow rounded-lg">
          <div class="text-sm text-gray-500">In Stock</div>
          <div class="text-xl font-bold">{{ inStock }}</div>
        </div>
        <div class="p-4 bg-white shadow rounded-lg">
          <div class="text-sm text-gray-500">Low Stock</div>
          <div class="text-xl font-bold text-red-500">{{ lowStock }}</div>
        </div>
        <div class="p-4 bg-white shadow rounded-lg">
          <div class="text-sm text-gray-500">Best Seller</div>
          <div class="text-xl font-bold">{{ bestSeller }}</div>
        </div>
      </div>

      <!-- Product Actions & Table -->
      <div class="bg-white shadow rounded-lg p-4">
        <div class="flex justify-between items-center mb-4">
          <h2 class="text-lg font-semibold">Product Overview</h2>
          <Link
            href="/products/create"
            class="inline-block px-4 py-2 bg-blue-600 text-white rounded-md shadow hover:bg-blue-700 transition">
            Add Product
          </Link>
        </div>

        <table class="w-full text-sm">
          <thead>
            <tr class="text-left border-b">
              <th class="py-2">Name</th>
              <th class="py-2">Price</th>
              <th class="py-2">Stock</th>
              <th class="py-2">Image</th>
              <th class="py-2">Actions</th>
            </tr>
          </thead>
          <tbody>
            <tr
              v-for="product in products.data"
              :key="product.id"
              class="border-b hover:bg-gray-50"
            >
              <td class="py-2">{{ product.name }}</td>
              <td class="py-2">${{ product.price.toFixed(2) }}</td>
              <td class="py-2" :class="{ 'text-red-500': product.stock === 0 }">{{ product.stock }}</td>
              <td class="py-2">
                  <img :src="`/storage/${product.image}`" alt="Product" class="h-8 rounded" />             
              </td>
              <td class="py-2 flex gap-2">
                <Link
                  :href="`/products/${product.id}/edit`"
                  class="px-3 py-1 bg-yellow-500 text-white rounded hover:bg-yellow-600 transition"
                >
                  Edit
                </Link>
                <button
                  @click="deleteProduct(product.id)"
                  class="px-3 py-1 bg-red-500 text-white rounded hover:bg-red-600 transition"
                >
                  Delete
                </button>
              </td>
            </tr>
          </tbody>
        </table>

        <!-- Pagination Controls -->
        <div class="mt-4 flex justify-center space-x-2">
          <Link
            v-for="link in products.links"
            :key="link.label"
            :href="link.url"
            class="px-3 py-1 rounded text-sm"
            :class="{
              'bg-blue-600 text-white': link.active,
              'bg-gray-100 text-gray-600 hover:bg-gray-200': !link.active && link.url,
              'cursor-not-allowed text-gray-400': !link.url,
            }"
            >
            <span v-html="link.label"></span>
            </Link>
        </div>
      </div>
    </div>
  </AppLayout>
</template>