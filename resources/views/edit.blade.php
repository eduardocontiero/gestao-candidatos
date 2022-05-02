@extends('layout')

@section('content')
<edit-candidate
:user-data="{{ json_encode($user)}}"
:professional-data="{{ json_encode($professional)}}"
:academic-data="{{ json_encode($academic)}}"
></edit-candidate>
@endsection