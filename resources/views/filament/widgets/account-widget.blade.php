<div class="flex items-center space-x-4 custom-background">
    <div class="flex-1">
        <div class="font-medium">{{ auth()->user()->name }}</div>
        <div class="text-sm text-gray-500">{{ auth()->user()->email }}</div>
    </div>

    <style>
        .custom-background {
            background-color: #17181a;
            padding: 1rem;
            border-radius: 0.5rem;
            border: 1px solid #272829; /* border color */
        }
    </style>
</div>
