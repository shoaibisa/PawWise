@include('pages.header', ['title' => "PayWise Home"]) @include('pages.navbar') @include('pages.sidebar')
 
<main id="main" class="main">
    <div class="container">
        <h1 class="text-success">Welcome to PayWise <i class="bi bi-wallet"></i></h1>
        <span class="mb-10">Here, you can manage your finances easily.</span>

        <!-- Add more meaningful content or dynamic data here -->
        <div class="mt-10 pagetitle ">
            <!-- Add mt-4 for margin below the span and text-center for center alignment -->
            <div class="row">
                <div class="col-lg-6">
                    <h1 class="mt-5 mb-2">All Users Lists</h1>
                </div>


            </div>
          
            <section class="section">
                <div class="row">
                    <div class="col-lg-12">


                        @if(session('msg'))
                        <div class="alert {{session('isError')?'alert-danger':'alert-success'}} alert-dismissible">
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            <strong>{{session('isError')?'Failed':'Success'}} !</strong> {{ session('msg') }}

                        </div>
                        @endif
                        <div class="card">
                            <div class="card-body">


                                <!-- Table with stripped rows -->
                                <div class="table-responsive">


                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th>S.No</th>
                                                <th style="cursor: pointer;">
                                                    <a href="?sort_column=name&sort_ord={{ (!request()->has('sort_ord')  || request()->input('sort_ord') == 'asc') ? 'desc' : 'asc' }}{{ (request()->has('page')) ? '&page=' . request()->input('page') : '' }}" style="text-decoration: none; color: inherit;">
                                                        <div style="display: flex; align-items: center;">
                                                            <b>Name</b>
                                                            <div class="d-flex flex-column">
                                                                <i class="bi bi-caret-up{{request()->has('sort_column')&&request()->input('sort_column')=='name'&&request()->has('sort_ord')&&request()->input('sort_ord')=='asc'?'-fill':''}}"></i>
                                                                <i class="bi bi-caret-down{{request()->has('sort_column')&&request()->input('sort_column')=='name'&&request()->has('sort_ord')&&request()->input('sort_ord')=='desc'?'-fill':''}}"></i>
                                                            </div>
                                                        </div>
                                                    </a>
                                                </th>
                                                <th>Email</th>
                                                <th title="Total money=GIVE/TAKE">Net Balance <i class="bi bi-cash-coin"></i></th>
                                                <th style="cursor: pointer;">
                                                    <a href="?sort_column=created_at&sort_ord={{ (!request()->has('sort_ord') || request()->input('sort_ord') == 'asc') ? 'desc' : 'asc' }}{{ (request()->has('page')) ? '&page=' . request()->input('page') : '' }}" style="text-decoration: none; color: inherit;">
                                                        <div style="display: flex; align-items: center;">
                                                            <b>Created At</b>
                                                            <div class="d-flex flex-column">
                                                                <i class="bi bi-caret-up{{request()->has('sort_column')&&request()->input('sort_column')=='created_at'&&request()->has('sort_ord')&&request()->input('sort_ord')=='asc'?'-fill':''}}"></i>
                                                                <i class="bi bi-caret-down{{request()->has('sort_column')&&request()->input('sort_column')=='created_at'&&request()->has('sort_ord')&&request()->input('sort_ord')=='desc'?'-fill':''}}"></i>
                                                            </div>
                                                        </div>
                                                    </a>
                                                </th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($users as $id => $user)
                                            <tr>
                                                <td>{{$loop->iteration}}</td>
                                                <td>{{$user->name}}</td>
                                                <td>{{$user->email}}</td>
                                                <td><i class="bi bi-caret-up-fill text-success" title="You will Get"></i> $100 </td>

                                                <td>{{ date('M d, Y', strtotime($user->created_at)) }}</td>
                                                <td>
                                                    <div class="d-flex">



                                                        <a href="/addtransaction/user/{{$user->id}}" title="Add transaction" class="btn btn-sm btn-outline-success"><i class="bi bi-send-arrow-up-fill"></i></a>
                                                        <div style="margin-left: 5px;"></div>
                                                        <a href="/user/{{$user->id}}" class="btn btn-sm btn-outline-info" title="View User"> <i class="bi bi-eye"></i></i>
                                                        </a>


                                                        <div style="margin-left: 5px;"></div>

                                                        <a href="/user/{{$user->id}}?to=edit" class="btn btn-sm btn-outline-warning" title="Edit user"><i class="bi bi-pencil-square"></i></a>
                                                        <div style="margin-left: 5px;"></div>
                                                        <form title="Delete user" action="{{route('userdelete')}}" method="post" onsubmit="return confirm('Are you sure want to delete this user!')">
                                                            @csrf
                                                            <input type="hidden" name="id" value="{{$user->id}}">
                                                            <button type="submit" name="delete" value="delete" class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i></button>
                                                        </form>
                                                    </div>
                                                </td>
                                                <!-- Add action column here -->
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>

                                    <!-- End Table with stripped rows -->
                                    <nav aria-label="...">
                                        <div class="d-flex justify-content-between align-items-center">


                                            <p class="m-0"> Showing {{count($users)}} of {{$total_users}} entries</p>
                                            <ul class="pagination justify-content-end m-0">
                                                <li class="page-item {{$current_page==1?'disabled':''}}">
                                                    <a class="page-link " href="?page=1{{ request()->has('sort_column') ? '&sort_column=' . request()->input('sort_column') : '' }}{{ request()->has('sort_ord') ? '&sort_ord=' . request()->input('sort_ord') : '' }}" tabindex="-1" aria-disabled="{{$current_page==1?'true':''}}">First</a>
                                                </li>
                                                <li class="page-item  {{$current_page==1?'disabled':''}}">
                                                    <a class="page-link" href="?page={{$current_page-1}}{{ request()->has('sort_column') ? '&sort_column=' . request()->input('sort_column') : '' }}{{ request()->has('sort_ord') ? '&sort_ord=' . request()->input('sort_ord') : '' }}" aria-disabled=" " tabindex=" -1"
                                                        aria-disabled="{{$current_page==1?'true':''}}">Previous</a>
                                                </li>


                                                @php $total_pages = ceil($total_users/$limit_page); @endphp @for ($i = 1; $i
                                                <=$total_pages; $i++) <li class="page-item  {{$i==$current_page?'active':''}}">
                                                    <a class="page-link" href="?page={{$i}}{{ request()->has('sort_column') ? '&sort_column=' . request()->input('sort_column') : '' }}{{ request()->has('sort_ord') ? '&sort_ord=' . request()->input('sort_ord') : '' }}">{{$i}}</a>
                                                    </li>
                                                    @endfor
                                                    <!-- <li class="page-item active" aria-current="page">
                                                <a class="page-link" href="#">2</a>
                                            </li> -->
                                                    <li class="page-item {{$current_page==$total_pages?'disabled':''}}">
                                                        <a class="page-link" aria-disabled="{{$current_page==$total_pages?'true':''}}" href="?page={{$current_page+1}}{{ request()->has('sort_column') ? '&sort_column=' . request()->input('sort_column') : '' }}{{ request()->has('sort_ord') ? '&sort_ord=' . request()->input('sort_ord') : '' }}">Next</a>
                                                    </li>
                                                    <li class="page-item {{$current_page==$total_pages?'disabled':''}}">
                                                        <a class="page-link" aria-disabled="{{$current_page==$total_pages?'true':''}}" href="?page={{$total_pages}}{{ request()->has('sort_column') ? '&sort_column=' . request()->input('sort_column') : '' }}{{ request()->has('sort_ord') ? '&sort_ord=' . request()->input('sort_ord') : '' }}">Last</a>
                                                    </li>
                                            </ul>
                                        </div>
                                    </nav>

                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </section>
      
           
        </div>
    </div>
</main>


@include('pages.footer')