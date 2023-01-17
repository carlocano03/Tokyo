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
}

.wrapper .sidebar h2{
  color: var(--c-primary);
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
  margin-left: 250px;
}

.wrapper .main_content .header {
    /* padding: 20px; */
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

</style>

 


<div class="wrapper">
    <div class="sidebar">
        <div class="top-nav">
            <i class="fa fa-user"></i>
            <h2>Denneb Gomez</h2> 
        </div>
        <ul>
            <li >
              <a href="#" class="active-nav"><i class="fa fa-home "></i>Membership Application</a>
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
            <li><a href="#"><i class="fa fa-gears"></i>Account & Settings</a></li>

           
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

      const elm = document.querySelector('ul');
      elm.addEventListener('click', (el) => {
        const elActive = elm.querySelector('.active-nav');
        if (elActive) {
          elActive.removeAttribute('class' );
        }
        el.target.setAttribute('class', 'active-nav');
      });
      

  </script>