<li class="flex items-start gap-2">
    @if($type === 0)
        <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" class="w-[6px] h-[6px] flex-shrink-0 mt-[9px] text-brand-dark" viewBox="0 0 16 16">
            <path d="M0 2a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v12a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2z"/>
        </svg>
        <p>{{ $item }}</p>
    @elseif($type === 1)
        <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" class="w-2 h-2 flex-shrink-0 mt-[9px] text-brand-dark" viewBox="0 0 16 16">
            <path d="M3.612 15.443c-.386.198-.824-.149-.746-.592l.83-4.73L.173 6.765c-.329-.314-.158-.888.283-.95l4.898-.696L7.538.792c.197-.39.73-.39.927 0l2.184 4.327 4.898.696c.441.062.612.636.282.95l-3.522 3.356.83 4.73c.078.443-.36.79-.746.592L8 13.187l-4.389 2.256z"/>
        </svg>
        <p>{{ $item }}</p>
    @endif
</li>