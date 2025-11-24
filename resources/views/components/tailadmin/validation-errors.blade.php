@if (session('status'))
    <div class="mb-4 rounded border border-green-200 bg-green-50 px-4 py-3 text-green-700">
        {{ session('status') }}
    </div>
@endif

@if (session('error'))
    <div class="mb-4 rounded border border-red-200 bg-red-50 px-4 py-3 text-red-700">
        {{ session('error') }}
    </div>
@endif

@if ($errors->any())
    <div class="mb-4 rounded border border-red-200 bg-red-50 px-4 py-3 text-red-700">
        <div class="font-medium mb-2">Terjadi kesalahan:</div>
        <ul class="list-inside list-disc space-y-1">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
