@include('pages.header', ['title' => "PayWise Home"]) @include('pages.navbar') @include('pages.sidebar')
 <script>
    function assignRole(roles){
        var valuesArray = roles.split(',');
    var roleId = valuesArray[0];
    var userId = valuesArray[1];

    // Get the checked state of the checkbox
    var isChecked = document.getElementById(roles).checked;
        isChecked = isChecked?1:0;
 
    console.log("Role ID:", roleId);
    console.log("User ID:", userId);
    console.log("Checked:", isChecked);

    var xmlhttp3 = new XMLHttpRequest();
        xmlhttp3.onreadystatechange = function(){
            if(this.readyState===4 && this.status===200){
               console.log("done")
            }
        }
        xmlhttp3.onerror = function() {
            console.error("An error occurred while fetching states.");
        };
        xmlhttp3.open("GET", "/assignerole/"+userId+"/"+roleId+"/"+isChecked, true);
        xmlhttp3.send();
    
    }

    function verifyU(uid){
        var xmlhttp3 = new XMLHttpRequest();
        xmlhttp3.onreadystatechange = function(){
            if(this.readyState===4 && this.status===200){
                console.log("Yes");
            }else{
                console.log("No");
             }
         }
        xmlhttp3.onerror = function() {
            console.error("An error occurred while fetching states.");
        };
        xmlhttp3.open("GET", "/userverification/"+uid, true);
        xmlhttp3.send();
    }
 </script>
<main id="main" class="main">
    <div class="container">
        <h1 class="text-success">Welcome to PayWise <i class="bi bi-wallet"></i></h1>
        <span class="mb-10">Here, you can manage your finances easily.</span>
        @if (count($users)<=0)
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
                    <h1 class="mt-5 mb-2">All User Detail Lists</h1>
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
                                                    <a href=" " style="text-decoration: none; color: inherit;">
                                                        <div style="display: flex; align-items: center;">
                                                            <b>Name</b>
                                                            <div class="d-flex flex-column">
                                                                <i class="bi bi-caret-up "></i>
                                                                <i class="bi bi-caret-down "></i>
                                                            </div>
                                                        </div>
                                                    </a>
                                                </th>
                                                <th>Email</th>
                                                <th>Verify</th>
                                                <th title="Total money=Assign Roles">Assign Roles <i class="bx bx-layer-plus"></i></th>
                                                <th style="cursor: pointer;">
                                                    <a href=" " style="text-decoration: none; color: inherit;">
                                                        <div style="display: flex; align-items: center;">
                                                            <b>Created At</b>
                                                            <div class="d-flex flex-column">
                                                                <i class="bi bi-caret-up "></i>
                                                                <i class="bi bi-caret-down "></i>
                                                            </div>
                                                        </div>
                                                    </a>
                                                </th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($users as $id => $u)
                                            <tr>
                                                <td>{{$loop->iteration}}</td>
                                                <td>{{$u->name}}</td>
                                                <td>{{$u->email}}</td>
                                                <td>
                                                    <select name="verifiying" class="form-select" id="{{$u->id}}" onchange="verifyU(this.value)">
                                                        <option value="{{$u->id}}"  {{$u->verified==0?'selected':''}}> 
                                                              Not Verified </option>
                                                        <option value="{{$u->id}}" {{$u->verified?'selected':''}}> <p class="text-success">Verified</p>
                                                        </option>

                                                    </select>
                                                </td>
                                               <td>
                                                <div class="row mb-3">
                                                     <div class="col-sm-10">
                                                    @foreach ($roles as $id=>$role)
                                                      <div class="form-check">
                                                        <input class="form-check-input" name="role_checked[{{$u->id}}][]" type="checkbox" id="{{$role->id.','.$u->id}}" value="{{$role->id.','.$u->id}}" {{$u->hasRole($role->name)?'checked':''}} onchange="assignRole(this.value)">
                                                        <label class="form-check-label" for="role_check">
                                                            {{$role->name}}
                                                        </label>
                                                      </div>
                                                      @endforeach
                                                  
                                                    </div>
                                                  </div>
                                  
                                               </td>
                                                <td>{{ date('M d, Y', strtotime($u->created_at)) }}</td>
                                                <td>
                                                    <div class="d-flex">



                                                        <a href="/addtransaction/?user={{$u->id}}" title="Add transaction" class="btn btn-sm btn-outline-success"><i class="bi bi-send-arrow-up-fill"></i></a>
                                                        <div style="margin-left: 5px;"></div>
                                                     <a href="/transactions/user/{{$u->id}}" class="btn btn-sm btn-outline-info" title="View Users transactions"> <i class="bi bi-eye"></i></i>
                                                        </a>
   {{-- 

                                                        <div style="margin-left: 5px;"></div>

                                                        <a href="/user/{{$u->id}}?to=edit" class="btn btn-sm btn-outline-warning" title="Edit user"><i class="bi bi-pencil-square"></i></a>
                                                        <div style="margin-left: 5px;"></div>
                                                        <form title="Delete user" action="{{route('userdelete')}}" method="post" onsubmit="return confirm('Are you sure want to delete this user!')">
                                                            @csrf
                                                            <input type="hidden" name="id" value="{{$u->id}}">
                                                            <button type="submit" name="delete" value="delete" class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i></button>
                                                        </form> --}}
                                                    </div>
                                                </td>
                                                <!-- Add action column here -->
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>

                                    <!-- End Table with stripped rows -->
                                    {{-- <nav aria-label="...">
                                        <div class="d-flex justify-content-between align-items-center">


                                            <p class="m-0"> Showing   of   entries</p>
                                            <ul class="pagination justify-content-end m-0">
                                                <li class="page-item  ">
                                                    <a class="page-link " href="" tabindex="-1" aria-disabled=" ">First</a>
                                                </li>
                                                <li class="page-item  ">
                                                    <a class="page-link" href="?pa  " aria-disabled=" " tabindex=" -1"
                                                        aria-disabled="  ">Previous</a>
                                                </li>


                                               
                                                    <li class="page-item  ">
                                                        <a class="page-link" aria-disabled=" " href=" ">Next</a>
                                                    </li>
                                                    <li class="page-item  ">
                                                        <a class="page-link" aria-disabled=" " href="?page ">Last</a>
                                                    </li>
                                            </ul>
                                        </div>
                                    </nav> --}}

                                </div>
                                @endif
                            </div>
                        </div>

                    </div>
                </div>
            </section>
        </div>
    </div>
</main>


@include('pages.footer')