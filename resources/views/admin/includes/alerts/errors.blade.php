<!-- START ALERT SECTION-->
@if (Session::has('error'))

    <!-- START ALERT SECTION-->
    <div class="row mr-2 ml-2">
        <button
            type="text"
            class="btn btn-lg btn-block btn-outline-danger mb-2"
            id="type-error">   
                {{ Session::get('error') }}
        </button>
    </div>
    <!-- END ALERT SECTION-->

@endif