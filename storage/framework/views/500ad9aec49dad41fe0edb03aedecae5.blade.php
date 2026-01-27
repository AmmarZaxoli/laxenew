    <div wire:poll.20s="fetchCount" style="display: inline-block;">
        @if($count > 0)
            <span class="badge rounded-pill bg-danger" style="font-size: 0.75rem;">
                {{ $count }}
            </span>
        @else
            <span class="badge rounded-pill bg-secondary" style="opacity: 0.5;">0</span>
        @endif
    </div>