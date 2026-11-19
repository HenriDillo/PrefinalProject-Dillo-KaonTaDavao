@props(['rating'])

<span aria-label="{{ number_format((float) $rating, 1) }} stars">
    @for ($star = 1; $star <= 5; $star++)
        {{ $star <= round((float) $rating) ? '★' : '☆' }}
    @endfor
</span>
