<x-layout>
    <x-breadcrumbs 
        :links="[ __('Jobs') => route('jobs.index')]" 
        class="mb-4"/>
    <x-card class="mb-4 text-sm">
        <form id="filtering_form" action="{{ route('jobs.index') }}" method="GET">
            <div class="filter-grid">
                <div>
                    <div class="filter-title"> {{ __('Search') }}</div>
                    <x-text-input name="search" value="{{ request('search') }}" placeholder="Search for any text" formid="filtering_form" />
                </div>
                <div>
                    <div class="filter-title">{{ __('Salary') }}</div>
                    <div class="flex space-x-2">
                        <x-text-input name="min_salary" value="{{ request('min_salary') }}" placeholder="From" formid="filtering_form"/>
                        <x-text-input name="max_salary" value="{{ request('max_salary') }}" placeholder="To" formid="filtering_form"/>
                    </div>
                </div>
                <div>
                    <div class="filter-title">{{ __('Experience') }}</div>
                    <x-radio-group name="experience" :options="$experience" />                
                </div>
                <div>
                    <div class="filter-title">{{ __('Category') }}</div>
                    <x-radio-group name="category" :options="$category" />                
                </div>
            </div>
            <x-button class="w-full">{{ __('Filter') }}</x-button>
        </form>
    </x-card>
    @foreach($jobs as $job)
        <x-job-card class="mb-4" :$job 
            :experience="array_search($job->experience, $experience)" 
            :category="array_search($job->category, $category)">
            <div>
                <x-link-button :href="route('jobs.show', $job)">
                {{ __('Show') }}
                </x-link-button>
            </div>
        </x-job-card>
    @endforeach
   
</x-layout>