<?php

use Livewire\Volt\Component;
use App\Helpers\Menu;

new class extends Component {
    public string $header;
    public function mount($header)
    {
        $this->header = $header;
    }
}
?>
<flux:kanban.column class="space-y-1 p-1 bg-transparent h-full  ">
        <flux:kanban.column.header heading="{{$header}}" class="rounded-xl border-2 border-red-300"/>
        <div class=" h-full overflow-y-auto scrollbar-hide space-y-1 px-1 pt-0.5">
        @foreach(range(1, 100) as $i)
        <flux:kanban.card>
            <flux:accordion>
                <flux:accordion.item>
                    <flux:accordion.heading>Add your Idea Spaces {{$i}}</flux:accordion.heading>
                    <flux:accordion.content class="space-y-2">
                        <flux:text>Fill details of your idea.</flux:text>
                        <flux:input />
                        <flux:textarea/>
                        <flux:button>Add your ideas</flux:button>
                    </flux:accordion.content>
                </flux:accordion.item>
            </flux:accordion>
        </flux:kanban.card>
        @endforeach
        </div>
        <style>
        .scrollbar-hide::-webkit-scrollbar {
    width: 0px;
    background: transparent;
}

/* Show scrollbar on hover */
.scrollbar-hide::-webkit-scrollbar {
    width: 0px;
}

.scrollbar-hide:hover::-webkit-scrollbar {
    width: 6px;
}

/* Style the scrollbar */
.scrollbar-hide::-webkit-scrollbar-thumb {
    background: #ccc;
    border-radius: 4px;
}
</style>
    </flux:kanban.column>