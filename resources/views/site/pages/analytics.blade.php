@extends('site.layouts.master')

@section('content')

<div class="product-input-output">
    <div class="container-fluid">
      <div class="row">
          <div class="col-md-10 col-md-offset-1">
              <h3 class="text-center"><b>Products Analytics</b></h3>
              <div class="row line-big">
                <div class="col-md-12 text-center">
                 <img src="{{ asset('assets/admy/image/line-big.png') }}">
               </div>
              </div>
              <div class="row line-sm">
                <div class="col-md-12 text-center">
                 <img src="{{ asset('assets/admy/image/line-sm.png') }}">
               </div>
              </div>
              <h5 class="text-center"><b>AdMy provides an analytical calculator where the users can easily calculate and find their customized requirements.</b></h5>

              <table class="table table-bordered">
                  <thead>
                    <tr>
                      <th colspan="3" class="text-center input-color">INPUT</th>
                      <th colspan="3" class="text-center output-color">OUTPUT</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr>
                      <td class="color-orange">Subscriber</td>
                      <td class="color-orange">Category</td>
                      <td class="color-orange">Campaign Length</td>
                      <td class="color-light-orange">OBD/day</td>
                      <td class="color-light-orange">Total_OBD</td>
                      <td class="color-light-orange">Total_BDT</td>
                    </tr>
                    <tr>
                      <td class="td-center">1000</td>
                      <td class="td-center">Islamic</td>
                      <td class="td-center">05</td>
                      <td class="td-center">1,20,000</td>
                      <td class="td-center">6,00,000</td>
                      <td class="td-center">1,20,000</td>
                    </tr>
                    
                  </tbody>
                </table>

                <div class="text-center">
                  <a href="http://localhost:8080/admy-analysis/calculate" class="btn btn-danger btn-calculate" role="button">CALCULATE</a>
                </div> 
          </div>
      </div>
    </div>
  </div>

@endsection