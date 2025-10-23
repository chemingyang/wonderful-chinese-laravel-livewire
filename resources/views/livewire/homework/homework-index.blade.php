<section>
    <div class="relative overflow-x-auto">
        @if ($user_type === 'student')
            @include('partials.homework.homework-index-student-tables',['uniqs' => $uniqs])
        @elseif ($user_type === 'teacher')
            @include('partials.homework.homework-index-teacher-tables',['uniqs' => $uniqs])
        @endif
        @include('partials.message-modal')
    </div>
</section>
