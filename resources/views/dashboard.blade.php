<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    {{ __("You're logged in!") }}
                </div>
            </div>
        </div>
    </div>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                @if(Auth::user()->role == 'admin')

                    {{-- ADMIN DASHBOARD --}}
                    <div class="p-6 text-red-600 font-bold">
                        ADMIN PANEL
                    </div>

                    <a href="/admin/users" class="btn btn-danger mt-2">
                        👤 Manage Users
                    </a>

                    <br><br>

                    <a href="/admin/books" class="btn btn-warning mt-2">
                        📚 Manage Books
                    </a>
                    
                @else
                    <div class="p-6 text-gray-900 dark:text-gray-100">
                        <a href="/book/create" class="btn btn-success mt-2">
                            ➕ Sell a Book
                        </a>
                        <br><br>
                        <a href="/homepage" class="btn btn-primary mt-2">
                            🌍 Browse Books
                        </a>
                        <br><br>
                        <a href="{{ route('book.myListings') }}" class="btn btn-warning mt-2">
                            📚 My Listings
                        </a>
                        <br><br><br><br>
                        <a href="/inbox" class="btn btn-dark mt-2">
                            📥 Inbox (Requests)
                        </a>
                        <br><br>
                        <a href="{{ route('sent.requests') }}" class="btn btn-info mt-2">
                            📤 Sent Requests
                        </a>
                        <br><br><br><br>
                        <a href="{{ route('book.saved') }}" class="btn btn-danger mt-2">
                            ❤️ Saved Books
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
