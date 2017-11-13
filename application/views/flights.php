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
                <tr>
                    <td title="{plane}"><a href="fleet/plane/{planeid}">{id}</a></td>
                    <td title="{depart_airport}">{depart}</td>
                    <td>{depart_time}</td>
                    <td title="{arrival_airport}">{arrival}</td>
                    <td>{arrival_time}</td>
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


