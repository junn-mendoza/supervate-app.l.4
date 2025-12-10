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
<flux:kanban.column class="space-y-1 p-1 bg-transparent">
        <flux:kanban.column.header heading="{{$header}}"  class="rounded-xl border-2 border-red-300"/>
        @foreach(range(1, 10) as $i)
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
    </flux:kanban.column>