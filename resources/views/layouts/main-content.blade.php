<style>
    {
  margin: 0;
  padding: 0;
  box-sizing: border-box;
  list-style: none;
  text-decoration: none;
  font-family: 'Josefin Sans', sans-serif;
}

body{
   background-color: #f3f5f9;
}

.wrapper{
  display: flex;
  position: relative;
}

.wrapper .sidebar{
    width: 250px;
    height: 100%;
    background: var(--c-white);
    padding: 30px 0px;
    position: fixed;
    z-index: 1001;
}

.wrapper .sidebar h2{
  /* color: var(--c-primary); */
  color: #979797;
  text-transform: uppercase;
  text-align: center;
  margin-bottom: 30px;
}

.wrapper .sidebar ul li{
  /* padding: 15px; */
  border-bottom: 1px solid #bdb8d7;
  border-bottom: 1px solid rgba(0,0,0,0.05);
  border-top: 1px solid rgba(255,255,255,0.05);
}    

.wrapper .sidebar ul li a{
  color: var(--c-primary-80);
  display: block;
}

.wrapper .sidebar ul li a .fa{
  width: 25px;
}

.wrapper .sidebar ul li:hover{
  color: var(--c-primary);
}
    
.wrapper .sidebar ul li:hover a{
  color: var(--c-primary);
}
 
