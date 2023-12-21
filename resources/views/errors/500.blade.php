@extends('errors::illustrated-layout')

@section('code', ' ')

@section('title', __('Page Not Found'))

@section('image')

<div style="background-image: url('/images/500-bg.jpg');" class="absolute pin bg-no-repeat md:bg-left lg:bg-center">
</div>

@endsection

@section('message', __('Oops, Something went wrong. please try again later'))