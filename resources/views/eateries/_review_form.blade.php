@if ($errors->any())
    <div class="mb-5 rounded-xl border border-red-200 bg-red-50 px-4 py-3 text-red-800">
        <strong>Please fix the following errors:</strong>
    </div>
@endif

<div class="grid gap-5 md:grid-cols-2">
    <div>
        <label for="user_id" class="mb-2 block text-sm font-semibold text-slate-700">Reviewer</label>
        <select id="user_id" name="user_id"
                class="w-full rounded-lg border border-slate-300 px-3 py-2.5 shadow-sm focus:border-amber-600 focus:outline-none focus:ring-2 focus:ring-amber-200">
            <option value="">Choose reviewer</option>
            @foreach ($users as $user)
                <option value="{{ $user->id }}" @selected(old('user_id') == $user->id)>{{ $user->name }}</option>
            @endforeach
        </select>
        @error('user_id')<p class="mt-1 text-sm font-medium text-red-700">{{ $message }}</p>@enderror
    </div>

    <div>
        <label for="rating" class="mb-2 block text-sm font-semibold text-slate-700">Rating</label>
        <div class="flex items-center gap-1" id="rating-stars" role="radiogroup" aria-label="Rating">
            @for ($star = 1; $star <= 5; $star++)
                <input type="radio" id="rating-{{ $star }}" name="rating" value="{{ $star }}"
                       class="peer sr-only"
                       @checked((string) old('rating') === (string) $star)>
                <label for="rating-{{ $star }}"
                       data-rating="{{ $star }}"
                       class="cursor-pointer text-3xl text-slate-300 transition hover:text-amber-500"
                       aria-label="{{ $star }} {{ $star === 1 ? 'star' : 'stars' }}">★</label>
            @endfor
        </div>
        @error('rating')<p class="mt-1 text-sm font-medium text-red-700">{{ $message }}</p>@enderror
    </div>

    <div class="md:col-span-2">
        <label for="body" class="mb-2 block text-sm font-semibold text-slate-700">Review</label>
        <textarea id="body" name="body" rows="4"
                  class="w-full rounded-lg border border-slate-300 px-3 py-2.5 shadow-sm focus:border-amber-600 focus:outline-none focus:ring-2 focus:ring-amber-200">{{ old('body') }}</textarea>
        @error('body')<p class="mt-1 text-sm font-medium text-red-700">{{ $message }}</p>@enderror
    </div>
</div>

<div class="mt-5 flex justify-end">
    <button type="submit"
            class="rounded-lg bg-amber-800 px-5 py-2.5 font-semibold text-white shadow-sm hover:bg-amber-900 focus:outline-none focus:ring-2 focus:ring-amber-600 focus:ring-offset-2">
        Submit Review
    </button>
</div>

<script>
    const ratingStars = document.querySelectorAll('#rating-stars label');
    const ratingInputs = document.querySelectorAll('#rating-stars input');

    function showStars(rating) {
        ratingStars.forEach((star) => {
            const starNumber = Number(star.dataset.rating);
            star.classList.toggle('text-amber-500', starNumber <= rating);
            star.classList.toggle('text-slate-300', starNumber > rating);
        });
    }

    const selectedRating = document.querySelector('#rating-stars input:checked');
    showStars(selectedRating ? Number(selectedRating.value) : 0);

    ratingInputs.forEach((input) => {
        input.addEventListener('change', () => showStars(Number(input.value)));
    });

    ratingStars.forEach((star) => {
        star.addEventListener('mouseenter', () => showStars(Number(star.dataset.rating)));
        star.addEventListener('click', () => showStars(Number(star.dataset.rating)));
    });

    document.getElementById('rating-stars').addEventListener('mouseleave', () => {
        const checked = document.querySelector('#rating-stars input:checked');
        showStars(checked ? Number(checked.value) : 0);
    });
</script>
