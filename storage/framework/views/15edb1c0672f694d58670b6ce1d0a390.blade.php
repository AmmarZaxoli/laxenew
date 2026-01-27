    <div wire:poll.15s="fetchCount" style="display: inline-block;">
        @if($count > 0)
            <span class="badge rounded-pill bg-danger" 
                  style="font-size: 0.75rem; padding: 0.35em 0.65em; margin-left: 5px;">
                {{ $count }}
            </span>
        @else
            <span class="badge rounded-pill bg-secondary" style="font-size: 0.6rem; opacity: 0.3;">0</span>
        @endif
    </div>