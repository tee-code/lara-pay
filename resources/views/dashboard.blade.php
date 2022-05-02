<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 text-center">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-2 text-white border-b border-gray-200 bg-secondary">
                    Transactions
                </div>
                <table class="table-auto w-full p-2 shadow-md">
                    <thead class="">
                        <tr>
                            <td>Email: </td>
                            <td>Gateway: </td>
                            <td>Reference: </td>
                            <td>Amount: </td>
                            <td>Date: </td>

                        </tr>
                    </thead>
                    <tbody>
                    @foreach ( $transactions as $tranx )
                        
                        <tr class="">
                            <td>{{ $tranx->user->email }} </td>
                            <td>{{ $tranx->gateway }} </td>
                            <td>{{ $tranx->reference }} </td>
                            <td>{{ $tranx->amount }} </td>
                            <td>{{ $tranx->created_at }} </td>

                        </tr>
                    @endforeach
                    </tbody>
                    {{ $transactions->links() }}
                </table>
            </div>
            <a href="{{ route('payment') }}" class="btn flash-button text-white animate animate-shake">Pay</a>
        </div>
    </div>
</x-app-layout>
