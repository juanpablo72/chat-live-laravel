<div x-data="{ type: 'all', id: @entangle('id') }" x-init="setTimeout(() => {
    conversationElement = document.getElementById('conversation-' + id);

    // list of elements chat

    if (conversationElement) {
        conversationElement.scrollIntoView({ 'behavior': 'smooth' });

    }

}), 200;
Echo.private('users.{{ Auth()->User()->id }}')
    .notification((notification) => {
        if (notification['type'] == 'App\\Notifications\\MenssageRead' || notification['type'] == 'App\\Notifications\\MessageSent') {

            window.Livewire.dispatch('refresh');
        }
    });" class="flex flex-col transition-all h-full overflow-hidden">
    <header class="px-3 z-10 bg-white sticky w-full py-2">
        <div class="border-b justify-between flex items-center pb-2">
            <div class="flex items-center gap-2">
                <h5 class="font-extrabold text-2xl"> Chat</h5>
            </div>
            <button>
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="w-7 h-7"
                    viewBox="0 0 16 16">
                    <path
                        d="M6 10.5a.5.5 0 0 1 .5-.5h3a.5.5 0 0 1 0 1h-3a.5.5 0 0 1-.5-.5m-2-3a.5.5 0 0 1 .5-.5h7a.5.5 0 0 1 0 1h-7a.5.5 0 0 1-.5-.5m-2-3a.5.5 0 0 1 .5-.5h11a.5.5 0 0 1 0 1h-11a.5.5 0 0 1-.5-.5" />
                </svg>
            </button>
        </div>

        {{-- btns filters in chat --}}
        <div class="flex gap-3 items-center p-2 bg-white">
            <button @click="type='all'"
                :class="{ 'bg-blue-600 border-0 text-white': type === 'all', 'bg-blue-100 border-0 text-black': type !== 'all' }"
                class="inline-flex justify-center items-center rounded-full gap-x-1 text-xs font-medium px-3 lg:px-5 py-1 lg:py-2.5 border active:bg-blue-200">
                Todos
            </button>
            <button @click="type='groups'"
                :class="{ 'bg-blue-600 border-0 text-white': type === 'groups', 'bg-blue-100 border-0 text-black': type !== 'groups' }"
                class="inline-flex justify-center items-center rounded-full gap-x-1 text-xs font-medium px-3 lg:px-5 py-1 lg:py-2.5 border active:bg-blue-200">
                Grupos
            </button>
        </div>

    </header>

    <main class=" overflow-y-scroll overflow-hidden grow  h-full relative " style="contain:content">

        <ul class="p-2 grid w-full spacey-y-2">
            @if ($conversations)
                @foreach ($conversations as $conversation)
                    <li id="conversation-{{ $conversation->id }}" wire:key="{{ $conversation->id }}"
                        class="py-3 hover:bg-gray-50 rounded-2xl dark:hover:bg-gray-700/70 transition-colors duration-150 flex gap-4 relative w-full cursor-pointer px-2 {{ $conversation->id == $selectedConversation?->id ? 'bg-gray-100/70' : '' }}">


                        <a href="#" class="shrink-0">
                            <x-avatar></x-avatar>

                        </a>
                        <aside class="grid grid-col-12 w-full">
                            <a href="{{ route('chat', $conversation->id) }}"
                                class="col-span-11 border-b pb-2 border-gray-200 relative overflow-hidden truncate leading-5 w-full flex-nowrap p-1">
                                <div class="flex justify-between w-full items-center">
                                    <h6 class="truncate font-medium trancking+wider text-gray-500">
                                        {{ $conversation->getReceiver()->name }}
                                    </h6>

                                    <small class="text-gray-700">
                                        {{ $conversation->messages()->latest('created_at')->first()?->created_at?->shortAbsoluteDiffForHumans() }}
                                    </small>
                                </div>

                                {{-- section to name user of chat and date time menssage  --}}

                                {{-- body of  last message  --}}

                                <div class="flex gap-x-2 items-center">
                                    {{-- part whrere is  icon checks single and double --}}
                                    @if ($conversation->messages?->last()?->sender_id == auth()->id())
                                        @if ($conversation->lastMessageRead())
                                            <span>
                                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                                    fill="currentColor" class="bi bi-check-all" viewBox="0 0 16 16">
                                                    <path
                                                        d="M8.97 4.97a.75.75 0 0 1 1.07 1.05l-3.99 4.99a.75.75 0 0 1-1.08.02L2.324 8.384a.75.75 0 1 1 1.06-1.06l2.094 2.093L8.95 4.992zm-.92 5.14.92.92a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 1 0-1.091-1.028L9.477 9.417l-.485-.486z" />
                                                </svg>
                                            </span>
                                        @else
                                            <span>
                                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                                    fill="currentColor" class="bi bi-check" viewBox="0 0 16 16">
                                                    <path
                                                        d="M10.97 4.97a.75.75 0 0 1 1.07 1.05l-3.99 4.99a.75.75 0 0 1-1.08.02L4.324 8.384a.75.75 0 1 1 1.06-1.06l2.094 2.093 3.473-4.425z" />
                                                </svg>
                                            </span>
                                        @endif
                                    @endif



                                    {{-- icon check double --}}




                                    {{-- icon single check --}}
                                    {{--  --}}

                                    {{-- part text menssage --}}
                                    <p class="grow truncate text-sm font-[100]">
                                        {{ $conversation->messages?->last()?->body ?? ' ' }}
                                    </p>
                                    @if ($conversation->unreadMessagesCount() > 0)
                                        <span
                                            class="font-bold p-px px-2 text-xs shrink-0 rounded-full bg-blue-500 text-white">
                                            {{ $conversation->unreadMessagesCount() }}
                                        </span>
                                    @endif
                                    {{--  @if ($conversation->unreadMessagesCount() > 0)
                                        <span
                                            class="font-bold text-xs flex items-center justify-center w-6 h-6 shrink-0 rounded-full bg-blue-500 text-white">
                                            {{ $conversation->unreadMessagesCount() }}
                                        </span>
                                    @endif --}}
                                    {{-- <span
                                        class="font-bold text-xs flex items-center justify-center w-6 h-6 shrink-0 rounded-full bg-blue-500 text-white">
                                        5
                                    </span> --}}

                                </div>

                            </a>

                        </aside>
                    </li>
                @endforeach
        </ul> {{-- list menssage of chat --}}
    @else
        @endif
    </main>
</div>
