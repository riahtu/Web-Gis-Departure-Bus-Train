
@extends('master')
@section('konten')
@section('container','container-fluid')

<div class="container-fluid con_petaBr">
    <div class="con_petaBG cf">
        <div class="col-md-3 sideBar">
            <h1>Web Gis</h1>
            <p>Source Location</p>
            <ul id="location">
                <li>
                    <input type="text" class="ketRoutes" placeholder="...">
                    <input type="hidden" id="from_place_id">
                    <input type="hidden" id="to_place_id">
                    <input type="hidden" id="departure_time">
                    <span id="timepicker" class="fa fa-clock-o"></span>
                    {{ csrf_field() }}
                </li>

                <!-- jika user login -->
                @if(session()->has('WebclientSession'))
                    @if($historyPlace)
                    @php
                        $arrPlaceId = [];
                    @endphp
                    @foreach($historyPlace as $r)
                    @php array_push($arrPlaceId,$r['place_id']); @endphp

                    <li><a class="places" place_id="{{ $r['place_id'] }}" place_name="{{ $r['name'] }}">{{ $r['name'] }}</a><span class="historyBy pull-right">Hitory search by {{ $r['user'] }}</span></li>
                    @endforeach

                    @if($place && count($place) != count($historyPlace))
                    @foreach($place as $r)
                        @if(!in_array($r['id'],$arrPlaceId))
                        <li><a class="places" place_id="{{ $r['id'] }}" place_name="{{ $r['name'] }}">{{ $r['name'] }}</a></li>
                        @endif
                    @endforeach
                    @endif

                    @else
                    @if($place)
                    @foreach($place as $r)
                        <li><a class="places" place_id="{{ $r['id'] }}" place_name="{{ $r['name'] }}">{{ $r['name'] }}</a></li>
                    @endforeach
                    @endif

                    @endif
                @else
                    @if($place)
                    @foreach($place as $r)
                    <li><a class="places" place_id="{{ $r['id'] }}" place_name="{{ $r['name'] }}">{{ $r['name'] }}</a></li>
                    @endforeach
                    @endif
                @endif
            </ul>
            <div class="boxpicker">
                <form id="formBoxpicker">
                <div class="input-group">
                    <label for="minutes">Hourse</label>
                    <input type="range" name="" id="hourse" min="0" max="23" value="0">
                </div>
                <div class="input-group">
                    <label for="minutes">Minutes</label>
                    <input type="range" name="" id="minutes" min="0" max="59" value="0">
                </div>
                <div class="input-group">
                    <label for="minutes">Second</label>
                    <input type="range" name="" id="second" min="0" max="59" value="0">
                </div>
                </form>
            </div>

            <a id="getRoutes" type="submit" disabled="" class="btn btn-default">Get Routes</a>

            <ul id="routes">
                <li class="loadingRoutes"><img src="/img/loading.gif"></li>
                <route></route>
            </ul>
        </div>
        <div class="col-md-9 nopadding-all">
            <div class="peta">
                <img usemap="#peta" class="peta" src="/img/peta sumatra.jpg">
                <map name="peta" id="peta">
                    @if($place)

                    @php
                        $i = 0;
                        foreach($place as $d) :

                        $left = (int)$d['x'];
                        $top = (int)$d['y'];
                        $right = $d['x']-10;
                        $bottom = $d['y']+10;
                        $coords = $left.','.$top.','.$right.','.$bottom;
                    @endphp
                    
                    <area shape="rect" id="{{ $d['name'] }}" left="{{$left}}" top="{{$top}}" right="{{$right}}" bottom="{{$bottom}}" coords="{{ $coords }}" target="_blank" alt="AUSTRALIA">
                    <a coords="1,1,1,1" shape="rect" id="{{ $d['name'] }}" class="namaArea">{{ $d['name'] }}
                    </a>
                    <div coords="1,1,1,1" shape="rect" id="{{ $d['name'] }}" class="ketArea">
                        <img coords="1,1,1,1" shape="rect" src="{{ $d['img_path'] }}" alt="">
                        <p coords="1,1,1,1" shape="rect">{{ $d['description'] }}</p>
                    </div>

                    @endforeach
                    @endif
                </map>
            </div>
        </div>
    </div>
