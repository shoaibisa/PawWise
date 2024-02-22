@include('pages.header', ['title' => "PayWise Home"]) @include('pages.navbar') @include('pages.sidebar')
 
<script>
    function verifyT(tid){
        var xmlhttp3 = new XMLHttpRequest();
        xmlhttp3.onreadystatechange = function(){
            if(this.readyState===4 && this.status===200){
                document.getElementById('hasDone').innerHtml=this.responseText;
            }else{
                console.log("No");
                document.getElementById('hasDone').innerHtml="changed";
            }
            document.getElementById('hasDone').innerHtml="changed";
        }
        xmlhttp3.onerror = function() {
            console.error("An error occurred while fetching states.");
        };
        xmlhttp3.open("GET", "/verifying/"+tid, true);
        xmlhttp3.send();
    }
</script>
<main id="main" class="main">
    <div class="container">
        <h1 class="text-success">Welcome to PayWise <i class="bi bi-wallet"></i></h1>
        <span class="mb-10">Here, you can manage your bank transacctions easily.</span>
      
        @if(count($transactions)<=0)
        <div class="alert alert-danger alert-dismissible">
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            <strong>No !</strong> Transactions

        </div>
        
      @else
        <!-- Add more meaningful content or dynamic data here -->
        <div class="mt-10 pagetitle ">
            <!-- Add mt-4 for margin below the span and text-center for center alignment -->
            <div class="row">
                <div class="col-lg-6">
                    <h1 class="mt-5 mb-2">Your bank users transactions</h1>
                </div>


            </div>
            <section class="section">
                <div class="row">
                    <div class="col-lg-12">


                        <span class="" id="hasDone"> </span>
                       
                        <div class="card">
                            <div class="card-body">

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
                                                    $isYou = ($transaction->sender->id==$user->id)||($transaction->receiver->id==$user->id);
                                                    
                                                @endphp
                                                <td> ${{$transaction->amount}} </td>
                                                
                                                <td>{{$transaction->sender->name}}@if($isYou){{'(You)'}}@endif</td>
                        
                                                <td>{{$transaction->receiver->name}}@if($isYou){{'(You)'}}@endif</td>

                                                <td>
                                                    <select name="verifiying" class="form-select" id="{{$transaction->id}}" onchange="verifyT(this.value)">
                                                        <option value="{{$transaction->id}}"  {{$transaction->verified==0?'selected':''}}> 
                                                              Not Verified </option>
                                                        <option value="{{$transaction->id}}" {{$transaction->verified?'selected':''}}> <p class="text-success">Verified</p>
                                                        </option>

                                                    </select>
                                                </td>

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
                       
                            </div>
                        </div>

                    </div>
                </div>
            </section>
        </div>
        @endif
    </div>
</main>


@include('pages.footer')