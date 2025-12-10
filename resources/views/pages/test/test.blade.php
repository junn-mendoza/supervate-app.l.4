<?php

use Livewire\Component;
use Livewire\Attributes\Layout;
use Illuminate\Support\Str;

new 
#[Layout('layouts::tile')]  
class extends Component
{
    public int $timeline = 1; // <-- change this value (1–4)
    public $control;
    public $data = [];
    public $hasProcess = false;
    public string $name;
    public int $step = 1;
    public $tile;
    public $current_control;
    public $label;
    public $placeholder;
    public $isEdit = false;
    public bool $isEditControl = false;
    public ?string $editingKey = null;
    public $prompt_input;
    public $prompt_description;
    public $prompt_actual;
    public array $available_controls = [
        'input_box',
        'description_box',
        'shortlist_idea',
        'shortlist_customer',
        'shortlist_problem',
        'shortlist_solution',
        'shortlist_alternative',
    ];
    public array $left = [
        '1' => [
            'text' => '',
            'disabled' => true,
            'command' => '',
        ],
        '2' => [
            'text' => 'Create a Process',
            'disabled' => false,
            'command' => 'back',
        ],
        '3' => [
            'text' => 'Add Controls',
            'disabled' => false,
            'command' => 'back',
        ],
        '4' => [
            'text' => 'Add a Prompt',
            'disabled' => false,
            'command' => 'back',
        ],
    ];
    public array $right = [
        '1' => [
            'text' => 'Add Controls',
            'disabled' => false,
            'command' => 'step1'
        ],
        '2' => [
            'text' => 'Add a Prompt',
            'disabled' => false,
            'command' => 'step2'
        ],
        '3' => [
            'text' => 'Save & Generate',
            'disabled' => false,
            'command' => 'step3'

        ],
        '4' => [
            'text' => '',
            'disabled' => true,
            'command' => ''

        ],
    ];
    public function mount()
    {
        // session()->forget('process');
        // session()->forget('step');
        $this->isProcess();
         
    }
    public function boot()
    {
        // dump(session('process'));
        if(session()->has('process')) {
            if (empty($this->data)) {
                $this->data = session('process');
            } 
            $this->name = $this->data['name'];
            
        }
        if(session()->has('step')) {
            $this->timeline = session('step');
        }
        if(session()->has('current_control')) {
            $this->current_control = session('current_control');
        }
        if(session()->has('tile')) {
            $this->tile = session('tile');
        }
       
        if (session()->has('prompt')) {
            $this->prompt_input = session('prompt');
        }

         if(isset($this->data['controls'])) {
            if (!session()->has('prompt')) {
                $this->regeneratePromptInput();
            }
            $this->regeneratePromptDescription();
            $this->generateActualPrompt();    // FIXES REFRESH ISSUE
            // if(empty($this->prompt_input)) {
            //     $this->prompt_description = "<br/>";
            //     $this->prompt_input = "<br/>";
            //     foreach($this->data['controls'] as $control) {
            //         // dd($control);
            //         $this->prompt_input .= "&lt;{$control['control']}&gt;<br/><br/>";
            //         $this->prompt_description .= "<span class='font-bold'>&lt;{$control['control']}&gt;</span><br>";;
            //         $tmp = "'".Str::replace('_',' ',$control['control'])."'";
            //         $this->prompt_description .= "This is a placeholder for your {$tmp}.<br/><br/>";
            //     }
            //     session()->put('prompt',$this->prompt_input);
            // }
        }
        // $this->generateActualPrompt();
    }
    public function generateActualPrompt()
    {
        $tmp = $this->prompt_input;

        if (isset($this->data['controls'])) {
            foreach ($this->data['controls'] as $control) {

                switch ($control['control']) {

                    case "input_box":
                        $tmp = Str::replace('&lt;input_box&gt;', "'Lego Toy'", $tmp);
                        break;

                    case "description_box":
                        $description = "Create ideas regarding Lego toy...";
                        $tmp = Str::replace('&lt;description_box&gt;', $description, $tmp);    
                        break;

                    default:
                        if (Str::startsWith($control['control'], 'shortlist_')) {
                            $list = '';
                            $clean = Str::after($control['control'], '_');

                            foreach (range(1,2) as $i) {
                                $list .= "prompt for '{$clean}' {$i}<br/>";
                            }

                            $tmp = Str::replace("&lt;{$control['control']}&gt;", $list, $tmp);
                        }
                }
            }
        }

        $this->prompt_actual = $tmp;
    }

