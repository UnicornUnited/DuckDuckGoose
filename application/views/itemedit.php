<div class="container-fluid">
    <div class="jumbotron">
        <h2><strong>Add new flight data:</strong></h2>
        <form role="form" action="/flights/submit" method="post">
            <div class="form-group">
                {fid}
            </div>
            <div class="form-group">{fplaneid}</div>
            <div class="form-group">{fdepart}</div>
            <div class="form-group">{fdepart_airport}</div>
            <div class="form-group">{fdepart_time}</div>
            <div class="form-group">{farrival}</div>
            <div class="form-group">{farrival_airport}</div>
            <div class="form-group">{farrival_time}</div>
            <div class="form-group">{zsubmit}</div>
        </form>
        {error}
        <a href="/flights"><input class="btn btn-primary" type="button" value="Cancel the current edit"/></a>
        <!--id,planeid,depart,depart_airport,depart_time,arrival,arrival_airport,arrival_time-->
    </div>
</div>
