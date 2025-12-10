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
<flux:kanban.column  class="space-y-1 p-1 bg-transparent">
        <flux:kanban.column.header heading="{{$header}}" class="rounded-xl border-2 border-red-300"/>
    
    </flux:kanban.column>