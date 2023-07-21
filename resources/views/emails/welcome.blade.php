<x-mail::message>
# WELCOME!

Congrats {{ $user_name }} for registering in our website!

<x-mail::button :url="'https://laravel.com/docs/10.x/mail'">
READ LARAVEL DOCS
</x-mail::button>

Thanks,<br>
{{ config('app.name') }}
</x-mail::message>
