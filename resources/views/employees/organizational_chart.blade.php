@extends('layouts.app')
@section('content')
        <style>
            #orgChart{
                margin-top: 70px;
                width:100%;
                height:100%;
                background-color: white;
            }
        </style>
        <script src="{{ asset('js/orgchart.js') }}"></script>
        <script src="{{asset('js/jquery.min.js')}}"></script>
        <div class="top-heading">
            
            <div class="col-md-12" style="background-color:white;padding:20px 10px 10px 10px;border-radius: 4px;">  
                <h5>ORGANIZATIONAL CHART FOR "{{ $user->first_name }} {{ $user->last_name }}"
               
                {{-- <div class="form-group pull-right" style="width:100%;">
                    <form method="GET" action="" class="custom_form">
                        <div class="row">
                            <div class="col-md-6">
                                {!! Form::text('search', null,  ['class' => 'form-control','placeholder' => 'Search Employee']) !!}
                            </div>
                            <div class="col-md-2">
                                <button class="btn btn-fill btn-sm btn-submit" style="width:100px;border-radius:4px" type="submit">Search</button>
                            </div>
                        </div>
                    </form>
                </div> --}}
                <select style='right:0px;'  id="selectTemplate">
                    <option>luba</option>
                    <option>olivia</option>
                    <option>derek</option>
                    <option>diva</option>
                    <option>mila</option>
                    <option>polina</option>
                    <option>mery</option>
                    <option>rony</option>
                    <option>belinda</option>
                    <option>ula</option>
                    <option>ana</option>
                    <option>isla</option>
                    <option>deborah</option>
                </select>
            </h5>
            </div>
           

            
         
            <div id="orgChart"/>
        </div>
        <script>
            
            let jsonData  =  JSON.parse({!! json_encode($datas) !!});
            outputData = [];
            $.each(jsonData , function(index, item){
                outputData.push({
                    id: item.id,
                    pid: item.pid,
                    name: item.name,
                    position: item.position,
                    img: item.img,
                });
            });
            console.log(outputData);
            var chart;
            window.onload = function () {
            var chart = new OrgChart(document.getElementById("orgChart"), {
                    template: "luba",
                    menu: {
                        svg: { text: "Export SVG" },
                    },
                    nodeBinding: {
                        field_0: "name",
                        field_1: "position",
                        img_0 : 'img'
                    },
                    // slinks: [
                    //     {from: 6, to: 2, template: 'orange', label: 'Direct Superior' },
                    //     {from: 7, to: 2, template: 'orange', label: '' },
                    //     {from: 8, to: 2, template: 'orange', label: '' },
                    //     {from: 9, to: 2, template: 'orange', label: '' },
                    //     {from: 3, to: 2, template: 'orange', label: '' },
                    // ],       
                    nodes: outputData
                });
                document.getElementById("selectTemplate").addEventListener("change", function () {
                chart.config.template = this.value;
                chart.draw();
    });
        };


        </script>
@endsection





