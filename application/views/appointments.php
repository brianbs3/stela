<div class="container-fluid">
    <div class="row">
        <div class="col-2">
            <div id="datepicker"></div>
            <div id="datepickerNext"></div>
        </div>
        <div class="col-10 appointments-right">
            col 2
        </div>
</div>




<script>
  $( function() {
    $( "#datepicker" ).datepicker({
     numberOfMonths: [2,1]
    });
  } );
  </script>