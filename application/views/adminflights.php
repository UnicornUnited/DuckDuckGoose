<div class="container-fluid">
    <div class="jumbotron">
            <div class="table-responsive">
                <table class="table">
                    <tr>
                        <th>Flight ID</th>
                        <th>Departure Airport</th>
                        <th>Departure Time</th>
                        <th>Arrival Airport</th>
                        <th>Arrive Time</th>
                    </tr>
                    {flightdata}
<!--                    The Idea is that the next block can trigger a function (call it update) that uses all the data and-->
<!--                    updates the CSV file.-->
                    <tr>
                        <td title="{plane}"><input type="text" value="{id}"></td>
                        <td title="{depart_airport}"><input type="text" value="{depart_airport}"></td>
                        <td title="{depart_time}"><input type="text" value="{depart_time}"></td>
                        <td title="{arrival_airport}"><input type="text" value="{arrival}"></td>
                        <td title="{arrival_time}"><input type="text" value="{arrival_time}"></td>
                        <td><a href="/flights/update/{id}/{depart_airport}/{depart_time}/{arrival}/{arrival_time}"><input class="btn btn-success" type="button" value="Submit"></a></td>
                    </tr>
                    {/flightdata}
                </table>
            </div>
    </div>
</div>