<?php

use Livewire\Volt\Component;
use App\Helpers\Menu;
new class extends Component {
    public $menus = [];
    public function mount($tile = [])
    {
        $use_menu = $tile;
        $this->menus = Menu::$use_menu();
    }
    //
}; ?>
<div class="flex-1 w-screen h-screen ">
<flux:sidebar sticky collapsible class="bg-zinc-50 dark:bg-zinc-900 border-r border-zinc-200 dark:border-zinc-700">
        {{-- <flux:sidebar.header>
            <flux:sidebar.brand
                href="#"
                logo="https://fluxui.dev/img/demo/logo.png"
                logo:dark="https://fluxui.dev/img/demo/dark-mode-logo.png"
                name="Acme Inc."
            />
            <flux:sidebar.collapse class="in-data-flux-sidebar-on-desktop:not-in-data-flux-sidebar-collapsed-desktop:-mr-2" />
        </flux:sidebar.header> --}}
        
        <flux:sidebar.nav>
            @foreach($menus as $menu)
                <flux:header class="-ml-8">{{$menu['name']}}</flux:header>
                @if(isset($menu['sub-menu']))
                    <div class="ml-2">
                    @foreach($menu['sub-menu'] as $sub_menu)
                        <flux:sidebar.item href="{{ route($sub_menu['route']) }}">{{$sub_menu['name']}}</flux:sidebar.item>
                        @if(isset($sub_menu['sub-menu'])) 
                            <div class="ml-4">
                            @foreach($sub_menu['sub-menu'] as $sub_menu2)
                                <flux:sidebar.item href="{{ route($sub_menu2['route']) }}">{{$sub_menu2['name']}}</flux:sidebar.item>
                            @endforeach
                            </div>
                        @endif       
                    @endforeach
                    </div>
                @endif
            @endforeach
            {{-- <flux:header class="-ml-8">Library</flux:header>
            <div class="ml-2">
                <flux:sidebar.item href="#" current>Projects</flux:sidebar.item>
                <flux:sidebar.item href="#">Favourites</flux:sidebar.item>
                <flux:sidebar.item href="#">Shared with me</flux:sidebar.item>
            </div>
            <flux:header class="-ml-8">Account</flux:header>
            <div class="ml-2">
                <flux:sidebar.item href="#">Help</flux:sidebar.item>
                <flux:sidebar.item href="#">Upgrade</flux:sidebar.item>
                <flux:sidebar.item href="#">Settings</flux:sidebar.item>
            </div> --}}
          
        </flux:sidebar.nav>
        <flux:sidebar.spacer />
        <flux:sidebar.nav>
            <flux:sidebar.item icon="cog-6-tooth" href="#">Settings</flux:sidebar.item>
            <flux:sidebar.item icon="information-circle" href="#">Help</flux:sidebar.item>
        </flux:sidebar.nav>
        <flux:dropdown position="top" align="start" class="max-lg:hidden">
            <flux:sidebar.profile avatar="https://fluxui.dev/img/demo/user.png" name="Olivia Martin" />
            <flux:menu>
                <flux:menu.radio.group>
                    <flux:menu.radio checked>Olivia Martin</flux:menu.radio>
                    <flux:menu.radio>Truly Delta</flux:menu.radio>
                </flux:menu.radio.group>
                <flux:menu.separator />
                <flux:menu.item icon="arrow-right-start-on-rectangle">Logout</flux:menu.item>
            </flux:menu>
        </flux:dropdown>
    </flux:sidebar>

    <flux:header class="lg:hidden">
        <flux:sidebar.toggle class="lg:hidden" icon="bars-2" inset="left" />
        <flux:spacer />
        <flux:dropdown position="top" align="start">
            <flux:profile avatar="/img/demo/user.png" />
            <flux:menu>
                <flux:menu.radio.group>
                    <flux:menu.radio checked>Olivia Martin</flux:menu.radio>
                    <flux:menu.radio>Truly Delta</flux:menu.radio>
                </flux:menu.radio.group>
                <flux:menu.separator />
                <flux:menu.item icon="arrow-right-start-on-rectangle">Logout</flux:menu.item>
            </flux:menu>
        </flux:dropdown>
    </flux:header>
    <flux:main>
        <flux:heading size="xl" level="1">Good afternoon, Olivia</flux:heading>
        <flux:text class="mt-2 mb-6 text-base">Here's what's new today</flux:text>
        <flux:separator variant="subtle" />
        {{$slot}}
    </flux:main>
</div>

