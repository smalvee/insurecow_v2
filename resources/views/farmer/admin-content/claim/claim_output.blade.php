@extends('super-admin.admin-panel.index')

@section('content')
    <main>
        <header
            class="page-header page-header-compact page-header-light border-bottom bg-white mb-4"
        >
            <div class="container-xl px-4">
                <div class="page-header-content">
                    <div
                        class="row align-items-center justify-content-between pt-3"
                    >
                        <div class="col-auto mb-3">
                            <h1 class="page-header-title">
                                <div class="page-header-icon">
                                    <i data-feather="user"></i>
                                </div>
                                Claim Insurance - 
                                {{-- <span style="color: red">&nbsp;Under Construction</span> --}}
                            </h1>
                        </div>
                    </div>
                </div>
            </div>
        </header>
        <!-- Main page content-->
        <div class="container-xl px-4 mt-4">
            <!-- Account page navigation-->
            <div class="row">


                <div class="col-xl-12">
                    <!-- Account details card-->
                    <div class="card mb-4">
                        <div class="card-header">Claim Insurance -<span
                                {{-- style="color: red">&nbsp;Under Construction</span></div> --}}
                        <div class="card-body">

                            {{-- ---------------------------------------- Farmer Cow Registration ---------------------------------------- --}}

                            @if(session('claim_success'))
                                <div class="alert alert-success" role="alert">

                                    {{ session('claim_success') }}
                                    <br>
                                    <br>
                                    @foreach($cattle as $c)
                                    <div>
                                        <label>Cattle ID: {{ $c->id }}</label>
                                    </div>
                                    <label>Cattle Name: {{ $c->cattle_name }}</label>
                                    @endforeach
                                </div>
                            @elseif(session('claim_failed'))
                                <div class="alert alert-danger" role="alert">
                                    {{ session('claim_failed') }}
                                </div>
                            @elseif(session('error'))
                                <div class="alert alert-warning" role="alert">
                                    {{ session('error') }}
                                </div>
                            @endif

                            

                            {{-- ---------------------------------------- Farmer Cow Registration ---------------------------------------- --}}

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

@endsection
