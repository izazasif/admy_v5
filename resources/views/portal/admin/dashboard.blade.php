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
                 <option value="daily" >Daily</option>
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
                                <h4><span id="pack_sold" style="font-weight:800;">0</span></h4>
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
                                <h4><span id="total_bdt" style="font-weight:800;">0</span></h4>
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
                                    <h4><span id="schdeule" style="font-weight:800;">0</span></h4>
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
                                        <h4><span id="pack_sold_1" style="font-weight:800;">0</span></h4>
                                        <p>Package Sold </p>
                                        </div>
                                    </div>
                                  </div>
                                  
                                  <div class="col-lg-4 col-xs-4">
                                    <div class="small-box bg-grey">
                                    <div class="inner">
                                        <h4><span id="pack_total_bdt" style="font-weight:800;">0</span></h4>
                                        <p>Total BDT.</p>
                                        </div>
                                    </div>
                                  </div> 

                                  <div class="col-lg-4 col-xs-4">
                                    <div class="small-box bg-grey">
                                       <div class="inner">
                                        <h4 class="description-header"><span id="total_obd" style="font-weight:800;">0</span></h4>
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
                                        <h4><span id="pack_sold_2" style="font-weight:800;">0</span></h4>
                                        <p>Package Sold </p>
                                      </div>
                                    </div>
                                  </div>
                                  
                                  <div class="col-lg-4 col-xs-4">
                                    <div class="small-box bg-grey">
                                      <div class="inner">
                                        <h4><span id="sms_total_bdt" style="font-weight:800;">0</span></h4>
                                        <p>Total BDT.  </p>
                                      </div>
                                    </div>
                                  </div> 

                                  <div class="col-lg-4 col-xs-4">
                                    <div class="small-box bg-grey">
                                      
                                        <!-- <h3><span id="sms_total"  >0</span></h3>
                                        <p>Total SMS Sold</p> -->
                                        <div class="inner">
                                        <h4 class="description-header"> <span id="sms_total" style="font-weight:800;">0</span></h4>
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
      
      $.ajax({
           url: '/get_bar_chart/dashboard',
           type: 'get',
           dataType: 'json',
           
           success: function(response){
             
            for (var key in response) {
                  if (response[key] === null) {
                    response[key] = 0;
                  }
                }
            $('#new_reg').text(response.user);
            $('#pack_sold').text(response.package_sold);
            $('#total_bdt').text(response.total);
            $('#schdeule').text(response.schdeule);

            $('#pack_sold_2').text(response.pack_sold1);
            $('#pack_sold_1').text(response.pack_sold2);

            $('#pack_total_bdt').text(response.total2);
            $('#sms_total_bdt').text(response.total1);

            $('#total_obd').text(response.to_sms);
            $('#sms_total').text(response.to_odb);
            
            $('#bar-chart').text(response.total_five);
            to_five = response.total_five;
            to_five_1 = response.total_five_1;
           
            let days =  lastsevendaysOfWeek();
           
        
          let as = days[0];
          let as1 = days[1] ;
          let as2 = days[2] ;
          let as3 = days[3] ;
          let as4 = days[4] ;
          let as5 = days[5] ;
          let as6 = days[6] ;

          

          let on = response.today_sells_1;
          let on1 = response.today_sells_2;
          let on2 = response.today_sells_3;
          let on3 = response.today_sells_4;
          let on4 = response.today_sells_5;
          let on5 = response.today_sells_6;
          let on6 = response.today_sells_7;

          let on_1 = response.today_sells_obd_1;
          let on1_2 = response.today_sells_obd_2;
          let on2_3 = response.today_sells_obd_3;
          let on3_4 = response.today_sells_obd_4;
          let on4_5 = response.today_sells_obd_5;
          let on5_6 = response.today_sells_obd_6;
          let on6_7 = response.today_sells_obd_7;

            var bar = Morris.Bar({
              element: 'bar-chart',
              resize: true,
              data: [
                {y: as6,  a: on_1, b: on,    c:  on+ on_1},
                {y: as5, a: on1_2, b:on1,  c: on1+on1_2},
                {y: as4, a: on2_3, b:on2,  c: on2+on2_3},
                {y: as3, a: on3_4, b: on3, c: on3+on3_4},
                {y: as2, a: on4_5, b: on4, c: on4+on4_5},
                {y: as1, a: on5_6, b: on5, c: on5+on5_6},
                {y: as, a: on6_7, b: on6, c: on6+on6_7},
              ],
              barColors: ['#58a8d9', '#8cc177','#808080'],
              xkey: 'y',
              ykeys: ['a', 'b','c'],
              labels: ['OBD', 'SMS','Total'],
              hideHover: 'auto'
            });
          }
          

        })
      $('#time').change(function(){
         var tm_period = $(this).val();
          
         $.ajax({
           url: 'get_data/dashboard/'+tm_period,
           type: 'get',
           dataType: 'json',
           
           success: function(response){
            for (var key in response) {
                  if (response[key] === null) {
                    response[key] = 0;
                  }
                }
            $('#new_reg').text(response.user);
            $('#pack_sold').text(response.package_sold);
            $('#total_bdt').text(response.total);
            $('#schdeule').text(response.schdeule);

            $('#pack_sold_2').text(response.pack_sold1);
            $('#pack_sold_1').text(response.pack_sold2);

            $('#pack_total_bdt').text(response.total2);
            $('#sms_total_bdt').text(response.total1);

            $('#total_obd').text(response.to_sms);
            $('#sms_total').text(response.to_odb);
            
            $('#bar-chart').text(response.total_five);
            to_five = response.total_five;
            to_five_1 = response.total_five_1;
        
            // bar.setData(to_five);
            // bar.redraw();

          
          }
          

        })

    });
    
  
      
  });
  
  
    function lastsevendaysOfWeek() {
      const daysOfWeek = ['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'];
        const today = new Date();
        const lastSevenDays = [];
        
        for (let i = 0; i < 7; i++) {
          const date = new Date(today.getTime() - i * 24 * 60 * 60 * 1000);
          lastSevenDays.unshift(daysOfWeek[date.getUTCDay()]);
        }
        
        return lastSevenDays;
      }
        
</script>
@endsection