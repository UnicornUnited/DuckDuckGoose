<div class="container-fluid">
    <div class="jumbotron">
        <table id="flights">
            <tr>
                <th>Flight ID</th>
                <th>Departure Airport</th>
                <th>Departure Time</th>
                <th>Arrival Airport</th>
                <th>Arrive Time</th>
            </tr>
            {flightdata}
            <tr>
                <td title="{plane}">{id}</td>
                <td title="{depart_airport}">{depart}</td>
                <td>{depart_time}</td>
                <td title="{arrival_airport}">{arrival}</td>
                <td>{arrival_time}</td>
            </tr>
            {/flightdata}
        </table>
    </div>
</div>


