@include('pages.header', ['title' => "User register"])
<script>
    function showStates(cid) {
        if (cid == "") {
            document.getElementById('stateSelect').innerHTML = '<select class="form-select" id="floatingSelect" name="state"  aria-label="State" onchange="showCities(this.value)"><option value="" >Select State</option></select> <label for="floatingSelect">State</label>';
            document.getElementById('selectCity').innerHTML = '<select class="form-select" id="floatingSelect" name="city"  aria-label="City"><option value="" >Select City</option></select> <label for="floatingSelect">City</label>';

            return;
        }

        var xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function() {
            if (this.readyState === 4 && this.status === 200) {
                document.getElementById("stateSelect").innerHTML = this.responseText;
                document.getElementById('selectCity').innerHTML = '<select class="form-select" id="floatingSelect"  name="city" aria-label="City"><option value="" >Select City</option></select> <label for="floatingSelect">City</label>';

            }
        };

        xmlhttp.onerror = function() {
            console.error("An error occurred while fetching states.");
        };

        xmlhttp.open("GET", "/states/" + cid, true);
        xmlhttp.send();
    }

    function showCities(sid) {

        if (sid == "") {
            document.getElementById('selectCity').innerHTML = '<select class="form-select" id="floatingSelect" aria-label="City"><option value="" >No City</option></select> <label for="floatingSelect">City</label>';
            return;
        }
        var xmlhttp1 = new XMLHttpRequest();
        xmlhttp1.onreadystatechange = function() {
            if (this.readyState === 4 && this.status === 200) {
                document.getElementById('selectCity').innerHTML = this.responseText;
            }
        }
        xmlhttp1.onerror = function() {
            console.error("An error occurred while fetching states.");
        };
        xmlhttp1.open("GET", "/city/" + sid, true);
        xmlhttp1.send();
    }
</script>
<main>
    <div class="container">

        <section class="section register min-vh-100 d-flex flex-column align-items-center justify-content-center py-4">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-lg-4 col-md-6 d-flex flex-column align-items-center justify-content-center">

                        <div class="d-flex justify-content-center py-4">
                            <a href="/register" class="logo d-flex align-items-center w-auto">
                                <img src="assets/img/logo.png" alt="">
                                <span class="d-none d-lg-block">PayWise</span>
                            </a>
                        </div>
                        <!-- End Logo -->

                        <div class="card lg">

                            <div class="card-body">

                                <div class="pt-4 pb-2">
                                    <h5 class="card-title text-center pb-0 fs-4">Create an Account</h5>
                                    <p class="text-center small">Enter your personal details to create account</p>
                                </div>
                                @if(session('msg'))
                                <div class="alert {{session('isError')?'alert-danger':'alert-success'}} alert-dismissible">
                                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                                    <strong>{{session('isError')?'Failed':'Success'}} !</strong> {{ session('msg') }}

                                </div>
                                @endif


                                <form class="row  needs-validation" method="post" action="{{route('register')}}" enctype="multipart/form-data" novalidate>
                                    @csrf
                                    <div class="col-12">
                                        <label for="yourName" class="form-label">Your Name</label>
                                        <input type="text" name="name" class="form-control" id="yourName" required>
                                        <div class="invalid-feedback">Please, enter your name!</div>
                                    </div>

                                    <div class="col-12">
                                        <label for="yourEmail" class="form-label">Your Email</label>
                                        <input type="email" name="email" class="form-control" id="yourEmail" required>
                                        <div class="invalid-feedback">Please enter a valid Email adddress!</div>
                                    </div>
                                    <div class="col-12">
                                        <label for="yourPassword" class="form-label">Profile Pic</label>
                                        <input type="file" name="image" class="form-control" id="image" accept="image/*"  required>
                                        <div class="invalid-feedback">Please upload profile pic!</div>
                                    </div>

                                    <div class="col-12">
                                        <label for="yourPassword" class="form-label">Password</label>
                                        <input type="password" name="password" class="form-control" id="yourPassword" required>
                                        <div class="invalid-feedback">Please enter your password!</div>
                                    </div>
                                    <div class="col-12">
                                        <label for="register" class="form-label">Register As</label>

                                        <div class="form mb-3">
                                            <select class="form-select" name="rtype" id="floatingSelect" aria-label="State" onchange="showStates(this.value)">
                                                <option value="user">User</option>
                                                <option value="bank">Bank</option>
                                             
                                                </select>
                                           
                                        </div>  
                                                                       
                                    </div>
                                    <div class="col-12">
                                        <label for="yourPassword" class="form-label">Address</label>

                                        <div class="form-floating mb-3">
                                            <select class="form-select" name="country" id="floatingSelect" aria-label="State" onchange="showStates(this.value)">
                                                <option value="">Choose country</option>
                                                @foreach ($countries as $id=>$country)
                                                <option value="{{$country->id}}">{{$country->name}}</option>
                                                @endforeach
                                             
                                                </select>
                                            <label for="floatingSelect">Country</la bel>
                                        </div>  
                                                                       
                                    </div>
                                     <div class="col-12">
                                        <div class="form-floating mb-3" id="stateSelect">
                                            <select class="form-select" id="floatingSelect" name="state" aria-label="State" onchange="showCities(this.value)">
                                                <option value="" id="">Select State</option>
                                                <!-- <span id="stateSelect">
                                                   
                                                </span> -->
                      <!-- <option selected>New York</option>
                      <option value="1">Oregon</option>
                      <option value="2">DC</option> -->
                    </select>
                                            <label for="floatingSelect">State</label>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="form-floating mb-3" id="selectCity">
                                            <select class="form-select" id="floatingSelect" aria-label="State" name="city">
                                                    <option value="">Select city</option>
                                                    
                    </select>
                                            <label for="floatingSelect">City</label>
                                        </div>
                                    </div>

                                    <div class="col-12">
                                        <div class="form-check">
                                            <input class="form-check-input" name="terms" type="checkbox" value="" id="acceptTerms" required>
                                            <label class="form-check-label" for="acceptTerms">I agree and accept the <a href="#">terms and conditions</a></label>
                                            <div class="invalid-feedback">You must agree before submitting.</div>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <button class="btn btn-primary w-100" type="submit">Create Account</button>
                                    </div>
                                    <div class="col-12">
                                        <p class="small mb-0">Already have an account? <a href="{{route('login')}}">Log in</a></p>
                                    </div>
                                </form>

                            </div>
                        </div>


                    </div>
                </div>
            </div>

        </section>

    </div>
</main>


@include('pages.footer')