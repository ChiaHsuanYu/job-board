<x-layout>
    <x-breadcrumbs :links="['My Jobs' => route('my-jobs.index'), 'Create' => '#' ]" class="mb-4" />

    <x-card class="mb-8">
        <form action="{{ route('my-jobs.store') }}" method="post">
            @csrf

            <div class="mb-4 grid grid-cols-2 gap-4">
                <div>
                    <x-label for="title" :required="true">{{ __('Job Title') }}</x-label>
                    <x-text-input name="title" />
                </div>
                <div>
                    <x-label for="location" :required="true">{{ __('Location') }}</x-label>
                    <x-text-input name="location" />
                </div>

                <div class="col-span-2">
                    <x-label for="salary" :required="true">{{ __('Salary') }}</x-label>
                    <x-text-input name="salary" />
                </div>

                <div class="col-span-2">
                    <x-label for="description" :required="true">{{ __('Description') }}</x-label>
                    <x-text-input name="description" type="textarea"/>
                </div>

                <div>
                    <x-label for="experience" :required="true">{{ __('Experience') }}</x-label>
                    <x-radio-group name="experience" :value="old('experience')" :options="$experience" :all-option="false" />
                </div>

                <div>
                    <x-label for="category" :required="true">{{ __('Category') }}</x-label>
                    <x-radio-group name="category" :value="old('category')" :options="$category" :all-option="false" />
                </div>

                <x-button class="col-span-2 w-full">{{ __('Create Job') }}</x-button>
            </div>
        </form>
    </x-card>
</x-layout>