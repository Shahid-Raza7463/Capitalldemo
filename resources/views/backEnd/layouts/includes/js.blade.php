 <!--Global script(used by all pages)-->
 <script data-cfasync="false" src="{{ url('backEnd/cdn-cgi/scripts/5c5dd728/cloudflare-static/email-decode.min.js')}}"></script>
 @if (Request::is('gnattchart') || Request::is('gnattchart/store'))
 @else
 <script src="{{ url('backEnd/plugins/jQuery/jquery-3.4.1.min.js')}}"></script>
  <!--Page Active Scripts(used by this page)-->
 <script src="{{ url('backEnd/dist/js/pages/dashboard.js')}}"></script>
 @endif
 <script src="{{ url('backEnd/dist/js/popper.min.js')}}"></script>
 <script src="{{ url('backEnd/plugins/bootstrap/js/bootstrap.min.js')}}"></script>
 <script src="{{ url('backEnd/plugins/metisMenu/metisMenu.min.js')}}"></script>
 <script src="{{ url('backEnd/plugins/perfect-scrollbar/dist/perfect-scrollbar.min.js')}}"></script>
 <!-- Third Party Scripts(used by this page)-->
 <script src="{{ url('backEnd/plugins/chartJs/Chart.min.js')}}"></script>
 <script src="{{ url('backEnd/plugins/sparkline/sparkline.min.js')}}"></script>
 <script src="{{ url('backEnd/plugins/datatables/dataTables.min.js')}}"></script>
 <script src="{{ url('backEnd/plugins/datatables/dataTables.bootstrap4.min.js')}}"></script>

 <!--Page Scripts(used by all page)-->
 <script src="{{ url('backEnd/dist/js/sidebar.js')}}"></script>

 <!--colorpicker(used by all page)-->
 <script src="{{ url('backEnd/dist/js/jscolor.js') }}"></script>

 <!--Page Active Scripts(used by this page)-->
 <script src="{{ url('backEnd/plugins/datatables/data-basic.active.js')}}"></script>


 <!--summernote-->
<!-- Third Party Scripts(used by this page)-->
<script src="{{ url('backEnd/plugins/summernote/summernote.min.js')}}"></script>
<script src="{{ url('backEnd/plugins/summernote/summernote-bs4.min.js')}}"></script>
<!--Page Active Scripts(used by this page)-->
<script src="{{ url('backEnd/plugins/summernote/summernote.active.js')}}"></script>

