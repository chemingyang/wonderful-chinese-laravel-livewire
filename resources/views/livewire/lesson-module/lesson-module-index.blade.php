<section>
    @role('admin')
    <div class="flex justify-end mr-6 pb-4">
        <!-- turn this into a button -->
        <button wire:click="$set('showImportModal', true)" class="text-indigo-500 hover:text-indigo-700 font-medium">
            <span class="inline-flex mr-1">    
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75V16.5m-13.5-9L12 3m0 0 4.5 4.5M12 3v13.5" />
                </svg>
                <label>Import Lesson Modules</label>
            </span>
        </button>
        
        <a href="{{ route('lessonmodules.create') }}" class="text-indigo-500 hover:text-indigo-700 font-medium">
            <span class="inline-flex mr-1">    
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 22 22" stroke-width="2.5" stroke="currentColor" class="w-5 h-5 mr-1 p-0.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                </svg>
                <label>Lesson Module</label>
            </span>
        </a>
    </div>
    @endrole
    <div class="relative overflow-x-auto">
        <table class="w-full text-sm text-left :text-right text-gray-500 dark:text-gray-400">
            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-600 dark:text-gray-400">
                <tr>
                    <th scope="col" class="px-6 py-3">
                        ID
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Type
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Lesson
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Question
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Char.
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Audio
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Image
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Answer
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Wt.
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Note
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
                @forelse (@$lessonmodules as $lessonmodule)
                   <tr class="odd:bg-white odd:dark:bg-gray-900 even:bg-gray-50 even:dark:bg-gray-800 border-b dark:border-gray-700 border-gray-200">
                        <th scope="row" class="px-5 py-2 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                            {{ $lessonmodule->id }}
                        </th>
                        <td class="px-5 py-2">
                            {{ $lessonmodule->type }}
                        </td>
                        <td class="px-5 py-2">
                            {{ $lessonmodule->lesson->title }}
                        </td>
                        <td class="px-5 py-2">
                            {{ $lessonmodule->question }}
                        </td>
                        <td class="px-5 py-2">
                            {{ $lessonmodule->character ? $lessonmodule->character->chinese_phrase . ' (' . $lessonmodule->character->pinyin . ')' : '-' }}
                        </td>
                        <td class="px-5 py-2">
                            @if ($lessonmodule->audio)
                                <audio id="player{{$lessonmodule->id}}" src="{{ asset('storage/' . $lessonmodule->audio) }}"></audio>
                                <flux:button size="xs" onclick="document.getElementById('player{{$lessonmodule->id}}').play()" class="p-0 border-0 bg-transparent">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M15.91 11.672a.375.375 0 0 1 0 .656l-5.603 3.113a.375.375 0 0 1-.557-.328V8.887c0-.286.307-.466.557-.327l5.603 3.112Z" />
                                    </svg>
                                </flux:button>
                            @else
                                -
                            @endif
                        </td>
                        <td class="px-5 py-2">
                            @if ($lessonmodule->image)
                            <img src="{{ asset('storage/' . $lessonmodule->image) }}" alt="{{ $lessonmodule->type }} image" class="w-16 rounded-md object-fit"> 
                            @else
                                -
                            @endif
                        </td>
                        <td class="px-5 py-2">
                            {{ $lessonmodule->answer_key  }}
                        </td>
                        <td class="px-5 py-2">
                            {{ $lessonmodule->weight }}
                        </td>
                        <td class="px-5 py-2">
                            {{ $lessonmodule->note  }}
                        </td>
                        @role('admin')
                        <td class="px-5 py-2">
                            <div class="flex item-center justify-center">
                                <a href="{{ route('lessonmodules.edit', $lessonmodule->id) }}" class="w-5">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-5">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0 1 15.75 21H5.25A2.25 2.25 0 0 1 3 18.75V8.25A2.25 2.25 0 0 1 5.25 6H10" />
                                    </svg>
                                </a>
                                <a href="#" wire:click="delete({{ $lessonmodule->id }})" wire:confirm="Are you sure you want to delete this module from this lesson?" class="w-5">
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
                        <td colspan="9" class="px-6 py-4 text-center text-gray-500">
                            No lesson Module available.
                        </td>
                    </tr>
               @endforelse
            </tbody>
        </table>    
        @include('partials.message-modal')
    </div>
    <flux:modal wire:model="showImportModal">
        <flux:heading>Import Lesson Modules</flux:heading>
        
        <form wire:submit="importLessonModules" enctype="multipart/form-data">
            <div class="space-y-4">
                <flux:field>
                    <flux:label>CSV File</flux:label>
                    <flux:input type="file" wire:model="csvFile" accept=".csv" />
                    @error('csvFile') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </flux:field>

                <div class="text-sm text-gray-600">
                    <p>File must be a CSV with these columns:</p>
                    <ul class="list-disc list-inside ml-4">
                        <li>type</li>
                        <li>lesson_id</li>
                        <li>character_id</li>
                        <li>question</li>
                        <li>answer_key</li>
                    </ul>
                </div>
            </div>

            <div class="mt-4 flex justify-end space-x-2">
                <button wire:click="$set('showImportModal', false)">Cancel</button>
                <flux:button type="submit">Import</flux:button>
            </div>
        </form>
    </flux:modal>
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
