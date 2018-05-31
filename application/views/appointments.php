<div class="container-fluid">
    <div class="row">
        <div class="col-md- appointments-left">
            col 1
            <div id="calendar"></div>
        </div>
        <div class="col-xl appointments-right">
            col 2
        </div>
</div>

    <script type="text/javascript">
        var calendar = $('#calendar').calendar({events_source: 'public/events.json.php'});
    </script>