<!--wysihtml5-->
    <!-- Third Party Scripts(used by this page)-->
    <script src="{{ url('backEnd/plugins/bootstrap-wysihtml5/wysihtml5.js')}}"></script>
    <script src="{{ url('backEnd/plugins/bootstrap-wysihtml5/bootstrap-wysihtml5.js')}}"></script>
    <!--Page Active Scripts(used by this page)-->
    <script src="{{ url('backEnd/plugins/bootstrap-wysihtml5/wysihtml5.active.js')}}"></script>
    <script>
    $(document).ready(function(){
    $('#softskillstraining').on('change', function() {
  
    var selectedvalue=[];
   for (var option of document.getElementById('softskillstraining').options)
   {
     if (option.selected)
     {
     debugger;
      if (option.value == '8')
      {
        $("#keyother").show();
     
      }
      else
      {
        $("#keyother").hide();
      }
     selectedvalue.push(option.value);

    }

   }
  


     
     
    });
});
</script>
<script>
  $(document).ready(function(){
  $('#concerntype').on('change', function() {
    if ( this.value == '0')
    {
      $("#Assetconcern").show();
      document.getElementById("Assetconcerns").required = true;
    }
    else
    {
      $("#Assetconcern").hide();
      
    }
  });
});
</script>
<script>
  $(document).ready(function(){
  $('#Tickets_Booked_By').on('change', function() {
    if ( this.value == 'Self')
    {
      $("#tickets").show();
    
    }
    else
    {
      $("#tickets").hide();
		 value25 = 0;
      var totalvalue = parseInt(value25);
      document.getElementById('ticket').value = totalvalue;
		 document.getElementById('ApprovedRate').value = totalvalue;
		document.getElementById('outstationnoofday').value = totalvalue;
		 document.getElementById('claimed').value = totalvalue;
		 document.getElementById('conveyances').value = totalvalue;
		 document.getElementById('journey').value = totalvalue;
		 document.getElementById('miscellaneous').value = totalvalue;
		 document.getElementById('food').value = totalvalue;
		 document.getElementById('total').value = totalvalue;
    }
  });
});
</script>
<script>
  $(document).ready(function(){
  $('#documentbcom').on('change', function() {
    if ( this.value == '0')
    {
      $("#bcomcertificate").show();
      $("#noc").show();
      document.getElementById("bcomcertificate").required = true;
		  document.getElementById("noc").required = true;
    }
    else if ( this.value == '1')
    {
      $("#bcomcertificate").show();
		  document.getElementById("bcomcertificate").required = true;
      $("#noc").hide();
    }
    else
    {
      $("#bcomcertificate").hide();
      $("#noc").hide();
    }
  });
});
</script>
<script>
  $(document).ready(function(){
  $('#conveyances').on('change', function() {
    debugger;
    if ( this.value > '0')
    {
    
      $("#Conveyance_file").show();
   
    }
    else
    {
      $("#Conveyance_file").hide();
      document.getElementById("Conveyance_file").required = true;
    }
  });
});
</script>
<script>
  $(document).ready(function(){
  $('#journey').on('change', function() {
    debugger;
    if ( this.value > '0')
    {
    
      $("#During_Journeyfile").show();
   
    }
    else
    {
      $("#During_Journeyfile").hide();
      document.getElementById("During_Journeyfile").required = true;
    }
  });
});
</script>
<script>
  $(document).ready(function(){
  $('#miscellaneous').on('change', function() {
    debugger;
    if ( this.value > '0')
    {
    
      $("#Miscellaneous_Expfile").show();
   
    }
    else
    {
      $("#Miscellaneous_Expfile").hide();
      document.getElementById("Miscellaneous_Expfile").required = true;
    }
  });
});
</script>
<script>
    $(document).ready(function(){
    $('#classification').on('change', function() {
      if ( this.value == '4')
      {
        $("#otherclassification").show();
     
      }
      else
      {
        $("#otherclassification").hide();
      }
    });
});
</script>
 <script>
      $(document).ready(function(){
      $('#din').on('change', function() {
        if ( this.value == 'Yes')
        {
          $("#dinno").show();
       
        }
        else
        {
          $("#dinno").hide();
        }
      });
  });
  </script>
    <script>
    $(document).ready(function(){
    $('#currency').on('change', function() {
      if ( this.value == '1')
      {
        $("#currencychange").show();
     
      }
      else
      {
        $("#currencychange").hide();
      }
    });
});
</script>
   <script>
    $(document).ready(function(){
    $('#Position_Referred').on('change', function() {
      if ( this.value == 'Other')
      {
        $("#other").show();
     
      }
      else
      {
        $("#other").hide();
      }
    });
});
</script>
<script>
  $(document).ready(function(){
  $('#localfood').on('change', function() {
    debugger;
    if ( this.value > '0')
    {
    
      $("#Travelfoodsupportingfile").show();
		document.getElementById("Travelfoodsupportingfiler").required = true;
   
    }
    else
    {
      $("#Travelfoodsupportingfile").hide();
    }
  });
});
</script>
<script>
  $(document).ready(function(){
  $('#travelMiscellaneous').on('change', function() {
    debugger;
    if ( this.value > '0')
    {
    
      $("#TravelMiscellaneoussupportingfile").show();
		document.getElementById("TravelMiscellaneoussupportingfiler").required = true;
   
    }
    else
    {
      $("#TravelMiscellaneoussupportingfile").hide();
    }
  });
});
</script>
<script>
  $(document).ready(function(){
  $('#leave').on('change', function() {
    debugger;
    if ( this.value == '8')
    {
    
      $("#type").show();
		document.getElementById("leavetype").required = true;
    $("#sickleave").hide();
    }
    else
    {
      
      $("#type").hide();
    }
  });
});
</script>
<script>
  $(document).ready(function(){
  $('#selectexam').on('change', function() {
    debugger;
    if ( this.value == '3')
    {
    
      $("#otherexamtype").show();
		document.getElementById("otherexamtype").required = true;
    $("#sickleave").hide();
    }
    else
    {
      
      $("#otherexamtype").hide();
    }
  });
});
</script>
<script>
  $(document).ready(function(){
  $('#leave').on('change', function() {
    debugger;
    if ( this.value == '7')
    {
    
      $("#examtype").show();
		document.getElementById("examtype").required = true;
    $("#sickleave").hide();
    }
    else
    {
      
      $("#examtype").hide();
    }
  });
});
</script>
<script>
  $(document).ready(function(){
  $('#to').on('change', function() {
    var selectedvalue = document.getElementById("leave").value;
    
   if ( selectedvalue == '6')
    {
       var value5 = document.getElementById("to").value;
       var value8 = document.getElementById("from").value;
//       var date1 = new Date(value5);
// var date2 = new Date(value8);
  
// To calculate the time difference of two dates
// var Difference_In_Time = date2.getTime() - date1.getTime();
  
// // To calculate the no. of days between two dates
// var Difference_In_Days = Difference_In_Time / (1000 * 3600 * 24);

var diff =  Math.floor(
    (
        Date.parse(
          value5.replace(/-/g,'\/')
    ) - Date.parse(
      value8.replace(/-/g,'\/')
    )               
    ) / 86400000);
   
if(diff > 1)
{
	debugger;
 // $("#sickleave").show();
  $("#report").show();
  document.getElementById("report").required = true;
}
else
{
  $("#report").hide();
  document.getElementById("report").required = false;

}
		
		
    }
  });
});
</script>
<script>
    $(document).ready(function(){
    $('#pocketexpenseamount').on('change', function() {
      debugger;
      if ( this.value > '0')
      {
      
        $("#pocket").show();
     
      }
      else
      {
        $("#pocket").hide();
      }
    });
});
</script>
     <script>
      $(document).ready(function(){
      $('#exampleFormControlSelect2').on('change', function() {
        if ( this.value == '2')
        {
          $("#designation").show();
        }
        else
        {
          $("#designation").hide();
        }
      });
  });
  </script>
    <script>
      $(document).ready(function(){
      $('#exampleFormControlSelect33').on('change', function() {
        if ( this.value == '2')
        {
          $("#designationn").show();
       
        }
        else
        {
          $("#designationn").hide();
        }
      });
  });
  </script>
 <script>
      $(document).ready(function(){
      $('#invoicereject').on('change', function() {
        if ( this.value == '1')
        {
          $("#designationn").show();
          $("#deb").hide();
        }
        else if ( this.value == '5')
        {
          $("#deb").show();
          $("#designationn").hide();
        }
        else
        {
          $("#designationn").hide();
          $("#deb").hide();
        }
      });
  });
  </script>
 <script>
      $(document).ready(function(){
      $('#Tickets_Booked_By').on('change', function() {
        if ( this.value == 'Self')
        {
          $("#designationn").show();
       
        }
        else
        {
          $("#designationn").hide();
        }
      });
  });
  </script>
   <script>
      $(document).ready(function(){
          $("#template").change(function(){
              $(this).find("option:selected").each(function(){
                  var optionValue = $(this).attr("value");
                 // alert(optionValue);
           
                  if(optionValue==1){
                      $("#div2").hide();
                      $("#div1").show();
                      
                  }
                  else if(optionValue==2){
                      $("#div1").hide();
                      $("#div2").show();
                  }
                  else{
                      $("#div2").hide();
                      $("#div1").hide();
                     
                      
                  }
              });
          }).change();
      });
      </script>
 <script>
    $(document).ready(function(){
    $('#travel').on('change', function() {
      if ( this.value == '0')
      {
        $("#travels").show();
		   $("#ticket").val('0');
                    $("#food").val('0');
                    $("#conveyance").val('0');
                    $("#other").val('0');
                    $("#total").val('0');
      }
      else
      {
        $("#travels").hide();
      }
    });
});
</script>
        <script>
      $(document).ready(function(){
      $('#exampleFormControlSelect3').on('change', function() {
        if ( this.value == '2')
        {
          $("#designationn").show();
       
        }
        else
        {
          $("#designationn").hide();
        }
      });
  });
  </script>
         <script>
      $(document).ready(function(){
      $('#exampleFormControlSelect4').on('change', function() {
        if ( this.value == '1')
        {
          $("#designationnn").show();
       
        }
        else
        {
          $("#designationnn").hide();
        }
      });
  });
  </script>
    <script>
        $(document).ready(function(){
        $('#exampleFormControlSelect1').on('change', function() {
          if ( this.value == '1')
          {
            $("#designation").show();
          }
          else
          {
            $("#designation").hide();
          }
        });
    });
    </script>

