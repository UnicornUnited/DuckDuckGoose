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
                    <form action="/flights/update" method="post">
                    <tr>
                        <td title="{plane}"><input type="text" name="id" value="{id}"></td>
                        <td title="{depart_airport}"><input type="text" name="depart_airport" value="{depart_airport}"></td>
                        <td title="{depart_time}"><input type="text" name="depart_time" value="{depart_time}"></td>
                        <td title="{arrival_airport}"><input type="text" name="arrival" value="{arrival}"></td>
                        <td title="{arrival_time}"><input type="text" name="arrival_time" value="{arrival_time}"></td>
                        <td><a href=><input class="btn btn-success" type="submit" value="Update"></a></td>
                    </tr>
                    </form>
                    {/flightdata}
                </table>
            </div>
        <!-- Button trigger modal -->
        <a href="/flights/add">
            <button type="button" class="btn btn-primary">
                Add Flight
            </button>
        </a>
    </div>
</div>
