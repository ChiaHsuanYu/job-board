<x-layout>
    <x-breadcrumbs  
        :links="[
            'Jobs' => route('jobs.index'),
            $job->title => route('jobs.show', $job),
            'Apply' => '#',
        ]" 
        class="mb-4"/>
    <x-job-card :$job 
        :experience="array_search($job->experience, $experience)" 
        :category="array_search($job->category, $category)"/>
    <x-card>
        <h2 class="mb-4 job-title">
            {{ __('Your Job Application') }}
        </h2>
        <form action="{{ route('job.appliation.store', $job) }}" method="POST"
            enctype="multipart/form-data">
            @csrf
            <div class="mb-4">
                <x-label for="expected_salary" :required="true">{{ __('Expected Salary') }}</x-label>
                <x-text-input type="number" name="expected_salary" />
            </div>

            <div class="mb-4">
                <x-label for="expected_salary" :required="true">{{ __('Upload CV') }}</x-label>
                <x-text-input type="file" name="cv" />
            </div>

            <x-button class="w-full">{{ __('Apply') }}</x-button>
            
        </form>
    </x-card>
</x-layout>