@extends('layouts.admin')
@section('title', 'Edit New Main Category')

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
                                <li class="breadcrumb-item active">تعديل قسم رئيسى</li>
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
                                        id="basic-layout-form">تعديل قسم رئيسى</h4>
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
                                            
                                            <div class="form-body">
                                                <h4 class="form-section">
                                                    <i class="ft-home"></i>
                                                    <span>تفاصيل قسم رئيسى</span>
                                                </h4>

                                                <div class="row">

                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="cate-name">الاسم</label>
                                                            <input
                                                                type="text"
                                                                value="{{old('name', $cate->name)}}"
                                                                id="cate-name"
                                                                name="cate-name"
                                                                class="form-control"
                                                                placeholder="ادخل اسم قسم رئيسى" />

                                                            @error('cate-name')
                                                                <span class="text-danger">{{$message}}</span>
                                                            @enderror
                                                            
                                                        </div>
                                                    </div>

                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="cate-abbr">الاختصار</label>
                                                            <input
                                                                type="text"
                                                                value="{{old('abbr', $cate->abbr)}}"
                                                                id="cate-abbr"
                                                                name="cate-abbr"
                                                                class="form-control"
                                                                placeholder="ادخل اختصار قسم رئيسى" />

                                                            @error('cate-abbr')
                                                                <span class="text-danger">{{$message}}</span>
                                                            @enderror
                                                            
                                                        </div>
                                                    </div>

                                                </div>

                                                {{-- <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="cate-dire">الاتجاة</label>
                                                            <select
                                                                id="cate-dire"
                                                                name="cate-dire"
                                                                class="select2 form-control">

                                                                <optgroup label="من فضلك أختر اتجاه اللغة">
                                                                    <option
                                                                        value="rtl"
                                                                        {{(old('direction', $cate->direction) == 'rtl')? 'selected': ''}}>
                                                                        
                                                                        <span>من اليمين الي اليسار</span>
                                                                    </option>
                                                                
                                                                    <option
                                                                        value="ltr"
                                                                        {{(old('direction', $cate->direction) == 'ltr')? 'selected': ''}}>
                                                                        
                                                                        <span>من اليسار الي اليمين</span>
                                                                    </option>
                                                                </optgroup>
                                                            </select>

                                                            @error('cate-dire')
                                                                <span class="text-danger">{{$message}}</span>
                                                            @enderror
                                                            
                                                        </div>
                                                    </div>
                                                </div> --}}


                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="form-group mt-1">
                                                            <input
                                                                type="checkbox"
                                                                name="cate-stat"
                                                                id="switcheryColor4"
                                                                value="1"
                                                                class="switchery"
                                                                data-color="success"
                                                                @if (old('status', $cate->status) == 1) checked @endif />
                                                            <label
                                                                for="switcheryColor4"
                                                                class="card-title ml-1">الحالة</label>

                                                            @error('cate-stat')
                                                                <div>
                                                                    <span class="text-danger">{{$message}}</span>
                                                                </div>
                                                            @enderror

                                                        </div>
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