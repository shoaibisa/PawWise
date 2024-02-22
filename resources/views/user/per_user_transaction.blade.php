@include('pages.header', ['title' => $user_transaction->name." Details"]) @include('pages.navbar') @include('pages.sidebar')


@php
 $netBalance =$user->netBalanceWithUser($user_transaction);
@endphp
<main id="main" class="main">


    <section class="section profile">
        <div class="row">
            <div class="col-xl-4">

                <div class="card">
                    <div class="card-body profile-card pt-4 d-flex flex-column align-items-center">

                        <img src="{{$user_transaction->profile_pic()}}" alt="Profile" class="rounded-circle">
                        <h2>{{$user_transaction->name}} </h2>
                        <h3>{{$user_transaction->email}} </h3>
                        <div class="social-links mt-2">

                            <p>Net Balance @if($netBalance>0) <i class="bi bi-caret-up-fill text-success" title="You will get"></i> @else <i class="bi bi-caret-down-fill text-danger" title="You have to give"></i> @endif {{$netBalance}}</p>
                        </div>
                        <a href="/addtransaction/?user={{$user_transaction->id}}" class="btn btn-primary">Add Transaction</a>
                    </div>
                </div>

            </div>

            <div class="col-xl-8">

                <div class="card">
                    <div class="card-body pt-3">
                        <!-- Bordered Tabs -->
                        <ul class="nav nav-tabs nav-tabs-bordered">

                            <li class="nav-item">
                                <button class="nav-link @if(!request()->has('to')) active @endif" data-bs-toggle="tab" data-bs-target="#profile-overview">Overview</button>
                            </li>
 


                        </ul>
                        <div class="tab-content pt-2">

                            <div class="tab-pane fade   @if(!request()->has('to'))show  active @endif profile-overview" id="profile-overview">
                                {{-- <h5 class="card-title">About</h5>
                                <p class="small fst-italic">Sunt est soluta temporibus accusantium neque nam maiores cumque temporibus. Tempora libero non est unde veniam est qui dolor. Ut sunt iure rerum quae quisquam autem eveniet perspiciatis odit. Fuga sequi sed ea saepe at
                                    unde.
                                </p> --}}

                                <h5 class="card-title">Profile Details</h5>

                                <div class="row">
                                    <div class="col-lg-3 col-md-4 label ">Full Name</div>
                                    <div class="col-lg-9 col-md-8">{{$user_transaction->name}} </div>
                                </div>


                                <div class="row">
                                    <div class="col-lg-3 col-md-4 label">Email</div>
                                    <div class="col-lg-9 col-md-8">{{$user_transaction->email}} </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-3 col-md-4 label">Created at</div>
                                    <div class="col-lg-9 col-md-8">{{date('M d, Y',strtotime($user->created_at))}} </div>
                                </div>
                                <h5 class="card-title">Addresses</h5>
                                @foreach ($addresses as $id=>$address)
                                <div class="row">
                                    <div class="col-lg-3 col-md-4 label">{{$loop->iteration}}. @foreach ($address as $a) {{$a}} @endforeach </div>
                                </div>
                                @endforeach


                            </div>
 


                        </div>
                        <!-- End Bordered Tabs -->

                    </div>
                </div>

            </div>
        </div>
    </section>
    <div class="row" id="transaction">
        @if(session('msg'))
        <div class="alert {{session('isError')?'alert-danger':'alert-success'}} alert-dismissible">
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            <strong>{{session('isError')?'Failed':'Success'}} !</strong> {{ session('msg') }}

        </div>
        @endif

    </div>
    <div class="col-lg">
        <div class="card">
            <div class="card-body profile-card pt-4 d-flex flex-column align-items-center">
                <h3>Your all transactions with {{$user_transaction->name}}</h3>
                <p>Net Balance @if($netBalance>0) <i class="bi bi-caret-up-fill text-success" title="You will get"></i> @else <i class="bi bi-caret-down-fill text-danger" title="You have to give"></i> @endif {{$netBalance}}</p>

            </div>

        </div>
        <div class="table-responsive">


            <table class="table">
                <thead>
                    <tr>
                        <th>S.No</th>
                        <th style="cursor: pointer;">
                            <a href="?sort_column=fname&sort_ord={{ (!request()->has('sort_ord')  || request()->input('sort_ord') == 'asc') ? 'desc' : 'asc' }}{{ (request()->has('page')) ? '&page=' . request()->input('page') : '' }}" style="text-decoration: none; color: inherit;">
                                <div style="display: flex; align-items: center;">
                                    <b>Amount</b>
                                    <div class="d-flex flex-column">
                                        <i class="bi bi-caret-up "></i>
                                        <i class="bi bi-caret-down{{request()->has('sort_ord')&&!request()->has('sort_column')&&request()->input('sort_column')=='fname'&&request()->input('sort_ord')=='desc'?'-fill':''}}"></i>
                                    </div>
                                </div>
                            </a>
                        </th>
                        <th>Verified</th>
                        <th>From</th>
                        <th>To</th>
                        
                        <th>Action</th>

                        <th>Created At</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($transactions as $id => $transaction)
                    <tr>
                        <td>{{$loop->iteration}}</td>
                        @php
                            $isSender = ($transaction->sender->id==$user->id);
                            
                        @endphp
                        <td><i class="bi bi-caret-{{$isSender?'up':'down'}}-fill text-{{$isSender?'success':'danger'}}" title="{{$isSender?'You will get':'You will give'}}"></i> ${{$transaction->amount}} </td>
                        <td class="align-item-center">
                            @if($transaction->verified==0)
                          <i class="bi bi-x-octagon-fill text-danger" title="Not verified transacctions"></i>  Not Verified 
                            @else
                           <i class="bi bi-patch-check-fill text-success" title="Verified transacctions"></i> Verified  
                            @endif
                        </td>
                        <td>{{$transaction->sender->name}}@if($isSender){{'(You)'}}@endif</td>

                        <td>{{$transaction->receiver->name}}@if(!$isSender){{'(You)'}}@endif</td>
                        <td>{{$isSender?'Take money from '.$transaction->receiver->name:'Give money to '.$transaction->sender->name}}</td>
                        <td>{{ date('M d, Y', strtotime($transaction->created_at)) }}</td>
                        <td>
                            <div class="d-flex">

                            </div>
                        </td>
                        <!-- Add action column here -->
                    </tr>
                    @endforeach
                </tbody>
            </table>
            {{-- <nav aria-label="...">
                <div class="d-flex justify-content-between  ">


                    <p class="m-0"> Showing of entries</p>
                    <ul class="pagination justify-content-end m-0">
                        <!-- <li class="page-item  ">
                            <a class="page-link " href="?page=1 " tabindex="-1" aria-disabled=" ">First</a>
                        </li>
                        <li class="page-item  ">
                            <a class="page-link" href="?page= {{ request()->has('sort_column') ? '&sort_column=' . request()->input('sort_column') : '' }}{{ request()->has('sort_ord') ? '&sort_ord=' . request()->input('sort_ord') : '' }}" aria-disabled="{{$transactions['prev_page_url']!=null?'true':'false'}}"
                                tabindex=" -1" aria-disabled=" ">Previous</a>
                        </li>


                        <li class="page-item   ">
                            <a class="page-link" href=" {{ request()->has('sort_column') ? '&sort_column=' . request()->input('sort_column') : '' }}{{ request()->has('sort_ord') ? '&sort_ord=' . request()->input('sort_ord') : '' }}"> </a>
                        </li> -->

                        <!-- <li class="page-item active" aria-current="page">
                                                <a class="page-link" href="#">2</a>
                                            </li> -->
                        <li class="page-item  ">
                            <a class="page-link" aria-disabled=" " href="?page= {{ request()->has('sort_column') ? '&sort_column=' . request()->input('sort_column') : '' }}{{ request()->has('sort_ord') ? '&sort_ord=' . request()->input('sort_ord') : '' }}">Next</a>
                        </li>
                        @foreach($transactions as $link)
                        <li class="page-item">
                            <a class="page-link" href="{{$link->amount}}">{{$link->label}}</a>
                        </li>
                        @endforeach
                        <li class="page-item ">
                            <a class="page-link" aria-disabled="" href="{{$transactions['first_page_url']}}{{ request()->has('sort_column') ? '&sort_column=' . request()->input('sort_column') : '' }}{{ request()->has('sort_ord') ? '&sort_ord=' . request()->input('sort_ord') : '' }}">Last</a>
                        </li>
                    </ul>
                </div>
            </nav>   --}}
        </div>
    </div>
</main>
<!-- End #main -->

@include('pages.footer')