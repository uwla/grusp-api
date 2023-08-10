Para verificar sua conta, clique no link abaixo:

<x-mail::button :url="$url">
VERIFICAR CONTA
</x-mail::button>

Se não funcionar, copie e cole o seguinte link no seu navegador:

<br/><br/>

{{ "$url" }}

<br/><br/>

O link expira em {{ config('auth.verification.expire') }} minutos.