<script>
  $(document).ready(function(){
  $('#subsidiaries').on('change', function() {
    if ( this.value == '1')
    {
      $("#subsidiariesother").show();
      document.getElementById("subsidiariesothers").required = true;
    }
    else
    {
      $("#subsidiariesother").hide();
      
    }
  });
});
</script>
<script>
  $(document).ready(function(){
  $('#financial').on('change', function() {
    if ( this.value == '1')
    {
      $("#financialother").show();
      document.getElementById("financialothers").required = true;
    }
    else
    {
      $("#financialother").hide();
    }
  });
});
</script>
<script>
  $(document).ready(function(){
  $('#outside').on('change', function() {
    if ( this.value == '1')
    {
      $("#outsideother").show();
      document.getElementById("outsideothers").required = true;
    }
    else
    {
      $("#outsideother").hide();
    }
  });
});
</script>
<script>
  $(document).ready(function(){
  $('#client').on('change', function() {
    if ( this.value == '1')
    {
      $("#clientother").show();
      document.getElementById("clientothers").required = true;
    }
    else
    {
      $("#clientother").hide();
    }
  });
});
</script>
<script>
  $(document).ready(function(){
  $('#authority').on('change', function() {
    if ( this.value == '1')
    {
      $("#authorityother").show();
      document.getElementById("authorityothers").required = true;
    }
    else
    {
      $("#authorityother").hide();
    }
  });
});
</script>
<script>
  $(document).ready(function(){
  $('#underwriter').on('change', function() {
    if ( this.value == '1')
    {
      $("#underwriterother").show();
      document.getElementById("underwriterothers").required = true;
    }
    else
    {
      $("#underwriterother").hide();
    }
  });
});
</script>
<script>
  $(document).ready(function(){
  $('#trustee').on('change', function() {
    if ( this.value == '1')
    {
      $("#trusteeother").show();
      document.getElementById("trusteeothers").required = true;
    }
    else
    {
      $("#trusteeother").hide();
    }
  });
});
</script>
<script>
  $(document).ready(function(){
  $('#spouse').on('change', function() {
    if ( this.value == '1')
    {
      $("#spouseother").show();
      document.getElementById("spouseothers").required = true;
    }
    else
    {
      $("#spouseother").hide();
    }
  });
});
</script>
<script>
  $(document).ready(function(){
  $('#compromisee').on('change', function() {
    if ( this.value == '1')
    {
      $("#compromiseotherr").show();
      document.getElementById("compromiseotherssss").required = true;
    }
    else
    {
      $("#compromiseotherr").hide();
    }
  });
});
</script>
<script>
  $(document).ready(function(){
  $('#litigation').on('change', function() {
    if ( this.value == '1')
    {
      $("#litigationother").show();
      document.getElementById("litigationothers").required = true;
    }
    else
    {
      $("#litigationother").hide();
    }
  });
});
</script>
<script>
  $(document).ready(function(){
  $('#relative').on('change', function() {
    if ( this.value == '1')
    {
      $("#relativeotherrs").show();
      document.getElementById("relativeotherssss").required = true;
    }
    else
    {
      $("#relativeotherrs").hide();
    }
  });
});
</script>
<script>
  $(document).ready(function(){
  $('#subsidiariess').on('change', function() {
    if ( this.value == '1')
    {
      $("#subsidiariesothers").show();
      document.getElementById("subsidiariesotherss").required = true;
    }
    else
    {
      $("#subsidiariesothers").hide();
      
    }
  });
});
</script>
<script>
  $(document).ready(function(){
  $('#financials').on('change', function() {
    if ( this.value == '1')
    {
      $("#financialothers").show();
      document.getElementById("financialotherss").required = true;
    }
    else
    {
      $("#financialothers").hide();
    }
  });
});
</script>
<script>
  $(document).ready(function(){
  $('#outsides').on('change', function() {
    if ( this.value == '1')
    {
      $("#outsideothers").show();
      document.getElementById("outsideotherss").required = true;
    }
    else
    {
      $("#outsideother").hide();
    }
  });
});
</script>
<script>
  $(document).ready(function(){
  $('#clients').on('change', function() {
    if ( this.value == '1')
    {
      $("#clientothers").show();
      document.getElementById("clientotherss").required = true;
    }
    else
    {
      $("#clientothers").hide();
    }
  });
});
</script>
<script>
  $(document).ready(function(){
  $('#authoritys').on('change', function() {
    if ( this.value == '1')
    {
      $("#authorityothers").show();
      document.getElementById("authorityotherss").required = true;
    }
    else
    {
      $("#authorityothers").hide();
    }
  });
});
</script>
<script>
  $(document).ready(function(){
  $('#underwriters').on('change', function() {
    if ( this.value == '1')
    {
      $("#underwriterothers").show();
      document.getElementById("underwriterotherss").required = true;
    }
    else
    {
      $("#underwriterothers").hide();
    }
  });
});
</script>
<script>
  $(document).ready(function(){
  $('#trustees').on('change', function() {
    if ( this.value == '1')
    {
      $("#trusteeothers").show();
      document.getElementById("trusteeotherss").required = true;
    }
    else
    {
      $("#trusteeothers").hide();
    }
  });
});
</script>
<script>
  $(document).ready(function(){
  $('#spouses').on('change', function() {
    if ( this.value == '1')
    {
      $("#spouseothers").show();
      document.getElementById("spouseotherss").required = true;
    }
    else
    {
      $("#spouseothers").hide();
    }
  });
});
</script>
<script>
  $(document).ready(function(){
  $('#compromises').on('change', function() {
    if ( this.value == '1')
    {
      $("#compromiseothers").show();
      document.getElementById("compromiseotherss").required = true;
    }
    else
    {
      $("#compromiseothers").hide();
    }
  });
});
</script>
<script>
  $(document).ready(function(){
  $('#litigations').on('change', function() {
    if ( this.value == '1')
    {
      $("#litigationothers").show();
      document.getElementById("litigationotherss").required = true;
    }
    else
    {
      $("#litigationothers").hide();
    }
  });
});
</script>
<script>
  $(document).ready(function(){
  $('#relatives').on('change', function() {
    if ( this.value == '1')
    {
      $("#relativeothers").show();
      document.getElementById("relativeotherss").required = true;
    }
    else
    {
      $("#relativeothers").hide();
    }
  });
});
</script>


    <!-- Third Party Scripts(used by this page)-->
