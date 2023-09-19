<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <title>SF-AdTech</title>
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <a class="navbar-brand" href="#">
            <img src="{{ asset('storage') . '/favicon.svg' }}" width="30" height="30" class="d-inline-block align-top" alt="">
            SF-AdTech
        </a>
        @auth("web")
        <ul class="navbar-nav ml-auto">
            <li class="nav-item">
                <a class="nav-link" href="{{ route("logout") }}">Выйти</a>
            </li>
        </ul>
        @endauth
        </div>
    </nav>

    @role('Работодатель')
    <figure class="highcharts-figure">
        <div id="container" style="width: 50%; margin-top: 100px; margin-left: 450px;"></div>
    </figure>
    @endrole

</body>
<script src="https://code.highcharts.com/highcharts.js"></script>
<script src="https://code.highcharts.com/highcharts-more.js"></script>
<script src="https://code.highcharts.com/modules/dumbbell.js"></script>
<script src="https://code.highcharts.com/modules/lollipop.js"></script>
<script src="https://code.highcharts.com/modules/exporting.js"></script>
<script src="https://code.highcharts.com/modules/accessibility.js"></script>
<script type="text/javascript">
var offerData = <?php echo json_encode($offerData)?>;
var now = new Date();
var monthName = now.toLocaleString('default', { month: 'long' });
Highcharts.chart('container', {

chart: {
    type: 'lollipop'
},

accessibility: {
    point: {
        valueDescriptionFormat: '{index}. {xDescription}, {point.y}.'
    }
},

legend: {
    enabled: false
},

subtitle: {
        text: monthName
    },

title: {
    text: 'Количество переходов'
},

tooltip: {
    shared: true
},

xAxis: {
    type: 'category'
},

yAxis: {
    title: {
        text: 'Переходы'
    }
},

series: [{
    name: 'Переходы',
    data: [{
        name: '1',
        y: 1444216107
    }, {
        name: '2',
        y: 1393409038
    }, {
        name: '3',
        y: 332915073
    }, {
        name: '4',
        y: 276361783
    }, {
        name: '5',
        y: 225199937
    }, {
        name: '6',
        y: 213993437
    }, {
        name: '7',
        y: 211400708
    }, {
        name: '8',
        y: 166303498
    }, {
        name: '9',
        y: 145912025
    }, {
        name: '10',
        y: 130262216
    }]
}]

});
</script>
</html>