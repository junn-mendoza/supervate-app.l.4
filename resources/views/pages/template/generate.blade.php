<?php

use Livewire\Component;
use Livewire\Attributes\Layout;
new 
#[Layout('layouts::tile')]  
class extends Component
{
    public $header = [];
    public string $name;
    public string $control;
    
    public $data = [];
    public function mount() {
        $this->name = 'Test ';
        $this->data['header'] = [$this->name.' finders', 'Idea Space','Filters','Shortlist'];
        // $this->header = ['Idea Space finders','Idea Space','Filters','Shortlist'];
    }
    public function rules()
    {
        return [
            'name' => 'required|min:5', // 👈 minimum of 5 characters
            'con=trol' => 'required',
        ];
    }
    public function create()
    {
        $this->validate();
        $this->data['header'] = [$this->name.' finders', 'Idea Space','Filters','Shortlist'];
        session()->put('info', $this->data);
        sleep(3);
    }

    public function add_control()
    {
        $this->validate();
        $this->data['controls'][] = [

        ];
    }
};
?>

<div class='w-full h-[calc(100vh-115px)] overflow-hidden'>
    <div class="flex space-x-2 h-full justify-center ">
        <div class="w-[350px]">
            <form class="space-y-2">
                {{-- Step 1 adding header--}}
                <flux:heading size="lg">Create Tile</flux:heading>
                <flux:input wire:model='name' label="Tile Name:"/>
                <flux:button wire:click="create" :loading="false" class="data-loading:opacity-50">
                    <div class="flex space-x-2">
                           <span>Create</span>
                    <flux:icon.loading class="size-5 hidden in-data-loading:block"/>
                 
                    </div>
                </flux:button>
                <flux:select variant="listbox" wire:model="control" placeholder="Add yourcontrol">
                    <flux:select.option>Input box</flux:select.option>
                    <flux:select.option>Description box</flux:select.option>
                    <flux:select.option>Shortlist ideas</flux:select.option>
                    <flux:select.option>Shortlist customers</flux:select.option>
                    <flux:select.option>Shortlist problems</flux:select.option>
                    <flux:select.option>Shortlist solutions</flux:select.option>
                    <flux:select.option>Shortlist alternatives</flux:select.option>
                </flux:select>
                <flux:button wire:click="add_control" :loading="false" class="data-loading:opacity-50">
                    <div class="flex space-x-2">
                           <span>Add</span>
                    <flux:icon.loading class="size-5 hidden in-data-loading:block"/>
                 
                    </div>
                </flux:button>
            </form>
        </div>
        @if(isset($data['header']))
            <flux:kanban class="flex w-full gap-2 h-full overflow-hidden justify-center "> 

            {{-- @livewire('common.column1',['header' => $data['header'][0]]) --}}

            <flux:kanban.column class="space-y-1 p-1 bg-transparent">
        <flux:kanban.column.header heading="{{$data['header'][0]}}" class="rounded-xl border-2 border-red-300"/>
        <flux:kanban.card>
            <flux:accordion exclusive transition>
                <flux:accordion.item>
                    {{-- <flux:accordion.heading>Add your Idea Spaces</flux:accordion.heading>
                    <flux:accordion.content class="space-y-2">
                        <flux:text>Fill details of your idea.</flux:text>
                        <flux:input />
                        <flux:textarea/>
                        <flux:button>Add your ideas</flux:button>
                    </flux:accordion.content> --}}
                 </flux:accordion.item>
               
            </flux:accordion> 
        </flux:kanban.card>
       
    </flux:kanban.column>
            {{-- @livewire('common.column2',['header' => $data['header'][1]])

            @livewire('common.column3',['header' => $data['header'][2]])

            @livewire('common.column4',['header' => $data['header'][0]]) --}}

            </flux:kanban>
        @endif 
    </div>
</div>