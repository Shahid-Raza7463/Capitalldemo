{!! $description ??'' !!}

<p><br /> <br /> <br /> <span style="text-decoration: underline;"><strong>Confirmation</strong></span><br /> <br /> We
    confirm that the in our books of account, the outstanding balance as on 30.09.2022 is
    <span style="color: #ff6600;">Rs {{ $amount ??''}}</span> <br /> </p>
<h1 style="text-align: center;"><strong><a
            href="{{url('/debtorconfirm?'.'clientid='.$clientid.'&&'.'debtorid='.$debtorid.'&&'.'status='.$yes)}}"
          ><span style="color: #000000; background-color: #99cc00;">Yes&nbsp;</span> &nbsp; &nbsp; <span
                style="background-color: #ff6600; color: #000000;">&nbsp;&nbsp;</span></a><span
            style="color: #000000; background-color: #ff6600;"><a style="color: #000000; background-color: #ff6600;"
                href="{{url('/debtorconfirm?'.'clientid='.$clientid.'&&'.'debtorid='.$debtorid.'&&'.'status='.$no)}}"
              >No
            </a>&nbsp;</span></strong></h1>
<p>&nbsp;</p>
<p><em>NOTICE: Information, including attachments if any, contained through this email is confidential and intended for
        a specific individual and purpose, and is protected by law. If you are not the intended recipient any use,
        distribution, transmission, copying or disclosure of this information in any way or in any manner is strictly
        prohibited. You should delete this message and inform the sender. </em></p>
<p>&nbsp;</p>