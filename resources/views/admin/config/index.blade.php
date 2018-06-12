@extends("layouts.app")

@section("content")

    <style>

        input[type=checkbox] {
            visibility: hidden;
        }

        /* SLIDE THREE */
        .slideThree {
            width: 80px;
            height: 26px;
            background: #333;
            margin: 20px;

            -webkit-border-radius: 50px;
            -moz-border-radius: 50px;
            border-radius: 50px;
            position: relative;

            -webkit-box-shadow: inset 0px 1px 1px rgba(0,0,0,0.5), 0px 1px 0px rgba(255,255,255,0.2);
            -moz-box-shadow: inset 0px 1px 1px rgba(0,0,0,0.5), 0px 1px 0px rgba(255,255,255,0.2);
            box-shadow: inset 0px 1px 1px rgba(0,0,0,0.5), 0px 1px 0px rgba(255,255,255,0.2);
        }

        .slideThree:after {
            content: 'OFF';
            font: 12px/26px Arial, sans-serif;
            color: #000;
            position: absolute;
            right: 10px;
            z-index: 0;
            font-weight: bold;
            text-shadow: 1px 1px 0px rgba(255,255,255,.15);
        }

        .slideThree:before {
            content: 'ON';
            font: 12px/26px Arial, sans-serif;
            color: #00bf00;
            position: absolute;
            left: 10px;
            z-index: 0;
            font-weight: bold;
        }

        .slideThree label {
            display: block;
            width: 34px;
            height: 20px;

            -webkit-border-radius: 50px;
            -moz-border-radius: 50px;
            border-radius: 50px;

            -webkit-transition: all .4s ease;
            -moz-transition: all .4s ease;
            -o-transition: all .4s ease;
            -ms-transition: all .4s ease;
            transition: all .4s ease;
            cursor: pointer;
            position: absolute;
            top: 3px;
            left: 3px;
            z-index: 1;

            -webkit-box-shadow: 0px 2px 5px 0px rgba(0,0,0,0.3);
            -moz-box-shadow: 0px 2px 5px 0px rgba(0,0,0,0.3);
            box-shadow: 0px 2px 5px 0px rgba(0,0,0,0.3);
            background: #fcfff4;

            background: -webkit-linear-gradient(top, #fcfff4 0%, #dfe5d7 40%, #b3bead 100%);
            background: -moz-linear-gradient(top, #fcfff4 0%, #dfe5d7 40%, #b3bead 100%);
            background: -o-linear-gradient(top, #fcfff4 0%, #dfe5d7 40%, #b3bead 100%);
            background: -ms-linear-gradient(top, #fcfff4 0%, #dfe5d7 40%, #b3bead 100%);
            background: linear-gradient(top, #fcfff4 0%, #dfe5d7 40%, #b3bead 100%);
            filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#fcfff4', endColorstr='#b3bead',GradientType=0 );
        }

        .slideThree input[type=checkbox]:checked + label {
            left: 43px;
        }

    </style>

    <h1>Config</h1>

    <div class="slideThree">
        <input type="checkbox" value="None" id="slideThree" name="check" />
        <label for="slideThree"></label>
    </div>
    
@endsection