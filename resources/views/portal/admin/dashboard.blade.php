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
                                <h3><span id="new_reg">0</span></h3>
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
                                <h3><span id="pack_sold">0</span></h3>
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
                                <h3><span id="total_bdt">0</span></h3>
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
                                    <h3><span id="schdeule">0</span></h3>
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
                        <div class="info-box" style="height: 160px;background-color:#718997;">
                          <h3 class="text-center">
                          <div class="external-event bg-light-blue">OBD</div>
                          </h3>
                        
                    
                                  <div class="col-lg-4 col-xs-4">
                                    <div class="small-box bg-grey">
                                      <div class="inner">
                                        <h3><span id="pack_sold_1">0</span></h3>
                                        <p>Package Sold </p>
                                      </div>
                                    </div>
                                  </div>
                                  
                                  <div class="col-lg-4 col-xs-4">
                                    <div class="small-box bg-grey">
                                      <div class="inner">
                                        <h3><span id="pack_total_bdt">0</span></h3>
                                        <p>Total BDT.</p>
                                      </div>
                                    </div>
                                  </div> 

                                  <div class="col-lg-4 col-xs-4">
                                    <div class="small-box bg-grey">
                                      <div class="inner">
                                        <h3><span id="total_obd">0</span></h3>
                                        <p>Total OBD Sold</p>
                                      </div>
                                    </div>
                                  </div> 
                            </div> 
                          </div>
                        </div>
                   <div class="col">
                      <div class="col-md-6">
                        <div class="info-box bg-Primary" style="height: 160px;background-color:#8cc177;">
                        
                        <h3 class="text-center">
                          <div class="external-event bg-green">My Push</div>
                          </h3>
                             
                                  <div class="col-lg-4 col-xs-4">
                                    <div class="small-box bg-grey">
                                      <div class="inner">
                                        <h3><span id="pack_sold_2">0</span></h3>
                                        <p>Package Sold </p>
                                      </div>
                                    </div>
                                  </div>
                                  
                                  <div class="col-lg-4 col-xs-4">
                                    <div class="small-box bg-grey">
                                      <div class="inner">
                                        <h3><span id="sms_total_bdt">0</span></h3>
                                        <p>Total BDT.  </p>
                                      </div>
                                    </div>
                                  </div> 

                                  <div class="col-lg-4 col-xs-4">
                                    <div class="small-box bg-grey">
                                      <div class="inner">
                                        <h3><span id="sms_total">0</span></h3>
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
                
               <a class="text-blue" href="#"><i class="fa fa-square"></i>OBD</a>
                <a class="text-green" href="#"><i class="fa fa-square"></i>SMS</a>
                <a class="text-muted" href="#"><i class="fa fa-square"></i>Total</a>
                
               
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
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>


<script>

    $(document).ready(function(){
      
      $.ajax({
           url: 'get_data/dashboard/'+"daily",
           type: 'get',
           dataType: 'json',
           
           success: function(response){
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

            "use strict";
            let days =  lastsevendaysOfWeek();
           
        
          let as = days[0];
          let as1 = days[1] ;
          let as2 = days[2] ;
          let as3 = days[3] ;
          let as4 = days[4] ;
          let as5 = days[5] ;
          let as6 = days[6] ;

          let on = to_five[0].price;
          let on1 = to_five[0].price;
          let on2 = to_five[0].price;
          let on3 = to_five[0].price;
          let on4 = to_five[0].price;
          let on5 = to_five[0].price;
          let on6 = to_five[0].price;

          let on_1 = to_five_1[0].price;
          let on1_2 = to_five_1[0].price;
          let on2_3 = to_five_1[0].price;
          let on3_4 = to_five_1[0].price;
          let on4_5 = to_five_1[0].price;
          let on3_6 = to_five_1[0].price;
          let on4_7 = to_five_1[0].price;

            var bar = Morris.Bar({
              element: 'bar-chart',
              resize: true,
              data: [
                {y: as, a: on, b: on_1,c:  3000},
                {y: as1, a: on1, b:on1_2, c: 8000},
                {y: as2, a: on2, b:on2_3, c: 4000},
                {y: as3, a: on3, b: on3_4, c: 8598},
                {y: as4, a: on4, b: on4_5, c: 8089},
                {y: as5, a: on4, b: on4_5, c: 8000},
                {y: as6, a: on4, b: on4_5, c: 8000},
              ],
              barColors: ['#3c8dbc', '#8cc177','#718997'],
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

            "use strict";
            
            let days =  lastsevendaysOfWeek();

         
        
          let as = days[0];
          let as1 = days[1] ;
          let as2 = days[2] ;
          let as3 = days[3] ;
          let as4 = days[4] ;
          let as5 = days[5] ;
          let as6 = days[6] ;

          let on = to_five[0].price;
          let on1 = to_five[0].price;
          let on2 = to_five[0].price;
          let on3 = to_five[0].price;
          let on4 = to_five[0].price;
          let on5 = to_five[0].price;
          let on6 = to_five[0].price;

          let on_1 = to_five_1[0].price;
          let on1_2 = to_five_1[0].price;
          let on2_3 = to_five_1[0].price;
          let on3_4 = to_five_1[0].price;
          let on4_5 = to_five_1[0].price;
          let on3_6 = to_five_1[0].price;
          let on4_7 = to_five_1[0].price;

            var bar = Morris.Bar({
              element: 'bar-chart',
              resize: true,
              data: [
                {y: as, a: on, b: on_1,   c:  3500},
                {y: as1, a: on1, b:on1_2, c: 7500},
                {y: as2, a: on2, b:on2_3, c: 4500},
                {y: as3, a: on3, b: on3_4, c: 4500},
                {y: as4, a: on4, b: on4_5, c: 7500},
                {y: as5, a: on3, b: on3_4, c: 4500},
                {y: as6, a: on4, b: on4_5, c: 7500}
              ],
              barColors: ['#3c8dbc', '#8cc177','#718997'],
              xkey: 'y',
              ykeys: ['a', 'b','c'],
              labels: ['OBD', 'SMS','Total'],
              hideHover: 'auto'
            });
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