    <span wire:poll.30s="fetchCount" class="ms-auto">
        @if($count > 0)
            <span class="badge rounded-pill bg-danger">
                {{ $count }}
            </span>
        @endif
    </span>