@component('mail::message')
# Hi, {{$user->first_name}} {{$user->last_name}}


Here is the link you can reset your password;

<a href="{{url('confirm_password_reset')}}/{{$user->id}}/{{$code}}"> Reset</a>


NB: If this email is not yours please contact us immidietly!



Thanks,<br>
Developer Team
Andit Ltd.
@endcomponent
