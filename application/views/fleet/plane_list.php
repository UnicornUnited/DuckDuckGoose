<section id="fleet">
    <div class="container-fluid">
        <div class="jumbotron">
            <table>
                <tbody>
                <tr>
                    <td colspan="2"><h1>Duck Duck Goose</h1></td>
                </tr>
                <tr>
                    <td colspan="2"><h2>Planes in Fleet</h2></td>
                </tr>
                {plane_items}
                <tr>
                    <td>Name:</td>
                    <td><a href="/fleet/plane/{key}">{key}</a></td>
                </tr>
                {/plane_items}
                </tbody>
            </table>
        </div>
    </div>
</section>
