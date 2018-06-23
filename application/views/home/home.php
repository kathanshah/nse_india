
<div class="container">
    <div class="row mt-3">
        <div class="col-12">
            <p class="text-right"><em><small>Last updated 15th June 2018</small></em></p>
        </div>
    </div>
    <form method="get" id="formdata">
        <div class="row">
            <div class="col-3">
                <div class="form-group">
                    <input type="search" placeholder="Search Symbol" class="form-control"/>
                </div>
            </div>
            <div class="col-3">
                <div class="form-group">
                    <input type="text" id="from" name="from" placeholder="From Date" class="form-control"/>
                </div>
            </div>
            <div class="col-3">
                <div class="form-group">
                    <input type="text" id="to" name="to" class="form-control" placeholder="To Date"/>
                </div>
            </div>
            <div class="col">
                <div class="form-group">
                    <button id="filterData" type="button" class="btn btn-info">Filter</button>
                </div>
            </div>
            <div class="col">
                <div class="form-group text-right">
                    <button type="button" class="btn btn-info">Update Data</button>
                </div>
            </div>
        </div>
    </form>
    <div class="row">
        <div class="col-12">
        <div class="table-responsive">
            <table class="table table-striped table-bordered">
                <thead class="thead-dark">
                    <tr>
                        <th scope="col">SYMBOL</th>
                        <th scope="col">Trend %</th>
                        <th scope="col">Total Value (in Lakhs)</th>
                        <th scope="col">Total Quantity</th>
                    </tr>
                </thead>
                <tbody id="list" v-cloak>
                    <tr v-for="(item, index) in items" v-on:click="chartpop(index)">
                        <th scope="row">{{item.symbol}}</th>
                        <td>
                            {{fixedPoint(item.trend)}}
                            <span v-show="item.trend>=0">
                                <i class="material-icons uptrend-icon">arrow_drop_up</i>
                            </span>
                            <span v-show="item.trend<0">
                                <i class="material-icons downtrend-icon">arrow_drop_down</i>
                            </span>
                        </td>
                        <td>{{item.tval}}</td>
                        <td>{{item.tqty}}</td>
                    </tr>
                </tbody>
            </table>
        </div>
        </div>
        
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="chartPopup" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel" v-cloak>{{stock.symbol}}</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <h4 class="text-center">Candle Stick Chart will be here</h4>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>

<footer class="pt-3 pb-3">
    <div class="container">
        <div class="col-12">
            <p class="text-center text-secondary"><small>&copy; Cat Technologies 2018</small></p>
        </div>
    </div>
</footer>

<script src="https://unpkg.com/vue"></script>
<script src="<?=base_url()?>assets/jquery-3.3.1.min.js"></script>
<script src="<?=base_url()?>assets/popper.min.js" crossorigin="anonymous"></script>
<script src="<?=base_url()?>assets/js/bootstrap.min.js" integrity="sha384-smHYKdLADwkXOn1EmN1qk/HfnUcbVRZyYmZ4qpPea6sjB/pTJ0euyQp0Mk8ck+5T" crossorigin="anonymous"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
<script>const base_url = "<?=base_url()?>";</script>
<script>

var $loader = $("#loader");
$loader.fadeOut();

  $( function() {
    var dateFormat = "mm/dd/yy",
      from = $( "#from" )
        .datepicker({
          defaultDate: "+1w",
          changeMonth: true,
          numberOfMonths: 2,
          maxDate: 0,
          dateFormat:'yy-mm-dd'
        })
        .on( "change", function() {
          to.datepicker( "option", "minDate", getDate( this ) );
        }),
      to = $( "#to" ).datepicker({
        defaultDate: "+1w",
        changeMonth: true,
        numberOfMonths: 2,
        maxDate: 0,
        dateFormat:'yy-mm-dd'
      })
      .on( "change", function() {
        from.datepicker( "option", "maxDate", getDate( this ) );
      });
 
    function getDate( element ) {
      var date;
      try {
        date = $.datepicker.parseDate( dateFormat, element.value );
      } catch( error ) {
        date = null;
      }
 
      return date;
    }
  } );

  var list = new Vue({
      el:'#list',
      data:{
          items:[]
      },
      methods:{
        fixedPoint:function(trend){
            return parseFloat(trend).toFixed(2)
        },
        chartpop:function(index){
            $("#chartPopup").modal("show");
            chartpopup.stock = this.items[index];
        }
      },
  });

  var chartpopup = new Vue({
      el:"#chartPopup",
      data:{
          stock:{}
      },
      methods:{

      }
  })

  var fdate = $("#from");
  var tdate = $("#to");

  $("#filterData").on('click',function(){

    var fd = fdate.datepicker("getDate");
    var td = tdate.datepicker("getDate");

    if (fd && td){
        var fromDate = $.datepicker.formatDate("yy-mm-dd", fd);
        var toDate = $.datepicker.formatDate("yy-mm-dd", td);

        $loader.fadeIn();
        
        $.get(base_url+'/welcome/getData',$("#formdata").serialize(),function(response){
            list.items = response;
            $loader.fadeOut("slow");
        });
    }

  });
</script>
</body>
</html>