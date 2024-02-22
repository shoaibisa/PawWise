@include('pages.header', ['title' => "PayWise Home"]) @include('pages.navbar') @include('pages.sidebar')
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
<main id="main" class="main">
    <div class="container">

        <!-- Add more meaningful content or dynamic data here -->
        <div class="mt-10 pagetitle ">
            <!-- Add mt-4 for margin below the span and text-center for center alignment -->

            <section class="section">
                <div class="row">
                    <div class="col-lg-12">

                        <div class="card">
                            <div class="card-body">
                                <h1 class="display-5 my-5"> Add new user</h1>
                                <form class="row g-3" action="{{route('adduser')}}" method="POST">
                                    @csrf

                                    <div class="col-md-6">
                                        <div class="form-floating">
                                            <input type="text" class="form-control" id="floatingName" name="name" placeholder="Your Name">
                                            <label for="floatingName">User Name</label>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-floating">
                                            <input type="email" class="form-control" id="floatingEmail" name="email" placeholder="Your Email">
                                            <label for="floatingEmail">User Email</label>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
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
                                    <div class="col-md-4">
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
                                    <div class="col-md-4">
                                        <div class="form-floating mb-3" id="selectCity">
                                            <select class="form-select" id="floatingSelect" aria-label="State" name="city">
                                                    <option value="">Select city</option>
                                                    
                    </select>
                                            <label for="floatingSelect">City</label>
                                        </div>
                                    </div>

                                    <div class="text-center">
                                        <button type="submit" class="btn btn-primary">Submit</button>
                                        <button type="reset" class="btn btn-secondary">Reset</button>
                                    </div>
                                </form>
                            </div>
                        </div>

                    </div>
                </div>
            </section>
        </div>
    </div>
</main>


@include('pages.footer')