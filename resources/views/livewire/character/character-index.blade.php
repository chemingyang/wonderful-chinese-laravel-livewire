<section>
    @role('admin')
    <div class="flex justify-end mr-6 pb-4">
        <a href="{{ route('characters.create') }}" class="text-indigo-500 hover:text-indigo-700 font-medium">
        <span class="inline-flex mr-1">    
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 22 22" stroke-width="2.5" stroke="currentColor" class="size-5">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
            </svg>
            <label>Add Character</label>
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
                        Chinese Phrase
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Zhuyin
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Pinyin
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Lesson
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Translation
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Audio
                    </th>
                    @role('admin')
                    <th scope="col" class="px-6 py-3">
                        Actions
                    </th>
                    @else
                    <th></th>
                    @endrole
                </tr>
            </thead>
            <tbody>
                @forelse (@$characters as $i => $character)
                   <tr class="odd:bg-white odd:dark:bg-gray-900 even:bg-gray-50 even:dark:bg-gray-800 border-b dark:border-gray-700 border-gray-200">
                        <th scope="row" class="px-5 py-2 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                            {{ $character->id }}
                        </th>
                        <td class="px-5 py-2">
                            {{ $character->chinese_phrase }}
                        </td>
                        <td class="px-5 py-2">
                            {{ $character->zhuyin }}
                        </td>
                        <td class="px-5 py-2">
                            {{ $character->pinyin }}
                        </td>
                        <td class="px-5 py-2">
                            {{ $character->lesson->title ?? "unassigned" }}
                        </td>
                        <td class="px-5 py-2">
                            {{ $character->english_translation }}
                        </td>
                        <td class="px-5 py-2">
                            @if ($character->audio)
                            <audio id="player{{$i}}" src="{{ asset('storage/' . $character->audio) }}"></audio>
                            <flux:button size="xs" onclick="document.getElementById('player{{$i}}').play()" class="p-0 border-0 bg-transparent">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15.91 11.672a.375.375 0 0 1 0 .656l-5.603 3.113a.375.375 0 0 1-.557-.328V8.887c0-.286.307-.466.557-.327l5.603 3.112Z" />
                            </svg>
                            </flux:button>
                            @endif
                        </td>
                        @role('admin')
                        <td class="px-5 py-2 space-x-2">
                            <a href="{{ route('characters.edit', $character->id) }}" class="text-indigo-500 hover:text-indigo-700 font-medium">Edit</a>
                            <button wire:click="delete({{ $character->id }})" wire:confirm="Are you sure you want to delete this character?" class="text-red-500 hover:text-red-700 font-medium ms-4">Delete</button>
                        </td>
                        @else
                        <td></td>
                        @endrole
                    </tr>
               @empty
                    <tr>
                        <td colspan="6" class="px-6 py-4 text-center text-gray-500">
                            No characters available.
                        </td>
                    </tr>
               @endforelse
            </tbody>
        </table>
        @include('partials.message-modal')
    </div>
</section>