</div>
<div class="bgModal" @if(session('data') || $errors->has('username') || $errors->has('password'))style="display: block;"@endif></div>
<div class="modalLogin" @if(session('data') || $errors->has('username') || $errors->has('password'))style="display: block;" @endif>

    <h1>Form login</h1>
    <form id="form" class="form" action="{{ url('/login') }}" method="post">
        @if(session('data'))
        <p class="warning">{{ session('data') }}</p>
        @endif

        <p class="warning">{{ $errors->first('username') }}</p>
        <div class="input-group">
            <input type="text" class="form-control" id="username" name="username" placeholder="username" value="{{ old('username') }}" aria-describedby="username">
            <span class="input-group-addon" id="username"><span class="fa fa-user-circle fa-lg"></span></span>
        </div>

        <p class="warning">{{ $errors->first('password') }}</p>
        <div class="input-group">
            <input type="password" class="form-control" id="password" name="password" placeholder="password" value="{{ old('password') }}" aria-describedby="password">
            <span class="input-group-addon" id="password"><span class="fa fa-lock fa-lg"></span></span>
        </div>

        {{ csrf_field() }}
        <div class="col-sm-6 col-md-6 nopadding-all">
            <button type="submit" id="login" class="btn btn-success"><span class="fa fa-sign-in"></span> Sig In</button>
        </div>
        <div class="col-sm-6 col-md-6 nopadding-all">
            <a id="closeModal" class="btn btn-default pull-right"><span class="fa fa-remove"></span></a>
        </div>
    </form>
