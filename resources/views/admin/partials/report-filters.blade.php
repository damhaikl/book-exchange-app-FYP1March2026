@if($errors->any())
    <div class="alert alert-danger mb-3" role="alert">
        Please check the filter values: {{ $errors->first() }}
    </div>
@endif

<form method="GET" action="{{ url()->current() }}" class="search-panel report-filters">
    <div class="filter-type-field">
        <label for="report-filter-by" class="form-label">Filter reports by</label>
        <select id="report-filter-by" name="filter_by" class="form-select">
            <option value="" {{ request('filter_by', '') === '' ? 'selected' : '' }}>Choose a filter</option>
            <option value="reporter" {{ request('filter_by') === 'reporter' ? 'selected' : '' }}>Reporter name</option>
            <option value="date" {{ request('filter_by') === 'date' ? 'selected' : '' }}>Submitted date range</option>
            <option value="specific_date" {{ request('filter_by') === 'specific_date' ? 'selected' : '' }}>Specific date</option>
            @if($showReviewerFilter ?? true)
                <option value="reviewer" {{ request('filter_by') === 'reviewer' ? 'selected' : '' }}>Reviewed by</option>
            @endif
        </select>
    </div>

    <div class="search-field" data-report-default-search @if(request('filter_by')) hidden @endif>
        <label for="search" class="form-label">Search reports</label>
        <input id="search" type="text" name="search" class="form-control" placeholder="Search by student, book, or reason" value="{{ request('search') }}">
    </div>

    <div class="filter-conditional-field" data-report-filter="reporter" @if(request('filter_by') !== 'reporter') hidden @endif>
        <label for="reporter-name" class="form-label">Reporter name</label>
        <input id="reporter-name" type="text" name="reporter_name" class="form-control" value="{{ request('reporter_name') }}" placeholder="Enter a name">
    </div>

    <div class="filter-conditional-field filter-date-range" data-report-filter="date" @if(request('filter_by') !== 'date') hidden @endif>
        <div>
            <label for="start-date" class="form-label">Starting date</label>
            <input id="start-date" type="date" name="start_date" class="form-control" value="{{ request('start_date') }}">
        </div>
        <div>
            <label for="end-date" class="form-label">Ending date</label>
            <input id="end-date" type="date" name="end_date" class="form-control" value="{{ request('end_date') }}">
        </div>
    </div>

    <div class="filter-conditional-field" data-report-filter="specific_date" @if(request('filter_by') !== 'specific_date') hidden @endif>
        <label for="specific-date" class="form-label">Report date</label>
        <input id="specific-date" type="date" name="specific_date" class="form-control" value="{{ request('specific_date') }}">
    </div>

    @if($showReviewerFilter ?? true)
        <div class="filter-conditional-field" data-report-filter="reviewer" @if(request('filter_by') !== 'reviewer') hidden @endif>
            <label for="reviewer-role" class="form-label">Reviewer role</label>
            <select id="reviewer-role" name="reviewer_role" class="form-select">
                <option value="">Choose a role</option>
                <option value="admin" {{ request('reviewer_role') === 'admin' ? 'selected' : '' }}>Admin</option>
                <option value="super_admin" {{ request('reviewer_role') === 'super_admin' ? 'selected' : '' }}>Superadmin</option>
            </select>
        </div>
    @endif

    <button type="submit" class="btn btn-primary"><i class="bi bi-funnel me-1" aria-hidden="true"></i>Apply</button>
    @if(request('search') || request('filter_by') || request('reporter_name') || request('start_date') || request('end_date') || request('specific_date') || request('reviewer_role'))
        <a href="{{ url()->current() }}" class="btn btn-outline-secondary"><i class="bi bi-arrow-counterclockwise me-1" aria-hidden="true"></i>Reset</a>
    @endif
</form>

<script>
    (() => {
        const selector = document.getElementById('report-filter-by');
        if (!selector) return;

        const fields = document.querySelectorAll('[data-report-filter]');
        const defaultSearch = document.querySelector('[data-report-default-search]');
        const searchInput = defaultSearch?.querySelector('input');

        const updateReportFilterFields = () => {
            const showDefaultSearch = selector.value === '';
            if (defaultSearch) defaultSearch.hidden = !showDefaultSearch;
            if (searchInput) searchInput.disabled = !showDefaultSearch;

            fields.forEach((group) => {
                const isActive = group.dataset.reportFilter === selector.value;
                group.hidden = !isActive;
                group.querySelectorAll('input, select').forEach((input) => {
                    input.disabled = !isActive;
                    input.required = isActive;
                });
            });
        };

        selector.addEventListener('change', updateReportFilterFields);
        updateReportFilterFields();
    })();
</script>
