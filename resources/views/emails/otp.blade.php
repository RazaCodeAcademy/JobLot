
@component('mail::message')
<center style="color: #320777; font-size:35px;">Reset Your Password <br/></center>

<h4>Here is your otp code : {{ $otp }}</h4>

Thanks,<br>
{{ config('app.name') }}
@endcomponent