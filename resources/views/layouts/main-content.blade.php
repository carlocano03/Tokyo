<style>
  {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
    list-style: none;
    text-decoration: none;
    font-family: 'Josefin Sans', sans-serif;
  }

  body {
    background-color: #f3f5f9;
  }

  .wrapper {
    display: flex;
    position: relative;
  }

  .wrapper .sidebar {
    width: 250px;
    height: 100%;
    background: var(--c-white);
    padding: 30px 0px;
    position: fixed;
    z-index: 1001;
    overflow-y: auto;
    padding-bottom: 50px;
    border-right: #e6e6e6 2px solid;
  }


  .wrapper .sidebar h2 {
    /* color: var(--c-primary); */
    color: #979797;
    text-transform: uppercase;
    text-align: center;
  }

  .wrapper .sidebar ul li {
    /* padding: 15px; */
    border-bottom: 1px solid #bdb8d7;
    border-bottom: 1px solid rgba(0, 0, 0, 0.05);
    border-top: 1px solid rgba(255, 255, 255, 0.05);
  }

  .info a {
    color: white !important;
  }

  .wrapper .sidebar ul li a {
    color: var(--c-primary-80);
    display: block;
  }

  .wrapper .sidebar ul li a .fa {
    width: 25px;
  }

  .wrapper .sidebar ul li a:hover {
    color: var(--c-primary);
    background-color: var(--c-base-10);
  }

  .wrapper .sidebar ul li:hover {
    color: var(--c-primary);
  }


  .wrapper .sidebar .social_media a {
    display: block;
    width: 40px;
    height: 40px;
    background: transparent;
    line-height: 45px;
    text-align: center;
    margin: 0 5px;
    color: var(--c-primary);
    border-top-left-radius: 5px;
    border-top-right-radius: 5px;
  }

  .wrapper .main_content {
    width: 100%;
    margin-left: 0px;
  }

  .wrapper .main_content .header {
    /* padding: 20px; */
    display: none;
    /* background-color: var(--c-primary-80); */
    background: rgb(137, 65, 104);
    background: linear-gradient(90deg, rgba(137, 65, 104, 1) 8%, rgba(26, 137, 129, 1) 98%);
    border-bottom: 1px solid #e0e4e8;
    border-bottom: 1px solid #e0e4e8;
  }

  .wrapper .main_content .info {
    margin: 20px;
    color: #717171;
    line-height: 25px;
  }

  .wrapper .main_content .info div {
    margin-bottom: 20px;
  }

  .header {
    position: fixed;
    width: 100%;
    z-index: 10;
    background-color: white;


  }

  .header label {
    font-size: 1.3rem;
  }

  .contents {
    /* height: 100%; */
    /* overflow-y: auto; */
    overflow-x: hidden;
  }

  .top-nav {
    text-align: center;
    color: var(--c-primary);
  }

  .top-nav i {
    font-size: 70px !important;
  }

  .active-nav {
    background-color: var(--c-primary) !important;
    color: white !important;
  }

  .active-nav li a {
    color: white !important;
  }

  /* .nav-child a{
   margin-left: 20px;
} */
  .arrow-left {
    margin-left: 20px;
    font-size: 20px;
    float: right;
  }

  .arrow-rotate {
    margin-top: 10px;
    margin-right: 10px;
    transform: rotateZ(90deg);
  }

  .dropdown-hide {
    display: none;
    z-index: 1;
  }

  .show-dropdown {
    display: block;
  }

  a {
    padding: 15px;
  }

  i {
    pointer-events: none
  }

  .logout {
    float: right;
    margin-right: 250px;
    color: var(--c-primary)
  }

  .mobile-toggle {
    display: block;
    position: absolute;
    z-index: 9999;
    left: 0;
    top: 0;
    margin: 15px;

    font-size: 35px;
    color: var(--c-active-hover-bg);
  }

  .hide {
    display: none;
  }

  .move-toggle {
    margin-left: 200px;
  }

  @media (min-width:656px) {

    .wrapper .main_content {
      width: 100%;
      margin-left: 250px;
    }

    .wrapper .main_content .header {
      display: block;
    }

    .wrapper .sidebar {
      display: block !important;
    }

    .mobile-toggle {
      display: none;
    }

    .hide {
      display: block;
    }

    .wrapper .sidebar {
      z-index: 0;
    }
  }

  @media (min-width:896px) {

    .wrapper .main_content {
      width: 100%;
      margin-left: 250px;
    }

    .wrapper .main_content .header {
      display: block;
    }

    .wrapper .sidebar {
      display: block !important;
    }

    .mobile-toggle {
      display: none;
    }

    .hide {
      display: block;
    }

    .wrapper .sidebar {
      z-index: 0;
    }

  }

  @media (min-width:992px) {}

  @media (min-width:1200px) {}


  .menu-toggle {
    position: fixed;
    display: inline-block;
    margin: 5px;
    height: 50px;
    background-color: transparent;
    padding-bottom: 24px;
    border-radius: 8px;
    z-index: 1002;
  }

  .menu-toggle span {
    margin: 0 auto;
    position: relative;
    top: 12px;
    transition-duration: 0s;
    transition-delay: .2s;
    transition: background-color 0.3s;
  }

  .menu-toggle span:before,
  .menu-toggle span:after {
    position: absolute;
    content: '';
  }

  .menu-toggle span,
  .menu-toggle span:before,
  .menu-toggle span:after {
    width: 40px;
    height: 6px;
    background-color: white;
    display: block;
    opacity: 1;
  }

  .menu-toggle span:before {
    margin-top: -12px;
    transition-property: margin, transform;
    transition-duration: .2s;
    transition-delay: .2s, 0;
  }

  .menu-toggle span:after {
    margin-top: 12px;
    transition-property: margin, transform;
    transition-duration: .2s;
    transition-delay: .2s, 0;
  }

  .menu-toggle-active span {
    /* background-color: white; */
    transition: 0.3s background-color;
  }

  .menu-toggle-active span:before {
    background-color: var(--c-accent);
    margin-top: 0;
    transform: rotate(45deg);
    transition-delay: 0, .2s;
  }

  .menu-toggle-active span:after {
    background-color: var(--c-accent);
    margin-top: 0;
    transform: rotate(-45deg);
    transition-delay: 0, .2s;
  }

  .dark-bg {
    background-color: black;
    padding: 100%;
    height: 100%;
    left: 0px;
    top: 0px;
    z-index: 1000 !important;
    position: absolute;
    opacity: 0.5;
  }

  .logout-mobile {
    position: fixed;
    bottom: 0px;
    color: var(--c-primary-80);
    background-color: white;
    padding-left: 152px;
    padding-right: 35px;
    left: 0px;
  }

  .unscroll {
    height: 100%;
    overflow: hidden;
  }

  .profile-details .name {
    font-size: 20px;
    font-weight: 300;
    color: var(--c-base-80);
  }

  .profile-details .role {
    color: var(--c-base-50);
    font-weight: 400;
    font-size: 12px;
    margin-top: -4px;
  }

  .profile-details .logout-button {
    margin-top: 10px;
    margin-bottom: 10px;
  }

  .profile-details .logout-button a {
    color: var(--c-accent);
  }

  .toggle-container {
    position: fixed;
    background-color: var(--c-accent);
    height: 73px;
    z-index: 9999;
  }

  .width-100 {
    width: 100%;
  }

  .width-0 {
    width: 0%;
  }
