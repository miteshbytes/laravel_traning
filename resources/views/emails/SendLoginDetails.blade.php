@component('mail::message')

<p>Hello <b><?php echo $details['name']; ?>,</b></p>

<p>Here below details your credentials For login</p>
<br>
Url : http://127.0.0.1:8000/login <br>
Email : <?php echo $details['email']; ?> <br>
Password : welcome123
<br><br>

Thanks,<br>
{{ config('app.name') }}
@endcomponent
