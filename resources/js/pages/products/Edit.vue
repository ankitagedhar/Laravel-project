<script setup lang="ts">
import { useForm, Head, router  } from '@inertiajs/vue3';
import AppLayout from '@/layouts/AppLayout.vue';
import { ref, watch } from 'vue';

const props = defineProps({ product: Object });

const form = useForm({
  name: props.product.name,
  price: props.product.price,
  description: props.product.description,
  stock: props.product.stock,
  image: null,
});

const submit = () => {
  const formData = new FormData();
  formData.append('name', form.name);
  formData.append('price', form.price);
  formData.append('description', form.description);
  formData.append('stock', form.stock);

  if (form.image) {
    formData.append('image', form.image);
  }

  formData.append('_method', 'PUT'); // if you're using router.post()
  router.post(`/products/${props.product.id}`, formData, {
    onError: (errors) => {
      console.log('Validation errors:', errors);
    },
  });
};

const preview = ref(null);


// Fill the form with the existing product data
watch(() => props.product, (product) => {
  if (!product) return;

  form.id = product.id;
  form.name = product.name;
  form.price = product.price;
  form.description = product.description;
  form.stock = product.stock;
  preview.value = product.image ? `/storage/${product.image}` : null;
}, { immediate: true });

function handleImageChange(e) {
  const file = e.target.files[0];
  if (file) {
    form.image = file;
    preview.value = URL.createObjectURL(file);
  }
}


</script>

<template>
  <Head title="Edit Product" />
  <AppLayout>
    <div class="p-6 max-w-xl mx-auto">
      <h1 class="text-xl font-bold mb-4">Edit Product</h1>

      <form @submit.prevent="submit" class="space-y-4">
        <input v-model="form.name" type="text" placeholder="Name" class="w-full border px-3 py-2" />
        <input v-model="form.price" type="number" placeholder="Price" class="w-full border px-3 py-2" />
        <textarea v-model="form.description" placeholder="Description" class="w-full border px-3 py-2" />
        <input v-model="form.stock" type="number" placeholder="Stock" class="w-full border px-3 py-2" />

        <input type="file" @change="handleImageChange" />

        <img v-if="preview" :src="preview" class="h-24 mt-2" />

        <button type="submit" :disabled="form.processing" class="bg-blue-600 text-white px-4 py-2 rounded">
          Update Product
        </button>
      </form>
    </div>
  </AppLayout>
</template>