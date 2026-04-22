<html>
    <h2>📥 Book Requests</h2>
    <body>
        @foreach($requests as $req)
            <div style="border:1px solid #ccc; padding:10px; margin-bottom:10px;">
                <p><b>Book:</b> {{ $req->book->title }}</p>
                <p><b>Requested by:</b> {{ $req->requester->name }}</p>
                <p><b>Status:</b> {{ $req->status }}</p>
            </div>
        @endforeach
    </body>
</html>