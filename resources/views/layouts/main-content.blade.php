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
    background: var(--c-accent);
    padding: 30px 0px;
    position: fixed;
}

.wrapper .sidebar h2{
  color: white;
  text-transform: uppercase;
  text-align: center;
  margin-bottom: 30px;
}

.wrapper .sidebar ul li{
  padding: 15px;
  border-bottom: 1px solid #bdb8d7;
  border-bottom: 1px solid rgba(0,0,0,0.05);
  border-top: 1px solid rgba(255,255,255,0.05);
}    

.wrapper .sidebar ul li a{
 color: white;
  display: block;
}

.wrapper .sidebar ul li a .fa{
  width: 25px;
}

.wrapper .sidebar ul li:hover{
  color: white;
}
    
.wrapper .sidebar ul li:hover a{
  color: white;
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
    color: #bdb8d7;
    border-top-left-radius: 5px;
    border-top-right-radius: 5px;
}
.wrapper .main_content{
  width: 100%;
  margin-left: 250px;
}

.wrapper .main_content .header {
    /* padding: 20px; */
    color: var(--c-accent);
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
    margin-top:200px;
    z-index: 9;
}
.top-nav {
    text-align:center;
    color:white;
}
.top-nav i {
    font-size: 70px !important;
}
</style>


<div class="wrapper">
    <div class="sidebar">
        <div class="top-nav">
            <i class="fa fa-user"></i>
            <h2>Denneb Gomez</h2> 
           
        </div>

        
        <ul>
            <li><a href="#"><i class="fa fa-home"></i>Membership Application</a></li>
            <li><a href="#"><i class="fa fa-user"></i>Members</a></li>
            <li><a href="#"><i class="fa fa-line-chart"></i>Loan </a></li>
            <li><a href="#"><i class="fa fa-comment-o"></i>Benefits </a></li>
            <li><a href="#"><i class="fa fa-line-chart"></i>Transacton </a></li>
            <li><a href="#"><i class="fa fa-address-book"></i>Election</a></li>
            <li><a href="#"><i class="fa fa-gears"></i>Account & Settings</a></li>
        </ul> 
        <div class="social_media">
          <a href="#"><i class="fa fa-facebook-f"></i></a>
          <a href="#"><i class="fa fa-globe"></i></a>
          <a href="#"><i class="fa fa-website"></i></a>
      </div>
    </div>
    <div class="main_content">
        <div class="header">
            <div class="info">
                <a href="/">
                <img src="{!! asset('assets/images/uppfi-logo-sm.png') !!}" alt="UPPFI">
                </a>
                <a class="mp-link mp-link--accent" href="/">
                    University of the Philippines Provident Fund Inc.
                </a>
                <a href="#">
                     <strong><a href="#">Log out</a> </strong>
                </a>
            </div>
            
 
        </div>
            
         
        <div class="contents">
            @section('content_body')
            @show
        </div>

  </div>