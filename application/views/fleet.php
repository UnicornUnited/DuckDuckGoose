<section id="fleet">
    <div class="container-fluid">
        <div class="jumbotron">
            <table class="table">
                <tbody>
                    <tr>
                        <td colspan="5">
                            <h2><span class="glyphicon glyphicon-plane"></span> Fleet Statistics</h2>
                        </td>
                    </tr>
                    <tr>
                        <th>Plane</th>
                        <th><span title="Number of different airports it travels">Airport Count</span></th>
                        <th><span title="Number of different flight it flies">Flight Count</span></th>
                        <th><span title="Earliest Flight">Earliest Flight</span></th>
                        <th><span title="Latest Flight">Latest Flight</span></th>
                    </tr>
                    {plane_items}
                    <tr>
                        <td><a href="/fleet/plane/{id}">{model_id}</a></td>
                        <td>{airport_count}</td>
                        <td>{flight_count}</td>
                        <td>{earliest_depart}({earliest_source}) <span class="glyphicon glyphicon-arrow-right"></span> {earliest_arrive}({earliest_destination})</td>
                        <td>{latest_depart}({earliest_source}) <span class="glyphicon glyphicon-arrow-right"></span> {latest_arrive}({latest_destination})</td>
                    </tr>
                    {/plane_items}
                </tbody>
            </table>
        </div>
    </div>
</section>
