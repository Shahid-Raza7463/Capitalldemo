<h4>Dear  <b>{{ $name ??''}},</b></h4>
<br>

<p>We've reset your password for your account. Your new password is created successfully. To access <b>VSA Portal </b> click the
    link below.</p>
<p>Link : <a href="{{ url('/')}}">{{ url('/')}}</a></p>
<p>Email : {{ $email ??''}}</p>
<p>Password : {{ $password ??''}}</p>
<br>
<p>If you experience any issues logging into your account, reach out to us at <a
        href="mailto:it@capitall.io">it@capitall.io</a></p>
<br>
<br>
<p><b>Regards,<br>Team VSA</b></p>