<script src="{{ url('backEnd/plugins/datatables/dataTables.responsive.min.js')}}"></script>
<script src="{{ url('backEnd/plugins/datatables/responsive.bootstrap4.min.js')}}"></script>
<script src="{{ url('backEnd/plugins/datatables/dataTables.buttons.min.js')}}"></script>
<script src="{{ url('backEnd/plugins/datatables/buttons.bootstrap4.min.js')}}"></script>
<script src="{{ url('backEnd/plugins/datatables/jszip.min.js')}}"></script>
<script src="{{ url('backEnd/plugins/datatables/pdfmake.min.js')}}"></script>
<script src="{{ url('backEnd/plugins/datatables/vfs_fonts.js')}}"></script>
<script src="{{ url('backEnd/plugins/datatables/buttons.html5.min.js')}}"></script>
<script src="{{ url('backEnd/plugins/datatables/buttons.print.min.js')}}"></script>
<script src="{{ url('backEnd/plugins/datatables/buttons.colVis.min.js')}}"></script>
<!--Page Active Scripts(used by this page)-->
<script src="{{ url('backEnd/plugins/datatables/data-bootstrap4.active.js')}}"></script>


   <!-- Third Party Scripts(used by this page)-->
                         <script src="{{ url('backEnd/plugins/select2/dist/js/select2.min.js')}}"></script>
                         <script src="{{ url('backEnd/plugins/jquery.sumoselect/jquery.sumoselect.min.js')}}"></script>
                         <!--Page Active Scripts(used by this page)-->
                         <script src="{{ url('backEnd/dist/js/pages/demo.select2.js')}}"></script>
                         <script src="{{ url('backEnd/dist/js/pages/demo.jquery.sumoselect.js')}}"></script>
                         
                         
                                <!-- Third Party Scripts(used by this page)-->
 <script src="{{ url('backEnd/plugins/icheck/icheck.min.js')}}"></script>
 <script src="{{ url('backEnd/plugins/bootstrap4-toggle/js/bootstrap4-toggle.min.js')}}"></script>
 <!--Page Active Scripts(used by this page)-->
 <script src="{{ url('backEnd/dist/js/pages/icheck.active.js')}}"></script>