    public function regeneratePromptDescription()
    {
        $this->prompt_description = "<br/>";

        foreach ($this->data['controls'] as $control) {

            $name = $control['control'];

            $this->prompt_description .= "<span class='font-bold'>&lt;{$name}&gt;</span><br>";
            
            $cleanName = Str::replace('_', ' ', $name);
            $this->prompt_description .= "This is a placeholder for your '{$cleanName}'.<br/><br/>";
        }
    }
    // public function regeneratePromptInput()
    // {
    //     $this->prompt_input = "<br/>";

    //     foreach ($this->data['controls'] as $control) {
    //         $this->prompt_input .= "&lt;{$control['control']}&gt;<br/><br/>";
    //     }

    //     session()->put('prompt', $this->prompt_input);
    // }
    public function regeneratePromptInput()
    {
        // If there is no existing prompt, build the initial one
        if (empty($this->prompt_input)) {
            $this->prompt_input = "<br/>";
            foreach ($this->data['controls'] as $control) {
                $this->prompt_input .= "&lt;{$control['control']}&gt;<br/><br/>";
            }
            session()->put('prompt', $this->prompt_input);
            return;
        }

        // Else: update placeholder blocks WITHOUT removing real text
        $text = $this->prompt_input;

        foreach ($this->data['controls'] as $control) {

            $placeholder = "&lt;{$control['control']}&gt;";

            // If placeholder already exists in user text, leave it alone
            if (Str::contains($text, $placeholder)) {
                continue;
            }

            // If placeholder is missing: append it at the bottom
            $text .= "{$placeholder}<br/><br/>";
        }

        $this->prompt_input = $text;
        session()->put('prompt', $this->prompt_input);
    }

    public function cleanPromptPlaceholders()
    {
        if (!isset($this->prompt_input)) return;

        // Build list of valid placeholder tags
        $valid = [];
        if (isset($this->data['controls'])) {
            foreach ($this->data['controls'] as $control) {
                $valid[] = "&lt;{$control['control']}&gt;";
            }
        }

        // Remove placeholders that are no longer valid
        $this->prompt_input = preg_replace_callback(
            '/&lt;([a-z_]+)&gt;/i',
            function ($match) use ($valid) {
                return in_array($match[0], $valid) ? $match[0] : '';
            },
            $this->prompt_input
        );

        // Clean actual prompt too
        if ($this->prompt_actual) {
            $this->prompt_actual = preg_replace_callback(
                '/&lt;([a-z_]+)&gt;/i',
                function ($match) use ($valid) {
                    return in_array($match[0], $valid) ? $match[0] : '';
                },
                $this->prompt_actual
            );
        }

        session()->put('prompt', $this->prompt_input);
    }

    public function rules()
    {
        return [
            'name' => 'required|min:5', // 👈 minimum of 5 characters
        ];
    }
    private function isProcess(): void 
    {

        if(session()->has('process')) {
            $this->hasProcess = true;
            $this->data = session('process'); 
        }
    }
    public function step1()
    {
        $this->validate();
        try {
            if(!$this->hasProcess) {
                $this->data = [
                    'name' => $this->name,
                    'id' => (string)Str::uuid(),
                ];
                $this->hasProcess = true;
                
            } else {
                $this->data['name'] = $this->name;
            }
            session()->put('process', $this->data);
            
        } catch(\Exception $e) {
            dd($e->getMessage());
        }
        $this->timeline = 2;
        session()->put('step',2);
    }
    public function step2()
    {
        $this->timeline = 3;
        // 🔥 Ensure prompt stays updated when user goes back then forward
        $this->generateActualPrompt();
        $this->regeneratePromptDescription();
        session()->put('step',$this->timeline);
    }
    public function step3()
    {
        // example only — adjust to your UI
        $this->data['prompt'] = $this->prompt_input;

        session()->put('process', $this->data);

        $this->timeline = 4;
        session()->put('step',$this->timeline);
    }
    public function back()
    {
        $this->timeline -= 1;
        session()->put('step', $this->timeline);
    }

