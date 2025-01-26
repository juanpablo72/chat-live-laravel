<div x-data="{
    height: 0,
    conversationElement: document.getElementById('conversation'),
    markAsRead: null
}" x-init="height = conversationElement.scrollHeight;
$nextTick(() => conversationElement.scrollTop = height);


Echo.private('users.{{ Auth()->User()->id }}')
    .notification((notification) => {
        if (notification['type'] == 'App\\Notifications\\MessageRead' && notification['conversation_id'] == {{ $this->selectedConversation->id }}) {

            markAsRead = true;
        }
    });"
    @scroll-bottom.window="
 $nextTick(()=>
 conversationElement.scrollTop= conversationElement.scrollHeight
 );
 "
    class="w-full overflow-hidden">

    <div class="border-b flex flex-col overflow-scroll grow h-full">

        <header class="w-full sticky inset-x-0 flex pb-[5px] pt-[5px] top-0 z-10 bg-white border-b">
            <div class="flex w-full items-center px-2 lg:px-4 gap-2 md:gap-5">
                <a href="#" class="shrink-0 lg:hidden">
                    {{--       image --}}
                </a>
                <div class="shrink-0">
                    <x-avatar class="h-9 w-9 lg:w-11 lg:h-11" alt="User Avatar"></x-avatar>
                </div>
                <h6 class="font-bold truncate">{{ $selectedConversation->getReceiver()->email }}</h6>
            </div>
        </header>

        {{-- section menssage --}}
        <main
            @scroll="
      scropTop = $el.scrollTop;

      if(scropTop <= 0){

        window.livewire.emit('loadMore');

      }
     
     "
            @update-chat-height.window="

         newHeight= $el.scrollHeight;

         oldHeight= height;
         $el.scrollTop= newHeight- oldHeight;

         height=newHeight;
     
     "
            id="conversation"
            class="flex flex-col gap-3 p-3 p-2.5 overflow-y-auto flex-grow overscroll-contain w-full my-auto overflow-x-hidden">
            @if ($loadedMenssages)
                @php
                    $previousMessage = null;
                @endphp


                @foreach ($loadedMenssages as $key => $menssage)
                    @if ($key > 0)
                        @php
                            $previousMessage = $loadedMenssages->get($key - 1);
                        @endphp
                    @endif
                    <div @class([
                        'max-w-[85%] md:max-w-[78%] flex w-auto gap-2 relative mt-2',
                        'ml-auto' => $menssage->sender_id === auth()->id(),
                    ])>
                        {{-- Image user --}}
                        <div @class([
                            'shrink-0',
                            'invisible' => $previousMessage?->sender_id == $menssage->sender_id,
                            'hidden' => $menssage->sender_id === auth()->id(),
                        ])>
                            <x-avatar alt="User Avatar"></x-avatar>
                        </div>
                        {{-- text menssage --}}
                        <div @class([
                            'flex flex-wrap text-[15px] rounded-xl p-2.5 flex flex-col text-black bg-[#f6f6f8fb]',
                            'rounded-bl-none border-gray-200/40' => !(
                                $menssage->sender_id === auth()->id()
                            ),
                            'rounded-br-none bg-blue-500/80 text-white' =>
                                $menssage->sender_id === auth()->id(),
                        ])>
                            <p class="whitespace-normal truncate text-sm md:text-base tracking-wide lg:tracking-normal">
                                {{ $menssage->body }}
                            </p>

                            {{-- part dateTime sms --}}
                            <div class="ml-auto flex gap-2">
                                <p @class([
                                    'text-xs',
                                    'text-gray-500' => !($menssage->sender_id === auth()->id()),
                                    'text-white' => $menssage->sender_id === auth()->id(),
                                ])>
                                    {{ $menssage->created_at->format('g:i a') }}
                                </p>
                                @if ($menssage->sender_id === auth()->id())
                                    <div>
                                        {{-- icon check send and seen menssage --}}
                                        {{-- two check --}}
                                        @if ($menssage->isRead())
                                            <span @class('text-gray-500')>
                                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                                    fill="currentColor" class="bi bi-check2-all" viewBox="0 0 16 16">
                                                    <path
                                                        d="M12.354 4.354a.5.5 0 0 0-.708-.708L5 10.293 1.854 7.146a.5.5 0 1 0-.708.708l3.5 3.5a.5.5 0 0 0 .708 0zm-4.208 7-.896-.897.707-.707.543.543 6.646-6.647a.5.5 0 0 1 .708.708l-7 7a.5.5 0 0 1-.708 0" />
                                                    <path
                                                        d="m5.354 7.146.896.897-.707.707-.897-.896a.5.5 0 1 1 .708-.708" />
                                                </svg>
                                            </span>
                                        @else
                                            {{--  single icon check --}}
                                            <span @class('text-gray-500')>
                                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                                    fill="currentColor" class="bi bi-check" viewBox="0 0 16 16">
                                                    <path
                                                        d="M10.97 4.97a.75.75 0 0 1 1.07 1.05l-3.99 4.99a.75.75 0 0 1-1.08.02L4.324 8.384a.75.75 0 1 1 1.06-1.06l2.094 2.093 3.473-4.425z" />
                                                </svg>
                                            </span>
                                        @endif



                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                @endforeach
            @endif
        </main>

        {{-- part write menssage and btn send sms --}}
        <footer class="shrink-0 z-10 bg-white inset-x-0">

            <div class=" p-2 border-t">

                <form x-data="{ body: @entangle('body').defer }" @submit.prevent="$wire.sendMessage" method="POST" autocapitalize="off">
                    @csrf

                    <input type="hidden" autocomplete="false" style="display:none">

                    <div class="grid grid-cols-12">
                        <input wire:model="body" type="text" autocomplete="off" autofocus placeholder="Escribe un"
                            maxlength="1700"
                            class="col-span-10 bg-gray-100 border-0 outline-0 focus:border-0 focus:ring-0 hover:ring-0 rounded-lg  focus:outline-none">

                        <button
                            class="col-span-2 px-4 py-2 text-white bg-blue-500 rounded-lg hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-300 transition duration-300"
                            type="submit">
                            Enviar
                        </button>

                    </div>

                </form>

            </div>
        </footer>
    </div>
</div>
