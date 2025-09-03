<div class="space-y-4 p-5 sm:p-6 bg-white rounded-md border border-gray-200 dark:border-gray-800 dark:bg-gray-900">
    <!-- Category Name -->
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