</style>
<div class="toggle-container" id="toggle-container">
  <button href="#" class="menu-toggle" id="menu-toggle"><span></span></button>
</div>

<!-- <div class="mobile-toggle" id="mobile-toggle">
  <i class="fa fa-bars" aria-hidden="true"></i>
</div> -->
<div class="dark-bg" id="dark-bg">

</div>
@if(Request::segment(1) === 'admin')
<div class="wrapper">
  <div class="sidebar" id="side_bar">

    <div class="top-nav">
      <div class="profile-img">
        <img src="https://scontent.fcrk1-2.fna.fbcdn.net/v/t1.6435-9/207187111_3997130053703269_3727726365217478114_n.jpg?_nc_cat=108&ccb=1-7&_nc_sid=174925&_nc_eui2=AeHnFnqZfxQAti6y9Nu31yIJpu92jMzPbxmm73aMzM9vGam2k3k7JFrwECdfoG8nsnn8Nw5TBnNTYzeViCwahNkZ&_nc_ohc=KkRv57b4p-sAX_DTHss&_nc_ht=scontent.fcrk1-2.fna&oh=00_AfBtUiem2TkNP3AjA-zXbSwJ3zCJtyeq6xaGBNIaFpc4yA&oe=63EDB659" alt="">
      </div>
      <div class="profile-details">
        <div class="name">{{ Auth::user()->first_name }} {{ Auth::user()->last_name }}</div>
        <div class="role">Up Diliman | Midlaner</div>
        <div class="logout-button">
          <strong><a href="{{ url('/logout') }}">Log out</a> </strong>
        </div>
      </div>
    </div>
    <ul>
      <li>
        <a href="/admin/dashboard" class="{{ Request::is('admin/dashboard') ? 'active-nav' : '' }}"><i class="fa fa-home "></i>Dashboard</a>
      </li>
      <div class="dropdown" id="dropdown">
        <div class="nav-parent ">
          <li><a href="#" id="membersDropdown">
              <i class="fa fa-user"></i>
              Members
              <i class="fa fa-caret-right arrow-left" id="arrow" aria-hidden="true"></i>
            </a></li>
        </div>
        <div class="nav-child">
          <div class="dropdown-hide" id="membersDropdown-content">
            <li><a href="/admin/members/records" class="{{ Request::is('admin/members/records') ? 'active-nav' : '' }}"><i class="fa fa-user"></i>View Records</a></li>
            <li><a href="/admin/members/trail"><i class="fa fa-user"></i>Application Trail</a></li>
            <li><a href="#"><i class="fa fa-user"></i>Generate Report</a></li>
          </div>
        </div>
      </div>
      <li><a href="#"><i class="fa fa-line-chart"></i>Loan </a></li>
      <li><a href="#"><i class="fa fa-comment-o"></i>Benefits </a></li>
      <li><a href="#"><i class="fa fa-line-chart"></i>Transacton </a></li>
      <li><a href="#"><i class="fa fa-address-book"></i>Election</a></li>
      <li><a href="/admin/settings/manage-account" class="{{ Request::is('admin/settings/manage-account')  ? 'active-nav' : '' }}">
          <i class="fa fa-gears"></i>Settings & Configuration</a>
      </li>

      <!-- <a href="#">
        <strong><a href="{{ url('/logout') }}" class="logout-mobile">Log out</a> </strong>
      </a> -->
    </ul>

  </div>
  <div class="main_content">
    <div class="header">
      <div class="info">
        <a href="/">
          <img src="{!! asset('assets/images/uppfi-logo-sm.png') !!}" alt="UPPFI">
        </a>
        <a class="univ-title" href="/">
          University of the Philippines Provident Fund Inc.
        </a>
        <!-- <a href="#">
          <strong><a href="{{ url('/logout') }}" class="logout">Log out</a> </strong>
        </a> -->
      </div>


    </div>


    <div class="contents">
      @section('content_body')
      @show
    </div>

  </div>

