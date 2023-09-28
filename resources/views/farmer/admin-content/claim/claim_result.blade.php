<?php
use Illuminate\Support\Facades\DB;

?>
@extends('super-admin.admin-panel.index')

@section('content')
<main>
    <header class="page-header page-header-compact page-header-light border-bottom bg-white mb-4">
        <div class="container-xl px-4">
            <div class="page-header-content">
                <div class="row align-items-center justify-content-between pt-3">
                    <div class="col-auto mb-3">
                        <h1 class="page-header-title">
                            <div class="page-header-icon">
                                <i data-feather="user"></i>
                            </div>
                            Match successfully
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
                <div class="card mb-4">
                    <div class="card-header">Cow Details
                        <div class="card-body">

                            <div>
                                @foreach($results as $info)
                                <h5><strong>ID: </strong>  {{ $info->cattle_r_id }}</h5>
                                <h5><strong>Name: </strong> {{ $info->cattle_name }}</h5>                                
                                <h5><strong>Cattle Color: </strong> {{ $info->cattle_color }}</h5>
                                <h5><strong>Cattle Weight: </strong> {{ $info->weight }}</h5>
                                <h5><strong>Cattle Type: </strong> {{ $info->cattle_type }}</h5>
                                <?php
                                
                                $farmer_id = $info->user_id;
                                $user = DB::select('SELECT * FROM users WHERE id = ?', [$farmer_id]);
                                ?>
                                    @foreach($user as $u)
                                    <h5><strong>Farmer Name: </strong> {{ $u->name }}</h5>
                                    @endforeach
                                
                                @endforeach
                            </div>


                        </div>
                    </div>
                </div>
            </div>



        </div>
    </div>
</main>

@endsection