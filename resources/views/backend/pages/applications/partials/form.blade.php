<div class="grid grid-cols-1 lg:grid-cols-4 gap-6">
    {{-- Main Content Area --}}
    <div class="lg:col-span-3 space-y-6">
        <div class="rounded-md border border-gray-200 bg-white dark:border-gray-800 dark:bg-gray-900">
            <div class="p-5 space-y-4 sm:p-6">

                <!-- Job Title -->
                <div class="space-y-1">
                    <label for="job_title" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Job Title</label>
                    <input type="text" name="job_title" id="job_title" required maxlength="255" class="form-control" value="{{ old('job_title', $job->job_title ?? '') }}">
                </div>

                <!-- Job Description -->
                <div class="space-y-1">
                    <label for="description" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Description</label>
                    <textarea name="description" id="description" rows="5" class="w-full border rounded-lg p-2">{{ old('description', $job->description ?? '') }}</textarea>
                </div>

                <!-- Salary -->
                <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                    <div class="space-y-1">
                        <label for="salary_currency" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Currency</label>
                        <input type="text" name="salary_currency" id="salary_currency" class="form-control" value="{{ old('salary_currency', $job->salary_currency ?? '') }}">
                    </div>
                    <div class="space-y-1">
                        <label for="min_salary" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Min Salary</label>
                        <input type="number" name="min_salary" id="min_salary" class="form-control" value="{{ old('min_salary', $job->min_salary ?? '') }}">
                    </div>
                    <div class="space-y-1">
                        <label for="max_salary" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Max Salary</label>
                        <input type="number" name="max_salary" id="max_salary" class="form-control" value="{{ old('max_salary', $job->max_salary ?? '') }}">
                    </div>
                </div>

                <!-- Location -->
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div class="space-y-1">
                        <label for="city" class="block text-sm font-medium text-gray-700 dark:text-gray-300">City</label>
                        <input type="text" name="city" id="city" class="form-control" value="{{ old('city', $job->city ?? '') }}">
                    </div>
                    <div class="space-y-1">
                        <label for="country" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Country</label>
                        <input type="text" name="country" id="country" class="form-control" value="{{ old('country', $job->country ?? '') }}">
                    </div>
                </div>

                <!-- Job Details Dropdowns -->
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div class="space-y-1">
                        <label for="job_location_type" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Location Type</label>
                        <select name="job_location_type" id="job_location_type" class="form-control">
                            <option value="On-site" @if(isset($job) && $job->job_location_type === 'On-site') selected @endif>On-site</option>
                            <option value="Hybrid" @if(isset($job) && $job->job_location_type === 'Hybrid') selected @endif>Hybrid</option>
                            <option value="Remote" @if(isset($job) && $job->job_location_type === 'Remote') selected @endif>Remote</option>
                        </select>
                    </div>
                    <div class="space-y-1">
                        <label for="experience_level" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Experience Level</label>
                        <select name="experience_level" id="experience_level" class="form-control">
                            <option value="Entry-level" @if(isset($job) && $job->experience_level === 'Entry-level') selected @endif>Entry-level</option>
                            <option value="Mid-level" @if(isset($job) && $job->experience_level === 'Mid-level') selected @endif>Mid-level</option>
                            <option value="Senior-level" @if(isset($job) && $job->experience_level === 'Senior-level') selected @endif>Senior-level</option>
                            <option value="Director" @if(isset($job) && $job->experience_level === 'Director') selected @endif>Director</option>
                            <option value="Executive" @if(isset($job) && $job->experience_level === 'Executive') selected @endif>Executive</option>
                        </select>
                    </div>
                </div>

                <!-- Job Type -->
                <div class="space-y-1">
                    <label for="job_type" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Job Type</label>
                    <select name="job_type" id="job_type" class="form-control">
                        <option value="Full-time" @if(isset($job) && $job->job_type === 'Full-time') selected @endif>Full-time</option>
                        <option value="Part-time" @if(isset($job) && $job->job_type === 'Part-time') selected @endif>Part-time</option>
                        <option value="Contract" @if(isset($job) && $job->job_type === 'Contract') selected @endif>Contract</option>
                        <option value="Internship" @if(isset($job) && $job->job_type === 'Internship') selected @endif>Internship</option>
                        <option value="Temporary" @if(isset($job) && $job->job_type === 'Temporary') selected @endif>Temporary</option>
                    </select>
                </div>
            </div>
        </div>
    </div>

    {{-- Sidebar Area --}}
    <div class="lg:col-span-1 space-y-6">
        <div class="rounded-md border border-gray-200 bg-white dark:border-gray-800 dark:bg-gray-900">
            <div class="p-3 space-y-2 sm:p-4">
                <h3 class="font-semibold text-gray-700 dark:text-gray-300">Associated Data</h3>
                <hr class="mt-1 mb-2 border-gray-200 dark:border-gray-700">

                <!-- Company -->
                <div class="space-y-1">
                    <label for="company_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Company</label>
                    <select name="company_id" id="company_id" class="form-control">
                        @foreach($companies as $company)
                        <option value="{{ $company->id }}" @if(isset($job) && $company->id === $job->company_id) selected @endif>{{ $company->company_name }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- Category -->
                <div class="space-y-1">
                    <label for="category_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Category</label>
                    <select name="category_id" id="category_id" class="form-control">
                        @foreach($categories as $category)
                        <option value="{{ $category->id }}" @if(isset($job) && $category->id === $job->category_id) selected @endif>{{ $category->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>

        <div class="rounded-md border border-gray-200 bg-white dark:border-gray-800 dark:bg-gray-900">
            <div class="p-3 space-y-2 sm:p-4">
                <h3 class="font-semibold text-gray-700 dark:text-gray-300">Status & Dates</h3>
                <hr class="mt-1 mb-2 border-gray-200 dark:border-gray-700">

                <!-- Checkboxes -->
                <div class="space-y-2">
                    <div class="flex items-center space-x-2">
                        <input type="checkbox" name="is_open" value="1" id="is_open" class="rounded" @if(isset($job) && $job->is_open) checked @endif>
                        <label for="is_open" class="text-sm font-medium text-gray-700 dark:text-gray-300">Is Open</label>
                    </div>
                    <div class="flex items-center space-x-2">
                        <input type="checkbox" name="is_featured" value="1" id="is_featured" class="rounded" @if(isset($job) && $job->is_featured) checked @endif>
                        <label for="is_featured" class="text-sm font-medium text-gray-700 dark:text-gray-300">Is Featured</label>
                    </div>
                </div>

                <!-- Dates -->
                <div class="space-y-1">
                    <label for="published_at" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Published At</label>
                    <input type="date" name="published_at" id="published_at" class="form-control" value="{{ old('published_at', isset($job) ? ($job->published_at ? $job->published_at->format('Y-m-d') : '') : '') }}">
                </div>
                <div class="space-y-1">
                    <label for="expires_at" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Expires At</label>
                    <input type="date" name="expires_at" id="expires_at" class="form-control" value="{{ old('expires_at', isset($job) ? ($job->expires_at ? $job->expires_at->format('Y-m-d') : '') : '') }}">
                </div>
            </div>
        </div>
    </div>

</div>