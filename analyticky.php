<!-- APU Schedule by jonathan law -->
<html lang="en">
<head>
	<title>APU/APIIT Schedule</title>
	<?php include('fragment/frameworkImports.html'); ?>
	<meta name="theme-color" content="#39393b">
  <script src="https://code.highcharts.com/highcharts.src.js"></script>
  <script src="https://code.highcharts.com/modules/wordcloud.js"></script>
  <style>
	body { display: flex; min-height: 100vh; flex-direction: column; } main {  flex: 1 0 auto; background-color:#39393b;}
	#wordchart{ width:85%; }
  </style>
</head>

<body>
  <main><div id="wordchart" style="margin-top:50px;"></div></main>
	<footer class="page-footer grey darken-3" id="meme"><div class="footer-copyright grey darken-4"><div class="container">APU-Schedule <a href="https://apu-schedule.azurewebsites.net">here</a><br></div></div></footer>
</body>

<script>
Highcharts.createElement('link', { href: 'https://fonts.googleapis.com/css?family=Unica+One', rel: 'stylesheet', type: 'text/css' }, null, document.getElementsByTagName('head')[0]);
Highcharts.theme = {
    colors: ['#2b908f', '#90ee7e', '#f45b5b', '#7798BF', '#aaeeee', '#ff0066', '#eeaaee', '#55BF3B', '#DF5353', '#7798BF', '#aaeeee'],
    chart: { backgroundColor: '#39393b', style: { fontFamily: '\'Unica One\', sans-serif' }, plotBorderColor: '#606063'},
    title: { style: { color: '#E0E0E3', textTransform: 'uppercase', fontSize: '20px' }},
    subtitle: { style: { color: '#E0E0E3', textTransform: 'uppercase' }},
    xAxis: { gridLineColor: '#707073', labels: { style: { color: '#E0E0E3' }}, lineColor: '#707073', minorGridLineColor: '#505053', tickColor: '#707073', title: { style: { color: '#A0A0A3' }}},
    yAxis: { gridLineColor: '#707073', labels: { style: { color: '#E0E0E3' }}, lineColor: '#707073', minorGridLineColor: '#505053', tickColor: '#707073', tickWidth: 1, title: { style: { color: '#A0A0A3' }}},
    tooltip: { backgroundColor: 'rgba(0, 0, 0, 0.85)', style: { color: '#F0F0F0' }},
    plotOptions: { series: { dataLabels: { color: '#B0B0B3' }, marker: { lineColor: '#333' }}, boxplot: { fillColor: '#505053' }, candlestick: { lineColor: 'white' }, errorbar: { color: 'white' }},
    legend: { itemStyle: { color: '#E0E0E3' }, itemHoverStyle: { color: '#FFF' }, itemHiddenStyle: { color: '#606063' }},
    credits: { style: { color: '#666' }},
    labels: { style: { color: '#707073' } },
    drilldown: { activeAxisLabelStyle: { color: '#F0F0F3' }, activeDataLabelStyle: { color: '#F0F0F3' }},
    navigation: { buttonOptions: { symbolStroke: '#DDDDDD', theme: { fill: '#505053' }}},
    // scroll charts
    rangeSelector: {
        buttonTheme: { fill: '#505053', stroke: '#000000', style: { color: '#CCC' },
            states: { hover: { fill: '#707073', stroke: '#000000', style: { color: 'white' }}, select: { fill: '#000003', stroke: '#000000', style: { color: 'white' }}}
        },
        inputBoxBorderColor: '#505053', inputStyle: { backgroundColor: '#333', color: 'silver' }, labelStyle: { color: 'silver' }
    },
    navigator: {
        handles: { backgroundColor: '#666', borderColor: '#AAA' }, outlineColor: '#CCC', maskFill: 'rgba(255,255,255,0.1)', series: { color: '#7798BF', lineColor: '#A6C7ED' }, xAxis: { gridLineColor: '#505053' }
    },
    scrollbar: {
        barBackgroundColor: '#808083', barBorderColor: '#808083', buttonArrowColor: '#CCC', buttonBackgroundColor: '#606063', buttonBorderColor: '#606063', rifleColor: '#FFF', trackBackgroundColor: '#404043', trackBorderColor: '#404043'
    },
    // special colors for some of the
    legendBackgroundColor: 'rgba(0, 0, 0, 0.5)', background2: '#505053', dataLabelsColor: '#B0B0B3', textColor: '#C0C0C0', contrastTextColor: '#F0F0F3', maskColor: 'rgba(255,255,255,0.3)'
};

// Apply the theme
Highcharts.setOptions(Highcharts.theme);
var text = "<?php $list = fopen("data/analytica.txt", "r"); while(!feof($list)) { echo trim(fgets($list)); } fclose($list); ?>";
var lines = text.split(/[,]+/g),
data = Highcharts.reduce(lines, function (arr, word) {
    var obj = Highcharts.find(arr, function (obj) { return obj.name === word; });
    if (obj) { obj.weight += 1; } else { obj = { name: word, weight: 1 }; arr.push(obj); }
    return arr;
}, []);

Highcharts.chart('wordchart', { series: [{ type: 'wordcloud', data: data, name: 'Occurrences' }], title: { text: 'apu-schedule.azurewebsites.net analyticky result' }});
</script>
</html>
