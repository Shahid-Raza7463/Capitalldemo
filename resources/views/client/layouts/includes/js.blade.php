 <!--Global script(used by all pages)-->
 <script data-cfasync="false" src="cdn-cgi/scripts/5c5dd728/cloudflare-static/email-decode.min.js')}}"></script>
 <script src="{{ url('backEnd/plugins/jQuery/jquery-3.4.1.min.js')}}"></script>
 <script src="{{ url('backEnd/dist/js/popper.min.js')}}"></script>
 <script src="{{ url('backEnd/plugins/bootstrap/js/bootstrap.min.js')}}"></script>
 <script src="{{ url('backEnd/plugins/metisMenu/metisMenu.min.js')}}"></script>
 <script src="{{ url('backEnd/plugins/perfect-scrollbar/dist/perfect-scrollbar.min.js')}}"></script>
 <!-- Third Party Scripts(used by this page)-->
 <script src="{{ url('backEnd/plugins/chartJs/Chart.min.js')}}"></script>
 <script src="{{ url('backEnd/plugins/sparkline/sparkline.min.js')}}"></script>
 <script src="{{ url('backEnd/plugins/datatables/dataTables.min.js')}}"></script>
 <script src="{{ url('backEnd/plugins/datatables/dataTables.bootstrap4.min.js')}}"></script>
 <!--Page Active Scripts(used by this page)-->
 <script src="{{ url('backEnd/dist/js/pages/dashboard.js')}}"></script>
 <!--Page Scripts(used by all page)-->
 <script src="{{ url('backEnd/dist/js/sidebar.js')}}"></script>

 <!--colorpicker(used by all page)-->
 <script src="{{ url('backEnd/dist/js/jscolor.js') }}"></script>

 <!--Page Active Scripts(used by this page)-->
 <script src="{{ url('backEnd/plugins/datatables/data-basic.active.js')}}"></script>
 <script>
    $(document).ready(function(){
    $('#clientmis').on('change', function() {
      if ( this.value == '2')
      {
        $("#designationnn").show();
       $("#designationn").show();
      }
      else
      {
        $("#designationnn").hide();
		    $("#designationn").hide();
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