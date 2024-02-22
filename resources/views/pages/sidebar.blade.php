<!-- ======= Sidebar ======= -->
<aside id="sidebar" class="sidebar">

    <ul class="sidebar-nav" id="sidebar-nav">

        <li class="nav-item">
            <a class="nav-link " href="/dashboard">
                <i class="bi bi-grid"></i>
                <span>Home</span>
            </a>
        </li>
        <!-- End Dashboard Nav -->
        @role('user')
        <li class="nav-item">
            <a class="nav-link " href="/addtransaction">
                <i class="bi bi-cash-coin"></i>
                <span>Add transaction</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link " href="/askbankrequest">
                <i class="bx  bxs-bank"></i>
                <span>Ask Bank Request</span>
            </a>
        </li>
     
        
        @endrole()
        
        @role('bank')
        <li class="nav-item">
            <a class="nav-link " href="/banktransactions">
                <i class="bi bi-bank"></i>
                <span>Bank Transactions</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link " href="/bankusers">
                <i class="ri  ri-user-received-2-fill"></i>
                <span>Your Bank users request</span>
            </a>
        </li>
        
        @endrole
        
        @role('admin')
        <li class="nav-item">
            <a class="nav-link " href="/users">
                <i class="bi bi-people-fill"></i>
                <span>Users List</span>
            </a>
        </li>
        @endrole()
    </ul>

</aside>
<!-- End Sidebar-->