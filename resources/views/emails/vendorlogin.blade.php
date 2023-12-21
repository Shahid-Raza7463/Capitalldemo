<h4>Dear  <b>Vendor,</b></h4>
<br>
<p><b>You have a new request for uploading your Invoice. For uploading please click here
    <a href="{{url('/vendorform/'.Crypt::encrypt($vendorid) )}}"> here </a> </b></p>

<p>We would like to inform you that your account is created successfully. To access <b>Vendor Login portal</b> click the
    link below.</p>
<p>Link : <a href="{{url('/vendorlogin')}}">Kgs.capitall.io/vendorlogin</a></p>
<p>Email : {{ $email ??''}}</p>
<p>Password : {{ $password ??''}}</p>
<br>

<p>If you experience any issues logging into your account, reach out to us at <a
        href="mailto:it@kgsomani.com">it@kgsomani.com</a></p>
<br>
<br>
<p><b>Regards,<br>Kgskonnect IT Team</b></p>
