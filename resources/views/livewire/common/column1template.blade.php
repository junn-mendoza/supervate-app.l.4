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
        <flux:kanban.column.header heading="{{$header}}" class="rounded-xl border-2 border-red-300"/>
        <flux:kanban.card>
            <flux:accordion exclusive transition>
                <flux:accordion.item>
                    <flux:accordion.heading>Add your Idea Spaces</flux:accordion.heading>
                    <flux:accordion.content class="space-y-2">
                        <flux:text>Fill details of your idea.</flux:text>
                        <flux:input />
                        <flux:textarea/>
                        <flux:button>Add your ideas</flux:button>
                    </flux:accordion.content>
                 </flux:accordion.item>
                {{--  <flux:accordion.item>
                    <flux:accordion.heading>AI generated Idea Spaces</flux:accordion.heading>
                    <flux:accordion.content class="space-y-2">
                        <flux:text>(*) Add a propmt to generate</flux:text>
                        <flux:textarea/>
                        <flux:button>Generate Idea Spaces</flux:button>
                    </flux:accordion.content>
                </flux:accordion.item>--}}
            </flux:accordion> 
        </flux:kanban.card>
        <flux:kanban.card>
            <flux:accordion>
                <flux:accordion.item>
                    <flux:accordion.heading>AI generated Idea Spaces</flux:accordion.heading>
                    <flux:accordion.content class="space-y-2">
                        <flux:text>(*) Add a propmt to generate</flux:text>
                        <flux:textarea/>
                        <flux:button>Generate Idea Spaces</flux:button>
                    </flux:accordion.content>
                </flux:accordion.item>
            </flux:accordion>
        </flux:kanban.card>
    </flux:kanban.column>