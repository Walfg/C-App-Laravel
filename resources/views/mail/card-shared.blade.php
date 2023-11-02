<x-mail::message>
# NEW CONTACT SHARED WITH YOU!

{{ $fromUser }} shared card {{ $sharedCard }} with you.

<x-mail::button :url="route('card-shares.index')">
Check shared card
</x-mail::button>

Thanks,<br>
{{ config('app.name') }}
</x-mail::message>
