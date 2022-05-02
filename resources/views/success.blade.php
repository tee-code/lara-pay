<x-app-layout>
    
    <div class="m-auto text-white text-center">
        <h1 class="text-3xl font-bold">LaraPay</h1>
        <h2 class="text-2xl">Reference ID: {{ $ref }}</h2>
        <h2 class="text-2xl">
            @if(session('msg'))
                {{ session('msg') }}
            @else
                Payment Successful. Thanks!
            @endif
        </h2>
        <a href="/" class="btn flash-button text-white">Back</a>
    </div>
    
</x-app-layout>