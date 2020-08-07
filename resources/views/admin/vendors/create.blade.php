@extends('layouts.admin')

@section('title', 'Create New Vendor')

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
                                <a href="{{route('admin.vendors')}}">المتاجر</a>
                            </li>
                            <li class="breadcrumb-item active">اضافة متجر جديد</li>
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
                                    id="basic-layout-form">اضافة متجر</h4>
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
                                        action="{{route('admin.vendor.save')}}"
                                        method="post"
                                        enctype="multipart/form-data">

                                        @csrf
                                        
                                        <div class="form-body">
                                            <h4 class="form-section">
                                                <i class="ft-home"></i>
                                                <span>التفاصيل</span>
                                            </h4>

                                            <div class="row">
                                                <div class="col-md-10">
                                                    <div class="form-group">
                                                        <label for="vend-name">الاسم</label>
                                                        <input
                                                            type="text"
                                                            id="vend-name"
                                                            name="vend-name"
                                                            class="form-control"
                                                            placeholder="ادخل اسم المتجر" />

                                                        @error('vend-name')
                                                            <span class="text-danger">{{$message}}</span>
                                                        @enderror
                                                        
                                                    </div>
                                                </div>
                                                <div class="col-md-2">
                                                    <div class="form-group" style="{{--margin-top: 37px;--}}">
                                                        <label
                                                            style="display: block; margin-bottom: 13px;"
                                                            for="switcheryColor4"
                                                            class="card-title mr-1">الحالة</label>
                                                        <input
                                                            type="checkbox"
                                                            name="vend-stat"
                                                            value="1"
                                                            id="switcheryColor4"
                                                            class="switchery"
                                                            data-color="success"
                                                            checked />

                                                        @error('vend-stat')
                                                                <span class="text-danger">{{$message}}</span>
                                                        @enderror

                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="vend-mail">البريد الالكتروني</label>
                                                        <input 
                                                            type="email"
                                                            class="form-control"
                                                            id="vend-mail"
                                                            name="vend-mail"
                                                            placeholder="ادخل البريد الالكتروني" />
                                                        
                                                        @error('vend-mail')
                                                            <span class="text-danger">{{$message}}</span>
                                                        @enderror

                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="vend-cate">القسم</label>
                                                        <select
                                                            id="vend-cate"
                                                            name="vend-cate"
                                                            class="custom-select custom-select-lg">

                                                            <optgroup label="اختر قسم المتجر...">
                                                                
                                                                @if (isset($cates) && $cates->count() > 0)

                                                                    @foreach ($cates as $cate)
                                                                        <option value="{{$cate->id}}">{{$cate->name}}</option>
                                                                    @endforeach
                                                                    
                                                                @endif
                                                                
                                                            </optgroup>
                                                        </select>

                                                        @error('vend-cate')
                                                            <span class="text-danger">{{$message}}</span>
                                                        @enderror
                                                        
                                                    </div>
                                                </div>
                                                
                                            </div>

                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="vend-logo">الشعار</label>
                                                        <input
                                                            type="file"
                                                            class="form-control form-control-file"
                                                            name="vend-logo"
                                                            id="vend-logo" />

                                                        @error('vend-logo')
                                                                <span class="text-danger">{{$message}}</span>
                                                        @enderror

                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="vend-mobi">التليفون</label>
                                                        <input
                                                            type="text"
                                                            id="vend-mobi"
                                                            name="vend-mobi"
                                                            class="form-control"
                                                            placeholder="ادخل رقم التليفون" />

                                                        @error('vend-mobi')
                                                            <span class="text-danger">{{$message}}</span>
                                                        @enderror
                                                        
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label for="vend-addr">العنوان</label>
                                                        <input
                                                            type="text"
                                                            class="form-control"
                                                            id="vend-addr"
                                                            name="vend-addr"
                                                            placeholder="1234 Main St" />
                                                        
                                                        @error('vend-addr')
                                                            <span class="text-danger">{{$message}}</span>
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