.wrapper .sidebar .social_media{
  position: absolute;
  bottom: 0;
  left: 50%;
  transform: translateX(-50%);
  display: flex;
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
.wrapper .main_content{
  width: 100%;
  margin-left: 0px;
}

.wrapper .main_content .header {
    /* padding: 20px; */
    display:none;
    color: var(--c-primary-80);
    border-bottom: 1px solid #e0e4e8;
    border-bottom: 1px solid #e0e4e8;
}

.wrapper .main_content .info{
  margin: 20px;
  color: #717171;
  line-height: 25px;
}

.wrapper .main_content .info div{
  margin-bottom: 20px;
}
.header {
    position: fixed;
    width: 100%;
    z-index: 10;
    background-color:white;
  
}
.contents {
  height: 100%;
  overflow-y: auto;
  overflow-x: hidden;
}
.top-nav {
   text-align:center;
   color: var(--c-primary);
}
.top-nav i {
    font-size: 70px !important;
}

.active-nav {
  background-color: var(--c-primary);
  color:white !important;
}
.active-nav li a{
  color:white !important;
}

/* .nav-child a{
   margin-left: 20px;
} */
.arrow-left {
  margin-left:20px;
  font-size:20px;
  float:right;
}
.arrow-rotate {
  margin-top: 10px;
  margin-right:10px;
  transform: rotateZ(90deg);
}

.dropdown-hide {
  display: none;
  z-index: 1;
}

.show-dropdown {
  display:block;
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
  display :none;
}

.move-toggle {
    margin-left: 200px;
}

@media (min-width:656px) {
    
  .wrapper .main_content{
    width: 100%;
    margin-left: 250px;
  }
  .wrapper .main_content .header{
    display:block;
  }
  .wrapper .sidebar {
    display:block !important;
  }
  .mobile-toggle {
    display:none;
  }
  .hide {
    display:block;
  }
  .wrapper .sidebar {
    z-index:0;
  }
}

@media (min-width:768px) {
   
}

@media (min-width:992px) {

}

@media (min-width:1200px) {
   
}


.menu-toggle {
	  position: absolute;
    display: inline-block;
    margin: 5px;
    height:50px;
    background:transparent;
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
.menu-toggle span:before, .menu-toggle span:after {
	position: absolute;
	content: '';
}
.menu-toggle span, .menu-toggle span:before, .menu-toggle span:after {
	width: 40px;
	height: 6px;
	background-color: var(--c-primary);
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
  background-color: white;
	transition: 0.3s background-color;
}
.menu-toggle-active span:before {
	margin-top: 0;
	transform: rotate(45deg);
	transition-delay: 0, .2s;
}
.menu-toggle-active span:after {
	margin-top: 0;
	transform: rotate(-45deg);
	transition-delay: 0, .2s;
}
.dark-bg {
    background-color: black;
    padding: 100%;
    z-index: 1000 !important;
    position: absolute;
    opacity: 0.5;
}

</style>

<button href="#" class="menu-toggle" id="menu-toggle"><span></span></button>
<!-- <div class="mobile-toggle" id="mobile-toggle">
  <i class="fa fa-bars" aria-hidden="true"></i>
</div> -->
<div class="dark-bg" id ="dark-bg">

</div>
@if(Request::is('admin/dashboard') || Request::is('admin/settings'))         
     <div class="wrapper">
    <div class="sidebar" id="side_bar">
        <div class="top-nav">
            <div class="profile-img">
              <img  src="https://scontent.fcrk1-2.fna.fbcdn.net/v/t1.6435-9/207187111_3997130053703269_3727726365217478114_n.jpg?_nc_cat=108&ccb=1-7&_nc_sid=174925&_nc_eui2=AeHnFnqZfxQAti6y9Nu31yIJpu92jMzPbxmm73aMzM9vGam2k3k7JFrwECdfoG8nsnn8Nw5TBnNTYzeViCwahNkZ&_nc_ohc=KkRv57b4p-sAX_DTHss&_nc_ht=scontent.fcrk1-2.fna&oh=00_AfBtUiem2TkNP3AjA-zXbSwJ3zCJtyeq6xaGBNIaFpc4yA&oe=63EDB659" alt="">
            </div>
            <h2>Denneb Gomez</h2> 
        </div>
        <ul>
            <li >
              <a href="/admin/dashboard" class ="{{ Request::is('admin/dashboard') ? 'active-nav' : '' }}"><i class="fa fa-home "></i>Membership Application</a>
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
                <div class="dropdown-hide" id ="membersDropdown-content">
                  <li><a href="#"><i class="fa fa-user"></i>Members</a></li>
                  <li><a href="#"><i class="fa fa-user"></i>Members</a></li>
                </div>
              </div>
            </div>
            <li><a href="#"><i class="fa fa-line-chart"></i>Loan </a></li>
            <li><a href="#"><i class="fa fa-comment-o"></i>Benefits </a></li>
            <li><a href="#"><i class="fa fa-line-chart"></i>Transacton </a></li>
            <li><a href="#"><i class="fa fa-address-book"></i>Election</a></li>
            <li><a href="/admin/settings" class ="{{ Request::is('admin/settings') ? 'active-nav' : '' }}">
              <i class="fa fa-gears"></i>Account & Settings</a>
            </li>

           
        </ul> 
        
    </div>
    <div class="main_content">
        <div class="header">
            <div class="info">
                <a href="/">
                <img src="{!! asset('assets/images/uppfi-logo-sm.png') !!}" alt="UPPFI">
                </a>
                <a class="mp-link mp-link--primary" href="/">
                    University of the Philippines Provident Fund Inc.
                </a>
                <a href="#">
                     <strong><a href="#" class="logout">Log out</a> </strong>
                </a>
            </div>
            
 
        </div>
            
         
        <div class="contents">
            @section('content_body')
            @show
        </div>

  </div>
@else
      <div class="wrapper">
    <div class="sidebar hide" id="side_bar">
        <div class="top-nav">
            <div class="profile-img">
              <img  src="https://scontent.fcrk1-2.fna.fbcdn.net/v/t1.6435-9/207187111_3997130053703269_3727726365217478114_n.jpg?_nc_cat=108&ccb=1-7&_nc_sid=174925&_nc_eui2=AeHnFnqZfxQAti6y9Nu31yIJpu92jMzPbxmm73aMzM9vGam2k3k7JFrwECdfoG8nsnn8Nw5TBnNTYzeViCwahNkZ&_nc_ohc=KkRv57b4p-sAX_DTHss&_nc_ht=scontent.fcrk1-2.fna&oh=00_AfBtUiem2TkNP3AjA-zXbSwJ3zCJtyeq6xaGBNIaFpc4yA&oe=63EDB659" alt="">
            </div>
            <h2>Member Account</h2> 
        </div>
        <ul>
            <li >
              <a href="/member/dashboard" class ="{{ Request::is('member/dashboard') ? 'active-nav' : '' }}">
                <i class="fa fa-home "></i>Dashboard</a>
            </li>
            <li><a href="/member/transaction" class="{{ Request::is('member/transaction') ? 'active-nav' : '' }}">
              <i class="fa fa-line-chart" ></i>Transactions </a>
            </li>
           
            <li><a href="/member/member" class="{{ Request::is('member/member') ? 'active-nav' : '' }}"> 
              <i class="fa fa-user"></i>  Member Forms </a>
            </li>
              
            <li><a href="/member/loan"class="{{ Request::is('member/loan') ? 'active-nav' : '' }}" >
              <i class="fa fa-address-book"></i>Loan Application</a>
            </li>
            <li><a href="/member/settings" class ="{{ Request::is('member/settings') ? 'active-nav' : '' }}">
              <i class="fa fa-gears"></i>Account & Settings</a>
            </li>

           
        </ul> 
        
    </div>
    <div class="main_content">
        <div class="header">
            <div class="info">
                <a href="/">
                <img src="{!! asset('assets/images/uppfi-logo-sm.png') !!}" alt="UPPFI">
                </a>
                <a class="mp-link mp-link--primary" href="/">
                    University of the Philippines Provident Fund Inc.
                </a>
                <a href="#">
                     <strong><a href="#" class="logout">Log out</a> </strong>
                </a>
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
        if (click === 1){
          $("#membersDropdown-content").removeClass("dropdown-hide"); 
          $("#arrow").addClass("arrow-rotate")
        }
        else if (click > 1) {
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
          elActive.removeAttribute('class' );
        }
        el.target.setAttribute('class', 'active-nav');
      });
      

      //member script




      //mobile togge script
      let toggle_click = 0;
      $(document).on('click', '#menu-toggle', function(e) {
        toggle_click++;
        if (toggle_click === 1){
          $("#side_bar").removeClass("hide"); 
          $("#dark-bg").removeClass("hide");
        }
        else if (toggle_click > 1) {
          $("#side_bar").addClass("hide"); 
          $("#dark-bg").addClass("hide");
          toggle_click = 0;
        }
       
    })
    window.addEventListener("resize", () => {
        const width = window.innerWidth;
        // const height = window.innerHeight;
      if (width >= 656){
        $("#side_bar").removeClass("hide"); 
        $("#menu-toggle").addClass("hide");
        $("#dark-bg").addClass("hide");
        $("#menu-toggle").removeClass("menu-toggle-active move-toggle");
        
      }
      else  {
        $("#side_bar").addClass("hide"); 
        $("#menu-toggle").removeClass("hide"); 
        $("#dark-bg").addClass("hide");
        $("#menu-toggle").addClass("menu-toggle ");
        toggle_click =0;
      }
    });

    let initialWidth = screen.width;
     if (initialWidth >= 656){
        $("#side_bar").removeClass("hide"); 
        $("#menu-toggle").addClass("hide");
        $("#dark-bg").addClass("hide");
        $("#menu-toggle").removeClass("menu-toggle-active move-toggle");
        
      }
      else  {
        $("#side_bar").addClass("hide"); 
        $("#menu-toggle").removeClass("hide"); 
        $("#dark-bg").addClass("hide");
        $("#menu-toggle").addClass("menu-toggle ");
        toggle_click =0;
      }

    document.getElementById('menu-toggle').addEventListener(
      'click',
      function() {
        this.classList.toggle('menu-toggle-active');
      }
    );
  </script>