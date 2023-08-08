<x-layout>
    <x-breadcrumbs :links="['My Jobs' => '#']" class="mb-4" />
    @if (count($jobs))
        <div class="mb-8 text-right">
            <x-link-button href="{{ route('my-jobs.create') }}">{{ __('Add New') }}</x-link-button>
        </div>
    @endif

    @forelse ($jobs as $job)
        <x-job-card :$job
            :experience="array_search($job->experience, $experience)" 
            :category="array_search($job->category, $category)">
            <div class="text-xs text-slate-500">
                @forelse ($job->jobApplications as $application)
                    <div class="mb-4 my_job_info_box">
                        <div>
                            <div>{{ $application->user->name }}</div>
                            <div>
                                {{ __('Applied'). $application->created_at->diffForHumans() }}
                            </div>
                            <div>
                                {{ __('Download CV') }}
                            </div>
                        </div>
                        <div>
                            $ {{ number_format( $application->expected_salary ) }}
                        </div>
                    </div>
                @empty
                    <div>{{ __('No applicationa yet') }}</div>
                @endforelse

                <div class="flex space-x-2 mt-2">
                    @if (!$job->deleted_at)
                        <x-link-button href="{{ route('my-jobs.edit', $job) }}">{{ __('Edit') }}</x-link-button>
                        <form action="{{ route('my-jobs.destroy', $job) }}" method="POST"
                            onsubmit="return deleteSubmit()">
                            @csrf
                            @method('DELETE')
                            <x-button>{{ __('Delete') }}</x-button>
                        </form>
                    @else
                        <x-link-button href="{{ route('my-jobs.restore', $job) }}">{{ __('Restore') }}</x-link-button>
                    @endif
                
                </div>
            </div>
        </x-job-card>
    @empty
        <div class="rounded-md border border-dashed border-slate-300 p-8">
            <div class="text-center font-medium">
                {{ __('No jobs yet') }}<br>
                {{ __('Post your first job') }}
                <a class="text-indigo-500 hover:underline"
                    href="{{ route('my-jobs.create') }}">here!</a>
            </div>
        </div>
    @endforelse
</x-layout>

<script>
    function deleteSubmit(){
        return confirm("Are you sure you want to delete this job?")
    }
</script>

