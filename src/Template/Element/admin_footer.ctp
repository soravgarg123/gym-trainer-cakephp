<div class="loading" style="display:none">
           <div class="loading_icon" style="display:none"><span class="fa fa-spin fa-spinner"></span>
           </div>
        </div>
</body>
</html>
<script type="text/javascript">  
$(document).ready(function () {            
$('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
    
  });
});
</script>
<script>
    $(document).ready(function () {
        $('#dataTables-example').dataTable();
        $('.alert-success').fadeOut(15000);
        $('.alert-danger').fadeOut(15000);
    });
</script>

<!-- Hidden Modal Script Start -->
<script type="text/javascript">
    $(document).ready(function(){
    $('#myModal').on('hidden.bs.modal', 'shown.bs.modal', function (e) {
        $('input,select').val("");
        $('#success_msg, #error_msg, img#loading-img').hide();
    });
    });
</script>
<!-- Hidden Modal Script End -->