@if(Request::is('invoice/create') || Request::is('invoice/*/edit') || Request::is('timesheet/create'))
 <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
 <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
 <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>

     <script>
         $(function() {
             $('#datepicker').datepicker({
                 dateFormat: 'dd-mm-yy'
             });
         });
         $(function() {
             $("#datepickers").datepicker({
                 maxDate: new Date,
                 dateFormat: 'dd-mm-yy'
             });
         });
     </script>
 @endif





   <!-- Third Party Scripts(used by this page)-->
   <script src="{{ url('backEnd/plugins/jQuery-mask-plugin/jquery.mask.min.js')}}"></script>
   <script src="{{ url('backEnd/plugins/jQuery-mask-plugin/examples.js')}}"></script>
   <!--Page Active Scripts(used by this page)-->
	<script>
        $(document).keypress(
  function(event){
    if (event.which == '13') {
      event.preventDefault();
    }
});
        </script>
<script>
	$(function(){
    var current = location.pathname;
    $('.metismenu li a').each(function(){
        var $this = $(this);
        // if the current path is like this link, make it active
        if($this.attr('href').indexOf(current) !== -1){
            $this.addClass('mm-active2');
        }
    })
})
</script>
@if(Request::is('assignmentmapping/create') )
<script>
    $(document).ready(function(){
   //     alert('hi');
    $("#EndDate").change(function () {
    var startDate = document.getElementById("StartDate").value;
    var endDate = document.getElementById("EndDate").value;
    //alert(startDate);

    if ((Date.parse(startDate) >= Date.parse(endDate))) {
        alert("End date should be greater than Start date");
        document.getElementById("EndDate").value = "";
    }
    
});
    });

