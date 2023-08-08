<x-card class="mb-4">
    <div class="single-job-box">
        <a class="job-title hover:underline" href="{{ route('jobs.show', $job) }}">
            {{ $job->title }}
        </a>
        <div class="job-salary">
            ${{ number_format($job->salary) }}
        </div>
    </div>

    <div class="job-experience-box">
        <div class="job-company-left">
            <div>{{ $job->employer->company_name }}</div>
            <div>{{ $job->location }}</div>

            @if ($job->deleted_at)
                <span class="text-xs font-medium text-red-500">{{ __('Deleted') }}</span>
            @endif
        </div>
        <div class="job-company-right">
            <x-tag>
                <a href="{{ route('jobs.index', ['experience' => $job->experience]) }}">
                    {{ __( Str::ucfirst($experience) ) }}
                </a>
            </x-tag>
            <x-tag>
                <a href="{{ route('jobs.index', ['category' => $job->category]) }}">
                    {{ __($category) }}
                </a>
            </x-tag>
        </div>
    </div>

    {{ $slot }}
</x-card>