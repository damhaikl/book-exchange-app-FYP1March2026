<h2>❤️ Saved Books</h2>
<a href="/dashboard" class="btn btn-secondary mb-3">⬅ Back</a>
<br><br>

@forelse($saved as $item)

<div style="border:1px solid #ccc; padding:10px; margin-bottom:10px;">

    <h4>{{ $item->book->title }}</h4>
    <p>{{ $item->book->description }}</p>

    <div style="display:flex; gap:10px;">

        <a href="/book/{{ $item->book->id }}" class="btn btn-primary">
            View
        </a>

        <form method="POST" action="{{ route('book.unsave', $item->book->id) }}">
            @csrf
            <button type="submit" class="btn btn-danger">
                ❌ Unsave
            </button>
        </form>

    </div>

</div>

@empty
<p>No saved books yet 😢</p>
@endforelse