</script>
@endif

@if(Request::is('check-In/create') )

 <script>
      $(function () {
          $('#client_id').on('change', function () {
              var cid = $(this).val();
               //alert(cid);
              $.ajax({
                  type: "get",
                  url: "{{ url('check-In-assignment') }}",
                  data: "cid=" + cid,
                  success: function (res) {
                    console.log(res);

                  //  alert(res);
                      $('#assignment_id').html(res);
                  },
                  error: function () {},
              });
          });
           });

  </script>

 @endif
 
@if(Request::is('reportsection') || Request::is('assignmentevaluationreport'))
 <script src="{{ url('backEnd/plugins/moment/moment.js')}}"></script>
      
 <script src="{{ url('backEnd/plugins/daterangepicker/daterangepicker.active.js')}}"></script> 
  <script src="{{ url('backEnd/plugins/daterangepicker/daterangepicker.js')}}"></script>


    
<script>
     $(function () {
        
          function fetch_work(query='')
 {
  //   alert(query);
  $.ajax({
   type:"GET",
   url: "{{url('reportsection')}}"+"?query="+query,
   success:function(data)
   {
    $('#row').html(data);
    $('#page').hide();
   }
  });
 }
// fetch_products();
 $(document).on('keyup', '#workitem', function(){
  var query = $(workitem).val();
  fetch_work(query);
 });
 


      });

  </script>
  

