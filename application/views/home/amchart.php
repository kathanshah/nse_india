
<div class="container">
    <div class="row">
        <h3>Chart</h3>
        <div id="chartdiv" style="width:100%;height:500px;"></div>
    </div>
</div>

<script src="https://unpkg.com/vue"></script>
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js" integrity="sha384-smHYKdLADwkXOn1EmN1qk/HfnUcbVRZyYmZ4qpPea6sjB/pTJ0euyQp0Mk8ck+5T" crossorigin="anonymous"></script>
<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
<script>const base_url = "<?=base_url()?>";</script>
<script id="data" type="application/json"><?php echo json_encode($data); ?></script>
<script src="https://www.amcharts.com/lib/3/amcharts.js"></script>
<script src="https://www.amcharts.com/lib/3/serial.js"></script>
<script src="https://www.amcharts.com/lib/3/amstock.js"></script>
<script src="https://www.amcharts.com/lib/3/plugins/dataloader/dataloader.min.js"></script>
<script src="https://www.amcharts.com/lib/3/plugins/export/export.min.js"></script>
<link rel="stylesheet" href="https://www.amcharts.com/lib/3/plugins/export/export.css" type="text/css" media="all" />
<script src="https://www.amcharts.com/lib/3/themes/light.js"></script>
<script>
var chart = AmCharts.makeChart( "chartdiv", {
  "type": "stock",
"theme": "light",

  //"color": "#fff",
  "dataSets": [ {
    "title": "MSFT",
    "fieldMappings": [ {
      "fromField": "Open",
      "toField": "open"
    }, {
      "fromField": "High",
      "toField": "high"
    }, {
      "fromField": "Low",
      "toField": "low"
    }, {
      "fromField": "Close",
      "toField": "close"
    }, {
      "fromField": "Volume",
      "toField": "volume"
    } ],
    "compared": false,
    "categoryField": "Date",

    /**
     * data loader for data set data
     */
    "dataLoader": {
      "url": "https://www.amcharts.com/wp-content/uploads/assets/stock/MSFT.csv",
      "format": "csv",
      "showCurtain": true,
      "showErrors": true,
      "async": true,
      "reverse": true,
      "delimiter": ",",
      "useColumnNames": true
    },

  }, {
    "title": "TXN",
    "fieldMappings": [ {
      "fromField": "Open",
      "toField": "open"
    }, {
      "fromField": "High",
      "toField": "high"
    }, {
      "fromField": "Low",
      "toField": "low"
    }, {
      "fromField": "Close",
      "toField": "close"
    }, {
      "fromField": "Volume",
      "toField": "volume"
    } ],
    "compared": true,
    "categoryField": "Date",
    "dataLoader": {
      "url": "https://www.amcharts.com/wp-content/uploads/assets/stock/TXN.csv",
      "format": "csv",
      "showCurtain": true,
      "showErrors": true,
      "async": true,
      "reverse": true,
      "delimiter": ",",
      "useColumnNames": true
    }
  } ],
  "dataDateFormat": "YYYY-MM-DD",

  "panels": [ {
      "title": "Value",
      "percentHeight": 70,

      "stockGraphs": [ {
        "type": "candlestick",
        "id": "g1",
        "openField": "open",
        "closeField": "close",
        "highField": "high",
        "lowField": "low",
        "valueField": "close",
        "lineColor": "#fff",
        "fillColors": "#fff",
        "negativeLineColor": "#db4c3c",
        "negativeFillColors": "#db4c3c",
        "fillAlphas": 1,
        "comparedGraphLineThickness": 2,
        "columnWidth": 0.7,
        "useDataSetColors": false,
        "comparable": true,
        "compareField": "close",
        "showBalloon": false,
        "proCandlesticks": true
      } ],

      "stockLegend": {
        "valueTextRegular": undefined,
        "periodValueTextComparing": "[[percents.value.close]]%"
      }

    },

    {
      "title": "Volume",
      "percentHeight": 30,
      "marginTop": 1,
      "columnWidth": 0.6,
      "showCategoryAxis": false,

      "stockGraphs": [ {
        "valueField": "volume",
        "openField": "open",
        "type": "column",
        "showBalloon": false,
        "fillAlphas": 1,
        "lineColor": "#fff",
        "fillColors": "#fff",
        "negativeLineColor": "#db4c3c",
        "negativeFillColors": "#db4c3c",
        "useDataSetColors": false
      } ],

      "stockLegend": {
        "markerType": "none",
        "markerSize": 0,
        "labelText": "",
        "periodValueTextRegular": "[[value.close]]"
      },

      "valueAxes": [ {
        "usePrefixes": true
      } ]
    }
  ],

  "panelsSettings": {
    //    "color": "#fff",
    "plotAreaFillColors": "#333",
    "plotAreaFillAlphas": 1,
    "marginLeft": 60,
    "marginTop": 5,
    "marginBottom": 5
  },

  "chartScrollbarSettings": {
    "graph": "g1",
    "graphType": "line",
    "usePeriod": "WW",
    "backgroundColor": "#333",
    "graphFillColor": "#666",
    "graphFillAlpha": 0.5,
    "gridColor": "#555",
    "gridAlpha": 1,
    "selectedBackgroundColor": "#444",
    "selectedGraphFillAlpha": 1
  },

  "categoryAxesSettings": {
    "equalSpacing": true,
    "gridColor": "#555",
    "gridAlpha": 1
  },

  "valueAxesSettings": {
    "gridColor": "#555",
    "gridAlpha": 1,
    "inside": false,
    "showLastLabel": true
  },

  "chartCursorSettings": {
    "pan": true,
    "valueLineEnabled": true,
    "valueLineBalloonEnabled": true
  },

  "legendSettings": {
    //"color": "#fff"
  },

  "stockEventsSettings": {
    "showAt": "high",
    "type": "pin"
  },

  "balloon": {
    "textAlign": "left",
    "offsetY": 10
  },

  "periodSelector": {
    "position": "bottom",
    "periods": [ {
        "period": "DD",
        "count": 10,
        "label": "10D"
      }, {
        "period": "MM",
        "count": 1,
        "label": "1M"
      }, {
        "period": "MM",
        "count": 6,
        "label": "6M"
      }, {
        "period": "YYYY",
        "count": 1,
        "label": "1Y"
      }, {
        "period": "YYYY",
        "count": 2,
        "selected": true,
        "label": "2Y"
      },
      /* {
           "period": "YTD",
           "label": "YTD"
         },*/
      {
        "period": "MAX",
        "label": "MAX"
      }
    ]
  }
} );
</script>
</body>
</html>