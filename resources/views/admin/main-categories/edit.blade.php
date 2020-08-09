@extends('layouts.admin')
@section('title', 'Edit Main Category')

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
                            <li class="breadcrumb-item active">تعديل القسم</li>
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
                                    id="basic-layout-form">تعديل القسم الرئيسي</h4>
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
                                        action="{{route('admin.main.cate.update', $cate->id)}}"
                                        method="post"
                                        enctype="multipart/form-data">

                                        @csrf

                                        {{-- HIDDEN INPUT TO DEACTIVATE REQUIRED VALIDATIONS --}}
                                        <input
                                            type="hidden"
                                            name="edit"
                                            value="{{$cate->id}}" />
                                        
                                        <div class="form-body">
                                            <h4 class="form-section">
                                                <i class="ft-home"></i>
                                                <span>التفاصيل</span>
                                            </h4>

                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        {{-- <label for="cate_imag">الصوره</label> --}}
                                                        <input
                                                            type="file"
                                                            class="form-control form-control-lg form-control-file"
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
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <div class="text-center">
                                                            <img
                                                                style="width: 100%; height:450px;"
                                                                class="{{--rounded-circle--}} {{--height-200--}}"
                                                                src="{{old('photo', $cate->photo)}}"
                                                                alt="{{$cate->name}} Photo" />
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row">

                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="cate-name">الاسم - {{__('global.' .$cate->trans_lang)}}</label>
                                                        <input
                                                            type="text"
                                                            value="{{old('name', $cate->name)}}"
                                                            id="cate-name"
                                                            name="cate_bags[1000][cate_name]"
                                                            class="form-control"
                                                            placeholder="ادخل اسم القسم الرئيسى" />

                                                        @error('cate_bags.1000.cate_name')
                                                            <span class="text-danger">{{$message}}</span>
                                                        @enderror
                                                        
                                                    </div>
                                                </div>

                                                <div class="col-md-0 hidden">
                                                    <div class="form-group">
                                                        <label for="cate-abbr">الاختصار - {{__('global.' .$cate->trans_lang)}}</label>
                                                        <input
                                                            type="hidden"
                                                            value="{{old('trans_lang', $cate->trans_lang)}}"
                                                            id="cate-abbr"
                                                            name="cate_bags[1000][cate_abbr]"
                                                            class="form-control"
                                                            placeholder="ادخل اختصار لغة القسم" />

                                                        @error('cate_bags.1000.cate_abbr')
                                                            <span class="text-danger">{{$message}}</span>
                                                        @enderror
                                                        
                                                    </div>
                                                </div>

                                                <div class="col-md-6">
                                                <div class="form-group text-center" style="{{--margin-top: 30px;--}}">
                                                        <label
                                                            style="display: block; margin-bottom: 13px;"
                                                            for="switcheryColor4"
                                                            class="card-title">الحالة - {{__('global.' .$cate->trans_lang)}}</label>
                                                        <input
                                                            type="checkbox"
                                                            name="cate_bags[1000][cate_stat]"
                                                            value="1"
                                                            id="switcheryColor4"
                                                            class="switchery"
                                                            data-color="success"
                                                            {{(old('status', $cate->status) == 1)? 'checked': ''}} />

                                                        @error('cate_bags.1000.cate_stat')
                                                            <div>
                                                                <span class="text-danger">{{$message}}</span>
                                                            </div>
                                                        @enderror

                                                    </div>
                                                </div>

                                            </div>

                                            @if (isset($cate->trans_cates) && $cate->trans_cates->count() > 0)
                                                @foreach ($cate->trans_cates as $index => $trans_cate)
                                                <div class="row">

                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="cate-name">الاسم - {{__('global.' .$trans_cate->trans_lang)}}</label>
                                                            <input
                                                                type="text"
                                                                value="{{old('name', $trans_cate->name)}}"
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
                                                            {{-- <label for="cate-abbr">الاختصار - {{__('global.' .$trans_cate->trans_lang)}}</label> --}}
                                                            <input
                                                                type="hidden"
                                                                value="{{old('trans_lang', $trans_cate->trans_lang)}}"
                                                                id="cate-abbr"
                                                                name="cate_bags[{{$index}}][cate_abbr]"
                                                                class="form-control"
                                                                placeholder="ادخل اختصار لغة القسم" />

                                                            @error('cate_bags.' .$index. '.cate_abbr')
                                                                <span class="text-danger">{{$message}}</span>
                                                            @enderror
                                                            
                                                        </div>
                                                    </div>
                                                    <div class="col-md-0 hidden">
                                                        <div class="form-group">
                                                            {{-- <label for="cate-abbr">الاب - {{__('global.' .$trans_cate->trans_lang)}}</label> --}}
                                                            <input
                                                                type="hidden"
                                                                value="{{old('trans_of', $trans_cate->trans_of)}}"
                                                                id="cate-abbr"
                                                                name="cate_bags[{{$index}}][cate_trans]"
                                                                class="form-control"
                                                                placeholder="ادخل اختصار لغة القسم" />

                                                            @error('cate_bags.' .$index. '.cate_trans')
                                                                <span class="text-danger">{{$message}}</span>
                                                            @enderror
                                                            
                                                        </div>
                                                    </div>
                                                    <div class="col-md-0 hidden">
                                                        <div class="form-group">
                                                            {{-- <label for="cate-abbr">الابن - {{__('global.' .$trans_cate->trans_lang)}}</label> --}}
                                                            <input
                                                                type="hidden"
                                                                value="{{old('id', $trans_cate->id)}}"
                                                                id="cate-abbr"
                                                                name="cate_bags[{{$index}}][cate_id]"
                                                                class="form-control"
                                                                placeholder="ادخل اختصار لغة القسم" />

                                                            @error('cate_bags.' .$index. '.cate_id')
                                                                <span class="text-danger">{{$message}}</span>
                                                            @enderror
                                                            
                                                        </div>
                                                    </div>

                                                    <div class="col-md-6">
                                                        <div class="form-group text-center" style="{{--margin-top: 30px;--}}">
                                                            <label
                                                                style="display: block; margin-bottom: 13px;"
                                                                for="switcheryColor4"
                                                                class="card-title">الحالة - {{__('global.' .$trans_cate->trans_lang)}}</label>
                                                            <input
                                                                type="checkbox"
                                                                name="cate_bags[{{$index}}][cate_stat]"
                                                                value="1"
                                                                id="switcheryColor4"
                                                                class="switchery"
                                                                data-color="success"
                                                                {{(old('status', $trans_cate->status) == 1)? 'checked': ''}} />

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
                                                <span>تحديث</span>
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