<script>
$(document).ready(function() {
  var dataTable = $('#tableData').DataTable({
    "processing": true,
    "serverSide": true,
    "paging": true, // Set paging to true
    "lengthMenu": [10, 20, 50, 100], // Set available page lengths
    "pageLength": 20,
    "ajax": {
      "url": "{{ url('filtersection') }}",
      "type": "GET",
      "data": function(d) {
        d.clientid = $("#client").val();
        d.assignmentid = $('#assignment').val();
        d.partnerid = $('#partner').val();
        d.daterange = $('#daterange').val();
        d.employeeid = $('#employee').val();
        d.billableid = $('#billable').val();
        d.workitem = $('#workitem').val();
        d.month = $('#month').val();
        d.length = d.length || 20; // Set length parameter to default to 20
      }
    },
    "columns": [
      { "data": "team_member" },
      { "data": "date" },
      { "data": "client_name" },
      { "data": "assignment_name" },
      { "data": "workitem" },
      { "data": "partnername" },
      { "data": "billable_status" },
      { "data": "hour" },
      { "data": "totalhour" }
    ],
    "initComplete": function(settings, json) {
      $('#tableData thead tr').clone(true).addClass('filters').appendTo('#DataTable thead');
      $('#tableData thead .filters th').each(function() {
        var title = $(this).text();
        var data_name = $(this).data('name');
        if (title == 'SR.' || title == 'Options' || data_name == '#') {
          $(this).html('');
        } else {
          $(this).html('<input type="text" class="form-control" placeholder="' + title +
            '" />');
        }
      });
      $('#tableData thead .filters input').on('keyup change', function() {
        var columnIndex = $(this).parent().index();
        dataTable.column(columnIndex).search($(this).val()).draw();
      });
      console.log(json);
    }
  });
  
  $('#formselect').on('change', function() {
    dataTable.ajax.reload();
  });
});
</script>
<script>
$(document).ready(function(){
//  alert('hi');
    $('#formevv').bind("change keyup", function(){
        var clientid = $("#clientev").val();
        var assignmentid = $('#assignmentev').val();
        var partnerid= $('#partnerev').val();
        var status= $('#status').val();
        var employeeid= $('#employeeev').val();

        $.ajax({
            type: 'get',
            dataType: 'json',
            url: '{{ url('filter/assignmentevaluation') }}',
            data: 'clientid=' + clientid + '&assignmentid=' + assignmentid + '&partnerid=' + partnerid + '&employeeid=' + employeeid + '&status=' + status,
            success: function(data) {
                var tableBody = $('#example tbody');
                tableBody.empty(); // Clear the table body before populating it
                $.each(data, function(index, value) {
                    var statusHtml = "";
                    if (value.status == 0) {
                        statusHtml ="<span class='badge badge-pill badge-warning'>Pending For Evaluation</span>";
                    } else if (value.status == 1) {
                        statusHtml ="<span class='badge badge-pill badge-success'>Evaluated</span>";
                    } else if (value.status == 3) {
                        statusHtml ="<span class='badge badge-pill badge-info'>Assignment Evaluation Created</span>";
                    } else if (value.status == 4) {
                        statusHtml = "<span class='badge badge-pill badge-secondary'>Not Submitted</span>";
                    }
                    var row = $('<tr>');
                    row.append($('<td>').text('AV00'+value.id));
                    row.append($('<td>').html(
                        $('<a>').attr('href', '/view/assignmentevaluation/' + value.id).text(value.creator_team_member)
                    ));
                    row.append($('<td>').text(value.rolename));                    
                    row.append($('<td>').html(statusHtml));
                    row.append($('<td>').text(value.client_name));
                    row.append($('<td>').text(value.assignment_name));
                    row.append($('<td>').text(value.assignmentgenerate_id));
                    row.append($('<td>').text(value.partner_team_member));
                    row.append($('<td>').text(value.end_date_of_assignment));
                    tableBody.append(row);
                });
                // Hide the pagination element
                $('.pagination').hide();
            },
            error: function() {
                alert('Error fetching data.');
            }
        });
    });
});
</script>

    <!--Page Active Scripts(used by this page)-->
 
  @endif
