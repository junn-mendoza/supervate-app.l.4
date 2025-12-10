<?php

use Livewire\Component;
use Livewire\Attributes\Layout;
new 
#[Layout('layouts::tile')]  
class extends Component
{
    public $header = [];
    public function mount() {
        $this->header = ['Idea Space finders','Idea Space','Filters','Shortlist'];
    }
};
?>

<div class='w-full h-[calc(100vh-115px)] overflow-hidden'>
    <div class="flex space-x-2 h-full justify-center items-center ">
        <flux:kanban class="flex w-full gap-2 h-full overflow-hidden justify-center ">   
            @livewire('common.column1',['header' => $header[0]])
            @livewire('common.column2',['header' => $header[1]])
            @livewire('common.column3',['header' => $header[2]])
            @livewire('common.column4',['header' => $header[3]])
        </flux:kanban> 
    </div>
</div>