</div>
<script type="text/javascript">
    $(function(){
        /* peta */
            function setDefaultStyleMapArea() {
                //initialize highlight
                $('img.peta').maphilight({
                    strokeWidth: 0,
                    fillColor: "f2f2f2",
                    fillOpacity: 0.8,
                    singleSelect: false,
                    strokeColor: '000000',
                });

                ////map wrap
                $("area.victory").wrap(function () {
                    //This block is what creates highlighting by trigger the "alwaysOn", 
                    let data = $(this).data('maphilight') || {};
                    data.alwaysOn = !data.alwaysOn;
                    $(this).data('maphilight', data).trigger('alwaysOn.maphilight');
                    //there is also "neverOn" in the docs, but not sure how to get it to work
                });
            }

            function ShowAreaPetaMap() {
                $('area').each(function () //get all area
                {
                    $(this).addClass("victory");
                });

                setDefaultStyleMapArea();
            }

            // responsive on resize browser
            let resizeEvt;
            $(window).on('resize.usemap', function(){
                clearTimeout(resizeEvt);
                resizeEvt = setTimeout(function(){
                    $('img[usemap]').maphilight();
                    positionAreaOnMap();
                    setDefaultStyleMapArea();
                }, 200);
            });

            // responsive on reload page
            let img = new Image();
            img.src = 'img/peta sumatra.jpg';
            img.onload = function() {
                positionAreaOnMap();
                ShowAreaPetaMap();
            }

            function positionAreaOnMap() {
                let peta = document.querySelector("img.peta");
                // height and width window
                let widthW = document.scrollingElement.clientWidth;
                let heightW = document.scrollingElement.clientHeight;
                let width = peta.clientWidth;
                let height = peta.clientHeight;
                let area = document.querySelectorAll('area');
                // set automatic default height ul location and routes
                let ul = document.querySelector("ul#location");
                if(widthW >= 1200) {
                    ul.style.maxHeight = (height-500)+"px";
                } else if(widthW >= 992) {
                    ul.style.maxHeight = (height-350)+"px";
                } else if(widthW >= 768) {
                    ul.style.maxHeight = (height-350)+"px";
                } else if(widthW >= 600 || widthW < 600) {
                    ul.style.maxHeight = (height-50)+"px";
                }

                area.forEach(function(e){
                    let a = document.querySelector('map a#'+e.getAttribute('id'));
                    let div = document.querySelector('map div#'+e.getAttribute('id'));

                    let left = parseInt(e.getAttribute('left'));
                    let top = parseInt(e.getAttribute('top'));
                    let right = parseInt(e.getAttribute('right'));
                    let bottom = parseInt(e.getAttribute('bottom'));

                    console.log(e);

                    $(e).data('maphilight',{
                        strokeWidth: 0,
                        fillColor: "f2f2f2",
                        fillOpacity: 0.8,
                        singleSelect: false,
                        strokeColor: '000000',
                    });

                    /*
                    rumus
                        1058 = 210
                        661 = x
                        x = 210*661;
                    */

                    /* set nilai default posisi keterangan dan nama tempat*/
                    if(a != null) {
                        //set posisi nama tempat
                        a.style.top = top+"px";
                        a.style.left = (left+5)+"px";
                        //set font size a
                        a.style.fontSize = 14+"px";
                    }

                    if(div != null) {
                        div.style.top = (top+25)+"px";
                        div.style.left = left+"px";
                    }

                    /* responsive saat halaman diload */
                    if(widthW < 1440) {
                        left = Math.ceil((width*left)/1058);
                        top = Math.ceil((height*top)/793);
                        right = Math.ceil((width*right)/1058);
                        bottom = Math.ceil((height*bottom)/793);

                        let coords = left+','+top+','+right+','+bottom;

                        e.setAttribute('coords',coords);
                        
                        if(a != null) {
                            //set posisi nama tempat
                            a.style.top = top+"px";
                            a.style.left = (left+5)+"px";
                            //set font size a
                            a.style.fontSize = Math.ceil((14*width)/1058)+"px";
                        }

                        if(div != null) {
                            let divWidth = div.clientWidth;
                            let plusTop = Math.ceil((25*width)/1058);

                            // set position div
                            div.style.top = (top+plusTop+5)+"px";
                            div.style.left = left+"px";
                            if(left+divWidth >= widthW) {
                                div.style.right = 0;
                                div.style.left = width-divWidth+"px";
                            }
                        }
                    } else {
                        let coords = left+','+top+','+right+','+bottom;
                        e.setAttribute('coords',coords);
                    }
                })

                console.log('...');
            }

        /* login */
            $("a#formLogin").click(function(){
                $(".bgModal").addClass('muncul');
                $(".modalLogin").addClass('muncul');
                $("body").css('overflow','hidden');
            });

            $("a#closeModal").click(function(){

                document.querySelector('.bgModal').classList.replace('muncul','hide');
                document.querySelector('.modalLogin').classList.replace('muncul','hide');

                setTimeout(function(){
                    $(".bgModal").removeClass('hide');
                    $(".modalLogin").removeClass('hide');
                }, 600)

                //reset
                $("form#form")[0].reset();
                $("p.warning").html("");
                $("body").css('overflow','auto');
            });

        /* serachRoutes */
            const loc = document.querySelector('ul#location');
            const inputFrom = document.querySelector('input#from_place_id');
            const inputTo = document.querySelector('input#to_place_id');
            const inputDepartureTime = document.querySelector('input#departure_time');
            const ketRoutes = document.querySelector('input.ketRoutes');
            const getRoutes = document.querySelector('a#getRoutes');
            const timepicker = loc.querySelector("span#timepicker");
            const boxpicker = document.querySelector("div.boxpicker");

            ketRoutes.value = "";
            inputFrom.value = "";
            inputTo.value = "";
            inputDepartureTime.value = "";

            String.prototype.capitalize = function() {
                return this.charAt(0).toUpperCase()+this.slice(1);
            }

            // set from and to place ketika user click place
            loc.addEventListener('click',function(e){
                const cek = e.target.classList.contains('places');
                if(cek != false) {
                    const place_id = e.target.getAttribute('place_id');
                    const place_name = e.target.getAttribute('place_name').capitalize();

                    if(inputFrom.value.length==0) {
                        ketRoutes.value = place_name;
                        inputFrom.value = place_id;

                    } else if(inputTo.value.length==0 && inputFrom.value != place_id) {

                        let hasTOonespace = /\sto/i;
                        let hasTOtwospace = /\sto\s/i;
                        if(hasTOtwospace.test(ketRoutes.value)) {
                            ketRoutes.value += place_name;
                            inputTo.value = place_id;
                        } else if(hasTOonespace.test(ketRoutes.value)) {
                            ketRoutes.value += " "+place_name;
                            inputTo.value = place_id;
                        } else {
                            ketRoutes.value += " to "+place_name;
                            inputTo.value = place_id;
                        }

                        getRoutes.removeAttribute('disabled');
                    }
                }
            });

            // set departure time ketika user ketik at lalu waktu-nya
            ketRoutes.addEventListener('input',function(){
                const hasAT = /\sat\s/i;
                const hasTO = /\sto\s/i;
                const space = /\s/g;
                const str = ketRoutes.value;

                if(hasAT.test(str)) {

                    if(inputFrom.length != 0 && inputTo.length != 0 && str.match(/\s?at\s/ig).length == 1) {
                        let arr = str.replace(space,'').split('at');
                        inputDepartureTime.value = arr[1];

                        // show timepicker and set position boxpicker
                        $(timepicker).show();
                        boxpicker.style.top = (loc.offsetTop+timepicker.offsetTop+30)+"px";
                        boxpicker.style.left = (loc.offsetLeft+timepicker.offsetLeft-230)+"px";

                    } else {
                        inputDepartureTime.value = inputDepartureTime.value;

                        // hide timepicker and box picker
                        $(timepicker).hide();
                        $(boxpicker).hide();
                    }

                } else if(hasTO.test(str) && !hasAT.test(str)) {
                    inputDepartureTime.value = "";
                    // hide timepicker and box picker
                    $(timepicker).hide();
                    $(boxpicker).hide();

                    if(str.match(/\s?to\s/ig).length == 1) {
                        let arr = str.replace(space,'').split('to');

                        if(arr[1].length == 0) {
                            inputTo.value = "";

                            // disable button get route
                            getRoutes.setAttribute('disabled','');
                        }
                    }

                } else if(!hasTO.test(str) && !hasAT.test(str)) {
                    // hide timepicker and box picker
                    $(timepicker).hide();
                    $(boxpicker).hide();

                    // disable button get route
                    getRoutes.setAttribute('disabled','');

                    if(str.length == 0) {
                        inputFrom.value = "";
                        inputTo.value = "";
                        inputDepartureTime.value = "";
                    } else {
                        inputTo.value = "";
                        inputDepartureTime.value = "";
                    }
                }
            });

            // show boxpicker
            timepicker.addEventListener('click',function(){
                $("div.boxpicker").toggle();
                $("form#formBoxpicker")[0].reset();
            });

            /// set departure time dengan date picker
            function setDepartureTime(hourse,minutes,second) {
                const str = ketRoutes.value;
                const regex = /\sat\s/i

                if(inputFrom.length != 0 && inputTo.length != 0 && regex.test(str)) {

                    let posisi = str.search(regex);
                    let data = str.substr(0,posisi+4);

                    inputDepartureTime.value = hourse+':'+minutes+':'+second;
                    ketRoutes.value = data+hourse+':'+minutes+':'+second;
                }
            }

            let hourse = boxpicker.querySelector('input[type="range"]#hourse');
            let minutes = boxpicker.querySelector('input[type="range"]#minutes');
            let second = boxpicker.querySelector('input[type="range"]#second');

            hourse.addEventListener('input',function(){
                setDepartureTime(hourse.value,minutes.value,second.value);
            });

            minutes.addEventListener('input',function(){
                setDepartureTime(hourse.value,minutes.value,second.value);
            });

            second.addEventListener('input',function(){
                setDepartureTime(hourse.value,minutes.value,second.value);
            });
            /// set departure time dengan date picker end

            getRoutes.addEventListener('click', function(e){
                e.preventDefault();

                const from_place_id = inputFrom.value;
                const to_place_id = inputTo.value;
                const departure_time = inputDepartureTime.value;

                // generate dataSend
                let dataSend = from_place_id+'/'+to_place_id;
                if(departure_time.length != 0) {
                    dataSend = from_place_id+'/'+to_place_id+'/'+departure_time;
                }

                if(from_place_id.length != 0 && to_place_id.length != 0) {

                    ketRoutes.value = "";

                    // hide timepicker and box picker
                    $(timepicker).hide();
                    $(boxpicker).hide();

                    $.ajax({
                        type:"get",
                        url:"http://localhost:8000/api/route/search/"+dataSend,
                        dataType:'json',
                        data:{api_token:'umum'},
                        beforeSend:function() {
                            if($("li.routeList").length == 0) {
                                $("li.loadingRoutes").fadeIn();
                            } else {
                                $("li.routeList").hide();
                                $("li.loadingRoutes").fadeIn();
                            }
                        },
                        success:function(response) {
                            let hasil = '';
                            if(response.data.length == 0) {
                                hasil += '<li class="routeList">No reute in schedules</li>';
                            } else {
                                response.data.forEach(function(e){
                                    hasil += '<li class="routeList">';
                                    hasil += '<a class="linkRoute"';
                                    hasil += 'schedule_id="'+e.schedules.schedule_id+'" ';
                                    hasil += 'from_place_id="'+e.schedules.from_place.id+'" ';
                                    hasil += 'to_place_id="'+e.schedules.to_place.id+'" ';
                                    hasil += 'from_place="'+e.schedules.from_place.name+'" ';
                                    hasil += 'to_place="'+e.schedules.to_place.name+'">';
                                        hasil += e.schedules.from_place.name.capitalize();
                                        hasil += ' to ';
                                        hasil += e.schedules.to_place.name.capitalize();
                                        hasil += ' => Departure time -> '+e.schedules.departure_time;
                                        hasil += ' => Arrival time -> '+e.schedules.arrival_time+', ';
                                        hasil += ' '+e.schedules.type.capitalize();
                                        hasil += ' Line '+e.schedules.line+', ';
                                        hasil += e.schedules.travel_time+', ';
                                        hasil += e.number_selection+' transfer';
                                    hasil += '</a>';
                                    hasil += '</li>';
                                });
                            }

                            $("li.loadingRoutes").fadeOut(function(){
                                $("ul#routes route").html(hasil);

                                inputFrom.value = "";
                                inputTo.value = "";
                                inputDepartureTime.value = "";
                                getRoutes.setAttribute('disabled','');
                            });
                        },
                        error:function(response) {
                            let hasil = '<li class="routeList">'+response.responseJSON.message+'</li>';

                            $("li.loadingRoutes").fadeOut(function(){
                                $("ul#routes route").html(hasil);

                                inputFrom.value = "";
                                inputTo.value = "";
                                inputDepartureTime.value = "";
                                getRoutes.setAttribute('disabled','');
                            });
                        }
                    })
                }
            });

        /* mapView */
            const route = document.querySelector('ul#routes route');
            const namaArea = document.querySelectorAll('a.namaArea');

            function setColorFromandToPlace(e) {
                const from_place = e.target.getAttribute('from_place');
                const to_place = e.target.getAttribute('to_place');

                // set default strokecolor
                if(localStorage.getItem('webclientRouteFromPlace') == null) {
                    localStorage.setItem('webclientRouteFromPlace',from_place);
                    localStorage.setItem('webclientRouteToPlace',to_place);
                }

                const from_placeLocalS = localStorage.getItem('webclientRouteFromPlace');
                const to_placeLocalS = localStorage.getItem('webclientRouteToPlace');

                $("area#"+from_placeLocalS+",area#"+to_placeLocalS).data('maphilight',{
                    strokeColor: '0000',
                });

                $("area#"+from_place).data('maphilight',{
                    strokeColor: '38d0cf',
                    fillColor: "38d0cf",
                    fillOpacity: 1,
                });

                $("area#"+to_place).data('maphilight',{
                    strokeColor: '0962a5',
                    fillColor: "0962a5",
                    fillOpacity: 1,
                });

                // map wrap
                $("#"+from_place+",#"+to_place+",#"+from_placeLocalS+",#"+to_placeLocalS).wrap(function () {
                    //This block is what creates highlighting by trigger the "alwaysOn", 
                    let data = $(this).data('maphilight') || {};
                    data.alwaysOn = !data.alwaysOn;
                    $(this).data('maphilight', data).trigger('alwaysOn.maphilight');
                     //there is also "neverOn" in the docs, but not sure how to get it to work
                });

                // set localstorage value
                localStorage.setItem('webclientRouteFromPlace',from_place);
                localStorage.setItem('webclientRouteToPlace',to_place);
            }

            route.addEventListener('click',function(e){
                if(e.target.classList.contains('linkRoute') == true) {

                    const from_place_id = e.target.getAttribute('from_place_id');
                    const to_place_id = e.target.getAttribute('to_place_id');
                    const schedule_id = e.target.getAttribute('schedule_id');
                    const api_token = "{{session()->get('WebclientSession')['api_token']??'umum'}}";
                    let user = "umum";
                    const loaderNavbar = document.querySelector('div.loaderNavbar');
                    const conNavbarLoader = document.querySelector('div.conNavbarLoader');

                    <?php  
                        if(session()->has('WebclientSession')) :
                    ?>
                    user = "{{session()->get('WebclientSession')['user']}}";
                    <?php endif; ?>

                    $.ajax({
                        type:"POST",
                        url:"http://localhost:8000/api/route/selection?api_token="+api_token,
                        dataType:'json',
                        data:{from_place_id:from_place_id,to_place_id:to_place_id,schedule_id:schedule_id,user:user},
                        beforeSend:function() {
                            conNavbarLoader.classList.add('muncul');
                            loaderNavbar.classList.add('width80');
                        },
                        success:function(response) {
                            loaderNavbar.classList.replace('width80','width100');
                            conNavbarLoader.classList.replace('muncul','remove');
                            setTimeout(function(){
                                conNavbarLoader.classList.remove('remove');
                                loaderNavbar.classList.remove('width100');
                            },1500);

                            setColorFromandToPlace(e);
                        },
                        error:function(response) {
                            loaderNavbar.classList.replace('width80','width100');
                            conNavbarLoader.classList.replace('muncul','remove');
                            setTimeout(function(){
                                conNavbarLoader.classList.remove('remove');
                                loaderNavbar.classList.remove('width100');
                            },1500);

                            setColorFromandToPlace(e);
                        }
                    });
                }
            });

            if(namaArea.length != 0) {
                namaArea.forEach(function(e){
                    e.addEventListener('click', function() {
                        $("map div.ketArea:not(#"+e.getAttribute('id')+")").hide();
                        $("map div#"+e.getAttribute('id')).fadeToggle();
                    });
                })
            }

        /* show password */
            const password = document.querySelector('.modalLogin span#password');
            const inputPassword = document.querySelector('.modalLogin form.form input#password');

            password.addEventListener('click', function(){
                const attribute = inputPassword.getAttribute('type');
                const span = password.querySelector('span');

                if(attribute == 'password') {
                    inputPassword.setAttribute('type','text');
                    span.setAttribute('class','fa fa-unlock-alt fa-lg');
                } else {
                    inputPassword.setAttribute('type','password');
                    span.setAttribute('class','fa fa-lock fa-lg');
                }
            });
    });
</script>
@endsection