    public function updatedPromptInput()
    {
        session()->put('prompt', $this->prompt_input);

        // now generate actual prompt output
        $this->generateActualPrompt();
        // $tmp = $this->prompt_input;
        // if(isset($this->data['controls'])) {
        //     foreach($this->data['controls'] as $control) {
                
        //         switch($control['control']) {
        //             case "input_box":
        //                 $tmp = Str::replace('&lt;input_box&gt;',"'Lego Toy'",$tmp);
        //                 break;
        //             case "description_box":
        //                 $description = "
        //                     Create ideas regagarding Lego toy for future use,
        //                     that is portable and easy to transport.";
        //                 $tmp = Str::replace('&lt;description_box&gt;',$description,$tmp);    
        //                 break;
        //             case "shortlist_idea":
        //             case "shortlist_customer":
        //             case "shortlist_problem":
        //             case "shortlist_solution":
        //             case "shortlist_alternative":
        //                 $list = '';
        //                 foreach(range(1,2) as $i) {
        //                     $list .= "prompt value for '".Str::replace('_','',$control['control'])."' {$i}<br/>";
        //                 }   
        //                  $tmp = Str::replace('&lt;'.$control['control'].'&gt;',$list,$tmp);  
        //                 break;

        //         }
        //     }
        //     $this->prompt_actual = $tmp;
        // }
    }
    public function navigate($command)
    {
        if (!$command) {
            return;
        }

        // ------------------------------
        // Step 2 → Step 3
        // Require at least 1 control
        // ------------------------------
        if ($this->timeline == 2 && $command !== 'back') {

            if (empty($this->data['controls'] ?? [])) {
                $this->dispatch('toast', 
                    type: 'error', 
                    message: 'Please add at least one control before continuing.'
                );
                return;
            }
        }

        // ------------------------------
        // Step 3 → Step 4
        // Require a prompt
        // ------------------------------
        if ($this->timeline == 3 && $command !== 'back') {

            if (empty($this->data['prompt'] ?? '')) {
                $this->dispatch('toast', 
                    type: 'error', 
                    message: 'Please provide a prompt before continuing.'
                );
                return;
            }
        }

        // ------------------------------
        // Execute navigation command
        // ------------------------------
        if (method_exists($this, $command)) {
            $this->{$command}();
        }
    }

    public function add_control()
    {
        if($this->current_control && $this->hasProcess) {

            $id = (string)Str::uuid();

            $this->data['controls'][$this->current_control] = [
                'id' => $id,
                'control' => $this->current_control,
                'label' => $this->label,
                'placeholder' => $this->placeholder,
            ];

            session()->put('process', $this->data);

            // 🔥 REGENERATE PROMPT DESCRIPTION & ACTUAL PROMPT
            $this->regeneratePromptInput();
            $this->regeneratePromptDescription();
            $this->generateActualPrompt();

             // RESET UI STATE
            $this->current_control = null;
            $this->tile = null;
            $this->placeholder = $this->label = null;

            session()->forget('current_control');
            session()->forget('tile');
        }
    }
    public function edit_control($key)
    {
        if (!isset($this->data['controls'][$key])) {
            return;
        }

        // Mark edit mode
        $this->isEditControl = true;
        $this->editingKey = $key;

        // Load control being edited
        $control = $this->data['controls'][$key];

        $this->current_control = $control['control'];
        $this->tile = Str::after($control['control'], '_');
        $this->label = $control['label'];
        $this->placeholder = $control['placeholder'];

        // Sync with session (optional)
        session()->put('current_control', $this->current_control);
        session()->put('tile', $this->tile);
    }

    public function update_control()
    {
        if (!$this->editingKey || !isset($this->data['controls'][$this->editingKey])) {
            return;
        }

        // Update values
        $this->data['controls'][$this->editingKey]['label'] = $this->label;
        $this->data['controls'][$this->editingKey]['placeholder'] = $this->placeholder;

        // Save
        session()->put('process', $this->data);

        // Reset edit mode
        $this->isEditControl = false;
        $this->editingKey = null;

        $this->current_control = null;
        $this->tile = null;
        $this->label = null;
        $this->placeholder = null;

        $this->regeneratePromptInput();
        $this->regeneratePromptDescription();
        $this->generateActualPrompt();
    }

    public function delete_control($key)
    {
        if (isset($this->data['controls'][$key])) {

            // Delete the control
            unset($this->data['controls'][$key]);

            // If empty, remove the whole controls array
            if (empty($this->data['controls'])) {
                unset($this->data['controls']);
            }

            session()->put('process', $this->data);

            // Remove deleted placeholder tags from prompt
            $this->cleanPromptPlaceholders();

            // 🔥 REBUILD PROMPT DETAILS
            $this->regeneratePromptInput();
            $this->regeneratePromptDescription();
            $this->generateActualPrompt();
        }
    }

