<!-- resources/views/product-browser.blade.php -->

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Product Browser</title>

  <!-- ✅ Load TailwindCSS from CDN for styling -->
  <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100 p-6">
  <!-- 🧭 Page Heading -->
  <h1 class="text-3xl font-bold mb-6">Product Browser</h1>

  <!-- 📦 Product list will be rendered here by JS -->
  <div id="product-list"></div>

  <!-- ✏️ Edit Product Form (initially hidden) -->
  <div id="edit-section" class="mt-10 hidden">
    <h2 class="text-xl font-bold mb-2">Edit Product</h2>
    <form id="edit-product-form" class="bg-white p-4 rounded shadow">
      <!-- 🔒 Hidden input to hold product ID -->
      <input type="hidden" name="id" />

      <!-- 🧾 Editable fields for product data -->
      <input type="text" name="name" placeholder="Name" class="block w-full mb-2 border p-2" required />
      <input type="number" name="price" placeholder="Price" class="block w-full mb-2 border p-2" required />
      <input type="number" name="stock" placeholder="Stock" class="block w-full mb-2 border p-2" required />
      <textarea name="description" placeholder="Description" class="block w-full mb-2 border p-2" required></textarea>

      <!-- ✅ Submit button to update product -->
      <button type="submit" class="bg-green-500 text-white px-4 py-2 rounded">Update Product</button>
    </form>
  </div>

  <!-- ➕ Add New Product Form -->
  <div class="mt-10">
    <h2 class="text-xl font-bold mb-2">Add New Product</h2>
    <form id="add-product-form" class="bg-white p-4 rounded shadow">
      <!-- 🧾 Input fields for new product -->
      <input type="text" name="name" placeholder="Name" class="block w-full mb-2 border p-2" required />
      <input type="number" name="price" placeholder="Price" class="block w-full mb-2 border p-2" required />
      <input type="number" name="stock" placeholder="Stock" class="block w-full mb-2 border p-2" required />
      <textarea name="description" placeholder="Description" class="block w-full mb-2 border p-2" required></textarea>

      <!-- ✅ Submit button to add product -->
      <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Add Product</button>
    </form>
  </div>

  <!-- 🧠 JavaScript Logic Section -->
  <script>
    // 📥 Fetch all products from the API and render them
    async function fetchProducts() {
      const response = await fetch('/api/products');
      const data = await response.json();

      // 🧹 Clear the product list
      document.getElementById('product-list').innerHTML = '';

      // 🧱 Render each product card
      data.data.forEach(renderProduct);
    }

    // 🎨 Create a card for each product
    function renderProduct(product) {
      const productCard = document.createElement('div');
      productCard.className = 'bg-white p-4 rounded shadow mb-4';

      // 📝 Create the inner HTML structure
      productCard.innerHTML = `
        <h2 class="text-xl font-bold">${product.name}</h2>
        <p class="text-gray-700">Price: $${product.price}</p>
        <p class="text-gray-700">Stock: ${product.stock}</p>
        <p class="text-gray-700">${product.description}</p>
        <div class="mt-4">
          <!-- ✏️ Edit button (passes product object to edit form) -->
          <button onclick='openEditForm(${JSON.stringify(product)})' class="bg-yellow-400 px-2 py-1 rounded mr-2">✏️ Edit</button>

          <!-- 🗑️ Delete button -->
          <button onclick="deleteProduct(${product.id})" class="bg-red-500 text-white px-2 py-1 rounded">🗑️ Delete</button>
        </div>
      `;

      // 🧩 Append to product list
      document.getElementById('product-list').appendChild(productCard);
    }

    // ✏️ Fill the edit form with selected product's data
    function openEditForm(product) {
      // 👁️ Show the edit form section
      document.getElementById('edit-section').classList.remove('hidden');

      // 🛠️ Fill form inputs with product values
      const form = document.getElementById('edit-product-form');
      form.name.value = product.name;
      form.price.value = product.price;
      form.stock.value = product.stock;
      form.description.value = product.description;
      form.id.value = product.id;
    }

    // 🗑️ Delete a product by ID
    async function deleteProduct(productId) {
      if (confirm("Are you sure you want to delete this product?")) {
        await fetch(`/api/products/${productId}`, { method: 'DELETE' });
        fetchProducts(); // 🔁 Refresh list after delete
      }
    }

    // ➕ Handle Add Product Form Submit
    document.getElementById('add-product-form').addEventListener('submit', async (e) => {
      e.preventDefault(); // 🚫 Prevent page reload

      const form = e.target;
      const formData = new FormData(form); // 📦 Extract form data
      const data = Object.fromEntries(formData.entries()); // 🔄 Convert to object

      await fetch('/api/products', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify(data) // 🔥 Send to backend
      });

      form.reset();     // 🔄 Reset form
      fetchProducts();  // 🔁 Refresh list
    });

    // 📝 Handle Edit Product Form Submit
    document.getElementById('edit-product-form').addEventListener('submit', async (e) => {
      e.preventDefault(); // 🚫 Prevent page reload

      const form = e.target;
      const productId = form.id.value;

      // 📦 Updated product data
      const updatedData = {
        name: form.name.value,
        price: form.price.value,
        stock: form.stock.value,
        description: form.description.value
      };

      await fetch(`/api/products/${productId}`, {
        method: 'PUT',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify(updatedData)
      });

      // ✅ Reset and hide form after successful update
      form.reset();
      document.getElementById('edit-section').classList.add('hidden');

      fetchProducts(); // 🔁 Refresh updated list
    });

    // 🚀 Load all products when page loads
    fetchProducts();
  </script>

</body>
</html>
