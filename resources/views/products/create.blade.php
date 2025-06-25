<x-layout>
    <x-slot:title>
        Products
    </x-slot:title>
    <x-slot:heading>
        Add Product
    </x-slot:heading>

     @if (session('success'))
        <div class="bg-green-900 text-green-300 px-4 py-2 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

    @if ($errors->any())
        <div class="bg-red-900 text-red-300 px-4 py-2 rounded mb-4">
            <ul class="list-disc list-inside">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('products.store') }}" method="POST" enctype="multipart/form-data"
      class="max-w-xl mx-auto bg-gray-900 text-white p-6 rounded-lg shadow-lg border border-gray-800">
        @csrf

        <div class="mb-4">
            <label class="block text-gray-300 mb-1" for="name">Product Name</label>
            <input type="text" name="name" id="name"
                   value="{{ old('name') }}"
                   class="w-full bg-gray-800 text-white border border-gray-700 rounded px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
                   required>
        </div>

        <div class="mb-4">
            <label class="block text-gray-300 mb-1" for="description">Description</label>
            <textarea name="description" id="description" rows="4"
                      class="w-full bg-gray-800 text-white border border-gray-700 rounded px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">{{ old('description') }}</textarea>
        </div>

        <div class="mb-4">
            <label class="block text-gray-300 mb-1" for="price">Price ($)</label>
            <input type="number" name="price" id="price" step="0.01"
                   value="{{ old('price') }}"
                   class="w-full bg-gray-800 text-white border border-gray-700 rounded px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
                   required>
        </div>

        <div class="mb-6">
            <label class="block text-gray-300 mb-1" for="stock">Stock Quantity</label>
            <input type="number" name="stock" id="stock"
                   value="{{ old('stock') }}"
                   class="w-full bg-gray-800 text-white border border-gray-700 rounded px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
                   required>
        </div>

        <div class="mb-6">
            <label class="block text-gray-300 mb-1" for="image">Product Image</label>
            <input type="file" name="image" id="image"
                class="block w-full text-sm text-gray-300 file:mr-4 file:py-2 file:px-4
                        file:rounded file:border-0 file:text-sm file:font-semibold
                        file:bg-blue-600 file:text-white hover:file:bg-blue-700" />
        </div>

        <div class="flex justify-end">
            <button type="submit"
                    class="bg-blue-600 text-white px-6 py-2 rounded hover:bg-blue-700 transition">
                Save Product
            </button>
        </div>
    </form>
</x-layout>