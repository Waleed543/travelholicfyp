@extends('layouts.app')
@section('nav','fixed-top')
@section('content')

<div class="container" style="margin-top: 10rem; background-color: lightgrey;  border-radius: 20px; color: #40474e">

    <h2>Jquery UI Datepicker Disable Specific Dates Example - Nicesnippets.com</h2>
    <div class="container">
        <label>Date :</label>
        <input  id="test" type='text' class='date'>
    </div>
    </body>


</div>
    @endsection

@section('js_bottom')
    <link href="http://code.jquery.com/ui/1.9.2/themes/smoothness/jquery-ui.css" rel="stylesheet" />
    <script src="http://code.jquery.com/ui/1.9.2/jquery-ui.js"></script>
    <script type="text/javascript">
        var array = ["04-03-2021","05-03-2021","03-06-2020","15-06-2020"]
        $('#test').datepicker({
            beforeShowDay: function(date){
                var string = jQuery.datepicker.formatDate('dd-mm-yy', date);
                return [ array.indexOf(string) == -1 ]
            }
        });
    </script>
    @endsection