    public function control_entry()
    {
        $this->current_control = $this->control;
        $this->tile = Str::after($this->control, '_');
        session()->put('current_control',$this->current_control);
        session()->put('tile',$this->tile);
    }
}
?>
<div class="w-full justify-center">

    @include('pages.test.timeline')

    @if($timeline == 1)
        <div class="w-[350px] mx-auto mt-14 space-y-2">
            <flux:input wire:model="name" label='Enter your process name' placeholder="enter your process here."/> 
             <flux:button wire:click="step1" :loading="false" class="data-loading:opacity-50">
                <div class="flex space-x-2">
                        <span>Save</span>
                <flux:icon.loading class="size-5 hidden in-data-loading:block"/>
                
                </div>
            </flux:button>
        </div>
    @endif

    @if($timeline == 2)
        <div class="flex space-x-4 mx-auto justify-center w-full  mt-14">
            <flux:card class="space-y-6 w-[350px]">
                <flux:heading size="lg">Select control</flux:heading>
                <flux:select variant="listbox" wire:click="control_entry" wire:model="control" placeholder="Add your control">
                    @foreach($available_controls as $ctrl)
                        @if(!isset($data['controls']) || !array_key_exists($ctrl, $data['controls']))
                            <flux:select.option value="{{ $ctrl }}">{{ ucwords(str_replace('_', ' ', $ctrl)) }}</flux:select.option>
                        @endif
                    @endforeach
                </flux:select>
                {{-- <flux:button wire:click="back">Back</flux:button> --}}
                {{-- <flux:button wire:click="control_entry">Select</flux:button> --}}
            </flux:card>
            <flux:card class="space-y-6 w-[400px]">
                <flux:heading size="lg">Control entry</flux:heading>
                <flux:card class="space-y-6">
                    <flux:text>Active control: <span class=" font-bold">{{ Str::ucwords(Str::replace('_',' ',$this->current_control))}}</span></flux:text>
                    @if($tile == "box") 
                        <flux:input wire:model='label' label="Enter your label"/>
                        <flux:input wire:model='placeholder' label="Enter your placeholder"/>
                    @else
                        @if($tile != null)
                            <flux:input wire:model='label' placeholder="enter your label here..."/>
                            {{-- <flux:select 
                                variant="listbox" 
                                wire:model="control" 
                                multiple 
                                placeholder="Add your control" 
                                class="-mt-4">
                                <flux:select.option value="">--select your {{$tile}}s--</flux:select.option>
                                @foreach(range(1,5) as $i)
                                    <flux:select.option>title of {{$this->tile}} {{$i}}</flux:select.option>
                                @endforeach
                            </flux:select> --}}
                        @endif
                    @endif
                    @if($tile != null)
                        @if($isEditControl)
                            <flux:button wire:click="update_control">Update control</flux:button>
                        @else
                            <flux:button wire:click="add_control">Add control</flux:button>
                        @endif
                    @endif
                </flux:card>
            </flux:card>
            <flux:card class="space-y-6 w-[450px]">
                <flux:heading size="lg">View process</flux:heading>
                @if(isset($data['controls']))
                    <div class="flex justify-between">
                        <flux:text>This is how it looks like actual page.</flux:text>
                        <flux:field variant="inline">
                            <flux:label>Edit</flux:label>
                            <flux:switch wire:model.live="isEdit" />
                            <flux:error name="isEdit" />
                        </flux:field>
                    </div>
                    <flux:kanban class="flex w-full gap-2 h-full overflow-hidden justify-center "> 
                        <flux:kanban.column class="space-y-1 p-1 bg-transparent">
                            <flux:kanban.column.header heading="Customize Process" class="rounded-xl border-2 border-red-300"/>
                                <flux:kanban.card>
                                    <flux:accordion exclusive transition>
                                        <flux:accordion.item>
                                            <flux:accordion.heading>{{$data['name']}}</flux:accordion.heading>
                                            <flux:accordion.content class="space-y-2">
                                                @php
                                                    $isEditClass = $isEdit?"block":"hidden";
                                                @endphp
                                            @foreach($data['controls'] as $key => $control)
                                                @php
                                                    $tmp_tile = Str::after($control['control'], '_');
                                                @endphp
                                                @switch($control['control'])
                                                    @case('input_box')
                                                        <div class="flex-1 w-full space-x-2 relative">
                                                            <flux:icon.pencil 
                                                                wire:click="edit_control('{{$key}}')"
                                                                variant="mini" 
                                                                class=" {{ $isEditClass }} absolute cursor-pointer right-8" />
                                                            
                                                            <flux:icon.trash 
                                                                wire:click="delete_control('{{$key}}')" 
                                                                variant="mini"
                                                                class=" {{ $isEditClass }} absolute cursor-pointer right-0" />
                                                            <flux:input class="w-full" :label="$control['label']" :placeholder="$control['placeholder']" />
                                                        </div>
                                                        @break
                                                    @case('description_box')
                                                        <div class="flex-1 w-full space-x-2 relative">
                                                            <flux:icon.pencil 
                                                                wire:click="edit_control('{{$key}}')"
                                                                variant="mini" 
                                                                class=" {{ $isEditClass }} absolute cursor-pointer right-8 z-5" />
                                                            
                                                            <flux:icon.trash 
                                                                wire:click="delete_control('{{$key}}')" 
                                                                variant="mini"
                                                                class=" {{ $isEditClass }} absolute cursor-pointer right-0 z-5" />
                                                            {{-- <flux:input class="w-full" :label="$control['label']" :placeholder="$control['placeholder']" /> --}}
                                                            <flux:textarea class="w-full" :label="$control['label']" :placeholder="$control['placeholder']" />
                                                        </div>
                                                       @break
                                                    @case('shortlist_idea')
                                                    @case('shortlist_customer')
                                                    @case('shortlist_problem')
                                                    @case('shortlist_solution')
                                                    @case('shortlist_alternative')
                                                        <div class="flex-1 w-full space-x-2 relative">
                                                            <flux:icon.pencil 
                                                                wire:click="edit_control('{{$key}}')"
                                                                variant="mini" 
                                                                class=" {{ $isEditClass }} absolute cursor-pointer right-8 z-5" />
                                                            
                                                            <flux:icon.trash 
                                                                wire:click="delete_control('{{$key}}')" 
                                                                variant="mini"
                                                                class=" {{ $isEditClass }} absolute cursor-pointer right-0 z-5" />
                                                            
                                                        @if($control['label'])
                                                            <flux:heading>{{ $control['label'] }}</flux:heading>
                                                        @endif
                                                        
                                                        <flux:select 
                                                            >
                                                            <flux:select.option selected>--select your {{ $tmp_tile }}s--</flux:select.option>
                                                            @foreach(range(1,5) as $i)
                                                                <flux:select.option>title of {{$tmp_tile}} {{$i}}</flux:select.option>
                                                            @endforeach
                                                        </flux:select>
                                                        </div>
                                                        @break
                                                @endswitch
                                            @endforeach
                                            <flux:button class="w-full">Generate</flux:button>
                                            </flux:accordion.content>
                                        
                                        </flux:accordion.item>
                                    </flux:accordion>
                                </flux:kanban.card>
                        </flux:kanban.column>
                    </flux:kanban>
                @endif
            </flux:card>
        </div>
    @endif

     @if($timeline == 3)
    {{-- <div class="w-[350px] mx-auto mt-14 space-y-2"> --}}
        <div class='flex space-x-4 mt-6 justify-center'>
            <flux:card class=" w-[500px] ">
                <flux:editor wire:model.live="prompt_input" label="Prompt" description="your prompt will be enter here" />
                <flux:button wire:click="step3">Save prompt</flux:button>
            </flux:card>
            <flux:card class=" w-[450px]">
                <flux:heading>Actual prompt</flux:heading>
                 {!!$this->prompt_actual!!}
            </flux:card>
            <flux:card>
                <flux:heading>Prompt description</flux:heading>
                {!!$this->prompt_description!!}
            </flux:card>
        </div>
    {{-- </div> --}}
    @endif

    @if($timeline == 4)
        <div class="w-[350px] mx-auto mt-14 space-y-2">
            <flux:button wire:click="back">Back</flux:button>
        </div>
    @endif
    <div class="flex justify-center items-center space-x-4 mt-6">
        <flux:text>{{ $left[$this->timeline]['text']}}</flux:text>
        <flux:icon.chevron-left 
            wire:click="navigate('{{ $left[$timeline]['command'] }}')" 
            class="cursor-pointer"
        />

        <flux:icon.chevron-right 
            wire:click="navigate('{{ $right[$timeline]['command'] }}')" 
            class="cursor-pointer"
/>
        <flux:text>{{ $right[$this->timeline]['text']}}</flux:text>
    </div>
</div>

