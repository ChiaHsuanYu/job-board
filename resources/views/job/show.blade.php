<x-layout>  
    <x-breadcrumbs 
        :links="[
            'Jobs' => route('jobs.index'),
            $job->title => '#'
        ]" 
        class="mb-4"/>
    <x-job-card class="mb-4" 
        :$job
        :experience="array_search($job->experience, $experience)" 
        :category="array_search($job->category, $category)">
        <p class="job-description">
            {!! nl2br( e($job->description) )  !!}
        </p>

       
        @can('apply', $job)
            <x-link-button :href="route('job.appliation.create', $job)">
                {{ __('Apply') }}
            </x-link-button>
        @else
            <div class="text-center text-sm font-medium text-slate-500">
                {{ __('You already applied to this job') }}
            </div>
        @endcan
       
    </x-job-card>

    <x-card class="mb-4">
        <h2 class="mb-4 job-title">
            {{ __('More') }}  
            <p class="inline font-bold">{{ $job->employer->company_name }}</p>
            {{ __('Jobs') }}
        </h2>

        <div class="job-description">
            @forelse ($job->employer->jobs as $otherJob)
                <div class="mb-4 flex justify-between">
                    <div>
                        <div class="text-slate-900">
                            <a href="{{ route('jobs.show', $otherJob) }}">
                                {{ $otherJob->title }}
                            </a>
                        </div>
                        <div class="text-xs">
                            {{ $otherJob->created_at->diffForHumans() }}
                        </div>
                    </div>
                    <div class="text-xs">
                        {{ number_format($otherJob->salary) }}
                    </div>
                </div>
            @empty
                {{ __('No other job yet') }} 
            @endforelse 
        </div>

    </x-card>
</x-layout>