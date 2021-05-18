<x-admin-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <h3 class="evogria mb-3">Dashboard</h3>

        <div class="row align-items-center charts">
            <div class="col-12">
                <h5 class="mb-3 mt-2">Analytics for the last 3 Months</h5>
                <hr>
            </div>
            <div class="col-12 col-lg-5 mb-3 chart">
                <canvas id="mostviewed" aria-label="Most Views 3 Months" role="img"></canvas>
            </div>
            <div class="col-12 col-lg-7 chart">
                <canvas id="usertype" aria-label="User Type 3 Months" role="img"></canvas>
            </div>
            <div class="col-12 chart">
                <canvas id="totalViews" aria-label="Total Views in 3 Months" role="img"></canvas>
            </div>
        </div>
    </div>

    @section('js')
    <script>
        var primary = '#4A2984'
        var secondary = '#c614cc';
        var blue = '#4c57d3';
        var pink = '#f186b0';

        var mv =  {!!json_encode($mostVisited3)!!}
        var pageTitle = [];
        var pageViews = [];
        mv.forEach(element => {
            pageTitle.push(element.pageTitle.substr(0, 15))
            pageViews.push(element.pageViews)
        });

        var mostViewedData = {
            labels: pageTitle,
            datasets: [{
                label: 'Total Views',
                backgroundColor: [primary,secondary, blue, 'lightgrey', pink],
                data: pageViews
            }]
        };

        var ut =  {!!json_encode($fetchUser3)!!}
        var sessions = [];
        var type = [];
        // console.log(ut)
        ut.forEach(element => {
            sessions.push(element.sessions)
            type.push(element.type)
        });

        var fetchedUsers = {
            labels: type,
            datasets: [{
                label: 'Total Users',
                backgroundColor: [primary,secondary, blue, 'lightgrey', pink],
                data: sessions
            }]
        };

        var tv =  {!!json_encode($totalVisitors1)!!}
        var date = [];
        var pageViews = [];
        console.log(tv)
        tv.forEach(element => {
            date.push(element.date.substr(0, 10))
            pageViews.push(element.pageViews)
        });

        var totalVisitors = {
            labels: date,
            datasets: [{
                label: 'Page Views',
                backgroundColor: [primary],
                data: pageViews
            }]
        };

        window.onload = function() {
            var ctx = document.getElementById("mostviewed").getContext("2d");
            window.myBar = new Chart(ctx, {
                type: 'pie',
                data: mostViewedData,
                options: {
                    responsive: true,
                    title: {
                        display: true,
                        text: 'Most Visited Pages'
                    }
                }
            });

            var ctxUt = document.getElementById("usertype").getContext("2d");
            window.myBar = new Chart(ctxUt, {
                type: 'bar',
                data: fetchedUsers,
                options: {
                    elements: {
                        rectangle: {
                            borderWidth: 2,
                            borderColor: '#c1c1c1',
                        }
                    },
                    indexAxis: 'y',
                    responsive: true,
                    title: {
                        display: true,
                        text: 'Fetch Users'
                    }
                }
            });

            var ctxTv = document.getElementById("totalViews").getContext("2d");
            window.myBar = new Chart(ctxTv, {
                type: 'line',
                data: totalVisitors,
                options: {
                    responsive: true,
                    title: {
                        display: true,
                        text: 'Fetch Users'
                    }
                }
            });
        };
    </script>
    @endsection
</x-admin-layout>
