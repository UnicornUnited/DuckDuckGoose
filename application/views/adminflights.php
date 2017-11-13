<div class="container-fluid">
    <div class="jumbotron">
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
                    {flightdata}
<!--                    The Idea is that the next block can trigger a function (call it update) that uses all the data and-->
<!--                    updates the CSV file.-->
                    <form action="/flights/update" method="post">
                    <tr>
                        <td title="{plane}"><input type="text" name="id" value="{id}" readonly="true"></td>
                        <td title="{plane}">{plane_selection}</td>
                        <td title="{depart_airport}">{depart_selection}</td>
                        <td title="{depart_time}"><input type="text" name="depart_time" value="{depart_time}"></td>
                        <td title="{arrive_airport}">{arrive_selection}</td>
                        <td title="{arrive_time}"><input type="text" name="arrive_time" value="{arrive_time}"></td>
                        <td><a href=><input class="btn btn-success" type="submit" value="Update"></a></td>
                    </tr>
                    </form>
                    {/flightdata}
                    <tr>
                        <td colspan="7">Add New Flight</td>
                    </tr>
                    <form action="/flights/add" method="post">
                    <tr>
                        <td title="{plane}"><input type="text" name="id" value="Auto Assigned" disabled="true"></td>
                        <td title="{plane}">{add_plane_selection}</td>
                        <td title="{depart_airport}">{add_depart_selection}</td>
                        <td title="{depart_time}"><input type="text" name="depart_time" value=""></td>
                        <td title="{arrive_airport}">{add_arrive_selection}</td>
                        <td title="{arrive_time}"><input type="text" name="arrive_time" value=""></td>
                        <td><a href=><input class="btn btn-success" type="submit" value="Add"></a></td>
                    </tr>
                    </form>
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
