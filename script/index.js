var options = {
    series: [
    {
      name: "кандидатов",
      data: [1380, 1100, 990, 880, 740, 548, 330, 200],
    },
  ],
    chart: {
    type: 'bar',
    height: 350,
  },
  plotOptions: {
    bar: {
      borderRadius: 0,
      horizontal: true,
      barHeight: '80%',
      isFunnel: true,
    },
  },
  dataLabels: {
    enabled: true,
    formatter: function (val, opt) {
      return opt.w.globals.labels[opt.dataPointIndex] + ':  ' + val
    },
    dropShadow: {
      enabled: true,
    },
  },
  title: {
    text: 'Воронка найма',
    align: 'middle',
  },
  xaxis: {
    categories: [
      '1 этап',
      '2 этап',
'3 этап',
'4 этап',
'5 этап',
'6 этап',
'7 этап',
'8 этап',
    ],
  },
  legend: {
    show: false,
  },
  };

  var chart = new ApexCharts(document.querySelector("#funnel"), options);
  chart.render();

