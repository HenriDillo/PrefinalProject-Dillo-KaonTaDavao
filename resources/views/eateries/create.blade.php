@extends('layouts.app')

@section('content')
    <div class="mx-auto max-w-3xl">
        <div class="mb-6">
            <p class="text-sm font-semibold uppercase tracking-wide text-amber-700">Eatery directory</p>
            <h1 class="mt-1 text-3xl font-bold text-slate-900">Add Eatery</h1>
        </div>

        <form method="POST" action="{{ route('eateries.store') }}"
              class="overflow-hidden rounded-2xl border border-amber-100 bg-white shadow-lg shadow-amber-950/5">
            @csrf
            @include('eateries._form')

            <div class="flex flex-col-reverse gap-3 border-t border-amber-100 bg-slate-50 px-6 py-5 sm:flex-row sm:justify-end">
                <a href="{{ route('eateries.index') }}"
                   class="inline-flex justify-center rounded-lg border border-slate-300 bg-white px-5 py-2.5 font-semibold text-slate-700 hover:bg-slate-100">
                    Cancel
                </a>
                <button type="submit"
                        class="inline-flex justify-center rounded-lg bg-amber-800 px-5 py-2.5 font-semibold text-white shadow-sm hover:bg-amber-900 focus:outline-none focus:ring-2 focus:ring-amber-600 focus:ring-offset-2">
                    Save Eatery
                </button>
            </div>
        </form>
    </div>
@endsection
