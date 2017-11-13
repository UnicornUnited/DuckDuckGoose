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
                    <tr>
                        <td title="{plane}">{id}</td>
                        <td title="{plane}">{plane}</td>
                        <td title="{depart_airport}">{depart}</td>
                        <td>{depart_time}</td>
                        <td title="{arrive_airport}">{arrive}</td>
                        <td>{arrive_time}</td>
                    </tr>
                    {/flightdata}
                </table>
        </div>
    </div>
</div>

<!--id,name,type,speed-->
<!--1,caravan,Grand Caravan Ex,340-->
<!--2,pc12ng,PC-12 NG,500-->
<!--3,phenom100,Phenom 100,704-->


