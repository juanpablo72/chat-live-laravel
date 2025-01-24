<div class="max-w-6xl mx-auto my-16">
    <h5 class="text-center text-5xl font-bold py-3">
        Contactos
    </h5>
    <div class="grid md:grid-cols-2 lg:grid-cols-3 xl:grip-cols-4 gap-5 p-2 ">
        @foreach ($users as $contact)
            <div class="w-full bg-white border border-gray-200 rounded-lg p-5 shadow mt-3 mb-3 ">

                <div class="flex flex-col items-center pb-10">
                    <x-avatar class=" w-24 h-24"></x-avatar>
                    <h5>{{ $contact->name }}</h5>
                    <span class="text-sm text-gray-500">{{ $contact->email }}</span>
                    <div class="flex mt-4 space-x-3 md:mt-6 mb-4">
                        <x-primary-button wire:click="menssage({{ $contact->id }})">
                            chatear
                        </x-primary-button>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>
