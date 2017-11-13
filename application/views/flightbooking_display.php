<div class="container-fluid">
    <div class="jumbotron">
        <!--Display all flights that match the departure and 
        destination airports.-->
        <div class="table-responsive">
            <table class="table">
                <tr>
                    <th>Flight ID</th>
                    <th>Plane</th>
                    <th>Departure Airport</th>
                    <th>Departure Time</th>
                    <th>Arrival Airport</th>
                    <th>Arrival Time</th>
                </tr>
                {availableflights}
                <tr>
                    <td title="{plane}">{id}</td>
                    <td title="{plane}">{model_id}</td>
                    <td title="{depart_airport}">{depart}</td>
                    <td>{depart_time}</td>
                    <td title="{arrive_airport}">{arrive}</td>
                    <td>{arrive_time}</td>
                </tr>
                {/availableflights}
            </table>
        </div>
    </div>
</div>
