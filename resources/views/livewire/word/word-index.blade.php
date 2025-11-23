<section>
    <div class="flex justify-between align-items-center gap-3">
        <div class="flex pb-2">
            <flux:select :filter="false" wire:model.live="selected_level">
                <flux:select.option value="" wire:key="">Select a level</flux:select.option>
                @foreach ($levels as $level)
                    <flux:select.option value="{{ $level }}" wire:key="{{ $level }}">
                        {{ $level }}
                    </flux:select.option>
                @endforeach
            </flux:select>
        </div>
        @role('admin')
        <div class="flex justify-end pb-2 space-x-4">
            <!--
            <button wire:click="$set('showImportModal', true)" class="text-indigo-500 hover:text-indigo-700 font-medium">
                <span class="inline-flex mr-1">    
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75V16.5m-13.5-9L12 3m0 0 4.5 4.5M12 3v13.5" />
                    </svg>
                    <label>Import Words</label>
                </span>
            </button> -->
            <a href="{{ route('words.create') }}" class="text-indigo-500 hover:text-indigo-700 font-medium">
                <span class="inline-flex mr-1">    
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 22 22" stroke-width="2.5" stroke="currentColor" class="size-5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                    </svg>
                    <label>Add Word</label>
                </span>
            </a>
        </div>
        @endrole
    </div>
    <div class="relative overflow-x-auto">
        <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-600 dark:text-gray-400">
                <tr>
                    <th scope="col" class="px-6 py-3">
                        ID
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Level
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Type
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Subtype
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Char
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Pinyin
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Zhuyin
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Cat.
                    </th>
                    <th scope="col" class="px-6 py-3">
                        English
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Book
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Lesson
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
                @forelse (@$this->words as $i => $word)
                @if (empty($selected_level) || $word->level === $selected_level)
                   <tr class="odd:bg-white odd:dark:bg-gray-900 even:bg-gray-50 even:dark:bg-gray-800 border-b dark:border-gray-700 border-gray-200">
                        <th scope="row" class="px-5 py-2 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                            {{ $word->id }}
                        </th>
                        <td class="px-5 py-2">
                            {{ $word->level }}
                        </td>
                        <td class="px-5 py-2">
                            {{ $word->type }}
                        </td>
                        <td class="px-5 py-2">
                            {{ $word->subtype }}
                        </td>
                        <td class="px-5 py-2">
                            {{ $word->traditional }}
                        </td>
                        <td class="px-5 py-2">
                            {{ $word->pinyin }}
                        </td>
                        <td class="px-5 py-2">
                            {{ $word->zhuyin }}
                        </td>
                        <td class="px-5 py-2">
                            {{ $word->category }}
                        </td>
                        <td class="px-5 py-2">
                            {{ $word->english }}
                        </td>
                        <td class="px-5 py-2">
                            {{ $word->book_id }}
                        </td>
                        <td class="px-5 py-2">
                            {{ $word->lesson_id }}
                        </td>
                        @role('admin')
                        <td class="px-5 py-2 space-x-2">
                            <div class="flex item-center justify-center">
                                <a href="{{ route('words.edit', $word->id) }}" class="w-5">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-5">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0 1 15.75 21H5.25A2.25 2.25 0 0 1 3 18.75V8.25A2.25 2.25 0 0 1 5.25 6H10" />
                                    </svg>
                                </a>
                                <a href="#" wire:click="delete({{ $word->id }})" wire:confirm="Are you sure you want to delete this word?" class="w-5">
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
                @endif    
                @empty
                    <tr>
                        <td colspan="6" class="px-6 py-4 text-center text-gray-500">
                            No words available.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div>
        @include('partials.message-modal')
    </div>
    @if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif
</section>
