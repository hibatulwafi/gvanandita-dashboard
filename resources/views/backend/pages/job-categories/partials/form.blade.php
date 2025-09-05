<div class="grid grid-cols-1 lg:grid-cols-4 gap-6">
  {{-- Main Content Area --}}
  <div class="lg:col-span-4 space-y-6">
    <div class="rounded-md border border-gray-200 bg-white dark:border-gray-800 dark:bg-gray-900">
      <div class="p-5 space-y-4 sm:p-6"> <!-- Category Name -->
        <div class="space-y-1">
          <label for="name" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Name</label>
          <input type="text" name="name" id="name" required maxlength="255"
            class="form-control" value="{{ old('name', $category->name ?? '') }}">
        </div>

        <!-- Category Slug -->
        <div class="space-y-1">
          <label for="slug" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Slug</label>
          <input type="text" name="slug" id="slug" required maxlength="255"
            class="form-control" value="{{ old('slug', $category->slug ?? '') }}">
        </div>
      </div>
    </div>
  </div>
</div>