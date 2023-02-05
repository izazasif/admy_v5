@extends('portal.layouts.master')

@section('content')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <section class="content">
    <div class="box box-default color-palette-box">
        <div class="box-header with-border">
        <h2 class="page-header">
            <i class="fa fa-globe"></i> Dashboard 
            <small class="pull-right">
            <div class="form-group">
                <select class="form-control input-sm" id="time">
                 <option value="daily" selected >Daily</option>
                 <option value="weekly"> Weekly</option>
                 <option value="monthly"> Monthly</option>
                </select>
               </div>

            </small>
        </h2>

          <div class="box-body">
              <div class="row">
                        <div class="col">
                          <div class="col-lg-3 col-xs-6">
                            <div class="small-box" style="color:#111111;">
                              <div class="inner">
                                <h4><span id="new_reg" style="font-weight:800;">0</span></h4>
                                <p> New Register </p>
                              </div>
                              <div class="icon">
                                <i class="ion ion-person-add"></i>
                              </div>
                            </div>
                          </div>
                        </div>
                        <div class="col">
                        <div class="col-lg-3 col-xs-6">
                            <div class="small-box" style="color:#111111;">
                              <div class="inner">
                                <h4><span id="total_package_sold" style="font-weight:800;">0</span></h4>
                                <p>Package Sold </p>
                              </div>
                              <div class="icon">
                                <i class="ion ion-bag"></i>
                              </div>
                            </div>
                          </div> 
                        </div>
                        <div class="col">
                        <div class="col-lg-3 col-xs-6">
                            <div class="small-box" style="color:#111111;">
                              <div class="inner">
                                <h4><span id="total_price_bdt" style="font-weight:800;">0</span></h4>
                                <p>Total BDT.</p>
                              </div>
                              <div class="icon">
                                <i class="ion ion-cash"></i>
                              </div>
                            </div>
                          </div> 
                        </div>
                        <div class="col">
                             <div class="col-lg-3 col-xs-6">
                              <div class="small-box" style="color:#111111;">
                                  <div class="inner">
                                    <h4><span id="total_schdeule" style="font-weight:800;">0</span></h4>
                                    <p>Schedule </p>
                                  </div>
                                  <div class="icon">
                                    <i class="ion ion-clock"></i>
                                  </div>
                              </div>
                            </div> 
                        </div>
                  </div>
                  
                  <div class="col">
                      <div class="col-md-6">
                        <div class="info-box" style="height: 140px;background-color:#58a8d9;!important;">
                          <h3 class="text-center">
                          <div class="external-event bg-light-blue">OBD</div>
                          </h3>
                               
                                  <div class="col-lg-4 col-xs-4">
                                    <div class="small-box bg-grey">
                                    <div class="inner">
                                        <h4><span id="obd_sold" style="font-weight:800;">0</span></h4>
                                        <p>Package Sold </p>
                                        </div>
                                    </div>
                                  </div>
                                  
                                  <div class="col-lg-4 col-xs-4">
                                    <div class="small-box bg-grey">
                                    <div class="inner">
                                        <h4><span id="obd_price" style="font-weight:800;">0</span></h4>
                                        <p>Total BDT.</p>
                                        </div>
                                    </div>
                                  </div> 

                                  <div class="col-lg-4 col-xs-4">
                                    <div class="small-box bg-grey">
                                       <div class="inner">
                                        <h4 class="description-header"><span id="obd_credit" style="font-weight:800;">0</span></h4>
                                        <p>Total OBD Sold</p>
                                        </div>
                                    </div>
                                  </div> 
                            </div> 
                          </div>
                        </div>
                   <div class="col">
                      <div class="col-md-6">
                        <div class="info-box bg-Primary" style="height: 140px;background-color:#8cc177;!important;">
                        
                        <h3 class="text-center">
                          <div class="external-event bg-green">My Push</div>
                          </h3>
                             
                                  <div class="col-lg-4 col-xs-4">
                                    <div class="small-box bg-grey">
                                      <div class="inner">
                                        <h4><span id="push_sms_sold" style="font-weight:800;">0</span></h4>
                                        <p>Package Sold </p>
                                      </div>
                                    </div>
                                  </div>
                                  
                                  <div class="col-lg-4 col-xs-4">
                                    <div class="small-box bg-grey">
                                      <div class="inner">
                                        <h4><span id="sms_price" style="font-weight:800;">0</span></h4>
                                        <p>Total BDT.  </p>
                                      </div>
                                    </div>
                                  </div> 

                                  <div class="col-lg-4 col-xs-4">
                                    <div class="small-box bg-grey">
                                      
                                        <!-- <h3><span id="sms_total"  >0</span></h3>
                                        <p>Total SMS Sold</p> -->
                                        <div class="inner">
                                        <h4 class="description-header"> <span id="sms_credit" style="font-weight:800;">0</span></h4>
                                        <p>Total SMS Sold</p>
                                        </div>
                                    </div>
                                  </div> 
                            </div> 
                          </div>
                        </div>
             </div> 
             
           <!-- BAR CHART -->
           <div class="box box-success">
            <div class="box-header with-border">
              <h3 class="box-title">Daily Sales Status (amount in BDT)</h3>

              <div class="box-tools pull-right">
                
               <a class="text-blue" style="color:#58a8d9;"><i class="fa fa-square"></i>OBD</a>
                <a class="text-Green" style="color:#8cc177;"><i class="fa fa-square"></i>SMS</a>
                <a class="text-Grey" style="color:#718997;"><i class="fa fa-square"></i>Total</a>
                
               
              </div>
            </div>
            <div class="box-body chart-responsive">
              <div class="chart" id="bar-chart" style="height: 300px;"></div>
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
          
        </div>
      </div>
   
  </section>
  <!-- /.content -->
