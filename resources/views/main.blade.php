@extends('layouts.app')

@section('content')
    <drinks-log
        :drinks="{{$drinks}}"
        :drink_log="{{$drink_log}}"
    ></drinks-log>
@endsection
