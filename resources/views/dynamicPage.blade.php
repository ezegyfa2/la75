<?php
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Session;
?>
@extends('layouts.app')

@section('content')
    <dynamic-component v-bind:component_infos="<?= str_replace('"', "'", json_encode($template)) ?>"></dynamic-component>
@endsection
