<section>
    <div class="flex justify-end mr-6 pb-4">
        <!-- turn this into a button -->
        <a href="{{ route('users.register') }}" class="text-indigo-500 hover:text-indigo-700 font-medium">
        <span class="inline-flex mr-1">    
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 22 22" stroke-width="2.5" stroke="currentColor" class="w-5 h-5 mr-1 p-0.5">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
            </svg>
            <label>Register User</label>
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
                        Name
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Email
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Type
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Actions
                    </th>
                </tr>
            </thead>
            <tbody>
                @forelse (@$users as $user)
                   <tr class="odd:bg-white odd:dark:bg-gray-900 even:bg-gray-50 even:dark:bg-gray-800 border-b dark:border-gray-700 border-gray-200">
                        <th scope="row" class="px-5 py-2 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                            {{ $user->id }}
                        </th>
                        <td class="px-5 py-2">
                            {{ $user->name }}
                        </td>
                        <td class="px-5 py-2">
                            {{ $user->email }}
                        </td>
                        <td class="px-5 py-2">
                            {{ ucfirst($user->type) }}
                        </td>
                        <td class="px-5 py-2 space-x-2">
                            <a href="{{ route('users.edit',$user->id)}}" class="text-indigo-500 hover:text-indigo-700 font-medium">Edit</a>
                            <button wire:click="delete({{ $user->id }})" wire:confirm="Are you sure you want to unregister this user?" class="text-red-500 hover:text-red-700 font-medium ms-4">Unregister</button>
                        </td>
                    </tr>
               @empty
                    <tr>  
                        <td colspan="7" class="px-6 py-4 text-center text-gray-500">
                            No User vailable.
                        </td>
                    </tr>
               @endforelse
            </tbody>
        </table>    
        @include('partials.message-modal')
    </div>
</section>
