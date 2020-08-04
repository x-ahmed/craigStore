@extends('layouts.admin')
@section('title', 'Create New Main Category')

@section('content')

<div class="app-content content">
        <div class="content-wrapper">
            <div class="content-header row">
                <div class="content-header-left col-md-6 col-12 mb-2">
                    <div class="row breadcrumbs-top">
                        <div class="breadcrumb-wrapper col-12">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item">
                                    <a href="{{route('admin.dashboard')}}">الرئيسية</a>
                                </li>
                                <li class="breadcrumb-item">
                                    <a href="{{route('admin.main.cates')}}">الاقسام الرئيسيه</a>
                                </li>
                                <li class="breadcrumb-item active">اضافة جديد</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
            <div class="content-body">
                <!-- Basic form layout section start -->
                <section id="basic-form-layouts">
                    <div class="row match-height">
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-header">
                                    <h4
                                        class="card-title"
                                        id="basic-layout-form">اضافة قسم رئيسى</h4>
                                    <a class="heading-elements-toggle">
                                        <i class="la la-ellipsis-v font-medium-3"></i>
                                    </a>
                                    <div class="heading-elements">
                                        <ul class="list-inline mb-0">
                                            <li>
                                                <a data-action="collapse">
                                                    <i class="ft-minus"></i>
                                                </a>
                                            </li>
                                            <li>
                                                <a data-action="reload">
                                                    <i class="ft-rotate-cw"></i>
                                                </a>
                                            </li>
                                            <li>
                                                <a data-action="expand">
                                                    <i class="ft-maximize"></i>
                                                </a>
                                            </li>
                                            <li>
                                                <a data-action="close">
                                                    <i class="ft-x"></i>
                                                </a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>

                                @include('admin.includes.alerts.success')
                                @include('admin.includes.alerts.errors')

                                <div class="card-content collapse show">
                                    <div class="card-body">
                                        <form
                                            class="form"
                                            action="{{route('admin.main.cate.save')}}"
                                            method="post"
                                            enctype="multipart/form-data">

                                            @csrf
                                            
                                            <div class="form-body">
                                                <h4 class="form-section">
                                                    <i class="ft-home"></i>
                                                    <span>التفاصيل</span>
                                                </h4>

                                                @if (getActiveLangs()->count() > 0)
                                                    @foreach (getActiveLangs() as $index => $lang)
                                                    <div class="row">

                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label for="cate-name">الاسم - {{__('global.' .$lang->abbr)}}</label>
                                                                <input
                                                                    type="text"
                                                                    value=""
                                                                    id="cate-name"
                                                                    name="cate_bags[{{$index}}][cate_name]"
                                                                    class="form-control"
                                                                    placeholder="ادخل اسم القسم الرئيسى" />

                                                                @error('cate_bags.' .$index. '.cate_name')
                                                                    <span class="text-danger">{{$message}}</span>
                                                                @enderror
                                                                
                                                            </div>
                                                        </div>

                                                        <div class="col-md-0 hidden">
                                                            <div class="form-group">
                                                                <label for="cate-abbr">الاختصار - {{__('global.' .$lang->abbr)}}</label>
                                                                <input
                                                                    type="text"
                                                                    value="{{$lang->abbr}}"
                                                                    id="cate-abbr"
                                                                    name="cate_bags[{{$index}}][cate_abbr]"
                                                                    class="form-control"
                                                                    placeholder="ادخل اختصار لغة القسم" />

                                                                @error('cate_bags.' .$index. '.cate_abbr')
                                                                    <span class="text-danger">{{$message}}</span>
                                                                @enderror
                                                                
                                                            </div>
                                                        </div>

                                                        <div class="col-md-6">
                                                            <div class="form-group" style="margin-top: 30px;">
                                                                <input
                                                                    type="checkbox"
                                                                    name="cate_bags[{{$index}}][cate_stat]"
                                                                    value="1"
                                                                    id="switcheryColor4"
                                                                    class="switchery"
                                                                    data-color="success"
                                                                    checked />

                                                                <label
                                                                for="switcheryColor4"
                                                                class="card-title ml-1">الحالة - {{__('global.' .$lang->abbr)}}</label>

                                                                @error('cate_bags.' .$index. '.cate_stat')
                                                                    <div>
                                                                        <span class="text-danger">{{$message}}</span>
                                                                    </div>
                                                                @enderror

                                                            </div>
                                                        </div>

                                                    </div>
                                                    @endforeach
                                                @endif

                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="cate_imag">الصوره</label>
                                                            <input
                                                                type="file"
                                                                class="form-control form-control-file"
                                                                name="cate_imag"
                                                                id="cate_imag" />

                                                            @error('cate_imag')
                                                                <div>
                                                                    <span class="text-danger">{{$message}}</span>
                                                                </div>
                                                            @enderror

                                                        </div>
                                                    </div>
                                                </div>

                                            <div class="form-actions">
                                                <button
                                                    type="button"
                                                    class="btn btn-warning mr-1"
                                                    onclick="history.back();">
                                                    
                                                    <i class="ft-x"></i>
                                                    <span>تراجع</span>
                                                </button>

                                                <button
                                                    type="submit"
                                                    class="btn btn-primary">

                                                    <i class="la la-check-square-o"></i>
                                                    <span>حفظ</span>
                                                </button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
                <!-- // Basic form layout section end -->
            </div>
        </div>
    </div>

@endsection