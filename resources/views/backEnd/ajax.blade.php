<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<script>
    $(function(){
       $('#client').on('change',function(){
           var cid =$(this).val();
       // alert(category_id);
        $.ajax({
            type: "get",
            url: "{{ url('assignmentfunction') }}",
            data: "cid="+cid,
            success : function(res){
              
                $('#assignment_id').html(res);
                debugger;
            },
            error : function(){
            },
        });
       });
     }); 
 </script>