@component('mail::message')

<p>Hello <b>Mitesh,</b></p>

<p>Here below details for new recent created user</p>
<br>
Name : <?php echo $details['name']; ?> <br>
Email : <?php echo $details['email']; ?> <br>
Gender : <?php echo $details['gender']; ?> <br>
BirthDate : <?php echo $details['birth_date']; ?> <br>
Password : welcome123
<br><br>

Thanks,<br>
{{ config('app.name') }}
@endcomponent
