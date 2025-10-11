<section>
    <div class="flex justify-end mr-6 pb-4">
        <!-- turn this into a button -->
        <a href="{{ route('lessons.create') }}" class="text-indigo-500 hover:text-indigo-700 font-medium">
        
        <span class="inline-flex mr-1">    
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 22 22" stroke-width="2.5" stroke="currentColor" class="w-5 h-5 mr-1 p-0.5">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
            </svg>
            <label>Add Lesson</label>
        </span>
        </a>
    </div>
    <div class="relative overflow-x-auto">
        <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-600 dark:text-gray-400">
                <tr>
                    <th scope="col" class="px-6 py-3">
                        ID
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Title
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Description
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Course ID
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Scheduled At
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Completed At
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Actions
                    </th>
                </tr>
            </thead>
            <tbody>
                @forelse (@$lessons as $lesson)
                   <tr class="odd:bg-white odd:dark:bg-gray-900 even:bg-gray-50 even:dark:bg-gray-800 border-b dark:border-gray-700 border-gray-200">
                        <th scope="row" class="px-5 py-2 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                            {{ $lesson->id }}
                        </th>
                        <td class="px-5 py-2">
                            {{ $lesson->title }}
                        </td>
                        <td class="px-5 py-2">
                            {{ $lesson->description }}
                        </td>
                        <td class="px-5 py-2">
                            {{ $lesson->course->title  }}
                        </td>
                        <td class="px-5 py-2">
                            {{ date('Y-m-d', strtotime($lesson->scheduled_at)) }}
                        </td>
                        <td class="px-5 py-2">
                            {{ date('Y-m-d', strtotime($lesson->completed_at)) }}
                        </td>
                        <td class="px-5 py-2 space-x-2">
                            <a href="{{ route('lessons.edit', $lesson->id) }}" class="text-indigo-500 hover:text-indigo-700 font-medium">Edit</a>
                            <button wire:click="delete({{ $lesson->id }})" wire:confirm="Are you sure you want to delete this lesson?" class="text-red-500 hover:text-red-700 font-medium ms-4">Delete</button>
                        </td>
                    </tr>
               @empty
                    <tr>  
                        <td colspan="7" class="px-6 py-4 text-center text-gray-500">
                            No lessons available.
                        </td>
                    </tr>
               @endforelse
            </tbody>
        </table>    
        @if (session()->has('message'))
        <div x-init="setTimeout(() => $wire.clearSessionMessage(), 3000)" id="toast-bottom-right" class="fixed flex items-center w-full max-w-xs p-3 space-x-4 text-gray-500 bg-white divide-x rtl:divide-x-reverse divide-gray-200 rounded-lg shadow-sm right-5 bottom-5 dark:text-gray-400 dark:divide-gray-700 dark:bg-gray-800" role="alert">
            <div id="toast-success" class="flex items-center w-full max-w-xs p-3 text-gray-500 bg-white rounded-lg  dark:text-gray-400 dark:bg-gray-800" role="alert">
                <div class="inline-flex items-center justify-center shrink-0 w-8 h-8 text-green-500 bg-green-100 rounded-lg dark:bg-green-800 dark:text-green-200">
                    <svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5Zm3.707 8.207-4 4a1 1 0 0 1-1.414 0l-2-2a1 1 0 0 1 1.414-1.414L9 10.586l3.293-3.293a1 1 0 0 1 1.414 1.414Z"/>
                    </svg>
                    <span class="sr-only">Check icon</span>
                </div>
                <div class="ms-3 text-sm font-normal">{{ session('message') }}</div>
                <button wire:click="clearSessionMessage" type="button" class="ms-auto -mx-1.5 -my-1.5 bg-white text-gray-400 hover:text-gray-900 rounded-lg focus:ring-2 focus:ring-gray-300 p-1.5 hover:bg-gray-100 inline-flex items-center justify-center h-8 w-8 dark:text-gray-500 dark:hover:text-white dark:bg-gray-800 dark:hover:bg-gray-700" data-dismiss-target="#toast-success" aria-label="Close">
                    <span class="sr-only">Close</span>
                    <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                    </svg>
                </button>
            </div>
        </div>
        @endif
    </div>
</section>
