@component('mail::message')

Уведомление для админа {{ $full_name }}

@component('mail::button', ['url' => route('admin.orders.edit', $order_id)])
Button Text
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
