<div class="grid grid-cols-1 lg:grid-cols-4 gap-6">
    <!-- Main Content Area -->
    <div class="lg:col-span-4 space-y-6">
        <div class="rounded-md border border-gray-200 bg-white dark:border-gray-800 dark:bg-gray-900">
            <div class="p-5 space-y-4 sm:p-6">

                <!-- Assigned User -->
                <div class="space-y-1">
                    <h3 class="text-base font-medium text-gray-700 dark:text-white">Assigned User</h3>
                    <label for="user_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Select User</label>
                    <select name="user_id" id="user_id" class="form-control">
                        @foreach ($users as $user)
                        <option value="{{ $user->id }}" @if(isset($company) && $user->id === $company->user_id) selected @endif>{!! $user->first_name . ' ' . $user->last_name . ' <span class="text-xs text-gray-400">(' . $user->email . ')</span>' !!}</option>
                        @endforeach
                    </select>
                </div>


                <!-- Company Name -->
                <div class="space-y-1">
                    <label for="company_name" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Company Name</label>
                    <input type="text" name="company_name" id="company_name" required maxlength="255"
                        class="form-control" value="{{ old('company_name', $company->company_name ?? '') }}">
                </div>

                <!-- Industry -->
                <div class="space-y-1">
                    <label for="industry" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Industry</label>
                    <input type="text" name="industry" id="industry" class="form-control" value="{{ old('industry', $company->industry ?? '') }}">
                </div>

                <!-- Contact Person Details -->
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div class="space-y-1">
                        <label for="contact_person_name" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Contact Person Name</label>
                        <input type="text" name="contact_person_name" id="contact_person_name" class="form-control" value="{{ old('contact_person_name', $company->contact_person_name ?? '') }}">
                    </div>
                    <div class="space-y-1">
                        <label for="contact_person_email" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Contact Person Email</label>
                        <input type="email" name="contact_person_email" id="contact_person_email" class="form-control" value="{{ old('contact_person_email', $company->contact_person_email ?? '') }}">
                    </div>
                </div>

                <div class="space-y-1">
                    <label for="contact_person_phone" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Contact Person Phone</label>
                    <input type="text" name="contact_person_phone" id="contact_person_phone" class="form-control" value="{{ old('contact_person_phone', $company->contact_person_phone ?? '') }}">
                </div>


                <!-- Status & Visibility -->
                <div class="space-y-1">
                    <h3 class="text-base font-medium text-gray-700 dark:text-white">Status & Visibility</h3>
                    <div class="flex items-center space-x-2">
                        <input type="checkbox" name="is_active" value="1" id="is_active" class="rounded" @if(isset($company) && $company->is_active) checked @endif>
                        <label for="is_active" class="text-sm font-medium text-gray-700 dark:text-gray-300">Active</label>
                    </div>
                </div>

                <!-- Address -->
                <div class="space-y-1">
                    <h3 class="text-base font-medium text-gray-700 dark:text-white">Address</h3>
                    <div class="space-y-1">
                        <textarea name="address" rows="3" class="form-control w-full border rounded-lg p-2">{{ old('address', $company->address ?? '') }}</textarea>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Sidebar Area - Now empty since content moved to main area -->
    <!-- <div class="lg:col-span-1"> -->
    <!-- Sidebar content has been moved to the main content area for a single-column layout -->
    <!-- </di   v> -->

</div>