    <div wire:poll.5s="fetchCount" style="display: inline-block;">
        @if($count > 0)
            <span class="badge rounded-pill bg-danger animate__animated animate__pulse">
                {{ $count }}
            </span>
        @endif
    </div>