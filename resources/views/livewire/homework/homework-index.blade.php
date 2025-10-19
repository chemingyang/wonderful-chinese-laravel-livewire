<section>
    <div class="relative overflow-x-auto">
        @if ($user_type === 'student')
            @include('partials.homework.homework-index-student-tables',['uniqs' => $uniqs])
        @endif
        @include('partials.message-modal')
    </div>
</section>
