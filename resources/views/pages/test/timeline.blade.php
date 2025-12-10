<div class="relative w-full max-w-xl mt-6 mx-auto">

    <!-- Background line (between circles only) -->
    <div class="absolute top-4 left-[calc(12.5%)] right-[calc(12.5%)] h-1 bg-gray-300"></div>

    <!-- Progress line with transition -->
    <div class="absolute top-4 left-[calc(12.5%)] h-1 bg-orange-400 
                transition-all duration-700 ease-in-out"
         style="width: calc((100% - 25%) / 3 * {{ $timeline - 1 }})">
    </div>

    <div class="flex justify-between relative">

        <!-- STEP 1 -->
        <div class="flex flex-col items-center w-1/4">
            <div class="
                rounded-full w-8 h-8 flex items-center justify-center
                transition-all duration-500 ease-in-out
                {{ $timeline >= 1 ? 'bg-orange-400 text-white scale-110' : 'bg-gray-300 text-gray-600 scale-100' }}
            ">
                1
            </div>
            <span class="mt-2 text-xs text-center">Create a Process</span>
        </div>

        <!-- STEP 2 -->
        <div class="flex flex-col items-center w-1/4">
            <div class="
                rounded-full w-8 h-8 flex items-center justify-center
                transition-all duration-500 ease-in-out
                {{ $timeline >= 2 ? 'bg-orange-400 text-white scale-110' : 'bg-gray-300 text-gray-600 scale-100' }}
            ">
                2
            </div>
            <span class="mt-2 text-xs text-center">Add Controls</span>
        </div>

        <!-- STEP 3 -->
        <div class="flex flex-col items-center w-1/4">
            <div class="
                rounded-full w-8 h-8 flex items-center justify-center
                transition-all duration-500 ease-in-out
                {{ $timeline >= 3 ? 'bg-orange-400 text-white scale-110' : 'bg-gray-300 text-gray-600 scale-100' }}
            ">
                3
            </div>
            <span class="mt-2 text-xs text-center">Add a Prompt</span>
        </div>

        <!-- STEP 4 -->
        <div class="flex flex-col items-center w-1/4">
            <div class="
                rounded-full w-8 h-8 flex items-center justify-center
                transition-all duration-500 ease-in-out
                {{ $timeline >= 4 ? 'bg-orange-400 text-white scale-110' : 'bg-gray-300 text-gray-600 scale-100' }}
            ">
                4
            </div>
            <span class="mt-2 text-xs text-center">Save & Generate</span>
        </div>

    </div>
</div>
