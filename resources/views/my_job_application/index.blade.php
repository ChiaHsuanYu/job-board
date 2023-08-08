<x-layout>
    <x-breadcrumbs class="mb-4"
        :links="['My Job Applications' => '#']" />

    @forelse ($applications as $application)
        <x-job-card :job="$application->job"
            :experience="array_search($application->job->experience, $experience)" 
            :category="array_search($application->job->category, $category)">
            <div class="my_job_info_box">
                <div>
                    <div>
                        {{ __('Applied').' '. $application->created_at->diffForHumans() }}
                    </div>
                    <div>
                        {{ __('Other '. Str::plural('applicant', $application->job->job_applications_count - 1 ) ) }} 
                            {{ $application->job->job_applications_count - 1 }}
                    </div>
                    <div>
                        {{ __('You asking salary'). ' $'. number_format($application->expected_salary) }}
                    </div>
                    <div>
                        {{ __('Average asking salary'). ' $'. number_format($application->job->job_applications_avg_expected_salary ) }}
                    </div>
                </div>
                <div>
                    <form action="{{ route('my-job-applications.destroy', $application) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <x-button>{{ __('Cancel') }}</x-button>
                    </form>
                </div>
            </div>
        </x-job-card>
    @empty
        <div class="no_job_box">
            <div class="text-center font-medium">
                {{ __('No job application yet') }}
            </div>
            <div class="text-center">
                {{ __('Go find some jobs ') }}
                <a class="text-indigo-500 hover:underline" href="{{ route('jobs.index') }}">
                    here!
                </a>
            </div>
        </div>
        
    @endforelse
</x-layout>