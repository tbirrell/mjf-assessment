@extends('layouts.app')

@section('content')
    <drinks-log
        :drinks="{{$drinks}}"
        :drink_log="{{$drink_log}}"
        :lifetime_consumption="{{$lifetime_consumption}}"
    ></drinks-log>
@endsection
