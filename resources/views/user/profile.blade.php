@include('pages.header', ['title' => $user->name." Details"]) @include('pages.navbar') @include('pages.sidebar')

<main id="main" class="main">


    <section class="section profile">
        <div class="row">
            <div class="col-xl-4">

                <div class="card">
                    <div class="card-body profile-card pt-4 d-flex flex-column align-items-center">

                        <img src="{{$user->profile_pic()}}" alt="Profile" class="rounded-circle">
                        <h2>{{$user->name}} </h2>
                        <h3>{{$user->email}} </h3>
                       
                        <div class="social-links mt-2">
                            @role('user')
                            <p>Net Balance @if($netBalance>=0) <i class="bi bi-caret-up-fill text-success" title="You will get"></i> @else <i class="bi bi-caret-down-fill text-danger" title="You have to give"></i> @endif {{$netBalance}}</p>        @endrole                
                        </div>
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

                            <li class="nav-item">
                                <button class="nav-link @if(request()->has('to')&&request()->input('to')=='edit') active @endif" data-bs-toggle="tab" data-bs-target="#profile-edit">Edit Profile</button>
                            </li>

                            <li class="nav-item">
                                <button class="nav-link @if(request()->has('to')&&request()->input('to')=='delete') active @endif" data-bs-toggle="tab" data-bs-target="#profile-remove">Remove User</button>
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
                                    <div class="col-lg-9 col-md-8">{{$user->name}} </div>
                                </div>


                                <div class="row">
                                    <div class="col-lg-3 col-md-4 label">Email</div>
                                    <div class="col-lg-9 col-md-8">{{$user->email}} </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-3 col-md-4 label">Created at</div>
                                    <div class="col-lg-9 col-md-8">{{date('M d, Y',strtotime($user->created_at))}} </div>
                                </div>
                                @role('user')
                                <h5 class="card-title">Addresses</h5>
                                @foreach ($addresses as $id=>$address)
                                <div class="row">
                                    <div class="col-lg-3 col-md-4 label">{{$loop->iteration}}. @foreach ($address as $a) {{$a}} @endforeach </div>
                                </div>
                                @endforeach
                                @endrole

                            </div>

                            <div class="tab-pane fade @if(request()->has('to')&&request()->input('to')=='edit')show active @endif  profile-edit pt-3" id="profile-edit">

                                <!-- Profile Edit Form -->
                                <form action="{{route('updateuser')}}" method="post">
                                    @csrf {{--
                                    <div class="row mb-3">
                                        <label for="profileImage" class="col-md-4 col-lg-3 col-form-label">Profile Image</label>
                                        <div class="col-md-8 col-lg-9">
                                            <img src="{{asset('assets/img/profile-img.jpg')}}" alt="Profile">
                                            <div class="pt-2">
                                                <a href="#" class="btn btn-primary btn-sm" title="Upload new profile image"><i class="bi bi-upload"></i></a>
                                                <a href="#" class="btn btn-danger btn-sm" title="Remove my profile image"><i class="bi bi-trash"></i></a>
                                            </div>
                                        </div>
                                    </div> --}}
                                    <input type="hidden" name="id" value="{{$user->id}}">

                                    <div class="row mb-3">
                                        <label for="fullName" class="col-md-4 col-lg-3 col-form-label">Full Name</label>
                                        <div class="col-md-8 col-lg-9">
                                            <input type="text" class="form-control" id="fullName" name="name" value="{{$user->name}}">
                                        </div>
                                    </div>


                                    <div class="row mb-3">
                                        <label for="Email" class="col-md-4 col-lg-3 col-form-label">Email</label>
                                        <div class="col-md-8 col-lg-9">
                                            <input name="email" type="email" class="form-control" id="Email" value="{{$user->email}}">
                                        </div>
                                    </div>



                                    <div class="text-center">
                                        <button type="submit" class="btn btn-primary">Save Changes</button>
                                    </div>
                                </form>
                                <!-- End Profile Edit Form -->

                            </div>


                            <div class="tab-pane @if(request()->has('to')&&request()->input('to')=='delete') active @endif fade profile-edit pt-3" id="profile-remove">
                                <div class="centre">
                                    <button type="submit" class="btn btn-danger">Delete User</button>
                                </div>
                            </div>


                        </div>
                        <!-- End Bordered Tabs -->

                    </div>
                </div>

            </div>
        </div>
    </section>
    @role('user')
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
                <h3>Your all transactions</h3>
                <p>Net Balance @if($netBalance>=0) <i class="bi bi-caret-up-fill text-success" title="You will get"></i> @else <i class="bi bi-caret-down-fill text-danger" title="You have to give"></i> @endif {{$netBalance}}</p>

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
    @endrole
</main>
<!-- End #main -->

@include('pages.footer')