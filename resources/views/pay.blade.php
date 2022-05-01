<x-app-layout>
    <div class="m-auto text-white text-center">
        <h1 class="text-3xl font-bold">LaraPay</h1>
        <form action="{{ route('pay') }}" method="POST" class="flex flex-col w-100 space-y-3 text-black"> 
            @csrf
            <input type="number" min="100" name="amount" value="" placeholder="Amount:" required> 
            <input type="tel" name="phone" value="" placeholder="Phone Number:" required> 
            <input type="text" name="reason" value="" placeholder="Reason:" required> 
            <select name="gateway" id="option" required>
                <option value="0">Select Payment Gateway</option>
                @foreach ($gateways as $gateway)
                    
                    @if($gateway['active'] == true)
                        <option value="{{ $gateway['code'] }}">{{ $gateway['name'] }}</option>
                    @endif
                @endforeach
                
            </select>
            <button class="btn flash-button text-white" type="submit" name="pay" id="pay" title="Pay now">Pay now</button>
        </form>
    </div>
    
</x-app-layout>