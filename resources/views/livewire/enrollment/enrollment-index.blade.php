<section>
    @role('admin')
    <div class="flex justify-end mr-6 pb-4">
        <!-- turn this into a button -->
        <a href="{{ route('enrollments.create') }}" class="text-indigo-500 hover:text-indigo-700 font-medium">
        
        <span class="inline-flex mr-1">    
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 22 22" stroke-width="2.5" stroke="currentColor" class="w-5 h-5 mr-1 p-0.5">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
            </svg>
            <label>Enroll</label>
        </span>
        </a>
    </div>
    @endrole
    <div class="relative overflow-x-auto">
        <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-600 dark:text-gray-400">
                <tr>
                    <th scope="col" class="px-6 py-3">
                        ID
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Course
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Student
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Semester
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Status
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Note
                    </th>
                    @role('admin')
                    <th scope="col" class="px-6 py-3">
                        <span class="flex justify-center">Actions</span>
                    </th>
                    @else
                    <th></th>
                    @endrole
                </tr>
            </thead>
            <tbody>
                @forelse (@$enrollments as $enrollment)
                   <tr class="odd:bg-white odd:dark:bg-gray-900 even:bg-gray-50 even:dark:bg-gray-800 border-b dark:border-gray-700 border-gray-200">
                        <th scope="row" class="px-5 py-2 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                            {{ $enrollment->id }}
                        </th>
                        <td class="px-5 py-2">
                            {{ $enrollment->course->title }}
                        </td>
                        <td class="px-5 py-2">
                            {{ $enrollment->student->name }}
                        </td>
                        <td class="px-5 py-2">
                            {{ $enrollment->semester  }}
                        </td>
                        <td class="px-5 py-2">
                            {{ $enrollment::VALID_STATUS[$enrollment->status] }}
                        </td>
                        <td class="px-5 py-2">
                            {{ $enrollment->note  }}
                        </td>
                        @role('admin')
                        <td class="px-5 py-2 space-x-2">
                            <div class="flex item-center justify-center">
                                <a href="{{ route('enrollments.edit', $enrollment->id) }}" class="w-5">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-5">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0 1 15.75 21H5.25A2.25 2.25 0 0 1 3 18.75V8.25A2.25 2.25 0 0 1 5.25 6H10" />
                                    </svg>
                                </a>
                                <a href="#" wire:click="delete({{ $enrollment->id }})" wire:confirm="Are you sure you want to unregister this student?" class="w-5">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-5">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
                                    </svg>
                                </a>
                            </div>
                        </td>
                        @else
                        <td></td>
                        @endrole
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
        @include('partials.message-modal')
    </div>
</section>