</div>
@else
<div class="wrapper">
  <div class="sidebar hide" id="side_bar">
    <div class="top-nav">
      <div class="profile-img">
        <img src="https://scontent.fcrk1-2.fna.fbcdn.net/v/t1.6435-9/207187111_3997130053703269_3727726365217478114_n.jpg?_nc_cat=108&ccb=1-7&_nc_sid=174925&_nc_eui2=AeHnFnqZfxQAti6y9Nu31yIJpu92jMzPbxmm73aMzM9vGam2k3k7JFrwECdfoG8nsnn8Nw5TBnNTYzeViCwahNkZ&_nc_ohc=KkRv57b4p-sAX_DTHss&_nc_ht=scontent.fcrk1-2.fna&oh=00_AfBtUiem2TkNP3AjA-zXbSwJ3zCJtyeq6xaGBNIaFpc4yA&oe=63EDB659" alt="">
      </div>
      <div class="profile-details">
        <div class="name">Member Account</div>
        <div class="role">Up Diliman | Midlaner</div>
        <div class="logout-button">
          <strong><a href="{{ url('/logout') }}">Log out</a> </strong>
        </div>

      </div>
    </div>
    <ul>
      <li>
        <a href="/member/dashboard" class="{{ Request::is('member/dashboard') ? 'active-nav' : '' }}">
          <i class="fa fa-home "></i>Dashboard</a>
      </li>
      <li><a href="/member/transaction" class="{{ Request::is('member/transaction') ? 'active-nav' : '' }}">
          <i class="fa fa-line-chart"></i>Transactions </a>
      </li>

      <li><a id="click_form" class="{{ Request::is('member/member') ? 'active-nav' : '' }}">
          <i class="fa fa-envelope" aria-hidden="true"></i> Member Forms </a>
      </li>

      <li><a href="/member/loan" class="{{ Request::is('member/loan') ? 'active-nav' : '' }}">
          <i class="fa fa-address-book"></i>Loan Application</a>
      </li>
      <li><a href="/member/settings" class="{{ Request::is('member/settings')
                  || Request::is('member/update-password')  ? 'active-nav' : '' }}">
          <i class="fa fa-gears"></i>Account & Settings</a>
      </li>
      <li><a href="https://www.upprovidentfund.com/contact-us/" target="_blank">
          <i class="fa fa-phone-square" aria-hidden="true"></i>Contact Us</a>
      </li>


    </ul>

  </div>
  <div class="main_content">
    <div class="header">
      <div class="info">
        <a href="/">
          <img src="{!! asset('assets/images/uppfi-logo-sm.png') !!}" alt="UPPFI">
        </a>
        <a class="univ-title" href="/">
          University of the Philippines Provident Fund Inc.
        </a>
        <!-- <a href="#">
          <strong><a href="#" class="logout">Log out</a> </strong>
        </a> -->
      </div>


    </div>


    <div class="contents">
      @section('content_body')
      @show
    </div>


  </div>
  @endif



  <script>
    var click = 0;
    $(document).on('click', '#membersDropdown', function(e) {
      click++;
      console.log(click)
      if (click === 1) {
        $("#membersDropdown-content").removeClass("dropdown-hide");
        $("#arrow").addClass("arrow-rotate")
      } else if (click > 1) {
        $("#membersDropdown-content").addClass("dropdown-hide");
        $("#arrow").removeClass("arrow-rotate")
        click = 0;
      }

    })


    //admin script

    const elm = document.querySelector('ul');
    elm.addEventListener('click', (el) => {

      const elActive = elm.querySelector('.active-nav');
      if (elActive) {
        elActive.removeAttribute('class');
      }
      el.target.setAttribute('class', 'active-nav');
    });


    //member script

    //member script



    $(document).on('click', '#click_form', function(e) {

      window.open("https://www.upprovidentfund.com/forms/", '_blank');
      location.replace('member');
    })
    //mobile togge script
    let toggle_click = 0;
    $(document).on('click', '#menu-toggle', function(e) {
      toggle_click++;
      if (toggle_click === 1) {
        $("#side_bar").removeClass("hide");
        $("#dark-bg").removeClass("hide");
        $("body").addClass("unscroll");
        $("#toggle-container").removeClass("width-100");
      } else if (toggle_click > 1) {
        $("#side_bar").addClass("hide");
        $("#dark-bg").addClass("hide");
        $("body").removeClass("unscroll");
        $("#toggle-container").addClass("width-100");
        toggle_click = 0;
      }

    })
    window.addEventListener("resize", () => {
      const width = window.innerWidth;
      // const height = window.innerHeight;
      if (width >= 656 || width >= 896) {
        $("#side_bar").removeClass("hide");
        $("#menu-toggle").addClass("hide");
        $("#dark-bg").addClass("hide");
        $("#menu-toggle").removeClass("menu-toggle-active move-toggle");
        $("#toggle-container").removeClass("width-100");

      } else {
        $("#side_bar").addClass("hide");
        $("#menu-toggle").removeClass("hide");
        $("#dark-bg").addClass("hide");
        $("#menu-toggle").addClass("menu-toggle ");
        $("#toggle-container").addClass("width-100");
        toggle_click = 0;
      }
    });

    let initialWidth = screen.width;

    if (initialWidth >= 656 || initialWidth >= 896) {
      $("#side_bar").removeClass("hide");
      $("#menu-toggle").addClass("hide");
      $("#dark-bg").addClass("hide");
      $("#menu-toggle").removeClass("menu-toggle-active move-toggle");
      $("#toggle-container").removeClass("width-100");

    } else {
      $("#side_bar").addClass("hide");
      $("#menu-toggle").removeClass("hide");
      $("#dark-bg").addClass("hide");
      $("#menu-toggle").addClass("menu-toggle ");
      $("#toggle-container").addClass("width-100");
      toggle_click = 0;
    }

    document.getElementById('menu-toggle').addEventListener(
      'click',
      function() {
        this.classList.toggle('menu-toggle-active');
      }
    );

    function myFunction(x) {
      if (x.matches) { // If media query matches
        $("#side_bar").addClass("hide");
        $("#menu-toggle").removeClass("hide");
        $("#dark-bg").addClass("hide");
        $("#menu-toggle").addClass("menu-toggle ");
        $("#toggle-container").addClass("width-100");
        toggle_click = 0;
      } else {
        $("#side_bar").removeClass("hide");
        $("#menu-toggle").addClass("hide");
        $("#dark-bg").addClass("hide");
        $("#menu-toggle").removeClass("menu-toggle-active move-toggle");
        $("#toggle-container").removeClass("width-100");
      }
    }

    var x = window.matchMedia("(max-width: 656px)")
    myFunction(x) // Call listener function at run time
    x.addListener(myFunction) // Attach listener function on state changes
  </script>