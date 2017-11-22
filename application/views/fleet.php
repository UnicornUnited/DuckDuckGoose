<section id="fleet">
    <div class="container-fluid">
        <div class="jumbotron">
            <table class="table">
                <tbody>
                    <tr>
                        <td colspan="6">
                            <h2><span class="glyphicon glyphicon-plane"></span> Fleet Statistics</h2>
                        </td>
                    </tr>
                    <tr>
                        <th>Plane</th>
<!--                        <th><span title="Number of plane in fleet">Available Count</span></th>
                        <th><span title="Number of different airports it visits">Airport Count</span></th>
                        <th><span title="Number of different flight it flies">Flight Count</span></th>-->
                    </tr>
                    {plane_items}
                    <tr>
                        <td><a href="/fleet/plane/{id}">{model_id}</a></td>
<!--                        <td>{plane_count}</td>
                        <td>{airport_count}</td>
                        <td>{flight_count}</td>-->
                    </tr>
                    {/plane_items}
                </tbody>
            </table>
        </div>
    </div>
</section>
