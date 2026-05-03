<style>
    .pending_text{
        color: #f59e0b;
    }

    .resolved_text{
        color: #16a34a;
    }

    .rejected_text{
        color: #dc2626;
    }
</style>
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
                @if(Auth::user()->role == 'super_admin')

                    {{-- SUPER ADMIN PANEL --}}
                    <div class="p-6 text-gray-900 dark:text-gray-100">

                        <div style="font-weight:bold; color:#7c3aed;">
                            SUPER ADMIN PANEL
                        </div>

                        <br>

                        <a href="/homepage" class="btn btn-primary mt-2">
                            View Book Listing
                        </a>

                        <br><br>

                        <a>Select a category to view reports:</a>

                        <a href="{{ route('admin.reports.pending') }}" class="btn btn-danger mt-2">
                            <div class="pending_text">Pending Reports</div>
                        </a>

                        <a href="{{ route('admin.reports.resolved') }}" class="btn btn-danger mt-2">
                            <div class="resolved_text">Resolved Reports</div>
                        </a>

                        <a href="{{ route('admin.reports.rejected') }}" class="btn btn-danger mt-2">
                            <div class="rejected_text">Rejected Reports</div>
                        </a>

                        <br>

                        {{-- 🔥 EXTRA FEATURE FOR SUPER ADMIN --}}
                        <a href="{{ route('admin.create') }}" class="btn btn-success mt-2">
                            ➕ Create New Admin
                        </a>

                    </div>
                @elseif(Auth::user()->role == 'admin')

                    {{-- ADMIN DASHBOARD --}}
                    <div class="p-6 text-gray-900 dark:text-gray-100">

                        <div style="font-weight:bold; color:#7c3aed;">
                            ADMIN PANEL
                        </div>

                        <br>

                        <a href="/homepage" class="btn btn-primary mt-2">
                            View Book Listing
                        </a>

                        <br><br>
                        <a>Select a category to view reports:</a>


                        <a href="{{ route('admin.reports.pending') }}" class="btn btn-danger mt-2">
                            <div class="pending_text">
                                Pending Reports
                            </div>
                        </a>

                        <a href="{{ route('admin.reports.resolved') }}" class="btn btn-danger mt-2">
                            <div class="resolved_text">
                                Resolved Reports
                            </div>
                        </a>

                        <a href="{{ route('admin.reports.rejected') }}" class="btn btn-danger mt-2">
                            <div class="rejected_text">
                                Rejected Reports
                            </div>
                        </a>
                @else
                    <div class="p-6 text-gray-900 dark:text-gray-100">
                        
                        <div style="font-weight:bold; color:#7c3aed;">
                            USER PANEL
                        </div>

                        <br>

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
                        <a href="{{ route('report.my') }}" class="btn btn-danger mt-2">
                            🚨 My Reports
                        </a><br><br>
                        <a href="{{ route('book.saved') }}" class="btn btn-danger mt-2">
                            ❤️ Saved Books
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
