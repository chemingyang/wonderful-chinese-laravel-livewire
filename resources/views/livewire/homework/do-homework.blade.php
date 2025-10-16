<section>
    <div class="relative overflow-x-auto">
        <h1>Hello {{ $student->name }}</h1>
        <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-600 dark:text-gray-400">
                <tr>
                    <th scope="col" class="px-6 py-3">
                        Course
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Lesson
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Action
                    </th>
                </tr>
            </thead>
             <tbody>
                @forelse (@$uniqs as $uniq)
                   <tr class="odd:bg-white odd:dark:bg-gray-900 even:bg-gray-50 even:dark:bg-gray-800 border-b dark:border-gray-700 border-gray-200">
                        <th scope="row" class="px-5 py-2 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                            {{ $uniq->course_title }}
                        </th>
                        <td class="px-5 py-2">
                            {{ $uniq->lesson_title }}
                        </td>
                        <td class="px-5 py-2 space-x-2">
                            <a href="{{ route('homeworks.do-lesson', $uniq->lesson_id) }}" class="text-indigo-500 hover:text-indigo-700 font-medium">Start Lesson</a>
                        </td>
                    </tr>
                @empty
                    <tr>  
                        <td colspan="3" class="px-6 py-4 text-center text-gray-500">
                            No Homework Found
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
        @include('partials.message-modal')
    </div>
</section>
