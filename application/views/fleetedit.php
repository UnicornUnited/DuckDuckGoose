<section id="fleet">
    <div class="container-fluid">
        <div class="jumbotron">
            <table class="table">
                <tbody>
                    <tr>
                        <td colspan="7">
                            <h2><span class="glyphicon glyphicon-plane"></span> Manage Our Fleet</h2>
                        </td>
                    </tr>
                    <tr>
                        <th>Plane Id</th>
                        <th>Model</th>
                        <th>Price (CAD)</th>
                        <th><span title="Number of different airports it stops at">Airport Count</span></th>
                        <th><span title="Number of different flight it is assigned to">Flight Count</span></th>
                        <th><span title="Earliest Flight">Earliest Flight</span></th>
                        <th><span title="Latest Flight">Latest Flight</span></th>
                    </tr>
                    {plane_items}
                    <tr>
                        <td>
                            <a href="/fleet/plane/{id}">
                                <button type="button" class="btn btn-primary">{id}</button>
                            </a>
                        </td>
                        <td>{model_id}</td>
                        <td>{price}</td>
                        <td>{airport_count}</td>
                        <td>{flight_count}</td>
                        <td>{earliest_depart}({earliest_source}) <span class="glyphicon glyphicon-arrow-right"></span> {earliest_arrive}({earliest_destination})</td>
                        <td>{latest_depart}({earliest_source}) <span class="glyphicon glyphicon-arrow-right"></span> {latest_arrive}({latest_destination})</td>
                    </tr>
                    {/plane_items}
                    <tr>
                        <td colspan="7">
                            <div class="btn-group btn-group-sm" role="group" aria-label="Basic example">
                            <button type="button" class="btn btn-primary">Total Plane</button>
                            <button type="button" class="btn btn-default">{plane_count}</button>
                            </div>
                            <div class="btn-group btn-group-sm" role="group" aria-label="Basic example">
                            <button type="button" class="btn btn-primary">Available Budget (CAD)</button>
                            <button type="button" class="btn btn-default">{available_budget}</button>
                            </div>
                        </td>
                    </tr>
                    <form action="/fleet/buy" method="post">
                    <tr>
                        <td colspan="7">Buy one plane of selected model: {plane_selection}
                        <input class="btn btn-success" type="submit" value="Buy it!"></td>
                    </tr>
                    </form>
                </tbody>
            </table>
        </div>
    </div>
</section>
