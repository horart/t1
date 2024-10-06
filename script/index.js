fetch('analytics.php?type=funnel').then(response=>response.json()).then(response=>{
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

document.addEventListener('DOMContentLoaded', function() {
  function updateForm() {
    sel = document.querySelector('.form-option').value;
    document.querySelector('.create-form').action = 'create.php?type=' + sel;
    document.querySelectorAll('.create-option').forEach(function(e) {
      if(!e.classList.contains(sel)) {
        e.classList.add('hidden');
        e.querySelectorAll('input, select').forEach(e=>{e.required = false});
      }
      else {
        e.classList.remove('hidden');
        e.querySelectorAll('input, select').forEach(e=>{e.required = true});

      }
    });
  }
  document.querySelector('.form-option').addEventListener('change', updateForm)
  updateForm();


});