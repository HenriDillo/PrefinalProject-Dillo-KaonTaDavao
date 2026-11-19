@if (session('success'))
    <div class="mx-auto max-w-6xl px-4 pt-4">
        <div class="rounded border border-green-300 bg-green-100 px-4 py-3 text-green-800">
            {{ session('success') }}
        </div>
    </div>
@endif
