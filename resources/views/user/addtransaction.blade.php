@include('pages.header', ['title' => "PayWise Home"]) @include('pages.navbar') @include('pages.sidebar')
<script>
    window.onload = function() {
    // Get the selected mode
    var selectedMode = document.getElementById('selectMode').value;
    // Hide banksdiv if mode is "offline"
    if (selectedMode === "offline") {
        document.getElementById('banksdiv').style.display = "none";
    }
    var selectElement = document.getElementById('user_selected');
    
   
    var selectedIndex = selectElement.selectedIndex;
    
  
    var selectedOptionText = selectElement.options[selectedIndex].text;
    
    document.getElementById('transacted_to_name').innerHTML='Add Transactions to '+selectedOptionText;
};

    function userChange(name){
     
   
    var selectElement = document.getElementById('user_selected');
    
   
    var selectedIndex = selectElement.selectedIndex;
    
  
    var selectedOptionText = selectElement.options[selectedIndex].text;
    
    document.getElementById('transacted_to_name').innerHTML='Add Transactions to '+selectedOptionText;
    }

    

    function showBanks(mode){
        if(mode=="offline"){
            return document.getElementById('banksdiv').innerHTML = "";
        }else{
            document.getElementById('banksdiv').style.display = "block";
        var xmlhttp3 = new XMLHttpRequest();
        xmlhttp3.onreadystatechange = function(){
            if(this.readyState===4 && this.status===200){
                document.getElementById('banksdiv').innerHTML=this.responseText;
            }
        }
        xmlhttp3.onerror = function() {
            console.error("An error occurred while fetching states.");
        };
        xmlhttp3.open("GET", "/banks/", true);
        xmlhttp3.send();
        }
        
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
                                <h1 class="display-5 my-5" id="transacted_to_name"></h1>

                                <form class="row g-3" action="{{route('addtrasaction')}}" method="POST">
                                    @csrf

                                    <div class="col-md-4">
                                        <div class="form-floating">
                                            <input type="number" class="form-control" id="floatingName" name="amount" placeholder="Your Name">
                                            <label for="floatingName">Amount</label>
                                        </div>
                                    </div>
                                    <input type="hidden" name="uid" value="{{$user->id}}">
                                    <div class="col-md-4">
                                        <div class="form-floating mb-3">
                                            <select class="form-select" name="whom" id="user_selected" aria-label="State" onchange="userChange(this.value)" required>
                                                @foreach ($users as $u)
                                                <option value="{{$u->id}}" @if($selected_receiver!='none'&&$selected_receiver->id==$u->id) {{'selected'}} @endif>{{$u->name.' '.$u->email}}</option>
                                                @endforeach
                                  
                    </select>
                                            <label for="floatingSelect">Whom?</la bel>
                                        </div>  
                                    </div>
                                       <div class="col-md-4">
                                        <div class="form-floating mb-3">
                                            <select class="form-select" name="type" id="floatingSelect" aria-label="State" onchange="showStates(this.value)">
                                                <option value="given">Given</option>
                                                <option value="taken">Taken</option>
                                                
                                             
                    </select>
                                            <label for="floatingSelect">Type?</la bel>
                                        </div>  
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-floating mb-3">
                                            <select class="form-select" name="mode" id="selectMode" aria-label="Mode" onchange="showBanks(this.value)">
                                                <option value="offline" selected>Offline</option>
                                                <option value="online">Online</option>
                                                
                                             
                    </select>
                                            <label for="floatingSelect">Mode</la bel>
                                        </div>  
                                    </div>
                                    <div class="col-8" >
                                        <div class="form-floating mb-3" id="banksdiv">
                                            <select class="form-select" id="bankSelect" aria-label="State" name="bank">
                                                    <option value="">Select Bank</option>
                                                    
                    </select>
                                            <label for="floatingSelect">Bank</label>
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