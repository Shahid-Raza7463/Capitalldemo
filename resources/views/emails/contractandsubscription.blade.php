Dear Sir/Madam
<br><br>
<h3>you have a new Subscription Request for :
       @if($kgsentity==1)
    <span ><b>Gvriksh</b></span>
       @elseif($kgsentity==2)
    <span ><b>SKL</b></span>
    @elseif($kgsentity==3)
    <span ><b>KGS</b></span>
    @elseif($kgsentity==4)
    <span ><b>KGS Insolvency</b></span>
    @elseif($kgsentity==5)
    <span ><b>KGS Advisors</b></span>
    @else
    <span ><b>Capitall</b></span>
   
    @endif</h3>
<p>Please click on link  <a href="{{url('view/contract/'.$ContractandSubscriptionid )}}">subscription</a></p>