</div>


<!-- /.content-wrapper -->
<!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script> -->
@endsection
@section('extra-foot-scripts')
<script>

$(document).ready(function(){
        $("#time").change(function() {
          makeAjaxCall();
        });

        makeAjaxCall();
  });
  function makeAjaxCall() {
            var tm_period = $("#time").val();
          $.ajax({
            url: 'get_data/dashboard/'+tm_period,
            type: 'get',
            dataType: 'json',
            
            success: function(response){
            
            $('#new_reg').text(response.user);
            $('#total_package_sold').text(response.total_package_sold);
            $('#total_price_bdt').text(response.total_price_bdt.toFixed(2));
            $('#total_schdeule').text(response.total_schdeule);

            $('#push_sms_sold').text(response.push_sms_sold);
            $('#obd_sold').text(response.obd_sold);


            $('#sms_price').text(response.sms_price.toFixed(2));
            $('#obd_price').text(response.obd_price.toFixed(2));

            $('#sms_credit').text(response.sms_credit);
            $('#obd_credit').text(response.obd_credit);


            var bar = Morris.Bar({
              element: 'bar-chart',
              resize: true,
              data: [
                {y: response.bar_chart.date_1, a: response.bar_chart.obd_1,  b: response.bar_chart.push_sms_1,    c: response.bar_chart.obd_1+response.bar_chart.push_sms_1},
                {y: response.bar_chart.date_2, a: response.bar_chart.obd_2,  b: response.bar_chart.push_sms_2,    c: response.bar_chart.obd_2+response.bar_chart.push_sms_2},
                {y: response.bar_chart.date_3, a: response.bar_chart.obd_3,  b: response.bar_chart.push_sms_3,    c: response.bar_chart.obd_3+response.bar_chart.push_sms_3},
                {y: response.bar_chart.date_4, a: response.bar_chart.obd_4,  b: response.bar_chart.push_sms_4,    c: response.bar_chart.obd_4+response.bar_chart.push_sms_4},
                {y: response.bar_chart.date_5, a: response.bar_chart.obd_5,  b: response.bar_chart.push_sms_5,    c: response.bar_chart.obd_5+response.bar_chart.push_sms_5},
                {y: response.bar_chart.date_6, a: response.bar_chart.obd_6,  b: response.bar_chart.push_sms_6,    c: response.bar_chart.obd_6+response.bar_chart.push_sms_6},
                {y: response.bar_chart.date_7, a: response.bar_chart.obd_7,  b: response.bar_chart.push_sms_7,    c: response.bar_chart.obd_7+response.bar_chart.push_sms_7},
              ],
              barColors: ['#58a8d9', '#8cc177','#808080'],
              xkey: 'y',
              ykeys: ['a', 'b','c'],
              labels: ['OBD', 'SMS','Total'],
              hideHover: 'auto'
            });
            
          
          }         

       })
}
  
        
</script>
@endsection

            
        
     