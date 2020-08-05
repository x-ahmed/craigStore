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
                            <li class="breadcrumb-item active">

                                @if (getDefaultLang() == 'AR')
                                    <span> تعديل قسم</span>
                                    <span>ال{{$cate->name}}</span>
                                @elseif (getDefaultLang() == 'EN')
                                    <span>Edit {{$cate->name}} Category</span>
                                @endif

                            </li>
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
                                            
                                            {{-- HIDDEN INPUT FOR THE DEACTIVATE IMAGE REQUIRED VALIDATION --}}
                                            <input
                                                type="hidden"
                                                name="edit"
                                                value="{{$cate->id}}" />

                                            <div class="form-body">
                                                <h4 {{--style="margin: 0 7px;"--}} class="form-section">
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
                                                                    style="width: 100%; height:250px;"
                                                                    class="{{--rounded-circle--}} {{--height-200--}}"
                                                                    src="{{old('photo', $cate->photo)}}"
                                                                    alt="{{$cate->name}} Photo" />
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="row">

                                                    <div class="col-md-8">
                                                        <div class="form-group py-0">
                                                            <label for="cate-name">الاسم - {{__('global.' .$cate->trans_lang)}}</label>
                                                            <input
                                                                type="text"
                                                                value="{{old('name', $cate->name)}}"
                                                                id="cate-name"
                                                                name="cate_bags[0][cate_name]"
                                                                class="form-control"
                                                                placeholder="ادخل اسم القسم الرئيسى" />

                                                            @error('cate_bags.0.cate_name')
                                                                <span class="text-danger">{{$message}}</span>
                                                            @enderror
                                                            
                                                        </div>
                                                    </div><br />

                                                    <div class="col-md-0 hidden">
                                                        <div class="form-group">
                                                            <label for="cate-abbr">الاختصار - {{__('global.' .$cate->trans_lang)}}</label>
                                                            <input
                                                                type="text"
                                                                value="{{$cate->trans_lang}}"
                                                                id="cate-abbr"
                                                                name="cate_bags[0][cate_abbr]"
                                                                class="form-control"
                                                                placeholder="ادخل اختصار لغة القسم" />

                                                            @error('cate_bags.0.cate_abbr')
                                                                <span class="text-danger">{{$message}}</span>
                                                            @enderror
                                                            
                                                        </div>
                                                    </div>

                                                    <div class="col-md-4">
                                                        <div class="form-group mb-0" style="margin-top: 30px;">
                                                            <input
                                                                type="checkbox"
                                                                name="cate_bags[0][cate_stat]"
                                                                value="1{{--old('status', $cate->status)--}}"
                                                                id="switcheryColor4"
                                                                class="switchery"
                                                                data-color="success"
                                                                @if(old('status', $cate->status) == 1) checked @endif />

                                                            <label
                                                            for="switcheryColor4"
                                                            class="card-title ml-1">الحالة - {{__('global.' .$cate->trans_lang)}}</label>

                                                            @error('cate_bags.0.cate_stat')
                                                                <div>
                                                                    <span class="text-danger">{{$message}}</span>
                                                                </div>
                                                            @enderror

                                                        </div>
                                                    </div>

                                                </div>
                                            </div>

                                            <div style="border:0" class="form-actions mt-0 pt-0">
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

                                        <ul class="nav nav-tabs">
                                            <li class="nav-item">
                                                <a
                                                    class="nav-link"
                                                    id="homeLable-tab"
                                                    data-toggle="tab"
                                                    href="#homeLable"
                                                    aria-controls="homeLable"
                                                    aria-expanded="true">Home</a>
                                            </li>
                                        </ul>
                                        <div class="tab-content px-1 pt-1">
                                            <div
                                                role="tabpanel"
                                                class="tab-pane"
                                                id="homeLable"
                                                aria-labelledby="homeLable-tab"
                                                aria-expanded="true">
                                                
                                                <form
                                                    class="form"
                                                    action="{{route('admin.main.cate.update', $cate->id)}}"
                                                    method="post"
                                                    enctype="multipart/form-data">

                                                    @csrf
                                                
                                                    {{-- HIDDEN INPUT FOR THE DEACTIVATE IMAGE REQUIRED VALIDATION --}}
                                                    <input
                                                        type="hidden"
                                                        name="edit"
                                                        value="{{$cate->id}}" />

                                                    <div class="form-body">
                                                        <div class="row">
                                                        
                                                            <div class="col-md-3">
                                                                <div class="form-group mb-0" style="margin-top: 30px;">
                                                                    <label
                                                                    for="switcheryColor4"
                                                                    class="card-title mr-1">الحالة - {{__('global.' .$cate->trans_lang)}}</label>

                                                                    <input
                                                                        type="checkbox"
                                                                        name="cate_bags[0][cate_stat]"
                                                                        value="1"
                                                                        id="switcheryColor4"
                                                                        class="switchery"
                                                                        data-color="success"
                                                                        @if(old('status', $cate->status) == 1) checked @endif />

                                                                    @error('cate_bags.0.cate_stat')
                                                                        <div>
                                                                            <span class="text-danger">{{$message}}</span>
                                                                        </div>
                                                                    @enderror
                                                        
                                                                </div>
                                                            </div>
                                                        
                                                            
                                                        
                                                            <div class="col-md-4">
                                                                <div class="form-group my-0">
                                                                    <label for="cate-name">{{--الاسم - {{__('global.' .$cate->trans_lang)}}--}}</label>
                                                                    <input
                                                                        type="text"
                                                                        value="{{old('name', $cate->name)}}"
                                                                        id="cate-name"
                                                                        name="cate_bags[0][cate_name]"
                                                                        class="form-control"
                                                                        placeholder="ادخل اسم القسم الرئيسى" />
                                                        
                                                                    @error('cate_bags.0.cate_name')
                                                                        <span class="text-danger">{{$message}}</span>
                                                                    @enderror
                                                                    
                                                                </div>
                                                            </div>
                                                        
                                                            <div class="col-md-0 hidden">
                                                                <div class="form-group">
                                                                    <label for="cate-abbr">الاختصار - {{__('global.' .$cate->trans_lang)}}</label>
                                                                    <input
                                                                        type="text"
                                                                        value="{{$cate->trans_lang}}"
                                                                        id="cate-abbr"
                                                                        name="cate_bags[0][cate_abbr]"
                                                                        class="form-control"
                                                                        placeholder="ادخل اختصار لغة القسم" />
                                                        
                                                                    @error('cate_bags.0.cate_abbr')
                                                                        <span class="text-danger">{{$message}}</span>
                                                                    @enderror
                                                                    
                                                                </div>
                                                            </div>
                                                        
                                                            <div class="col-md-4 offset-md-1">
                                                                <div style="border:0; margin-top: 30px;" class="form-actions pt-0">
                                                                    <button
                                                                        style="padding: 6px 3px;"
                                                                        type="button"
                                                                        class="btn btn-warning mr-1"
                                                                        onclick="history.back();">
                                                                        
                                                                        <i class="ft-x"></i>
                                                                        <span>تراجع</span>
                                                                    </button>
                                                                    
                                                                    <button
                                                                        style="padding: 6px 1.5px;"
                                                                        type="submit"
                                                                        class="btn btn-primary">
                                                                    
                                                                        <i class="la la-check-square-o"></i>
                                                                        <span>تحديث</span>
                                                                    </button>
                                                                </div>
                                                            </div>
                                                        
                                                            
                                                        
                                                        </div>
                                                    </div>
                                                </form>

                                            </div>
                                            <div
                                                class="tab-pane active"
                                                id="profileLable"
                                                role="tabpanel"
                                                aria-labelledby="profileLable-tab"
                                                aria-expanded="false">
                                                
                                                <p>Pudding candy canes sugar plum cookie chocolate cake powder
                                                croissant. Carrot cake tiramisu danish candy cake muffin
                                                croissant tart dessert. Tiramisu caramels candy canes chocolate
                                                cake sweet roll liquorice icing cupcake.</p>
                                            </div>
                                            <div
                                                class="tab-pane"
                                                id="dropdownLable1"
                                                role="tabpanel"
                                                aria-labelledby="dropdownLable1-tab"
                                                aria-expanded="false">
                                                
                                                <p>Cake croissant lemon drops gummi bears carrot cake biscuit
                                                cupcake croissant. Macaroon lemon drops muffin jelly sugar
                                                plum chocolate cupcake danish icing. Soufflé tootsie roll
                                                lemon drops sweet roll cake icing cookie halvah cupcake.</p>
                                            </div>
                                            <div
                                                class="tab-pane"
                                                id="dropdownLable2"
                                                role="tabpanel"
                                                aria-labelledby="dropdownLable2-tab"
                                                aria-expanded="false">
                                                
                                                <p>Chocolate croissant cupcake croissant jelly donut. Cheesecake
                                                toffee apple pie chocolate bar biscuit tart croissant.
                                                Lemon drops danish cookie. Oat cake macaroon icing tart
                                                lollipop cookie sweet bear claw.</p>
                                            </div>
                                            <div
                                                class="tab-pane"
                                                id="aboutLable"
                                                role="tabpanel"
                                                aria-labelledby="aboutLable-tab"
                                                aria-expanded="false">
                                                
                                                <p>Carrot cake dragée chocolate. Lemon drops ice cream wafer
                                                gummies dragée. Chocolate bar liquorice cheesecake cookie
                                                chupa chups marshmallow oat cake biscuit. Dessert toffee
                                                fruitcake ice cream powder tootsie roll cake.</p>
                                            </div>
                                        </div>

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