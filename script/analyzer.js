let dd = Array.from(Array(1000).keys())
    .map(e => new Date(new Date().getTime()+e*24*60*60*1000));
let pp = Array.from(Array(1000).keys());
var options = {
    series: [{
      name: "резюме",
      data: [...pp.keys()].map(k => [dd[k], pp[k]])
  }],
    chart: {
    height: 350,
    type: 'line',
    zoom: {
      enabled: false
    }
  },
  dataLabels: {
    enabled: false
  },
  stroke: {
    curve: 'straight'
  },
  grid: {
    row: {
      colors: ['#f3f3f3', 'transparent'], // takes an array which will be repeated on columns
      opacity: 0.5
    },
  },
  xaxis: {
    type: 'datetime',
  }
  };

  var chart = new ApexCharts(document.querySelector("#processedresumes"), options);
  chart.render();



      
  var options = {
    series: [{
    name: 'интервью',
    data: [5, 2, 1]
  }],
    chart: {
    height: 350,
    type: 'bar',
  },
  plotOptions: {
    bar: {
      borderRadius: 10,
      dataLabels: {
        position: 'top', // top, center, bottom
      },
    }
  },
  dataLabels: {
    enabled: true,
    formatter: function (val) {
      return val;
    },
    offsetY: -20,
    style: {
      fontSize: '12px',
      colors: ["#304758"]
    }
  },
  
  xaxis: {
    categories: ["Разработчик C++", "Тестировщик", "Менеджер"],
    position: 'top',
    axisBorder: {
      show: false
    },
    axisTicks: {
      show: false
    },
    crosshairs: {
      fill: {
        type: 'gradient',
        gradient: {
          colorFrom: '#D8E3F0',
          colorTo: '#BED1E6',
          stops: [0, 100],
          opacityFrom: 0.4,
          opacityTo: 0.5,
        }
      }
    },
    tooltip: {
      enabled: true,
    }
  },
  yaxis: {
    axisBorder: {
      show: false
    },
    axisTicks: {
      show: false,
    },
    labels: {
      show: false,
      formatter: function (val) {
        return val + " интервью";
      }
    }
  
  },
  };

  var chart = new ApexCharts(document.querySelector("#interview"), options);
  chart.render();


  var options = {
    series: [44, 55, 13, 43, 22],
    chart: {
    width: 500,
    type: 'pie',
  },
  labels:
   ['Отказано', 'Первичное собеседование', 'Техническое собеседование', 'Оффер', 'Штат'],
    responsive: [{
    breakpoint: 480,
    options: {
      chart: {
        width: 200
      },
      legend: {
        position: 'bottom'
      }
    }
  }]
  };

  var chart = new ApexCharts(document.querySelector("#closed"), options);
  chart.render();
function updateChart() {
  let s = '';
  if(datefrom.value && dateto.value) s = '&date_from=' + datefrom.value + '&date_to=' + dateto.value;
  fetch('analytics.php?type=funnel'+s).then(response=>response.json()).then(response=>{
    var options = {
      series: [
      {
        name: "кандидатов",
        data: response['data'],
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
      text: 'Воронка найма за месяц',
      align: 'middle',
    },
    xaxis: {
      categories: response['cats'],
    },
    legend: {
      show: false,
    },
    };
  
    var chart = new ApexCharts(document.querySelector("#funnel"), options);
    chart.render();
  
  });
}
updateChart();
document.querySelector('#update').addEventListener('click', updateChart);

        
  var options = {
    series: [{
    data: [5, 10, 20, 30, 40, 50],
    name: 'дней',
  }],
    chart: {
    type: 'bar',
    height: 350
  },
  plotOptions: {
    bar: {
      borderRadius: 4,
      borderRadiusApplication: 'end',
      horizontal: true,
    }
  },
  dataLabels: {
    enabled: true,
    formatter: (f=>f + ' дн.')
  },
  xaxis: {
    categories: [
      'Василий', 'Ольга', "Анна", "Артём", "Дарья", "Елена"
    ],
    title: 'дней'
  }
  };

  var chart = new ApexCharts(document.querySelector("#recruiters"), options);
  chart.render();
