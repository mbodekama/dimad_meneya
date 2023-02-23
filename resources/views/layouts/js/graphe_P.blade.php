<script type="text/javascript">
$(function()
  {

      var myjs = {{ json_encode(vntMois()) }};
      var lastMonthdata = {{ json_encode(vntOtherMois()) }};
      /*-----------------------------------------------
      |   Chart
      -----------------------------------------------*/
      window.utils.$document.ready(function () {
        /*-----------------------------------------------
        |   Helper functions and Data
        -----------------------------------------------*/
        var _window = window,
            utils = _window.utils;
        var chartData = myjs;

        //Fonction des generation des labels
          function generateLab(moiChoix)
          {
            const d = new Date();
            var numMois = d.getMonth();
            //Initialisation de la fin
            var fin  = d.getDate();
            if (moiChoix == 'lastMois') { numMois +=1 ; fin = new Date(d.getYear(), d.getMonth(), 0).getDate();}
              //Tableau de la liste des nom des mois
              var tab_mois = new Array("Janvier", "Février", "Mars", "Avril", "Mai", "Juin", "Juillet", "Août", "Septembre", "Octobre", "Novembre", "Décembre");

              // Modif valeur text des option du select dans le graphe
                $('#thisMois').text(tab_mois[d.getMonth()]);
                $('#lastMois').text(tab_mois[d.getMonth()-1]);
              //Coupure du nom du mois en cours
              var mois =' '+tab_mois[numMois].substring(0,2);

                //Initialisation du tableau de valeur
                var labels = new Array();
                for(var i = 0; i <fin; i++) 
                {
                 labels[i]=i+1;
                 labels[i] +=mois;
                }
                return labels;
          }

        //Varaible pour get le resultat de la fonction generateLabel
          var labels = new Array();
          labels = generateLab('thisMois');

        /*-----------------------------------------------
        |   Chart Initialization
        -----------------------------------------------*/
        var newChart = function newChart(chart, config) {
          var ctx = chart.getContext('2d');
          return new window.Chart(ctx, config);
        };


        /*-----------------------------------------------
        |   Custom Line Chart  for Principal Dashbord 
        -----------------------------------------------*/
        var chartLine = document.getElementById('myChart');
        if (chartLine) {
          var getChartBackground = function getChartBackground(chart) {
            var ctx = chart.getContext('2d');

            if (storage.isDark) {
              var _gradientFill = ctx.createLinearGradient(0, 0, 0, ctx.canvas.height);

              _gradientFill.addColorStop(0, utils.rgbaColor(utils.colors.primary, 0.5));

              _gradientFill.addColorStop(1, 'transparent');

              return _gradientFill;
            }

            var gradientFill = ctx.createLinearGradient(0, 0, 0, 250);
            gradientFill.addColorStop(0, 'rgba(255, 255, 255, 0.3)');
            gradientFill.addColorStop(1, 'rgba(255, 255, 255, 0)');
            return gradientFill;
          };

          var dashboardLineChart = newChart(chartLine, {
            type: 'line',
            data: {
              labels: labels.map(function (label) {
                return label.substring(0, 5);
              }),
              datasets: [{
                borderWidth: 2,
                data: chartData.map(
                  function (d) {
                  return d;
                  // return (d * 3.14).toFixed(2);
                }),
                borderColor: utils.settings.chart.borderColor,
                backgroundColor: getChartBackground(chartLine)
              }]
            },
            options: {
              legend: {
                display: false
              },
              tooltips: {
                mode: 'x-axis',
                xPadding: 20,
                yPadding: 10,
                displayColors: false,
                callbacks: {
                  label: function label(tooltipItem) {
                    return labels[tooltipItem.index] + " - " + tooltipItem.yLabel + " {{ getMyDevise() }}";
                  },
                  title: function title() {
                    return null;
                  }
                }
              },
              hover: {
                mode: 'label'
              },
              scales: {
                xAxes: [{
                  scaleLabel: {
                    show: true,
                    labelString: 'Month'
                  },
                  ticks: {
                    fontColor: utils.rgbaColor('#fff', 0.7),
                    fontStyle: 600
                  },
                  gridLines: {
                    color: utils.rgbaColor('#fff', 0.1),
                    zeroLineColor: utils.rgbaColor('#fff', 0.1),
                    lineWidth: 1
                  }
                }],
                yAxes: [{
                  display: false
                }]
              }
            }
          });
          $('#dashboard-chart-select').on('change', function (e) {

            // labels = generateLab('thisMois');

            var LineDB = {
              thisMois:myjs.map(function (d) {
                // return (d * 3.14).toFixed(2);
                 return d;

              }),
              lastMois: lastMonthdata.map(function (d) {
                // return (d * 3.14).toFixed(2);
                 return d;
              })
            };

            var LabelDB = {
              thisMois:generateLab('thisMois').map(function (d) {
                // return (d * 3.14).toFixed(2);
                 return d;

              }),
              lastMois: generateLab('lastMois').map(function (d) {
                // return (d * 3.14).toFixed(2);
                 return d;
              })
            };
            dashboardLineChart.data.datasets[0].data = LineDB[e.target.value];
            dashboardLineChart.data.labels = LabelDB[e.target.value];
            dashboardLineChart.options.tooltips.callbacks = {
                  label: function label(tooltipItem) {
                    return LabelDB[e.target.value][tooltipItem.index] + " - " + tooltipItem.yLabel + " {{ getMyDevise() }}";
                  },
                  title: function title() {
                    return '';
                  }
                };
            dashboardLineChart.update();
          });
        }

      });




  })

</script>